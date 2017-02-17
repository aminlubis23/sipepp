<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tr_pp extends CI_Controller {

	/*Default title for this module*/
	var $title = 'Para Pihak';

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
		$this->load->model('Pp_model','para_pihak');
		$this->load->model('Registrasi_model','registrasi');

		/*
		cek session login
		if session login false than redirect to login else read index
		*/
		if($this->session->userdata('login')==false){
			redirect(base_url().'login');
		}
		/*default breadcrumb*/
		$this->breadcrumbs->push('Daftar Para Pihak', 'AdmPengaduan/'.strtolower(get_class($this)));

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
		$this->load->view('Tr_pp/index', $data);

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
			$data['value'] = $this->para_pihak->get_by_id($id);

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
		$this->load->view('Tr_pp/form', $data);
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
		$total = $this->para_pihak->total_data($params);

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
		$rowData = $this->para_pihak->get_data($params);

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
		$prp_id = $this->regex->_genRegex($this->input->post('prp_id'), 'RGXINT');
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
		
		$dataparapihak = array(
			'pgd_id' => $this->regex->_genRegex($this->input->post('pgd_id'), 'RGXQSL'),
			'ktp_nik' => $this->regex->_genRegex($nik, 'RGXQSL'),
			'prp_no_telp_rumah' => $this->regex->_genRegex($this->input->post('prp_no_telp_rumah'), 'RGXQSL'),
			'prp_no_telp_kantor' => $this->regex->_genRegex($this->input->post('prp_no_telp_kantor'), 'RGXQSL'),
			'prp_no_hp' => $this->regex->_genRegex($this->input->post('prp_no_hp'), 'RGXQSL'),
			'prp_fax' => $this->regex->_genRegex($this->input->post('prp_fax'), 'RGXQSL'),
			'prp_email' => $this->regex->_genRegex($this->input->post('prp_email'), 'RGXQSL'),
			'prp_kode_pos' => $this->regex->_genRegex($this->input->post('prp_kode_pos'), 'RGXQSL'),
			'prp_penyelenggara' => $this->regex->_genRegex($this->input->post('prp_penyelenggara'), 'RGXQSL'),
			'flag' => $this->regex->_genRegex($this->input->post('flag'), 'RGXQSL'),
		);

		/*jika pihak bersangkutan merupakan penyelengara pemilu maka field yang diinput sebagai berikut*/
		if($this->input->post('prp_penyelenggara') == 'ya'){
			$dataparapihak['prp_organisasi'] = $this->regex->_genRegex($this->input->post('prp_organisasi'), 'RGXQSL');
			$dataparapihak['pp_id'] = $this->regex->_genRegex($this->input->post('pnylgra_id'), 'RGXINT');
			$dataparapihak['pp_jbp_id'] = $this->regex->_genRegex($this->input->post('jbp_id'), 'RGXINT');
			$dataparapihak['pp_province_id'] = $this->regex->_genRegex($this->input->post('province_id_pp'), 'RGXINT');
			$dataparapihak['pp_city_id'] = $this->regex->_genRegex($this->input->post('city_id_pp'), 'RGXINT');
			/*set NULL if penyelenggara*/
			$dataparapihak['prp_alamat_org'] = NULL;
			$dataparapihak['kpd_id'] = NULL;
			$dataparapihak['parpol_id'] = NULL;
		}else{
			
			$dataparapihak['prp_organisasi'] = $this->regex->_genRegex($this->input->post('prp_organisasi_notpp'), 'RGXQSL');
			/*then set null if not penyelenggara*/
			$dataparapihak['pp_id'] = NULL;
			$dataparapihak['pp_jbp_id'] = NULL;
			$dataparapihak['pp_province_id'] = NULL;
			$dataparapihak['pp_city_id'] = NULL;

			$dataparapihak['prp_alamat_org'] = $this->regex->_genRegex($this->input->post('prp_alamat_org'), 'RGXQSL');
			$dataparapihak['kpd_id'] = $this->regex->_genRegex($this->input->post('kpd_id'), 'RGXINT');
			$dataparapihak['parpol_id'] = $this->regex->_genRegex($this->input->post('parpol_id'), 'RGXINT');
		}

		/*if row ID not null then insert new data else update data by row ID*/
		if( $ktp_id == 0 ){

			/*user permission for create function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'C');

			/*insert new data ktp*/
			$dataktp['created_date'] = date('Y-m-d H:i:s');
			$dataktp['created_by'] = $this->session->userdata('data_user')->fullname;
			$last_ktp_id = $this->para_pihak->save('ktp', $dataktp);

			/*insert new data para pihak*/
			$dataparapihak['created_date'] = date('Y-m-d H:i:s');
			$dataparapihak['created_by'] = $this->session->userdata('data_user')->fullname;
			$last_pg_id = $this->para_pihak->save('tr_para_pihak', $dataparapihak);

		}else{

			/*user permission for update function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'U');

			/*update data ktp by row ID*/
			$dataktp['updated_date'] = date('Y-m-d H:i:s');
			$dataktp['updated_by'] = $this->session->userdata('data_user')->fullname;
			$this->para_pihak->update('ktp',array('ktp_id'=>$ktp_id), $dataktp);

			/*check para pihak by nik*/
			$existing = $this->para_pihak->get_by_custom(array('ktp_nik'=>$nik));

			/*if existing para pihak then insert*/
			if(empty($existing)){
				/*insert new data para pihak*/
				$dataparapihak['created_date'] = date('Y-m-d H:i:s');
				$dataparapihak['created_by'] = $this->session->userdata('data_user')->fullname;
				$last_pg_id = $this->para_pihak->save('tr_para_pihak', $dataparapihak);
			/*else update data para pihak*/
			}else{
				/*update data para pihak existing*/
				$dataparapihak['updated_date'] = date('Y-m-d H:i:s');
				$dataparapihak['updated_by'] = $this->session->userdata('data_user')->fullname;
				$this->para_pihak->update('tr_para_pihak',array('prp_id'=>$prp_id), $dataparapihak);
			}
			
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
		$this->para_pihak->delete_by_id($id);

		/*show gritter*/
		echo json_encode(array("message" => 'ID ['.$id.'] Deleted success!', "gritter" => 'gritter-success'));

	}

	public function generateNik($tabel)
	{

		$count_row = $this->db->get($tabel)->num_rows();
		$random = mt_rand(1,99999);
		$new_count_field = $count_row + 1;
		$new_id = '99'.$new_count_field.$random;

		return $new_id;
	}

	public function findData()
	{

		$keyword_search = $this->input->post('keyword_search');

		$data = $this->para_pihak->findData($keyword_search);

		if($data['count'] > 0){
			echo $this->para_pihak->getDataFromNik(count($data['result']), $data['result']);
		}else{
			echo '<span style="color:red">-Tidak ada data ditemukan-</span>';
		}

	}

	public function findDetilFromNik()
	{
		$nik = $this->input->post('nik');
		$result = $this->para_pihak->findDetilFromNik($nik);
		echo json_encode($result);
	}


}
