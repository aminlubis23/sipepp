<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City_model extends CI_Model {

	/*define for this class*/
	var $table = 'm_city';
	var $select = 'm_city.*,m_province.province_name';
	var $order = array('m_city.city_id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _query(){	
		$this->db->select($this->select);
		$this->db->from($this->table);
		$this->db->join('m_province','m_province.province_id=m_city.province_id','left');
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
		$this->db->order_by('city_id '.$params['sort']);

		/*result query*/
		$data = $this->db->get()->result();

		foreach($data as $row){
			$getdata = array(
				'id' => $row->city_id,
				'city_name' => strtoupper($row->city_name),
				'province_name' => strtoupper($row->province_name),
				'active' => $row->active,
				'updated_date' => $row->updated_date?$this->tanggal->formatDateTime($row->updated_date):$this->tanggal->formatDateTime($row->created_date),
				'myid' => $row->city_id,

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
		$this->db->where(''.$this->table.'.city_id',$id);
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
		$this->db->where_in(''.$this->table.'.city_id', $id);
		$this->db->delete($this->table);
	}

}
