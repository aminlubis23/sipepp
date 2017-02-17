<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tr_pegawai extends CI_Controller {

	/*Default title for this module*/
	var $title = 'Data Pegawai DKPP';

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
		$this->load->model('Pegawai_model','tr_pegawai');

		/*
		cek session login
		if session login false than redirect to login else read index
		*/
		if($this->session->userdata('login')==false){
			redirect(base_url().'login');
		}
		/*default breadcrumb*/
		$this->breadcrumbs->push('Daftar Data Pegawai', 'Kepegawaian/'.strtolower(get_class($this)));

	}

	public function index()
	{	
		/*default title*/
		$data['title'] = $this->title;

		/*show default breadcrumbs */
		$data['breadcrumbs'] = $this->breadcrumbs->show();

		/*load index view*/
		$this->load->view('Tr_pegawai/index', $data);

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
			$this->breadcrumbs->push('Edit', 'Kepegawaian/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);

			/*get data by id*/
			$data['value'] = $this->tr_pegawai->get_by_id($id);

		}else{

			/*user permission for create function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'C');

			/*breadcrumbs add*/
			$this->breadcrumbs->push('Add', 'Kepegawaian/'.strtolower(get_class($this)).'/form');

		}

		/*show breadcrumbs view*/
		$data['breadcrumbs'] = $this->breadcrumbs->show();
		
		/*load form view*/
		$this->load->view('Tr_pegawai/form', $data);
	}

	public function getData(){

		/*post limit or limit by default*/
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;

		/*post params search by and keyword*/
		$params = array(
			'search_by' => $this->input->post('search_by'),
			'keyword' => $this->input->post('keyword')
		);

		/*get total data by params post*/
		$total = $this->tr_pegawai->total_data($params);

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
		$rowData = $this->tr_pegawai->get_data($params);

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
		$pg_id = $this->regex->_genRegex($this->input->post('pg_id'), 'RGXINT');
		$ktp_id = $this->regex->_genRegex($this->input->post('ktp_id'), 'RGXINT');

		/*transaction begin*/
		$this->db->trans_begin();

		/*post data array*/

		$nik = $this->input->post('ktp_nik')?$this->input->post('ktp_nik'):$this->generateNik('ktp');

		$dataktp = array(
			'religion_id' => $this->regex->_genRegex($this->input->post('religion_id'), 'RGXINT'),
			'ms_id' => $this->regex->_genRegex($this->input->post('ms_id'), 'RGXINT'),
			'job_id' => $this->regex->_genRegex($this->input->post('job_id'), 'RGXINT'),
			'tb_id' => $this->regex->_genRegex($this->input->post('tb_id'), 'RGXINT'),
			'province_id' => $this->regex->_genRegex($this->input->post('province_id'), 'RGXINT'),
			'city_id' => $this->regex->_genRegex($this->input->post('city_id'), 'RGXINT'),
			'district_id' => $this->regex->_genRegex($this->input->post('district_id'), 'RGXINT'),
			'sub_district_id' => $this->regex->_genRegex($this->input->post('sub_district_id'), 'RGXINT'),
			'ktp_nik' => $this->regex->_genRegex($nik, 'RGXQSL'),
			'ktp_nama_lengkap' => $this->regex->_genRegex($this->input->post('ktp_nama_lengkap'), 'RGXQSL'),
			'ktp_jk' => $this->regex->_genRegex($this->input->post('ktp_jk'), 'RGXQSL'),
			'ktp_tempat_lahir' => $this->regex->_genRegex($this->input->post('ktp_tempat_lahir'), 'RGXQSL'),
			'ktp_tanggal_lahir' => $this->regex->_genRegex($this->input->post('ktp_tanggal_lahir'), 'RGXQSL'),
			'ktp_alamat' => $this->regex->_genRegex($this->input->post('ktp_alamat'), 'RGXQSL'),
			'ktp_rw' => $this->regex->_genRegex($this->input->post('ktp_rw'), 'RGXQSL'),
			'ktp_rt' => $this->regex->_genRegex($this->input->post('ktp_rt'), 'RGXQSL'),
			'ktp_kewarganegaraan' => $this->regex->_genRegex($this->input->post('ktp_kewarganegaraan'), 'RGXQSL'),
			'ktp_expired_date' => $this->regex->_genRegex($this->input->post('ktp_expired_date'), 'RGXQSL'),
			'active' => $this->regex->_genRegex($this->input->post('tr_pegawai_active'), 'RGXAZ'),
		);
		
		$datapegawai = array(
			'pg_nip' => $this->regex->_genRegex($this->input->post('pg_nip'), 'RGXQSL'),
			'pg_no_telp' => $this->regex->_genRegex($this->input->post('pg_no_telp'), 'RGXQSL'),
			'pg_no_hp' => $this->regex->_genRegex($this->input->post('pg_no_hp'), 'RGXQSL'),
			'pg_email' => $this->regex->_genRegex($this->input->post('pg_email'), 'RGXQSL'),
			'jabatan_id' => $this->regex->_genRegex($this->input->post('jabatan_id'), 'RGXQSL'),
			'active' => $this->regex->_genRegex($this->input->post('tr_pegawai_active'), 'RGXAZ'),
		);

		/*if row ID not null then insert new data else update data by row ID*/
		if( $ktp_id == 0 ){

			/*user permission for create function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'C');

			/*insert new data ktp*/
			$dataktp['created_date'] = date('Y-m-d H:i:s');
			$dataktp['created_by'] = $this->session->userdata('data_user')->fullname;
			$last_ktp_id = $this->tr_pegawai->save('ktp', $dataktp);

			/*insert new data pegawai*/
			$datapegawai['created_date'] = date('Y-m-d H:i:s');
			$datapegawai['created_by'] = $this->session->userdata('data_user')->fullname;
			$datapegawai['ktp_nik'] = $nik;
			$last_pg_id = $this->tr_pegawai->save('tr_pegawai', $datapegawai);

		}else{

			/*user permission for update function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'U');

			/*update data ktp by row ID*/
			$dataktp['updated_date'] = date('Y-m-d H:i:s');
			$dataktp['updated_by'] = $this->session->userdata('data_user')->fullname;
			$this->tr_pegawai->update('ktp',array('ktp_id'=>$ktp_id), $dataktp);

			/*update data pegawai by row ID*/
			$datapegawai['updated_date'] = date('Y-m-d H:i:s');
			$datapegawai['updated_by'] = $this->session->userdata('data_user')->fullname;
			$this->tr_pegawai->update('tr_pegawai',array('pg_id'=>$pg_id), $datapegawai);


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
		$this->tr_pegawai->delete_by_id($id);

		/*show gritter*/
		echo json_encode(array("message" => 'ID ['.$id.'] Deleted success!', "gritter" => 'gritter-success'));

	}

	public function generateNik($tabel){

		$count_row = $this->db->get($tabel)->num_rows();
		$random = mt_rand(1,99999);
		$new_count_field = $count_row + 1;
		$new_id = '99'.$new_count_field.$random;

		return $new_id;
	}


}
