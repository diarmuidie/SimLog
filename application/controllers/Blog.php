<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends My_Controller {

    /*
     * List all blog posts with pagination.
     */
	public function index($page = 0)
	{
        $this->load->model('Post_model');

        $entries = $this->Post_model->get_entries($page);

        // No posts found
        if(empty($entries)) {
            show_error('No More Posts Available', 404 );
        }

        $this->template['title'] .= "Blog";
        $this->template['content'] = $this->load->view('blog/index', array('entries' => $entries), true);
		$this->load->view('template', $this->template);
	}

    /*
     * Display a post based on its unique URL slug
     */
    public function post($slug = NULL) {

        if ($slug === NULL) {
            redirect('blog');
        }

        // Permanently redirect uppercase slugs to lowercase
        if (strtolower($slug) != $slug) {
            redirect('/blog/post/'.strtolower($slug), 'location', 301);
        }

        $this->load->model('Post_model');

        $entry = $this->Post_model->get_entry_slug(strtolower($slug));

        // No post with this slug found
        if(is_null($entry)) {
            show_404();
        }

        $tags = $this->Tag_model->get_post_tags($entry['id']);

        $this->template['title'] .= $entry['title'];
        $this->template['content'] = $this->load->view('blog/post', array('entry' => $entry, 'tags' => $tags), true);
        $this->load->view('template', $this->template);
    }

}