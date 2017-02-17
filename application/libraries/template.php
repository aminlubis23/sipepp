<?php
/**
 * Template Class
 *
 */
class Template extends  CI_Model {
	/**
	 * Constructor
	 */
	function __construct()
         {
        parent::__construct();
        
	}
	
	function getTemplate($pgd_id,$jl_id)
	{
		/*get template type by id*/
		$temp = $this->db->get_where('mst_jenis_lampiran', array('jl_id'=>$jl_id))->row(); 

		/*search by keyword send by form*/
		$search  = array('{tempat_pengaduan}',
						'{alat_bukti}',
						'{barang_bukti}',
						'{uraian_singkat}',
						'{no_pengaduan}',
						'{no_perkara}',
						'{data_pengadu}',
						'{data_teradu}',
						'{pokok_pengaduan}',
						'{data_bukti}',
						'{peraturan}', 
						'{pengkaji}',
						'{tanggal_verifikasi_materil}',
						'{peserta_rapat_verifikasi}',
						'{pengadu_detil}',
						'{kuasa_detil}',
						'{teradu_detil}',
						'{peristiwa}',
						'{detil_teradu_list}',
						'{saksi}',
						'{nama_pengadu}',
						'{pokok_perkara}',
						'{day}',
						'{date}',
						'{month}',
						'{year}',
						'{tanggal_pengaduan}' );

		/*get content by send parameters*/
		$getContent = $this->getFormat($search,$temp->jl_template,$pgd_id); 
		
		/*return data*/
		return $getContent;

	} 
	
	function getFormat($search,$subject,$id){
		/*search data and replace it to template form */
		$replace = str_replace($search, $this->findSearch($search, $id), $subject);
		/*return data*/
		return $replace;
	}

	function findSearch($search,$id){

		$getData = array();
		foreach($search as $row){
			$tmp = $this->replace($row,$id);
			$getData[] = $tmp;
		}
		
		return $getData;
	}
	

