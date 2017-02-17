<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bukti_model extends CI_Model {

	/*define for this class*/
	var $table = 'mc_pengaduan_bukti';
	var $select = 'mc_pengaduan_bukti.*';
	var $order = array('mc_pengaduan_bukti.updated_date' => 'desc');

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
		$this->db->order_by('pgdb_id '.$params['sort']);

		/*result query*/
		$data = $this->db->get()->result();

		foreach($data as $row){
			$getdata = array(
				'id' => $row->pgdb_id,
				'pgd_id' => $row->pgd_id,
				'pgdb_keterangan' => $row->pgdb_keterangan,
				'pgdb_nama_file' => $this->upload_file->getUploadedFile(array('ref_id'=>$row->pgdb_id,'ref_table'=>'mc_pengaduan_bukti'), 'html', 'uploaded_files/bukti/'),
				'myid' => $row->pgdb_id,

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
		if (!empty($params['pgd_id'])) {
			$this->db->where('pgd_id', $params['pgd_id']);
		}
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
		$this->db->where(''.$this->table.'.pgdb_id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	/*public function get_by_custom($where)
	{
		$this->_query();
		$this->db->where($where);
		$query = $this->db->get();

		return $query->row();
	}*/

	public function get_by_pgd_id($pgd_id)
	{
		$this->db->select('(SELECT attc_fullpath FROM tr_attachment WHERE ref_id=mc_pengaduan_bukti.pgdb_id AND ref_table="mc_pengaduan_bukti") AS fullpath');
		$this->_query();
		$this->db->where('pgd_id', $pgd_id);
		$query = $this->db->get();

		return $query->result();
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
		$data_exist = $this->db->where(array('ref_id' => $id, 'ref_table' => 'mc_pengaduan_bukti'))->get('tr_attachment')->result();
		foreach ($data_exist as $key => $value) {
			if (file_exists($value->attc_fullpath)) {
				unlink($value->attc_fullpath);
			}
		}

		$this->db->where_in('mc_pengaduan_bukti.pgdb_id', $id);
		$this->db->delete('mc_pengaduan_bukti');

		
		
	}

}
