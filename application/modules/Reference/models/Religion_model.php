<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Religion_model extends CI_Model {

	/*define for this class*/
	var $table = 'm_religion';
	var $select = 'm_religion.*';
	var $order = array('m_religion.religion_id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_data($params)
	{
		$arr_data = array();

		/*query data*/

		$this->db->from('m_religion');
		if (!empty($params['search_by'] and $params['keyword'])){
			$this->db->where(''.$params['search_by'].' like', '%'.$params['keyword'].'%');	
		} 
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('religion_id '.$params['sort']);

		/*result query*/
		$data = $this->db->get()->result();

		foreach($data as $row){
			$getdata = array(
				'id' => $row->religion_id,
				'religion_name' => strtoupper($row->religion_name),
				'active' => $row->active,
				'updated_date' => $row->updated_date?$this->tanggal->formatDateTime($row->updated_date):$this->tanggal->formatDateTime($row->created_date),
				'myid' => $row->religion_id,

				);
			$arr_data[] = $getdata;
		}

		return $arr_data;

	}

	public function total_data($params)
	{
		/*query*/
		$this->db->select("count(*) as total");
		$this->db->from('m_religion');
		if (!empty($params['search_by'] and $params['keyword'])){
			$this->db->where(''.$params['search_by'].' like', '%'.$params['keyword'].'%');	
		} 
		/*total data row*/
		$total = $this->db->get()->row();
		return $total->total;
	} 

	public function get_by_id($id)
	{
		$this->db->select($this->select);
		$this->db->from($this->table);
		$this->db->where(''.$this->table.'.religion_id',$id);
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
		$this->db->where_in(''.$this->table.'.religion_id', $id);
		$this->db->delete($this->table);
	}

}
