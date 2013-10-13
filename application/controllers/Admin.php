<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    protected $pagedata = array();

    function __construct()
    {
        parent::__construct();

        //comment out this line to remove all authorization requirements
        $this->_authorize();
        $this->load->model('Blog_model');

        $this->data = array(
            'title' => '',
            'content' => '',
            'navbar' => $this->load->view('admin/navbar', Null, TRUE)
        );

    }

    protected function _authorize()
    {
        $this->load->library('Basic_auth');

        /*
         * The set_protected_methods takes an associative array of all of the
         * method names that will be protected. The key is the method name while
         * the value is a comma-delimited list of groups allowed to access the
         * method.
         *
         * Using '*' as the key will protect all methods in the controller. Be
         * aware that using '*' will require that any authorization (login,
         * logout, etc.) be done in a different controller because those methods
         * would be protected as well.
         */
        $this->basic_auth->set_protected_methods(array(
                '*' => 'user,admins',
            ));

        $this->basic_auth->set_unprotected_methods(array(
                'login'
            ));

        if (!$this->basic_auth->check())
        {
            switch ($this->basic_auth->get_error())
            {
                case basic_auth::ERROR_USER_NOT_AUTHORIZED:
                    $redirect = 'admin/login';
                    break;

                case basic_auth::ERROR_USER_NOT_LOGGED_IN:
                    $redirect = 'admin/login';
                    $this->session->set_userdata('returnurl', uri_string());
                    break;
                default:
                    break;
            }

            redirect($redirect);
        }
    }

    public function login()
    {
        $data['title'] = 'Login';

        $user = $this->input->post('username');
        $pass = $this->input->post('password');
        $submitted = $this->input->post('submit');

        if (!empty($submitted))
        {
            if ($this->basic_auth->login($user, $pass))
            {
                $this->session->unset_userdata('returnurl');
                redirect('admin/');
            }
            else
            {
                $data['errors'][] = "Username or password were incorrect. Please try again.";
            }
        }

        $this->data['navbar'] = '';
        $this->data['content'] = $this->load->view('admin/login', $data, TRUE);
        $this->load->view('admin/template', $this->data);

    }

    public function logout()
    {
        $this->basic_auth->logout();
        redirect('/');
    }

    public function index()
    {

        $data['entries'] = $this->Blog_model->get_entries();


        $this->data['content'] = $this->load->view('admin/list', $data, TRUE);
        $this->load->view('admin/template', $this->data);

    }

    public function draft() {

        $data['entries'] = $this->Blog_model->get_draft_entries();

        $this->data['content'] = $this->load->view('admin/list', $data, TRUE);
        $this->load->view('admin/template', $this->data);

    }

    public function add() {

        $submitted = $this->input->post('submit');

        $data = array(
            'title' => '',
            'markdown' => '',
            'published' => '',
        );

        if (!empty($submitted))
        {
            if(!$this->input->post('published') AND $this->input->post('published') == "") {
                $published = Null;
            } else {
                $published = date('Y-m-d H:i:s', strtotime($this->input->post('published')));
            }

            $data = array(
                'title' => $this->input->post('title'),
                'slug' => url_title($this->input->post('title')),
                'markdown' => $this->input->post('markdown'),
                'published' => $published,
                'html' => $this->Blog_model->markdown($this->input->post('markdown')),
                'added' => date('Y-m-d H:i:s')
            );

            if (url_title($this->input->post('title')) == '') {
                $this->data['error'] = 'Title Cannot be blank';
            } elseif (!$this->Blog_model->check_unique_slug(url_title($this->input->post('title')))) {
                $this->data['error'] = 'Title already in use';
            } else {

                $entry = $this->Blog_model->add_entry($data);
                redirect('admin/edit/' . $entry);
            }

        }

        $this->data['content'] = $this->load->view('admin/add', $data, TRUE);
        $this->load->view('admin/template', $this->data);

    }

    public function edit($id) {

        $submitted = $this->input->post('submit');
        $delete = $this->input->post('delete');

        if (!empty($submitted))
        {

            if(!$this->input->post('published') AND $this->input->post('published') == "") {
                $published = Null;
            } else {
                $published = date('Y-m-d H:i:s', strtotime($this->input->post('published')));
            }

            $data = array(
                'title' => $this->input->post('title'),
                'slug' => url_title($this->input->post('title')),
                'markdown' => $this->input->post('markdown'),
                'edited' => date('Y-m-d H:i:s'),
                'published' => $published,
                'html' => $this->Blog_model->markdown($this->input->post('markdown')),
                'id' => $id
            );

            if (!$this->Blog_model->check_unique_slug(url_title($this->input->post('title')), $id)) {
                $this->data['error'] = 'Title already in use';
            } else {

                $entry = $this->Blog_model->update_entry($data);

                redirect('admin/edit/' . $id);
            }

        } elseif(!empty($delete)) {

            $this->Blog_model->delete_entry($id);
            redirect('admin/');

        } else {

            $data = $this->Blog_model->get_entry_id($id);
            if ($data['published'] != "" AND !is_null($data['published'])) {
                $data['published'] = date('Y-m-d',strtotime($data['published']));
            }

        }

        $this->data['content'] = $this->load->view('admin/edit', $data, TRUE);
        $this->load->view('admin/template', $this->data);

    }

    public function media() {
        $this->load->model('Media_model');
        $data['files'] = $this->Media_model->get_media('media/');

        $this->data['content'] = $this->load->view('admin/media', $data, TRUE);
        $this->load->view('admin/template', $this->data);

    }

    public function preview($id) {

        $data = $this->Blog_model->get_entry_id($id);

        $data['html'] = $this->Blog_model->markdown($data['markdown']);

        $this->data['content'] = $this->load->view('admin/preview', $data, TRUE);

        $this->data['navbar'] = '';
        $this->data['title'] = 'Preview :: ' . $data['title'];
        $this->load->view('admin/template', $this->data);

    }
}