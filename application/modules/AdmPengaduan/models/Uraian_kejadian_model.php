<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uraian_kejadian_model extends CI_Model {

	/*define for this class*/
	var $table = 'mc_pengaduan_uraian';
	var $select = 'mc_pengaduan_uraian.*';
	var $order = array('mc_pengaduan_uraian.updated_date' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _query(){	
		$this->db->select($this->select);
		$this->db->from($this->table);
	}

	public function get_by_id($id)
	{
		$this->_query();
		$this->db->where(''.$this->table.'.pgdu_id',$id);
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
		$this->db->where_in('mc_pengaduan_uraian.pgdu_id', $id);
		$this->db->delete('mc_pengaduan_uraian');
	}

}
