<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Para_pihak_model extends CI_Model {

	/*define for this class*/
	var $table = 'vw_pegawai';
	var $select = 'vw_pegawai.*';
	var $order = array('vw_pegawai.pg_id' => 'desc');

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
		$this->db->order_by('pg_id '.$params['sort']);

		/*result query*/
		$data = $this->db->get()->result();

		foreach($data as $row){
			$getdata = array(
				'id' => $row->pg_id,
				'ktp_nama_lengkap' => strtoupper($row->ktp_nama_lengkap),
				'pg_nip' => strtoupper($row->pg_nip),
				'jabatan_name' => $row->jabatan_name,
				'pg_no_hp' => $row->pg_no_hp,
				'pg_email' => $row->pg_email,
				'active' => $row->tr_pegawai_active,
				'myid' => $row->pg_id,

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
		$this->db->where(''.$this->table.'.pg_id',$id);
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
		$this->db->where_in('tr_pegawai.pg_id', $id);
		$this->db->delete('tr_pegawai');
	}

}