	function replace($rpl,$id){

    	/*query for data pengaduan*/
    	$pengaduan = $this->db->get_where('vw_pengaduan', array('pgd_id'=>$id))->row();

    	/*query for bukti pengaduan*/
    	$bukti = $this->db->get_where('mc_pengaduan_bukti', array('pgd_id'=>$id))->result();
    	$alat_bukti = $this->db->get_where('mc_pengaduan_bukti', array('pgd_id'=>$id, 'flag'=>'alat_bukti'))->result();
    	$brang_bukti = $this->db->get_where('mc_pengaduan_bukti', array('pgd_id'=>$id, 'flag'=>'barang_bukti'))->result();

    	/*query for uraian pengaduan*/
    	$uraian = $this->db->get_where('mc_pengaduan_uraian', array('pgd_id'=>$id))->row();

    	/*query for peristiwa pengaduan*/
    	$peristiwa = $this->db->get_where('mc_pengaduan_bukti', array('pgd_id'=>$id))->result();

    	/*query for para pihak pengaduan*/
    	$pengadu = $this->db->get_where('vw_para_pihak', array('pgd_id'=>$id,'flag'=>'pengadu'))->result();
    	$teradu = $this->db->get_where('vw_para_pihak', array('pgd_id'=>$id,'flag'=>'teradu'))->result();
    	$kuasa = $this->db->get_where('vw_para_pihak', array('pgd_id'=>$id,'flag'=>'kuasa'))->result();
    	$saksi = $this->db->get_where('vw_para_pihak', array('pgd_id'=>$id,'flag'=>'saksi'))->result();


		switch ($rpl) {

			case '{tanggal_pengaduan}':
				$tanggal_pengaduan = '&nbsp; <strong>'.strtoupper($this->tanggal->formatDate($pengaduan->pgd_tanggal)).'&nbsp;</strong>';
				return $tanggal_pengaduan;
				break;

			case '{day}':
				$day = '&nbsp; <strong>'.strtoupper($this->tanggal->getHari(date('D'))).'&nbsp;</strong>';
				return $day;
				break;

			case '{date}':
				$date = '&nbsp; <strong>'.strtoupper(date('d')).'&nbsp;</strong>';
				return $date;
				break;

			case '{month}':
				$month = '&nbsp; <strong>'.strtoupper($this->tanggal->getBulan(date('m'))).'&nbsp;</strong>';
				return $month;
				break;

			case '{year}':
				$year = '&nbsp; <strong>'.strtoupper(date('Y')).'&nbsp;</strong>';
				return $year;
				break;

			case '{no_pengaduan}':
				$val = Format::noPengaduan($pengaduan->pgd_no);
				$no_pengaduan = ($val)?$val:'(Belum ada no pengaduan)';
				return $no_pengaduan;
				break;

			case '{pengkaji}':
				$val = $pokok->pengkaji;
				return $val;
				break;

			case '{peraturan}':
				$val = '<b>(Peraturan Kode Etik)</b>';
				return $val;
				break;

			case '{peserta_rapat_verifikasi}':
				$temppeserta .= '(';
				foreach($nonkomisioner as $rownonkomisioner){
			          $temppeserta.=''.$rownonkomisioner->nama_nonkomisioner.',';
			      }
				$temppeserta .=')';
				$val = $temppeserta;
				return $val;
				break;			

			case '{tanggal_verifikasi_materil}':
				$val = $this->tanggal->formatDate($pokok->pengaduan_pengkajian_tgl);
				return $val;
				break;

			case '{no_perkara}':
				$val = $pengaduan->perkara_no.$pengaduan->format_no_perkara;
				return $val;
				break;

			case '{data_pengadu}':
				
      			$temppengadu = '
      							<p>&nbsp; Nama '.str_repeat('&nbsp;', 25).' : '.$pengadu->ktp_nama_lengkap.'</p>

								<p>&nbsp; Pekerjaan/Lembaga '.str_repeat('&nbsp;', 3).' : '.$pengadu->job_name.'</p>

								<p>&nbsp; Alamat '.str_repeat('&nbsp;', 23).' : '.$pengadu->ktp_alamat.'</p>

								<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Selanjutnya disebut sebagai-------------------------------------------------------<strong>Pengadu;</strong></p>

								<p>&nbsp;</p>
      			';
				$val = $temppengadu;
				return $val;
				break;

			case '{nama_pengadu}':
				
      			$tempnamapengadu = '
      							<span>'.$pengadu->ktp_nama_lengkap.'</span>

      			';
				$val = $tempnamapengadu;
				return $val;
				break;


			case '{tempat_pengaduan}':
				
      			$temppengaduan = '
      							<table border="0" cellpadding="0" cellspacing="0" style="border-spacing:1em; margin-left:60px; width:700px">
									<tbody>
										<tr>
											<td style="width:250px">a) Diadukan dan/atau dilaporkan di</td>
											<td style="width:400px">: '.$pengaduan->pgd_tempat.'</td>
										</tr>
										<tr>
											<td style="width:250px">b) Hari/Tanggal/Jam</td>
											<td style="width:400px">: '.$this->tanggal->formatDate($pengaduan->pgd_tanggal).'</td>
										</tr>
									</tbody>
								</table>
      			';
				$val = $temppengaduan;
				return $val;
				break;

			case '{data_teradu}':
				
	  			$no = 1;
	  			foreach($teradu as $rowteradu){
	  				$tempteradu .= '
		  							<p>&nbsp; Nama '.str_repeat('&nbsp;', 25).' : '.$rowteradu->ktp_nama_lengkap.'</p>

									<p>&nbsp; Pekerjaan/Lembaga '.str_repeat('&nbsp;', 5).' : '.$rowteradu->job_name.'</p>

									<p>&nbsp; Alamat '.str_repeat('&nbsp;', 23).' : '.$rowteradu->ktp_alamat.'</p>

									<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Selanjutnya disebut sebagai-------------------------------------------------------<strong>Teradu '.$no.' ;</strong></p>

									<p>&nbsp;</p>
		  			';
		  			$no++;
	  			}
	  			
				$val = $tempteradu;
				return $val;
				break;

			case '{pokok_pengaduan}':
				
