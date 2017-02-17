<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tr_registrasi extends CI_Controller {

	/*Default title for this module*/
	var $title = 'Registrasi Pengaduan';

	/*Function constructor*/
	public function __construct()
	{
		parent::__construct();

		/*Load library for this class*/
		$this->load->library('apps');
		$this->load->library('tanggal');
		$this->load->library('authuser');
		$this->load->library('master');
		$this->load->library('breadcrumbs');

		/*Load model for this class*/
		$this->load->model('Registrasi_model','registrasi');

		/*
		cek session login
		if session login false than redirect to login else read index
		*/
		if($this->session->userdata('login')==false){
			redirect(base_url().'login');
		}
		/*default breadcrumb*/
		$this->breadcrumbs->push('Daftar Registrasi Pengaduan', 'AdmPengaduan/'.strtolower(get_class($this)));

	}

	public function index()
	{	
		/*default title*/
		$data['title'] = $this->title;

		/*show default breadcrumbs */
		$data['breadcrumbs'] = $this->breadcrumbs->show();

		/*load index view*/
		$this->load->view('Tr_registrasi/index', $data);

	}

	public function form($id='')
	{
		/*default title*/
		$data['title'] = $this->title;

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
			$data['value'] = $this->registrasi->get_by_id($id);

		}else{

			/*user permission for create function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'C');

			/*breadcrumbs add*/
			$this->breadcrumbs->push('Add', 'AdmPengaduan/'.strtolower(get_class($this)).'/form');

		}

		/*show breadcrumbs view*/
		$data['breadcrumbs'] = $this->breadcrumbs->show();
		
		/*load form view*/
		$this->load->view('Tr_registrasi/form', $data);
	}

	public function formulir($id)
	{
		/*default title*/
		$data['title'] = $this->title;

		/*user permission for create formulir function*/
		$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'C');

		/*breadcrumbs formulir*/ 
		$this->breadcrumbs->push('Formulir', 'AdmPengaduan/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);

		/*get data by id*/
		$data['value'] = $this->registrasi->get_by_id($id);

		/*show breadcrumbs view*/
		$data['breadcrumbs'] = $this->breadcrumbs->show();
		
		/*load form view*/
		$this->load->view('Tr_registrasi/formulir', $data);
	}

	public function getData(){

		/*post limit or limit by default*/
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;

		/*post params search by and keyword*/
		$params = array(
			'search_by' => $this->input->post('search_by'),
			'keyword' => $this->input->post('keyword'),
			'year' => $this->input->post('keyword')?$this->input->post('keyword'):date('Y')
		);

		/*get total data by params post*/
		$total = $this->registrasi->total_data($params);

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
		$rowData = $this->registrasi->get_data($params);

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
		/*this function is for executing action create or update*/

		/*post ID row*/
		$pgd_id = $this->regex->_genRegex($this->input->post('id'), 'RGXINT');

		/*transaction begin*/
		$this->db->trans_begin();

		/*post data array*/
		$dataexc = array(
			'pgd_tanggal' => $this->regex->_genRegex($this->input->post('pgd_tanggal'), 'RGXQSL'),
			'tp_id' => $this->regex->_genRegex($this->input->post('tp_id'), 'RGXINT'),
			'kp_id' => $this->regex->_genRegex($this->input->post('kp_id'), 'RGXINT'),
			'pgd_tempat' => $this->regex->_genRegex($this->input->post('pgd_tempat'), 'RGXQSL'),
			'subdistrict_id' => $this->regex->_genRegex($this->input->post('subdistrict_id'), 'RGXINT'),
			'district_id' => $this->regex->_genRegex($this->input->post('district_id'), 'RGXINT'),
			'city_id' => $this->regex->_genRegex($this->input->post('city_id'), 'RGXINT'),
			'province_id' => $this->regex->_genRegex($this->input->post('province_id'), 'RGXINT'),
		);
		
		/*if row ID not null then insert new data else update data by row ID*/
		if( $pgd_id == 0 ){

			/*user permission for create function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'C');

			$dataexc['pgd_id'] = $this->registrasi->getNoRegistrasi();
			/*insert new data*/
			$dataexc['created_date'] = date('Y-m-d H:i:s');
			$dataexc['created_by'] = $this->session->userdata('data_user')->fullname;
			$this->registrasi->save('mc_pengaduan', $dataexc);
			
			/*update status pengaduan proses to registrasi pengaduan*/
			$this->registrasi->updateStatusProses($dataexc['pgd_id'],1);

		}else{

			/*user permission for update function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'U');

			/*update data by row ID*/
			$dataexc['updated_date'] = date('Y-m-d H:i:s');
			$dataexc['updated_by'] = $this->session->userdata('data_user')->fullname;
			$this->registrasi->update('mc_pengaduan',array('pgd_id'=>$pgd_id), $dataexc);

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
			echo json_encode(array("message" => 'Process success!', "gritter" => 'gritter-success'));
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
		$this->registrasi->delete_by_id('mc_pengaduan',$id);

		/*show gritter*/
		echo json_encode(array("message" => 'ID ['.$id.'] Deleted success!', "gritter" => 'gritter-success'));

	}

	public function RiwayatStatus($pgd_id)
	{
		/*this function for get data history status */
		$status = $this->db->select('ap_name,mc_pengaduan_proses.created_date,mc_pengaduan_proses.created_by')->join('mst_alur_pengaduan','mst_alur_pengaduan.ap_id=mc_pengaduan_proses.ap_id','left')->get_where('mc_pengaduan_proses', array('pgd_id'=>$pgd_id))->result();

		/*show data*/
		echo json_encode($status);

	}

	public function processSubmit()
	{
		/*this function is for deleteing row by id*/
		$id = $this->input->post('ID');
		
		/*user permission for submit function*/
		$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'S');

		/*update status proses to penelitan administrasi*/
		$this->registrasi->updateStatusProses($id, 2);

		/*auto insert lampiran form 1-4*/
		$this->registrasi->auto_insert_lampiran_pengaduan($id);

		/*show gritter*/
		echo json_encode(array("message" => 'ID ['.$id.'] Submitted success!', "gritter" => 'gritter-success'));

	}


}
