<?php

class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->template = array(
            'title' => 'Diarmuid.ie :: ',
            'content' => '',
            'footer' => ''
        );

    }
}