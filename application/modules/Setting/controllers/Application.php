<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('regex');
		$this->load->model('Setting/Application_model','application');
		/*if($this->session->userdata('login')==false){
			redirect(base_url().'login');
		}*/

	}

	public function index()
	{
		
		$data['title'] = "Application Setting";
		$data['subtitle'] = "Template app";
		$data['value'] = $this->application->get_by_id($this->regex->_genRegex(1, 'RGXINT'));
		
		$this->load->view('application/form', $data);
	}

	public function proses_app()
	{
		$id_conf_application = $this->regex->_genRegex(1, 'RGXINT');

		$this->db->trans_begin();
		$dataexc = array(
			'app_name' => $this->regex->_genRegex($this->input->post('app_name'), 'RGXQSL'),
			'header_title' => $this->regex->_genRegex($this->input->post('header_title'), 'RGXQSL'),
			'footer_text' => $this->regex->_genRegex($this->input->post('text_footer'), 'RGXQSL'),
			'copyright' => $this->regex->_genRegex($this->input->post('copyright'), 'RGXQSL'),
			'app_description' => $this->regex->_genRegex($this->input->post('description'), 'RGXQSL'),
			'author' => $this->regex->_genRegex($this->input->post('auth_name'), 'RGXQSL'),
			'company_name' => $this->regex->_genRegex($this->input->post('company_name'), 'RGXQSL'),
			'updated_by' => '',
			'updated_date' => date('Y-m-d H:i:s')
		);
		
		$this->application->update(array('id_conf_application'=>$id_conf_application), $dataexc);


		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			echo json_encode(array("status" => FALSE));
		}
		else
		{
			$this->db->trans_commit();
			echo json_encode(array("status" => TRUE));
		}
		
	}

	
}
