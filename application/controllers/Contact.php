<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends My_Controller {

    public function index()
    {
        $this->template['title'] .= "Contact";
        $this->template['content'] = $this->load->view('pages/contact', Null, true);
        $this->load->view('template', $this->template);
    }
}