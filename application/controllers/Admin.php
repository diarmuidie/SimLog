<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    protected $pagedata = array();

    function __construct()
    {
        parent::__construct();

        //comment out this line to remove all authorization requirements
        $this->_authorize();

        $this->load->model('Post_model');
        $this->load->model('Tag_model');

        $this->data = array(
            'title' => 'Admin :: Diarmuid.ie',
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
                    if (!$this->session->userdata('returnurl')) {
                        $this->session->set_userdata('returnurl', uri_string());
                    }
                    break;

                case basic_auth::ERROR_USER_NOT_LOGGED_IN:
                    if (!$this->session->userdata('returnurl')) {
                        $this->session->set_userdata('returnurl', uri_string());
                    }
                    break;
                default:
                    break;
            }

            redirect('admin/login');
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
            $redirect = $this->session->userdata('returnurl');
            if ($this->basic_auth->login($user, $pass))
            {
                $this->session->unset_userdata('returnurl');
                log_message('info', 'Successful login u:' . $user . ' uri:' . $redirect . ' ip:' . $_SERVER['REMOTE_ADDR']);
                redirect($redirect);
            }
            else
            {
                log_message('error', 'Failed login u:' . $user . ' p:' . $pass . ' uri:' . $redirect . ' ip:' . $_SERVER['REMOTE_ADDR']);
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

        $data['entries'] = $this->Post_model->get_entries();


        $this->data['content'] = $this->load->view('admin/published', $data, TRUE);
        $this->load->view('admin/template', $this->data);

    }

    public function draft() {

        $data['entries'] = $this->Post_model->get_draft_entries();

        $this->data['content'] = $this->load->view('admin/draft', $data, TRUE);
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
                'html' => $this->Post_model->markdown($this->input->post('markdown')),
                'added' => date('Y-m-d H:i:s')
            );

            if (url_title($this->input->post('title')) == '') {
                $this->data['error'] = 'Title Cannot be blank';
            } elseif (!$this->Post_model->check_unique_slug(url_title($this->input->post('title')))) {
                $this->data['error'] = 'Title already in use';
            } else {

                $entry = $this->Post_model->add_entry($data);
                $this->Tag_model->add_tags($this->input->post('tags'), $entry);

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
                'html' => $this->Post_model->markdown($this->input->post('markdown')),
                'id' => $id
            );

            if (!$this->Post_model->check_unique_slug(url_title($this->input->post('title')), $id)) {
                $this->data['error'] = 'Title already in use';
            } else {

                $this->Post_model->update_entry($data);

                $this->Tag_model->add_tags($this->input->post('tags'), $id);

                //Clear the caches
                $this->output->clear_all_cache();

                redirect('admin/edit/' . $id);
            }

        } elseif(!empty($delete)) {

            $this->Post_model->delete_entry($id);
            redirect('admin/');

        } else {

            $data = $this->Post_model->get_entry_id($id);
            $data['tags'] = $this->Tag_model->get_post_tags($id, True);

            if ($data['published'] != "" AND !is_null($data['published'])) {
                $data['published'] = date('Y-m-d',strtotime($data['published']));
            }

        }

        $this->data['content'] = $this->load->view('admin/edit', $data, TRUE);
        $this->load->view('admin/template', $this->data);

    }

    public function media() {

        $upload = $this->input->post('upload');
        $delete = $this->input->post('delete');
        $this->load->model('Media_model');

        if (!empty($delete)) {
            $this->Media_model->delete($delete, true);
            redirect('admin/media');
        }

        if (!empty($upload)) {

            $config['upload_path'] = './media/';
            $config['allowed_types'] = 'gif|jpg|jpeg|tiff|png|mp3|wav|mp4|flv|avi';

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload())
            {
                $this->data['error'] = $this->upload->display_errors();

            }
            else
            {
                $data = $this->upload->data();

                // Is an image uploaded
                if ($dims = getimagesize($data['full_path'])) {
                    $this->Media_model->resize($data['full_path']);
                }

                redirect('admin/media/');

            }
        }

        $data['files'] = $this->Media_model->get_media('media/');

        $this->data['content'] = $this->load->view('admin/media', $data, TRUE);
        $this->load->view('admin/template', $this->data);

    }

    public function cache() {

        $purge = $this->input->post('purge');

        if (!empty($purge)) {
            if ($purge == 'all') {
                $this->output->clear_all_cache();
            } else {
                $this->output->delete_cache_url($purge);
            }
            redirect('admin/cache');
        }

        $this->load->helper('file');
        $caches = get_filenames(APPPATH . 'cache/');

        $data = array();

        // TODO: Move all this code into some sort of model
        foreach($caches as $cache) {

            if ($cache != 'index.html') {
                $content = read_file(APPPATH . 'cache/' . $cache);

                // Look for embedded serialized file info.
                preg_match('/^(.*)ENDCI--->/', $content, $match);

                if ($match[1]) {
                    $cache_info = unserialize($match[1]);
                } else {
                    $cache_info['expire'] = '';
                    $cache_info['uri'] = 'undefined';
                }

                $data['caches'][] = array(
                    'filename' => $cache,
                    'uri' => $cache_info['uri'],
                    'expire' => $cache_info['expire'],
                    'modified' => filemtime(APPPATH . 'cache/' . $cache)
                );
            }

        }

        if (array_key_exists('caches', $data)) {
            // Sort the caches newest to oldest
            usort($data['caches'], function($a, $b) {
                    return $b['expire'] - $a['expire'];
                });
        }

        $this->data['content'] = $this->load->view('admin/cache', $data, TRUE);
        $this->load->view('admin/template', $this->data);


    }

    /*
     * Preview draft posts
     */
    public function preview($id) {

        $entry = $this->Post_model->get_entry_id($id);

        // No post with this id found
        if(is_null($entry)) {
            show_404();
        }

        $tags = $this->Tag_model->get_post_tags($id);

        $this->data['content'] = $this->load->view('blog/post', array('entry' => $entry, 'tags' => $tags), true);

        if (is_null($entry['published']) or !strtotime($entry['published'])) {
            $entry['published'] = date('Y-m-d H:i:s');
        }

        $this->template['navbar'] = '';
        $this->template['footer'] = '';
        $this->template['title'] = $entry['title'];

        $this->template['content'] = $this->load->view('blog/preview', array('entry' => $entry, 'tags' => $tags), true);
        $this->load->view('template', $this->template);
    }

    /*
     * Return all tags as JSON. Used in Admin UI to auto
     * complete tag entry.
     */
    public function tags_list() {

        $tags = $this->Tag_model->get_all_tags();

        foreach($tags as $tag) {
            $json[] = $tag['tag'];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

}