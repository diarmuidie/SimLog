<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends My_Controller {

	public function index()
	{
        $this->template['title'] .= "Projects";
        $this->template['content'] = $this->load->view('pages/projects', Null, true);
        $this->load->view('template', $this->template);
    }
}