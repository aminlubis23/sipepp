<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	/*define for this class*/
	var $table = 'm_user';
	var $select = 'm_user.*,m_apps.apps_name,m_role.role_name,m_role.apps_id';
	var $order = array('m_user.id_user' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _query(){

		$this->db->select($this->select);
		$this->db->from($this->table);
		$this->db->join('m_role', 'm_role.id_role=m_user.id_role','left');
		$this->db->join('m_apps', 'm_apps.apps_id=m_role.apps_id','left');

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
		$this->db->order_by('id_user '.$params['sort']);

		/*result query*/
		$data = $this->db->get()->result();

		foreach($data as $row){
			$getdata = array(
				'id' => $row->id_user,
				'code' => $row->kode_user,
				'email' => $row->email,
				'fullname' => $row->fullname,
				'role_name' => $row->role_name,
				'apps_name' => $row->apps_name,
				'active' => $row->active,
				'updated_date' => $row->updated_date?$this->tanggal->formatDateTime($row->updated_date):$this->tanggal->formatDateTime($row->created_date),
				'myid2' => $row->id_user,
				'myid' => $row->id_user,

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
		$this->db->where(''.$this->table.'.id_user',$id);
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
		$this->db->where_in(''.$this->table.'.id_user', $id);
		$this->db->delete($this->table);
	}

	public function generate_user_code($params)
	{
		/*total string fullname*/
		$str_name = strlen($params['fullname']);
		/*get max row id*/
		$max_row_id = $this->db->get('m_user')->num_rows();
		/*id_role - total_string_fullname - max_row_id*/
		$generate_code = $params['id_role'].$str_name.$max_row_id+1;
		return $generate_code;
	}

}
