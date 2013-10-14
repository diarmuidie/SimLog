<?php

class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->template = array(
            'title' => 'Diarmuid.ie :: ',
            'navbar' => $this->load->view('navbar', null, true),
            'content' => '',
            'footer' => ''
        );

        if(ENVIRONMENT === 'production') {
            $this->output->cache(60);
        }
    }
}