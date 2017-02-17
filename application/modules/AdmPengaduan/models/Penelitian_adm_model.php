<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penelitian_adm_model extends CI_Model {

	/*define for this class*/
	var $table = 'vw_pengaduan';
	var $select = 'vw_pengaduan.*';
	var $order = array('vw_pengaduan.pgd_tanggal' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _query($params){	

		$this->db->select($this->select);
		$this->db->from($this->table);

		/*search data subgrid if send parameters*/
		if (!empty($params['search_by'] and $params['keyword'])){
			if(in_array($params['search_by'], array('ktp_nama_lengkap','ktp_nik','prp_no_hp','prp_email'))){
				$this->db->select('(SELECT COUNT(prp_id) as total FROM vw_para_pihak WHERE '.$params['search_by'].' LIKE '."'%".$params['keyword']."%'".') as exist');
				$this->db->where('pgd_id IN (SELECT pgd_id FROM vw_para_pihak WHERE '.$params['search_by'].' LIKE '."'%".$params['keyword']."%'".')');
			}
		}

		if (!empty($params['search_by'] and $params['keyword'])){
			if(in_array($params['search_by'], array('pgd_tahun','pgd_id','pgd_tempat','tp_name'))){
				$this->db->where(''.$params['search_by'].' like', '%'.$params['keyword'].'%');	
			}
		}
		
		/*if isset get*/
		if(!empty($params['type'])){
			$this->db->where('last_proses > 2');
		}else{
			$this->db->where('last_proses', 2);
		}

		
	}

	public function get_data($params)
	{
		$arr_data = array();

		/*query data*/
		$this->_query($params);
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('pgd_tanggal', 'DESC');

		/*result query*/
		$data = $this->db->get()->result();
		//print_r($this->db->last_query());die;
		foreach($data as $row){
			
			$status = $this->getStatusPengaduan($row->pgd_id);

			$getdata = array(
				'id' => $this->apps->formatNoReg($row->pgd_id),
				'pgd_tempat' => $row->pgd_tempat,
				'pgd_tanggal' => $this->tanggal->formatDate($row->pgd_tanggal),
				'tp_name' => $row->tp_name,
				'kp_name' => $row->kp_name,
				'status' => '<i>'.$status.'</i>',
				'updated_date' => $row->updated_date?$this->tanggal->formatDateTime($row->updated_date):$this->tanggal->formatDateTime($row->created_date),
				'myid2' => $row->pgd_id,
				'myid' => $row->pgd_id,
				'exist' => isset($row->exist)?$row->exist:0,
				/*data hasil penelitian adm*/
				'pgdhpa_id' => $row->pgdhpa_id,
				'pgd_no' => $row->pgd_no,
				'pgdhpa_tanggal_penelitian' => $this->tanggal->formatDate($row->pgdhpa_tanggal_penelitian),
				'pgdhpa_kesimpulan' => ($row->pgdhpa_kesimpulan==1)?'Memenuhi Syarat':'Belum Memenuhi Syarat',
				'pgdhpa_pokok_pengaduan' => $row->pgdhpa_pokok_pengaduan,
				'pgdhpa_keterangan' => $row->pgdhpa_keterangan,
				'pgdhpa_kelengkapan_form' => ($row->pgdhpa_kelengkapan_form=='lengkap')?'<i class="fa fa-check green"></i>':'<i class="fa fa-times red"></i>',
				'penerima_pengaduan' => $row->penerima_pengaduan,
				'verifikator' => $row->verifikator,

				);
			$arr_data[] = $getdata;
		}

		return $arr_data;

	}

	public function total_data($params)
	{
		/*query*/
		$this->db->select("count(*) as total");
		$this->_query($params);
		
		/*total data row*/
		$total = $this->db->get()->row();
		return $total->total;
	} 

	public function get_by_id($id)
	{
		$this->db->from('mc_pengaduan_hasil_penelitian_adm');
		$this->db->where('mc_pengaduan_hasil_penelitian_adm.pgd_id',$id);
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

	public function delete_by_id($table,$id)
	{
		$this->db->where_in(''.$table.'.pgd_id', $id);
		$this->db->delete($table);
	}

	public function getParaPihak($params){
		$pp = $this->db->get_where('vw_para_pihak', $params)->result();
		$html = '';
		if(!empty($pp)){
			foreach ($pp as $key => $value) {
				$html .= '- '.$value->ktp_nama_lengkap.'<br>';
			}
		}
		return $html;
	}

	public function getStatusPengaduan($id){
		$pp = $this->db->join('mst_alur_pengaduan','mst_alur_pengaduan.ap_id=mc_pengaduan_proses.ap_id','left')->order_by('mc_pengaduan_proses.ap_id', 'DESC')->get_where('mc_pengaduan_proses', array('pgd_id'=>$id) )->row();
		return $pp->ap_name;
	}

	public function getNoRegistrasi(){

		$kp_id = isset($_POST['kp_id'])?$_POST['kp_id']:0;
		$tp_id = isset($_POST['tp_id'])?$_POST['kp_id']:0;
		$count_row = $this->db->get('mc_pengaduan')->num_rows();
		$random = mt_rand(1,999);
		$new_count_field = $count_row + 1;
		$no_registrasi = $kp_id.$tp_id.$new_count_field.$random;

		return $no_registrasi;
	}

	public function updateStatusProses($pgd_id, $ap_id)
	{
	    $data = array(
	      'pgd_id' => $pgd_id,
	      'ap_id' => $ap_id,
	      'created_date' => date('Y-m-d'),
	      'created_by' => $this->session->userdata('data_user')->fullname,
	      );

	    $this->db->insert('mc_pengaduan_proses', $data);

	    return true;
	}

	/*auto insert lampiran pengaduan form 1-4*/
	public function auto_insert_lampiran_pengaduan($pgd_id)
	{
		return true;
	}

}
