<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_reference extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('breadcrumbs');
		$this->load->library('lib_menus');
		if($this->session->userdata('login')==false){
			redirect(base_url().'login');
		}
		$this->breadcrumbs->push('Referance', strtolower(get_class($this)));
	}

	public function index()
	{
		
		$data['title'] = "Referance";
		$data['breadcrumbs'] = $this->breadcrumbs->show();
		$data['sub_menu'] = $this->lib_menus->get_sub_menu(strtolower(get_class($this)));
		$this->authuser->write_log();
		$this->load->view('index_main_menu', $data);
	}

	
}
