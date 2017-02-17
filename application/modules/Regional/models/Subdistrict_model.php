<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subdistrict_model extends CI_Model {

	/*define for this class*/
	var $table = 'm_subdistrict';
	var $select = 'm_subdistrict.*,m_district.district_name, m_district.district_id,m_district.city_id,m_city.city_name,m_province.province_name,m_city.province_id';
	var $order = array('m_subdistrict.subdistrict_id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _query(){	
		$this->db->select($this->select);
		$this->db->from($this->table);
		$this->db->join('m_district','m_district.district_id=m_subdistrict.district_id','left');
		$this->db->join('m_city','m_city.city_id=m_district.city_id','left');
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
		$this->db->order_by('subdistrict_id '.$params['sort']);

		/*result query*/
		$data = $this->db->get()->result();

		foreach($data as $row){
			$getdata = array(
				'id' => $row->subdistrict_id,
				'subdistrict_name' => strtoupper($row->subdistrict_name),
				'district_name' => strtoupper($row->district_name),
				'city_name' => strtoupper($row->city_name),
				'province_name' => strtoupper($row->province_name),
				'active' => $row->active,
				'updated_date' => $row->updated_date?$this->tanggal->formatDateTime($row->updated_date):$this->tanggal->formatDateTime($row->created_date),
				'myid' => $row->subdistrict_id,

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
		$this->db->where(''.$this->table.'.subdistrict_id',$id);
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
		$this->db->where_in(''.$this->table.'.subdistrict_id', $id);
		$this->db->delete($this->table);
	}

}
