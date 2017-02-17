<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq_model extends CI_Model {

	var $table = 'm_faq';
	var $column = array('m_faq.faq_title','m_faq.faq_description','m_faq.faq_flag','m_faq.active','m_faq.updated_date');
	var $select = 'm_faq.faq_id, m_faq.faq_title, m_faq.faq_description,m_faq.faq_flag ,m_faq.active, m_faq.updated_date';

	var $order = array('m_faq.faq_id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->select($this->select);
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if(isset($_POST['search']['value']))
				($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
			$column[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->select($this->select);
		$this->db->from($this->table);
		$this->db->where(''.$this->table.'.faq_id',$id);
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
		$this->db->where(''.$this->table.'.faq_id', $id);
		$this->db->delete($this->table);
	}


}
