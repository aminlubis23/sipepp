<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('tanggal');
		$this->load->library('regex');
		$this->load->model('pengaturan/faq_model','faq');
		if($this->session->userdata('login')==false){
			redirect(base_url().'login');
		}

	}

	public function index()
	{
		
		$data['title'] = "Pengaturan Faq";
		$data['subtitle'] = "Daftar Faq";
		$this->load->view('faq/index', $data);
	}

	public function form($id='')
	{
		
		$data['title'] = "Form Faq";
		$data['subtitle'] = "";
		if( $id != '' ){
			$data['value'] = $this->faq->get_by_id($id);
		}
		//print_r($data);die;
		$this->load->view('faq/form', $data);
	}

	public function ajax_list()
	{
		$list = $this->faq->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $faq) {
			$no++;
			$row = array();
			$row[] = '<label class="pos-rel">
						<input type="checkbox" class="ace" />
						<span class="lbl"></span>
					</label>';
			$row[] = $faq->faq_title;
			$row[] = $faq->faq_description;
			$row[] = strtoupper($faq->faq_flag);

			//add html for action
			$row[] = '<a class="btn btn-xs btn-success" href="javascript:void()" title="Edit" onclick="edit('."'".$this->regex->_genRegex($faq->faq_id,'RGXINT')."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void()" title="Delete" onclick="delete_faq('."'".$this->regex->_genRegex($faq->faq_id,'RGXINT')."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->faq->count_all(),
						"recordsFiltered" => $this->faq->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_add()
	{
		$faq_id = $this->regex->_genRegex($this->input->post('id'), 'RGXINT');

		$this->db->trans_begin();
		$dataexc = array(
			'faq_title' => $this->regex->_genRegex($this->input->post('faq_title'), 'RGXQSL'),
			'faq_description' => $this->regex->_genRegex($this->input->post('faq_description'), 'RGXQSL'),
			'faq_flag' => $this->regex->_genRegex($this->input->post('faq_flag'), 'RGXQSL'),
			'active' => $this->regex->_genRegex($this->input->post('active'), 'RGXAZ'),
			'updated_by' => '',
			'updated_date' => date('Y-m-d H:i:s')
		);
		
		if( $faq_id == 0 ){
			$this->faq->save($dataexc);
		}else{
			$this->faq->update(array('faq_id'=>$faq_id), $dataexc);
		}


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

	public function ajax_delete($id)
	{
		$this->faq->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	
}
