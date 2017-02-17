<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pp_model extends CI_Model {

	/*define for this class*/
	var $table = 'vw_para_pihak';
	var $select = 'vw_para_pihak.*';
	var $order = array('vw_para_pihak.updated_date' => 'desc');

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
		$this->db->order_by('prp_id '.$params['sort']);

		/*result query*/
		$data = $this->db->get()->result();

		foreach($data as $row){
			$getdata = array(
				'id' => $row->prp_id,
				'pgd_id' => $row->pgd_id,
				'ktp_nama_lengkap' => strtoupper($row->ktp_nama_lengkap),
				'ktp_nik' => strtoupper($row->ktp_nik),
				'prp_no_hp' => $row->prp_no_hp,
				'prp_penyelenggara' => $row->prp_penyelenggara,
				'prp_organisasi' => $row->prp_organisasi,
				'prp_email' => $row->prp_email,
				'flag' => strtoupper($row->flag),
				'myid' => $row->prp_id,

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
		$this->db->where(''.$this->table.'.prp_id',$id);
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
		$this->db->where_in('tr_para_pihak.prp_id', $id);
		$this->db->delete('tr_para_pihak');
	}

	function findData($key)
	{
	    $data = array();
	    $this->db->from('ktp');
	    $this->db->like('ktp_nik', ''.$key.'')->or_like('ktp_nama_lengkap', ''.$key.'');
	    $value = $this->db->get();
	    //print_r($this->db->last_query());die;
	    $data['count'] = $value->num_rows();
	    $data['result'] = $value->result();
	    return $data;
	}

	function getDataFromNik($count, $data){

	$tpl = '';
    $tpl .= '<i><b>'.$count.' data ditemukan dari hasil pencarian</b></i>
            <table id="" class="table table-condensed dataTable no-footer">
              <thead>
                <tr style="background-color:grey;color:white">
                  <th width="20px" data-hide="phone,tablet"><b>NO<b></th>
                  <th width="200px" data-hide="phone,tablet"><b>NO IDENTITAS<b></th>
                  <th width="200px" data-hide="phone,tablet"><b>NAMA LENGKAP</b></th>
                  <th width="200px" data-hide="phone,tablet"><b>TEMPAT, TANGGAL LAHIR</b></th>
                  <th width="200px" data-hide="phone,tablet"><b>JK</b></th>
                  <th width="350px" data-hide="phone,tablet"><b>ALAMAT</b></th>
                  <th width="70px">DETIL</th>
                </tr>
              </thead>
              <tbody>';
              $no = 1;
              foreach($data as $row){
                $tpl .= '
                  <tr>
                    <td><b>'.$no.'</b></td>
                    <td>'.$row->ktp_nik.'</td>
                    <td>'.$row->ktp_nama_lengkap.'</td>
                    <td>'.$row->ktp_tempat_lahir.','.$this->tanggal->formatDate($row->ktp_tanggal_lahir).'</td>
                    <td>'.$row->ktp_jk.'</td>
                    <td>'.$row->ktp_alamat.'</td>
                    <th width="70px"><a rel="'.$row->ktp_nik.'" onclick="showDetil('."'".$row->ktp_nik."'".')" class="label label-success"><i class="fa fa-arrow-circle-down"></i></a></th>
                  </tr>
                ';
                $no++;
              }
    $tpl .= '</tbody>
          </table>
          <hr>';

    return $tpl;

  }

  function findDetilFromNik($nik)
  {
    return $this->db->get_where('vw_ktp', array('ktp_nik'=>$nik))->row();
  }


}
