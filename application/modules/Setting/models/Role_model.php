<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {

	/*define for this class*/
	var $table = 'm_role';
	var $column = array('m_role.role_name','m_apps.apps_name','m_role.active','m_role.updated_date');
	var $select = 'm_role.*,m_apps.apps_name';
	var $order = array('m_role.id_role' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _query(){
		$this->db->select($this->select);
		$this->db->from($this->table);
		$this->db->join('m_apps','m_apps.apps_id=m_role.apps_id','left');
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
		$this->db->order_by('id_role '.$params['sort']);

		/*result query*/
		$data = $this->db->get()->result();

		foreach($data as $row){
			$getdata = array(
				'id' => $row->id_role,
				'name' => $row->role_name,
				'apps_name' => $row->apps_name,
				'active' => $row->active,
				'updated_date' => $row->updated_date?$this->tanggal->formatDateTime($row->updated_date):$this->tanggal->formatDateTime($row->created_date),
				'myid2' => $row->id_role,
				'myid' => $row->id_role,

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
		$this->db->where(''.$this->table.'.id_role',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function getSubData($id)
	{
		$query = 'SELECT m_menu.id_menu,m_menu.name, 
					(SELECT GROUP_CONCAT(CODE SEPARATOR ",") 
					FROM t_menu_role a
					WHERE a.id_role=b.id_role 
					AND a.`id_menu`=b.id_menu) AS code
					FROM t_menu_role b
					LEFT JOIN m_menu ON m_menu.`id_menu`=b.`id_menu`
					WHERE id_role='.$id.'
					GROUP BY b.id_menu';

		$result = $this->db->query($query);

		return $result->result();
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
		$this->db->where_in(''.$this->table.'.id_role', $id);
		$this->db->delete($this->table);
	}

	public function delete_sub_by_id($id)
	{
		$this->db->where_in('t_menu_role.id_menu', $id);
		$this->db->delete('t_menu_role');
	}
	
	public function get_checked_form($id_menu, $id_role, $code)
	{
		$data = $this->db->get_where('t_menu_role', array('id_menu'=>$id_menu, 'id_role'=>$id_role, 'code'=>$code));
		if($data->num_rows() > 0 ){
			return 'checked';
		}else{
			return false;
		}
	}

	public function get_menu_role_by_id($id)
	{
		$this->db->from('t_menu_role');
		$this->db->where('t_menu_role.id_role',$id);
		$query = $this->db->get();

		return $query->row();
	}


}
