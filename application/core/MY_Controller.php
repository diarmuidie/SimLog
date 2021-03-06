<?php

class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        // Auto populate the template with some defaults
        $this->template = array(
            'title' => 'Diarmuid.ie :: ',
            'navbar' => $this->load->view('navbar', null, true),
            'content' => '',
            'footer' => ''
        );

        // Only cache pages when in production mode
        // Disable cache for all Admin pages
        if(ENVIRONMENT === 'production' AND $this->uri->segment(1) !== 'admin') {
            // Enable cache for production pages for n mins
            $this->output->cache(6 * 60);
        }
    }
}