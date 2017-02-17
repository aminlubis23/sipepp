<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komisioner_model extends CI_Model {

	/*define for this class*/
	var $table = 'vw_komisioner';
	var $select = 'vw_komisioner.*';
	var $order = array('vw_komisioner.komisioner_id' => 'desc');

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
		$this->db->order_by('komisioner_id '.$params['sort']);

		/*result query*/
		$data = $this->db->get()->result();

		foreach($data as $row){
			$getdata = array(
				'id' => $row->komisioner_id,
				'ktp_nama_lengkap' => strtoupper($row->ktp_nama_lengkap),
				'awal_jabatan' => $this->tanggal->formatDate($row->awal_jabatan),
				'akhir_jabatan' => $this->tanggal->formatDate($row->akhir_jabatan),
				'active' => $row->active,
				'updated_date' => $row->updated_date?$this->tanggal->formatDateTime($row->updated_date):$this->tanggal->formatDateTime($row->created_date),
				'myid' => $row->komisioner_id,

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
		$this->db->where(''.$this->table.'.komisioner_id',$id);
		$query = $this->db->get();

		return $query->row();
	}


	public function save($data)
	{
		$this->db->insert('tr_komisioner', $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update('tr_komisioner', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where_in('komisioner_id', $id);
		$this->db->delete('tr_komisioner');
	}

}
