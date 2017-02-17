<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tr_uraian_kejadian extends CI_Controller {

	/*Default title for this module*/
	var $title = 'Uraian Kejadian';

	/*Function constructor*/
	public function __construct()
	{
		parent::__construct();

		/*Load library for this class*/
		$this->load->library('tanggal');
		$this->load->library('authuser');
		$this->load->library('master');
		$this->load->library('breadcrumbs');

		/*Load model for this class*/
		$this->load->model('Uraian_kejadian_model','uraian_kejadian');
		$this->load->model('Registrasi_model','registrasi');

		/*
		cek session login
		if session login false than redirect to login else read index
		*/
		if($this->session->userdata('login')==false){
			redirect(base_url().'login');
		}
		/*default breadcrumb*/
		$this->breadcrumbs->push('Daftar Uraian Kejadian', 'AdmPengaduan/'.strtolower(get_class($this)));

	}

	public function index()
	{	
		/*default title*/
		$data['title'] = $this->title;

		/*post pgd_id*/
		$data['pgd_id'] = $this->input->get('pgd_id');
		$data['pgd'] = $this->registrasi->get_by_id($data['pgd_id']);

		/*show default breadcrumbs */
		$data['breadcrumbs'] = $this->breadcrumbs->show();
		$data['value'] = $this->uraian_kejadian->get_by_custom(array('pgd_id' => $data['pgd_id']));

		/*load index view*/
		$this->load->view('Tr_uraian_kejadian/form', $data);

	}


	public function process()
	{
		/*this function is for executing action create or update*/

		/*post ID row*/
		$pgdu_id = $this->regex->_genRegex($this->input->post('pgdu_id'), 'RGXINT');

		/*transaction begin*/
		$this->db->trans_begin();

		/*post data array*/

		$dataexc = array(
			'pgd_id' => $this->regex->_genRegex($this->input->post('pgd_id'), 'RGXQSL'),
			'pgdu_uraian_kejadian' => $this->regex->_genRegex($this->input->post('pgdu_uraian_kejadian'), 'RGXQSL'),
		);
		
		/*if row ID not null then insert new data else update data by row ID*/
		if( $pgdu_id == 0 ){

			/*user permission for create function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'C');

			/*insert new data ktp*/
			$dataexc['created_date'] = date('Y-m-d H:i:s');
			$dataexc['created_by'] = $this->session->userdata('data_user')->fullname;
			$last_pgdu_id = $this->uraian_kejadian->save('mc_pengaduan_uraian', $dataexc);


		}else{

			/*user permission for update function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'U');

			/*update data ktp by row ID*/
			$dataexc['updated_date'] = date('Y-m-d H:i:s');
			$dataexc['updated_by'] = $this->session->userdata('data_user')->fullname;
			$this->uraian_kejadian->update('mc_pengaduan_uraian',array('pgdu_id'=>$pgdu_id), $dataexc);
			
		}

		/*if transaction false then transaction rollback else transaction commit*/
		if ($this->db->trans_status() === FALSE)
		{
			/*transaction rollback*/
			$this->db->trans_rollback();
			echo json_encode(array("message" => 'Process failed!', "gritter" => 'gritter-danger'));
		}
		else
		{
			/*transaction commit*/
			$this->db->trans_commit();
			echo json_encode(array("message" => 'Process success!', "gritter" => 'gritter-success', "pgd_id" => $this->input->post('pgd_id')));
		}
		
	}

	public function processDelete()
	{
		/*this function is for deleteing row by id*/
		if($this->input->post('ID')){
			$id = $this->input->post('ID');
		}else{
			$json = $this->input->post('json');
			$rowData = json_decode($json);
			$id = $rowData->id;
		}
		/*user permission for delete function*/
		$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'D');

		/*delete row*/
		$this->uraian_kejadian->delete_by_id($id);

		/*show gritter*/
		echo json_encode(array("message" => 'ID ['.$id.'] Deleted success!', "gritter" => 'gritter-success'));

	}

}
