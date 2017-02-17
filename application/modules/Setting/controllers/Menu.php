<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	/*Default title for this module*/
	var $title = 'Menu';

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
		$this->load->model('Menu_model','menu');

		/*
		cek session login
		if session login false than redirect to login else read index
		*/
		if($this->session->userdata('login')==false){
			redirect(base_url().'login');
		}
		/*default breadcrumb*/
		$this->breadcrumbs->push('List menus', 'Setting/'.strtolower(get_class($this)));

	}

	public function index()
	{	
		/*default title*/
		$data['title'] = $this->title;

		/*show default breadcrumbs */
		$data['breadcrumbs'] = $this->breadcrumbs->show();

		/*load index view*/
		$this->load->view('Menu/index', $data);

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
			$data['value'] = $this->menu->get_by_id($id);

		}else{

			/*user permission for create function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'C');

			/*breadcrumbs add*/
			$this->breadcrumbs->push('Add', 'Setting/'.strtolower(get_class($this)).'/form');

		}

		/*show breadcrumbs view*/
		$data['breadcrumbs'] = $this->breadcrumbs->show();
		
		/*load form view*/
		$this->load->view('Menu/form', $data);
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
		$total = $this->menu->total_data($params);

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
		$rowData = $this->menu->get_data($params);

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
		$data = $this->menu->getSubData($parent_id);

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
		$id_menu = $this->regex->_genRegex($this->input->post('id'), 'RGXINT');

		/*transaction begin*/
		$this->db->trans_begin();

		/*post data array*/
		$dataexc = array(
			'name' => $this->regex->_genRegex($this->input->post('name'), 'RGXQSL'),
			'class' => $this->regex->_genRegex($this->input->post('class'), 'RGXQSL'),
			'link' => $this->regex->_genRegex($this->input->post('link'), 'RGXQSL'),
			'icon' => $this->regex->_genRegex($this->input->post('icon'), 'RGXQSL'),
			'parent_menu' => $this->regex->_genRegex($this->input->post('parent_menu'), 'RGXINT'),
			'apps_id' => $this->regex->_genRegex($this->input->post('apps_id'), 'RGXINT'),
			'counter' => $this->regex->_genRegex($this->input->post('counter'), 'RGXINT'),
			'description' => $this->regex->_genRegex($this->input->post('description'), 'RGXQSL'),
			'active' => $this->regex->_genRegex($this->input->post('active'), 'RGXAZ'),
			'set_shortcut' => $this->regex->_genRegex($this->input->post('set_shortcut'), 'RGXAZ'),
			'set_notif' => $this->regex->_genRegex($this->input->post('set_notif'), 'RGXAZ'),
		);
		
		/*if row ID not null then insert new data else update data by row ID*/
		if( $id_menu == 0 ){

			/*user permission for create function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'C');

			/*insert new data*/
			$dataexc['created_date'] = date('Y-m-d H:i:s');
			$dataexc['created_by'] = $this->session->userdata('data_user')->fullname;
			$this->menu->save($dataexc);

		}else{

			/*user permission for update function*/
			$this->authuser->get_auth_action_user(strtolower(get_class($this)), 'U');

			/*update data by row ID*/
			$dataexc['updated_date'] = date('Y-m-d H:i:s');
			$dataexc['updated_by'] = $this->session->userdata('data_user')->fullname;
			$this->menu->update(array('id_menu'=>$id_menu), $dataexc);

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
		$this->menu->delete_by_id($id);

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
		$this->menu->delete_sub_by_id($id);

		/*show gritter*/
		echo json_encode(array("message" => 'ID ['.$id.'] Deleted success!', "gritter" => 'gritter-success'));

	}


}