      			$temppokok = '
								<p style="text-align:justify">'.$pokok->pengaduan_hasil_penelitian_pokok_pengaduan.'</p>
      			';
				$val = $temppokok;
				return $val;
				break;

			case '{pokok_perkara}':
				
      			$temppokok = '
								<p style="text-align:justify">'.$pokok->pengaduan_pengkajian_pokok_perkara.'</p>
      			';
				$val = $temppokok;
				return $val;
				break;

			case '{data_bukti}':
				
	  			$no = 1;
				$tempbukti .='<table border="0" cellpadding="0" cellspacing="0" style="width:100%"><tbody>';
	  			foreach($bukti as $rowbukti){
	  				$tempbukti .= '
		  							<tr>
										<td style="width:30px">
											'.$no.'.
										</td>
										<td style="width:94px">
										Bukti P-'.$no.'
										</td>
										<td style="width:19px">
										:
										</td>
										<td style="width:491px">
										'.$rowbukti->pgdb_keterangan.'
										</td>
									</tr>
		  			';
		  			$no++;
	  			}
	  			$tempbukti .='</tbody></table>';
	  			
				$val = $tempbukti;
				return $val;
				break;

			case '{alat_bukti}':
				
	  			$no = 1;
	  			if(!empty($alat_bukti)){
	  				foreach($alat_bukti as $rowalatbukti){
		  				$tempalatbukti .= '
			  							<p style="margin-left:80px; text-align:justify">'.$no.'. '.$rowalatbukti->pgdb_keterangan.'</p>
			  			';
			  			$no++;
		  			}	
	  			}else{
	  				$tempalatbukti .= '........................................................';
	  			}
				
	  			
				$val = $tempalatbukti;
				return $val;
				break;

			case '{barang_bukti}':
				
	  			$no = 1;
	  			if(!empty($barang_bukti)){
	  				foreach($barang_bukti as $rowbarangbukti){
		  				$tempbarangbukti .= '
			  				<p style="margin-left:80px; text-align:justify">'.$no.'.  '.$rowbarangbukti->pgdb_keterangan.'</p>
			  			';
			  			$no++;
		  			}
	  			}else{
	  				$tempbarangbukti .= '........................................................';
	  			}
				
	  			
				$val = $tempbarangbukti;
				return $val;
				break;

			case '{teradu_detil}':
				
