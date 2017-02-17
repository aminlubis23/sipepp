<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attachment_model extends CI_Model {

	/*define for this class*/
	var $table = 'tr_attachment';
	var $select = 'tr_attachment.*';
	var $order = array('tr_attachment.attc_id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _query(){	
		$this->db->select($this->select);
		$this->db->from($this->table);
	}

	public function get_data($params)
	{
		$arr_data = array();

		/*query data*/
		$this->_query();
		
		if (!empty($params['search_by'] and $params['keyword'])){
			$this->db->where(''.$params['search_by'].' like', '%'.$params['keyword'].'%');	
		} 
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('attc_id '.$params['sort']);

		/*result query*/
		$data = $this->db->get()->result();

		foreach($data as $row){
			$getdata = array(
				'id' => $row->attc_id,
				'ref_id' => $row->ref_id,
				'ref_table' => $row->ref_table,
				'attc_owner' => $row->attc_owner,
				'attc_name' => $row->attc_name,
				'attc_path' => $row->attc_path,
				'attc_fullpath' => '<a href="'.base_url().$row->attc_fullpath.'" target="_blank">'.$row->attc_fullpath.'</a>',
				'attc_type' => $row->attc_type,
				'attc_size' => $row->attc_size,
				'flag' => $row->flag,
				'created_date' => $row->created_date?$this->tanggal->formatDateTime($row->created_date):'',
				'myid' => $row->attc_id,

				);
			$arr_data[] = $getdata;
		}

		return $arr_data;

	}

	public function total_data($params)
	{
		/*query*/
		$this->db->select("count(*) as total");
		$this->_query();
		if (!empty($params['search_by'] and $params['keyword'])){
			$this->db->where(''.$params['search_by'].' like', '%'.$params['keyword'].'%');	
		} 
		/*total data row*/
		$total = $this->db->get()->row();
		return $total->total;
	} 

	public function get_by_id($id)
	{
		$this->_query();
		$this->db->where(''.$this->table.'.attc_id',$id);
		$query = $this->db->get();

		return $query->row();
	}


	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$data_exist = $this->db->where(array('attc_id' => $id))->get('tr_attachment')->result();
		foreach ($data_exist as $key => $value) {
			if (file_exists($value->attc_fullpath)) {
				unlink($value->attc_fullpath);
			}
		}
		$this->db->where_in(''.$this->table.'.attc_id', $id);
		$this->db->delete($this->table);
	}

}
