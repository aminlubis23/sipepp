<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tr_bukti extends CI_Controller {

	/*Default title for this module*/
	var $title = 'Alat dan Barang Bukti';

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
		$this->load->model('Bukti_model','bukti');
		$this->load->model('Registrasi_model','registrasi');

		/*
		cek session login
		if session login false than redirect to login else read index
		*/
		if($this->session->userdata('login')==false){
			redirect(base_url().'login');
		}
		/*default breadcrumb*/
		$this->breadcrumbs->push('Daftar Alat dan Barang Bukti', 'AdmPengaduan/'.strtolower(get_class($this)));

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

		/*load index view*/
		$this->load->view('Tr_bukti/index', $data);

	}

	public function form($id='')
	{
		//$this->output->enable_profiler(true);
		/*default title*/
		$data['title'] = $this->title;

		/*default pgd_id*/
		$data['pgd_id'] = $this->input->get('pgd_id');
		$data['pgd'] = $this->registrasi->get_by_id($data['pgd_id']);

		/*
		if not empty ID then get data by ID and load form view by showing data loaded
		else load form view to create new data
		*/
		if( $id != '' ){

			/*user permission for read function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'R');

			/*breadcrumbs edit*/ 
			$this->breadcrumbs->push('Edit', 'AdmPengaduan/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);

			/*get data by id*/
			$data['value'] = $this->bukti->get_by_id($id);
			$data['files'] = $this->upload_file->getUploadedFile(array('ref_id'=>$data['value']->pgdb_id,'ref_table'=>'mc_pengaduan_bukti'), 'data', 'uploaded_files/bukti/');

		}else{

			/*user permission for create function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'C');

			/*breadcrumbs add*/
			$this->breadcrumbs->push('Add', 'AdmPengaduan/'.strtolower(get_class($this)).'/form');

		}

		/*show breadcrumbs view*/
		$data['breadcrumbs'] = $this->breadcrumbs->show();
		
		/*params status*/
		$status = ($this->input->get('status')) ? $this->input->get('status') : '';
		/*if params status != 1 then not allowed to acces this module*/
		$this->registrasi->auth_module_by_status('AdmPengaduan/'.strtolower(get_class($this)), $status, $_GET);

		/*load form view*/
		$this->load->view('Tr_bukti/form', $data);
	}

	public function getData($pgd_id=''){

		/*post limit or limit by default*/
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;

		/*post params search by and keyword*/
		$params = array(
			'search_by' => $this->input->post('search_by'),
			'keyword' => $this->input->post('keyword'),
			'pgd_id' => $pgd_id
		);

		/*get total data by params post*/
		$total = $this->bukti->total_data($params);

		/*total pages*/
		$total_pages = ($total >0)?ceil($total/$limit):1;

		/*page existing*/
		$page = $this->input->post('page')?$this->input->post('page'):1;
		
		/*start row data*/
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;

		/*params for query data*/
		$params['start'] = $start;
		$params['limit'] = $limit;
		$params['sort'] = $this->input->post('sord');

		/*get data by params*/
		$rowData = $this->bukti->get_data($params);

		/*final result*/
		$data = array();
		$data['totalPages'] = $total_pages;
		$data['page'] = $page;
		$data['records'] = $total;
		$data['rows'] = $rowData;

		echo json_encode($data);
	}

	public function process()
	{
		//print_r($_FILES);die;
		/*post ID row*/
		$pgdb_id = $this->regex->_genRegex($this->input->post('pgdb_id'), 'RGXINT');

		/*transaction begin*/
		$this->db->trans_begin();

		/*post data array*/

		$dataexc = array(
			'pgd_id' => $this->regex->_genRegex($this->input->post('pgd_id'), 'RGXQSL'),
			'pgdb_keterangan' => $this->regex->_genRegex($this->input->post('pgdb_keterangan'), 'RGXQSL'),
			//'pgdb_nama_file' => $name_file,
			'flag' => $this->regex->_genRegex($this->input->post('flag'), 'RGXQSL'),
		);


		/*if row ID not null then insert new data else update data by row ID*/
		if( $pgdb_id == 0 ){

			/*user permission for create function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'C');

			/*insert new data ktp*/
			$dataexc['created_date'] = date('Y-m-d H:i:s');
			$dataexc['created_by'] = $this->session->userdata('data_user')->fullname;
			$last_pgdb_id = $this->bukti->save('mc_pengaduan_bukti', $dataexc);

			/*excecute upload file*/
			$params['ref_id'] = $last_pgdb_id;
			$params['ref_table'] = 'mc_pengaduan_bukti';
			$params['flag'] = $this->input->post('flag');
			$exc_upload = $this->upload_file->doUploadMultiple($params, 'file', 'uploaded_files/bukti/');

		}else{

			/*user permission for update function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'U');

			/*update data ktp by row ID*/
			$dataexc['updated_date'] = date('Y-m-d H:i:s');
			$dataexc['updated_by'] = $this->session->userdata('data_user')->fullname;
			$this->bukti->update('mc_pengaduan_bukti',array('pgdb_id'=>$pgdb_id), $dataexc);

			/*excecute upload*/
			$params['ref_id'] = $pgdb_id;
			$params['ref_table'] = 'mc_pengaduan_bukti';
			$params['flag'] = $this->input->post('flag');
			$exc_upload = $this->upload_file->doUploadMultiple($params, 'file', 'uploaded_files/bukti/');
			
		}

		/*if transaction false then transaction rollback else transaction commit*/
		if ($this->db->trans_status() === FALSE)
		{
			/*transaction rollback*/
			$this->db->trans_rollback();
			echo json_encode(array("message" => 'Process failed!', "gritter" => 'gritter-danger', "pgd_id" => $this->input->post('pgd_id')));
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
		if(empty($_GET)){
			if($this->input->post('ID')){
				$id = $this->input->post('ID');
			}else{
				$json = $this->input->post('json');
				$rowData = json_decode($json);
				$id = $rowData->id;
			}
		}
		/*user permission for delete function*/
		$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'D');

		/*params status*/
		$status = ($this->input->get('status')) ? $this->input->get('status') : '';
		/*if params status != 1 then not allowed to acces this module*/
		$this->registrasi->auth_module_by_status('AdmPengaduan/'.strtolower(get_class($this)), $status, $_GET);

		/*delete row*/
		$this->bukti->delete_by_id($id);

		/*show gritter*/
		echo json_encode(array("message" => 'ID ['.$id.'] Deleted success!', "gritter" => 'gritter-success'));

	}

}
