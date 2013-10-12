<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends My_Controller {

	public function index($page = 0)
	{
        $this->load->model('BlogModel');

        $entries = $this->BlogModel->get_entries($page);

        if(empty($entries)) {
            show_error('No More Posts Available', 404 );
        }

        $this->template['title'] .= "Blog";
        $this->template['content'] = $this->load->view('blog/index', array('entries' => $entries), true);
		$this->load->view('template', $this->template);
	}

    public function post($slug = NULL) {

        if ($slug === NULL) {
            redirect('blog');
        }
        $this->load->model('BlogModel');

        $entry = $this->BlogModel->get_entry_slug($slug);

        if(is_null($entry)) {
            show_error('Post Not Found', 404 );
        }

        $this->template['title'] .= $entry['title'];
        $this->template['content'] = $this->load->view('blog/post', array('entry' => $entry), true);
        $this->load->view('template', $this->template);
    }

}