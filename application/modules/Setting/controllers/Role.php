<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

	/*Default title for this module*/
	var $title = 'Role';

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
		$this->load->model('Role_model','role');

		/*
		cek session login
		if session login false than redirect to login else read index
		*/
		if($this->session->userdata('login')==false){
			redirect(base_url().'login');
		}
		/*default breadcrumb*/
		$this->breadcrumbs->push('List roles', 'Setting/'.strtolower(get_class($this)));

	}

	public function index()
	{	
		/*default title*/
		$data['title'] = $this->title;

		/*show default breadcrumbs */
		$data['breadcrumbs'] = $this->breadcrumbs->show();

		/*load index view*/
		$this->load->view('Role/index', $data);

	}

	public function set_permission($id)
	{	
		/*default title*/
		$data['title'] = $this->title;

		/*breadcrumbs set permission*/ 
		$this->breadcrumbs->push('Set Permission Module', 'Setting/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
		$data['breadcrumbs'] = $this->breadcrumbs->show();
		$data['value'] = $this->role->get_by_id($id);
		/*load index view*/
		$this->load->view('Role/form_permission', $data);

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
			$this->breadcrumbs->push('Edit', 'Setting/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);

			/*get data by id*/
			$data['value'] = $this->role->get_by_id($id);

		}else{

			/*user permission for create function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'C');

			/*breadcrumbs add*/
			$this->breadcrumbs->push('Add', 'Setting/'.strtolower(get_class($this)).'/form');

		}

		/*show breadcrumbs view*/
		$data['breadcrumbs'] = $this->breadcrumbs->show();
		
		/*load form view*/
		$this->load->view('Role/form', $data);
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
		$total = $this->role->total_data($params);

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
		$rowData = $this->role->get_data($params);

		/*final result*/
		$data = array();
		$data['totalPages'] = $total_pages;
		$data['page'] = $page;
		$data['records'] = $total;
		$data['rows'] = $rowData;

		echo json_encode($data);
	}

	public function getSubData(){
		
		/* this function for getting sub data from main data which is selected by user */
		$arr_data = array();

		/*post parent row ID*/
		$parent_id = $this->input->post('parent');

		/*query get row data by ID*/
		$data = $this->role->getSubData($parent_id);

		foreach($data as $row){
			$getdata = array(
				'id' => $row->id_menu,
				'name' => $row->name,
				'code' => $row->code,
				'mysubid' => $row->id_menu,
				);
			$arr_data[] = $getdata;
		}

		/*load data by json format*/
		echo json_encode($arr_data);
	}

	
	public function process()
	{
		/*this function is for executing action create or update*/

		/*post ID row*/
		$id_role = $this->regex->_genRegex($this->input->post('id'), 'RGXINT');

		/*transaction begin*/
		$this->db->trans_begin();

		/*post data array*/
		$dataexc = array(
			'role_name' 	=> strtoupper($this->regex->_genRegex($this->input->post('role_name'), 'RGXQSL')),
			'apps_id' 	=> strtoupper($this->regex->_genRegex($this->input->post('apps'), 'RGXINT')),
			'active' 		=> $this->regex->_genRegex($this->input->post('active'), 'RGXAZ'),
		);
		
		/*if row ID not null then insert new data else update data by row ID*/
		if( $id_role == 0 ){

			/*user permission for create function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'C');

			/*insert new data*/
			$dataexc['created_date'] = date('Y-m-d H:i:s');
			$dataexc['created_by'] = $this->session->userdata('data_user')->fullname;
			$this->role->save($dataexc);

		}else{

			/*user permission for update function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'U');

			/*update data by row ID*/
			$dataexc['updated_date'] = date('Y-m-d H:i:s');
			$dataexc['updated_by'] = $this->session->userdata('data_user')->fullname;
			$this->role->update(array('id_role'=>$id_role), $dataexc);

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

	public function processSetPermission()
	{
		/*this function is for executing action create or update*/

		/*post ID row*/
		$id_role = $this->regex->_genRegex($this->input->post('id'), 'RGXINT');

		/*transaction begin*/
		$this->db->trans_begin();

		// delete all field by id_role
		$this->db->delete('t_menu_role', array('id_role'=>$id_role));

		$post_chk = $this->input->post('chk');

		if($post_chk){

			foreach ($post_chk as $key => $value) {

				$explode_post = explode('-', $value);
				$id_menu = $explode_post[0];
				$code = $explode_post[1];

				// cek main menu //
				$check_main_menu = $this->db->get_where('m_menu', array('id_menu'=>$id_menu))->row();

				if($check_main_menu->parent_menu != 0){

					// cek t_menu_role by main_menu id
					$check_menu_role_exist = $this->db->get_where('t_menu_role', array('id_menu'=>$check_main_menu->parent_menu, 'id_role'=>$id_role))->row();

					if(empty($check_menu_role_exist)){
						
						// jika tidak ada main menu maka insert 
						$main_menu = array(
							'id_role' => $id_role,
							'id_menu' => $check_main_menu->parent_menu,
							'code' => $code,
						);	

						$this->db->insert('t_menu_role', $main_menu);
					}
				}

				$result_explode = array(
					'id_role' => $id_role,
					'id_menu' => $id_menu,
					'code' => $code,
					);

				$this->db->insert('t_menu_role', $result_explode);

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
		$this->role->delete_by_id($id);

		/*show gritter*/
		echo json_encode(array("message" => 'ID ['.$id.'] Deleted success!', "gritter" => 'gritter-success'));

	}

	public function processDeleteSubData()
	{
		/*this function is for deleteing row by id*/
		$id = $this->input->post('ID');

		/*user permission for delete function*/
		$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'D');

		/*delete row*/
		$this->role->delete_sub_by_id($id);

		/*show gritter*/
		echo json_encode(array("message" => 'ID ['.$id.'] Deleted success!', "gritter" => 'gritter-success'));

	}


}
