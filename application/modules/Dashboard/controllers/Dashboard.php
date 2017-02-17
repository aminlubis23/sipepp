<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if($this->session->userdata('login')==false){

			redirect(base_url().'login');

		}

		$this->load->library('Kerangka');

	}

	public function index()

	{
		
		$this->kerangka->site('home_view');

	}
	
}