	  			$no = 1;
	  			foreach($teradu as $rowteradu){
	  				$tempteradu .= '
		  							<p style="margin-left:80px"><strong>Teradu '.$no.' :</strong></p>
									<table border="0" cellpadding="0" cellspacing="0" style="border-spacing:1em; margin-left:60px; width:700px">
										<tbody>
											<tr>
												<td style="width:250px">a) Nama</td>
												<td style="width:400px">: '.$rowteradu->ktp_nama_lengkap.'</td>
											</tr>
											<tr>
												<td style="width:250px">b) Jabatan/Organisasi</td>
												<td style="width:400px">: '.$rowteradu->jbp_name.' / '.$rowteradu->pp_organisasi.' </td>
											</tr>
											<tr>
												<td style="width:250px">c) Alamat Kantor</td>
												<td style="width:400px">: </td>
											</tr>
											<tr>
												<td style="width:250px">d) Keterangan Lain</td>
												<td style="width:400px">: </td>
											</tr>
										</tbody>
									</table>
									<br>

		  			';
		  			$no++;
	  			}
	  			
				$val = $tempteradu;
				return $val;
				break;

			case '{saksi}':
				
	  			$no = 1;
	  			if(!empty($saksi)){
	  				foreach($saksi as $rowsaksi){
		  				$tempsaksi .= '
		  								<p style="margin-left:80px"><strong>Saksi '.$no.' :</strong></p>
			  							<table border="0" cellpadding="0" cellspacing="0" style="border-spacing:1em; margin-left:60px; width:700px">
											<tbody>
												<tr>
													<td style="width:250px">a) Nama</td>
													<td style="width:400px">: '.$rowsaksi->ktp_nama_lengkap.'</td>
												</tr>
												<tr>
													<td style="width:250px">b) Pekerjaan</td>
													<td style="width:400px">: '.$rowsaksi->job_name.'</td>
												</tr>
												<tr>
													<td style="width:250px">c) Alamat&nbsp;</td>
													<td style="width:400px">: '.$rowsaksi->ktp_alamat.'</td>
												</tr>
											</tbody>
										</table>

			  			';
			  			$no++;
		  			}
	  			}else{
	  				$tempsaksi .= $this->tempSaksi();
	  			}
	  			
	  			
				$val = $tempsaksi;
				return $val;
				break;

			case '{uraian_singkat}':
				
	  			if(!empty($uraian)){
		  				$tempuraian .= $uraian->pgdu_uraian_kejadian;
	  			}else{
	  				$tempuraian .= '........................................................';
	  			}
	  			
	  			
				$val = $tempuraian;
				return $val;
				break;

			case '{peristiwa}':
				
	  			$no = 1;
	  			if(!empty($peristiwa)){
	  				foreach($peristiwa as $rowperistiwa){
		  				$tempperistiwa .= '
			  							<table border="0" cellpadding="0" cellspacing="0" style="border-spacing:1em; margin-left:60px; width:700px">
											<tbody>
												<tr>
													<td style="width:250px">a) Waktu Kejadian</td>
													<td style="width:400px">: '.$this->tanggal->formatDate($rowperistiwa->pgdpp_tgl_kejadian).'</td>
												</tr>
												<tr>
													<td style="width:250px">b) Tempat Kejadian</td>
													<td style="width:400px">: '.$rowperistiwa->pgdpp_tempat_kejadian.'</td>
												</tr>
												<tr>
													<td style="width:250px">c) Perbuatan yang dilakukan</td>
													<td style="width:400px">: '.$rowperistiwa->pgdpp_perbuatan.'</td>
												</tr>
												<tr>
													<td style="width:250px">d) Pasal yang dilanggar</td>
													<td style="width:400px">: </td>
												</tr>
											</tbody>
										</table>

			  			';
			  			$no++;
		  			}
	  			}else{
	  				$tempperistiwa .= $this->tempPeristiwa();
	  			}
	  			
	  			
				$val = $tempperistiwa;
				return $val;
				break;

			case '{pengadu_detil}':
				
	  			$no = 1;
				$temppengadu .= $this->getPihak($pengadu);
	  			
				$val = $temppengadu;
				return $val;
				break;

			case '{detil_teradu_list}':
				foreach ($teradu as $key => $value) {
					$arr[] = $value->ktp_nama_lengkap;
				}
	  			$data_teradu = '<strong>( '.strtoupper(implode(', ', $arr)).' )</strong>' ; ;
				$val = $data_teradu;

				return $val;
				break;

			case '{kuasa_detil}':
				
	  			$no = 1;
				$tempkuasa .= $this->getPihak($kuasa);
	  			
				$val = $tempkuasa;
				return $val;
				break;

			default:
				$val = $rpl;
				return $val;
				break;

		}

	}

	function tempPeristiwa(){

		$html .='
				<table border="0" cellpadding="0" cellspacing="0" style="border-spacing:1em; margin-left:60px; width:700px">
					<tbody>
						<tr>
							<td style="width:250px">a) Waktu Kejadian</td>
							<td style="width:400px">: </td>
						</tr>
						<tr>
							<td style="width:250px">b) Tempat Kejadian</td>
							<td style="width:400px">: </td>
						</tr>
						<tr>
							<td style="width:250px">c) Perbuatan yang dilakukan</td>
							<td style="width:400px">: </td>
						</tr>
						<tr>
							<td style="width:250px">d) Pasal yang dilanggar</td>
							<td style="width:400px">: </td>
						</tr>
					</tbody>
				</table>
		';

		return $html;
	}

	function tempSaksi(){

		$html .='
				<p style="margin-left:80px"><strong>Saksi I :</strong></p>

					<table border="0" cellpadding="0" cellspacing="0" style="border-spacing:1em; margin-left:60px; width:700px">
						<tbody>
							<tr>
								<td style="width:250px">a) Nama</td>
								<td style="width:400px">:</td>
							</tr>
							<tr>
								<td style="width:250px">b) Pekerjaan</td>
								<td style="width:400px">:</td>
							</tr>
							<tr>
								<td style="width:250px">c) Alamat&nbsp;</td>
								<td style="width:400px">:</td>
							</tr>
						</tbody>
					</table>
		';

		return $html;
	}

	function getPihak($data){
		/*print_r($data);die;*/
		
		$html .= '
					<table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate; border-spacing:1em; margin-left:60px; width:700px">
				<tbody>
					<tr>
						<td style="width:250px">a) Nama</td>
						<td style="width:400px">: '.$data->ktp_nama_lengkap.'</td>
					</tr>
					<tr>
						<td style="width:250px">b) Nomor Identitas</td>
						<td style="width:400px">: '.$data->ktp_nik.'</td>
					</tr>
					<tr>
						<td style="width:250px">c) Tempat Lahir</td>
						<td style="width:400px">: '.$data->ktp_tempat_lahir.'</td>
					</tr>
					<tr>
						<td style="width:250px">d) Tanggal Lahir</td>
						<td style="width:400px">: '.$this->tanggal->formatDate($data->ktp_tgl_lahir).'</td>
					</tr>
					<tr>
						<td style="width:250px">e) Jenis Kelamin</td>
						<td style="width:400px">: '.$data->ktp_jk.'</td>
					</tr>
					<tr>
						<td style="width:250px">f) Pekerjaan</td>
						<td style="width:400px">: '.$data->job_name.'</td>
					</tr>
					<tr>
						<td style="width:250px">g) Jabatan</td>
						<td style="width:400px">: '.$data->jbp_name.'</td>
					</tr>
					<tr>
						<td style="width:250px">h) Organisasi/Lembaga</td>
						<td style="width:400px">: '.$data->prp_organisasi.' </td>
					</tr>
					<tr>
						<td style="width:250px">i) Kategori Penyelenggara &nbsp;</td>
						<td style="width:400px">: '.$data->kpd_name.' </td>
					</tr>
					<tr>
						<td style="width:250px">j) Partai Politik</td>
						<td style="width:400px">: '.$data->parpol_name.'</td>
					</tr>
					<tr>
						<td style="width:250px">k) Alamat &nbsp;</td>
						<td style="width:400px">: '.$data->ktp_alamat.'</td>
					</tr>
					<tr>
						<td style="width:250px">l) Provinsi</td>
						<td style="width:400px">: </td>
					</tr>
					<tr>
						<td style="width:250px">m) Kota/Kabupaten</td>
						<td style="width:400px">: </td>
					</tr>
					<tr>
						<td style="width:250px">n) Kecamatan</td>
						<td style="width:400px">: </td>
					</tr>
					<tr>
						<td style="width:250px">o) Kelurahan</td>
						<td style="width:400px">: </td>
					</tr>
					<tr>
						<td style="width:250px">p) No.Telp</td>
						<td style="width:400px">: '.$data->prp_no_hp.'</td>
					</tr>
					<tr>
						<td style="width:250px">q) No.Telp Rumah</td>
						<td style="width:400px">: '.$data->prp_no_telp_rumah.'</td>
					</tr>
					<tr>
						<td style="width:250px">r) No.Telp Kantor&nbsp;</td>
						<td style="width:400px">: '.$data->prp_no_telp_kantor.'</td>
					</tr>
					<tr>
						<td style="width:250px">s) No.Selular</td>
						<td style="width:400px">: '.$data->prp_no_hp.'</td>
					</tr>
					<tr>
						<td style="width:250px">t) Faximile</td>
						<td style="width:400px">: '.$data->prp_fax.'</td>
					</tr>
					<tr>
						<td style="width:250px">u) Email&nbsp;</td>
						<td style="width:400px">: '.$data->prp_email.'</td>
					</tr>
				</tbody>
			</table>

		';

		return $html;
	}

}
// END Login_model Class

/* End of file login_model.php */ 
/* Location: ./system/application/model/login_model.php */