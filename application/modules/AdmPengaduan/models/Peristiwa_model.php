<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peristiwa_model extends CI_Model {

	/*define for this class*/
	var $table = 'mc_pengaduan_peristiwa';
	var $select = 'mc_pengaduan_peristiwa.*';
	var $order = array('mc_pengaduan_peristiwa.updated_date' => 'desc');

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
		if (!empty($params['pgd_id'])) {
			$this->db->where('pgd_id', $params['pgd_id']);
		}
		
		if (!empty($params['search_by'] and $params['keyword'])){
			$this->db->where(''.$params['search_by'].' like', '%'.$params['keyword'].'%');	
		} 
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('pgdpp_id '.$params['sort']);

		/*result query*/
		$data = $this->db->get()->result();

		foreach($data as $row){
			$getdata = array(
				'id' => $row->pgdpp_id,
				'pgd_id' => $row->pgd_id,
				'pgdpp_tgl_kejadian' => $this->tanggal->formatDateTime($row->pgdpp_tgl_kejadian),
				'pgdpp_tempat_kejadian' => $row->pgdpp_tempat_kejadian,
				'pgdpp_perbuatan' => $row->pgdpp_perbuatan,
				'myid' => $row->pgdpp_id,

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
		$this->db->where(''.$this->table.'.pgdpp_id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_by_custom($where)
	{
		$this->_query();
		$this->db->where($where);
		$query = $this->db->get();

		return $query->row();
	}


	public function save($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function update($table, $where, $data)
	{
		$this->db->update($table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where_in('mc_pengaduan_peristiwa.pgdpp_id', $id);
		$this->db->delete('mc_pengaduan_peristiwa');
	}

}
