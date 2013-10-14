<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends My_Controller {

	public function index()
	{
        $this->template['title'] = "Diarmuid.ie";
        $this->template['content'] = $this->load->view('pages/welcome', Null, true);
        $this->load->view('template', $this->template);
	}
}