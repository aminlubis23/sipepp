<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
<script type="text/javascript">
   
  $(function() {
      $('select[name="prp_organisasi"]').change(function() {
          if ($(this).val()) {
              $.getJSON("<?php echo site_url('SipeppMaster/Mst_penyelenggara_pemilu/get_penyelenggara_by_flag') ?>/" + $(this).val(), '', function(data) {
                  $('#pnylgra_id option').remove()
                  $('<option value="">(Select Penyelenggara)</option>').appendTo($('#pnylgra_id'));
                  $.each(data, function(i, o) {
                      $('<option value="'+o.pp_id+'">'+o.pp_name+'</option>').appendTo($('#pnylgra_id'));
                  });

              });
          } else {
              $('#pnylgra_id option').remove()
              $('<option value="">(Select Penyelenggara)</option>').appendTo($('#pnylgra_id'));
          }
      });

      $('select[name="province_id"]').change(function() {
          if ($(this).val()) {
              $.getJSON("<?php echo site_url('Regional/M_province/get_city_by_prov') ?>/" + $(this).val(), '', function(data) {
                  $('#city_id option').remove()
                  $('<option value="">(Select City)</option>').appendTo($('#city_id'));
                  $.each(data, function(i, o) {
                      $('<option value="'+o.city_id+'">'+o.city_name+'</option>').appendTo($('#city_id'));
                  });

              });
          } else {
              $('#city_id option').remove()
              $('<option value="">(Select City)</option>').appendTo($('#city_id'));
          }
      });

      $('select[name="city_id"]').change(function() {
          if ($(this).val()) {
              $.getJSON("<?php echo site_url('Regional/M_city/get_district_by_city') ?>/" + $(this).val(), '', function(data) {
                  $('#district_id option').remove()
                  $('<option value="">(Select Dsitrict)</option>').appendTo($('#district_id'));
                  $.each(data, function(i, o) {
                      $('<option value="'+o.district_id+'">'+o.district_name+'</option>').appendTo($('#district_id'));
                  });

              });
          } else {
              $('#district_id option').remove()
              $('<option value="">(Select Dsitrict)</option>').appendTo($('#district_id'));
          }
      });

      $('select[name="district_id"]').change(function() {
          if ($(this).val()) {
              $.getJSON("<?php echo site_url('Regional/M_district/get_sub_district_by_district') ?>/" + $(this).val(), '', function(data) {
                  $('#sub_district_id option').remove()
                  $('<option value="">(Select Subdistrict)</option>').appendTo($('#sub_district_id'));
                  $.each(data, function(i, o) {
                      $('<option value="'+o.subdistrict_id+'">'+o.subdistrict_name+'</option>').appendTo($('#sub_district_id'));
                  });

              });
          } else {
              $('#sub_district_id option').remove()
              $('<option value="">(Select Subdistrict)</option>').appendTo($('#sub_district_id'));
          }
      });


  });
</script>
<!-- section header and breadcrumbs -->
<div class="title page-header">

  <h1>
    <!-- header title -->
    <?php echo $title?>

    <!-- header breadcrumbs -->
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      <?php echo $breadcrumbs?>
    </small>
    <!-- end header breadcrumbs -->
  
  </h1>

</div>
<!-- end section header and breadcrumbs -->

<style type="text/css">
label.error { color:red; }
</style>

<!-- PAGE CONTENT BEGINS -->
<div class="row">
  <div class="col-xs-12">
      <div class="widget-body">
        <div class="widget-main no-padding">

          <!-- BEGIN FORM -->
          <form class="form-horizontal" method="post" id="form_para_pihak" action="<?php echo site_url('BiodataPeradilan/Tr_para_pihak/process')?>">
            <br>

                <div class="form-group">
                  <label class="control-label col-md-2">*No Registrasi</label>
                  <div class="col-md-2">
                    <input name="pgd_id" id="pgd_id" value="<?php echo isset($value)?$value->pgd_id:''?>" class="form-control" type="text"><i>*Wajib diisi</i>
                  </div>
                </div>
                <?php if(!isset($value)):?>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Anggota baru?</label>
                  <div class="col-sm-4">
                    <div class="radio">
                          <label>
                            <input name="is_new" type="radio" class="ace" value="Y" id="new" />
                            <span class="lbl"> YA </span>
                          </label>
                          <label>
                            <input name="is_new" type="radio" class="ace" value="N" id="old" />
                            <span class="lbl"> TIDAK </span>
                          </label>
                    </div>
                    <span class="help-block"><i>Jika anda sudah pernah mengisi formulir silahkan pilih (TIDAK) untuk mencari data anda</i></span>
                  </div>
                </div>

                <!-- Jika yang bersangkutan merupakan anggota lama atau sudah pernah terdaftar sebelumnya -->
                <div id="has_registered" style="display:none">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Kata Kunci</label>
                    <div class="col-sm-4 input-group">
                       <input type="text" placeholder="Masukan Nama/No.Identitas" class="form-control" name="keyword_search" id="keyword_search"/>                                         
                      <span class="input-group-btn" style="margin-top:-10px">
                        <button class="btn btn-sm btn-primary" type="button" id="btn_search_name_or_id"><i class="fa fa-search"></i> Pencarian</button>
                      </span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                       <div id="result_searching"></div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

                <div id="new_member" <?php echo isset($value)?'':'style="display:none"'?>>

                    <div class="page-header">
                      <h1>
                        Data Pribadi <small> (Sesuai dengan KTP) </small>
                      </h1>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-2">ID KTP</label>
                      <div class="col-md-1">
                        <input name="ktp_id" id="ktp_id" value="<?php echo isset($value)?$value->ktp_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-2">Upload Foto</label>
                      <div class="col-md-4">
                        <input name="fupload" id="member_photo" class="form-control" placeholder="Foto Profile" type="file">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-2">Nama Lengkap</label>
                      <div class="col-md-6">
                        <input name="ktp_nama_lengkap" id="ktp_nama_lengkap" value="<?php echo isset($value)?$value->ktp_nama_lengkap:''?>" placeholder="" class="form-control" type="text">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-2">No.KTP</label>
                      <div class="col-md-3">
                        <input name="ktp_nik" id="ktp_nik" value="<?php echo isset($value)?$value->ktp_nik:''?>" placeholder="" class="form-control" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2">Tempat Lahir</label>
                      <div class="col-md-2">
                        <input name="ktp_tempat_lahir" id="ktp_tempat_lahir" value="<?php echo isset($value)?$value->ktp_tempat_lahir:''?>" placeholder="" class="form-control" type="text">
                      </div>
                      <label class="control-label col-md-2">Tanggal Lahir</label>
                        <div class="col-md-2">
                          <div class="input-group">
                            <input class="form-control date-picker" name="ktp_tanggal_lahir" id="ktp_tanggal_lahir" type="text" data-date-format="yyyy-mm-dd" value="<?php echo isset($value)?$value->ktp_tanggal_lahir:''?>"/>
                            <span class="input-group-addon">
                              <i class="fa fa-calendar bigger-110"></i>
                            </span>
                          </div>

                          <!-- <input type="text" name="tgl_lulus" id="tgl_lulus" class="form-control"> -->
                        </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-2">Jenis Kelamin</label>
                      <div class="col-md-9">
                        <div class="radio">
                              <label>
                                <input name="ktp_jk" type="radio" class="ace" value="L" <?php echo isset($value) ? ($value->ktp_jk == 'L') ? 'checked="checked"' : '' : 'checked="checked"'; ?>  />
                                <span class="lbl"> Laki-laki</span>
                              </label>
                              <label>
                                <input name="ktp_jk" type="radio" class="ace" value="P" <?php echo isset($value) ? ($value->ktp_jk == 'P') ? 'checked="checked"' : '' : ''; ?>/>
                                <span class="lbl">Perempuan</span>
                              </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-2">Alamat</label>
                      <div class="col-md-6">
                        <input name="ktp_alamat" id="ktp_alamat" value="<?php echo isset($value)?strip_tags($value->ktp_alamat):''?>" placeholder="" class="form-control" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2">RT</label>
                      <div class="col-md-1">
                        <input name="ktp_rt" id="ktp_rt" value="<?php echo isset($value)?$value->ktp_rt:''?>" placeholder="" class="form-control" type="text">
                      </div>
                      <label class="control-label col-md-1">RW</label>
                      <div class="col-md-1">
                        <input name="ktp_rw" id="ktp_rw" value="<?php echo isset($value)?$value->ktp_rw:''?>" placeholder="" class="form-control" type="text">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-2">Provinsi</label>
                      <div class="col-md-3">
                        <?php echo $this->master->get_master_custom(array('table'=>'m_province', 'where'=>array('active'=>'Y'), 'id'=>'province_id', 'name'=>'province_name'), isset($value->province_id)?$value->province_id:'','province_id','province_id', 'form-control','','inline')?>
                      </div>
                      <label class="control-label col-md-1">Kab/Kota</label>
                      <div class="col-md-3">
                        <?php echo $this->master->get_change_master_city(isset($value->city_id)?$value->city_id:'','city_id','city_id', 'form-control','','inline')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-2">Kecamatan</label>
                      <div class="col-md-3">
                        <?php echo $this->master->get_change_master_district(isset($value->district_id)?$value->district_id:'','district_id','district_id', 'form-control','','inline')?>
                      </div>
                      <label class="control-label col-md-1">Kelurahan</label>
                      <div class="col-md-3">
                        <?php echo $this->master->get_change_master_sub_district(isset($value->sub_district_id)?$value->sub_district_id:'','sub_district_id','sub_district_id', 'form-control','','inline')?>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-2">Status Marital</label>
                      <div class="col-md-2">
                        <?php echo $this->master->get_master_custom(array('table'=>'m_marital_status', 'where'=>array('active'=>'Y'), 'id'=>'ms_id', 'name'=>'ms_name'), isset($value->ms_id)?$value->ms_id:'','ms_id','ms_id', 'form-control','','inline')?>
                      </div>
                      <label class="control-label col-md-1">Agama</label>
                      <div class="col-md-2">
                        <?php echo $this->master->get_master_custom(array('table'=>'m_religion', 'where'=>array('active'=>'Y'), 'id'=>'religion_id', 'name'=>'religion_name'), isset($value->religion_id)?$value->religion_id:'','religion_id','religion_id', 'form-control','','inline')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-2">Pekerjaan</label>
                      <div class="col-md-2">
                        <?php echo $this->master->get_master_custom(array('table'=>'m_job', 'where'=>array('active'=>'Y'), 'id'=>'job_id', 'name'=>'job_name'), isset($value->job_id)?$value->job_id:'','job_id','job_id', 'form-control','','inline')?>
                      </div>
                      <label class="control-label col-md-1">Gol.Darah</label>
                      <div class="col-md-2">
                        <?php echo $this->master->get_master_custom(array('table'=>'m_type_blood', 'where'=>array('active'=>'Y'), 'id'=>'tb_id', 'name'=>'tb_name'), isset($value->tb_id)?$value->tb_id:'','tb_id','tb_id', 'form-control','','inline')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-2">Kewarganegaraan</label>
                      <div class="col-md-9">
                        <div class="radio">
                              <label>
                                <input name="ktp_kewarganegaraan" type="radio" class="ace" value="WNI" <?php echo isset($value) ? ($value->ktp_kewarganegaraan == 'WNI') ? 'checked="checked"' : '' : 'checked="checked"'; ?>  />
                                <span class="lbl"> WNI</span>
                              </label>
                              <label>
                                <input name="ktp_kewarganegaraan" type="radio" class="ace" value="WNA" <?php echo isset($value) ? ($value->ktp_kewarganegaraan == 'WNA') ? 'checked="checked"' : '' : ''; ?>/>
                                <span class="lbl">WNA</span>
                              </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-2">No Telp Rumah</label>
                      <div class="col-md-2">
                        <input name="prp_no_telp_rumah" id="prp_no_telp_rumah" value="<?php echo isset($value)?$value->prp_no_telp_rumah:''?>" placeholder="" class="form-control" type="text">
                      </div>
                      <label class="control-label col-md-1">No HP</label>
                      <div class="col-md-2">
                        <input name="prp_no_hp" id="prp_no_hp" value="<?php echo isset($value)?$value->prp_no_hp:''?>" placeholder="" class="form-control" type="text">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-2">No Fax</label>
                      <div class="col-md-2">
                        <input name="prp_fax" id="prp_fax" value="<?php echo isset($value)?$value->prp_fax:''?>" placeholder="" class="form-control" type="text">
                      </div>
                      <label class="control-label col-md-1">Email</label>
                      <div class="col-md-2">
                        <input name="prp_email" id="prp_email" value="<?php echo isset($value)?$value->prp_email:''?>" placeholder="" class="form-control" type="text">
                      </div>
                      <label class="control-label col-md-1">Kode Pos</label>
                      <div class="col-md-1">
                        <input name="prp_kode_pos" id="prp_kode_pos" value="<?php echo isset($value)?$value->prp_kode_pos:''?>" placeholder="" class="form-control" type="text">
                      </div>
                    </div>

                  </div>

                <div class="page-header">
                  <h1>
                    Apakah yang bersangkutan merupakan penyelenggara pemilu?
                  </h1>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">PRPID</label>
                  <div class="col-md-1">
                    <input name="prp_id" id="prp_id" value="<?php echo isset($value)?$value->prp_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                  </div>
                  <label class="col-sm-2 control-label">Jenis Pihak</label>
                  <div class="col-sm-3  ">
                     <select name="flag" class="form-control" id="flag">
                      <option value="">--Pilih--</option>
                      <option value="pengadu" <?php echo isset($value)?($value->flag=='pengadu')?'selected':'':''?> >Pengadu</option>
                      <option value="teradu" <?php echo isset($value)?($value->flag=='teradu')?'selected':'':''?>>Teradu</option>
                      <option value="kuasa" <?php echo isset($value)?($value->flag=='kuasa')?'selected':'':''?>>Kuasa</option>
                      <option value="saksi" <?php echo isset($value)?($value->flag=='saksi')?'selected':'':''?>>Saksi</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Penyelenggara?</label>
                  <div class="col-sm-4">
                    <div class="radio">
                          <label>
                            <input name="prp_penyelenggara" type="radio" class="ace" value="ya" id="yes_penyelenggara" <?php echo isset($value) ? ($value->prp_penyelenggara == 'ya') ? 'checked="checked"' : '' : 'checked="checked"'; ?> />
                            <span class="lbl"> YA </span>
                          </label>
                          <label>
                            <input name="prp_penyelenggara" type="radio" class="ace" value="tidak" id="no_penyelenggara" <?php echo isset($value) ? ($value->prp_penyelenggara == 'tidak') ? 'checked="checked"' : '' : 'checked="checked"'; ?>/>
                            <span class="lbl"> TIDAK </span>
                          </label>
                    </div>
                    <span class="help-block"><i>Jika anda merupakan penyelenggara pemilu maka pilih (YA), jika bukan penyelnggara pemilu maka pilih (TIDAK)</i></span>
                  </div>
                </div>


                <!--JIKA TIDAK-->
                  <div id="yes_penyelenggara_form" <?php echo isset($value)?($value->prp_penyelenggara=='ya')?'':'style="display:none"':'style="display:none"'?>>
                  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Organisasi</label>
                      <div class="col-sm-4">
                         <select name="prp_organisasi" class="form-control" id="prp_organisasi">
                          <option value="">--Pilih--</option>
                          <option value="KPU" <?php echo isset($value)?($value->prp_organisasi=='KPU')?'selected':'':''?>>KPU</option>
                          <option value="BAWASLU" <?php echo isset($value)?($value->prp_organisasi=='BAWASLU')?'selected':'':''?> >BAWASLU</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-4">
                         <?php echo $this->master->get_master_custom(array('table'=>'mst_penyelenggara_pemilu', 'where'=>array('active'=>'Y'), 'id'=>'pp_id', 'name'=>'pp_name'), isset($value->pp_id)?$value->pp_id:'','pnylgra_id','pnylgra_id', 'form-control','required','inline')?>
                      </div>
                      <label class="col-sm-2 control-label">Jabatan Penyelenggara</label>
                      <div class="col-sm-4">
                          <?php echo $this->master->get_master_custom(array('table'=>'mst_jabatan_penyelenggara', 'where'=>array('active'=>'Y'), 'id'=>'jbp_id', 'name'=>'jbp_name'), isset($value->pp_jbp_id)?$value->pp_jbp_id:'','jbp_id','jbp_id', 'form-control','required','inline')?>
                      </div>
                    </div>

                    <div id="divprovince" <?php echo isset($value)?($value->pp_id==2 || $value->pp_id==12)?'':'style="display:none"':'style="display:none"'?> >
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Provinsi </label>
                        <div class="col-sm-4">
                          <?php echo $this->master->get_master_custom(array('table'=>'m_province', 'where'=>array('active'=>'Y'), 'id'=>'province_id', 'name'=>'province_name'), isset($value->pp_province_id)?$value->pp_province_id:'','province_id_pp','province_id_pp', 'form-control','required','inline')?>
                        </div>
                      </div>
                    </div>

                     <div id="divcity" <?php echo isset($value)?($value->pp_id==4 || $value->pp_id==5)?'':'style="display:none"':'style="display:none"'?>>
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Kabupaten/Kota </label>
                        <div class="col-sm-4">
                          <?php echo $this->master->get_master_custom(array('table'=>'m_city', 'where'=>array('active'=>'Y'), 'id'=>'city_id', 'name'=>'city_name'), isset($value->city_id)?$value->city_id:'','city_id_pp','city_id_pp', 'form-control','required','inline')?>
                        </div>
                      </div>
                    </div>

                  </div>

                  <!--YA-->

                  <div id="no_penyelenggara_form" <?php echo isset($value)?($value->prp_penyelenggara=='tidak')?'':'style="display:none"':'style="display:none"'?>>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Organisasi</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="prp_organisasi_notpp" value="<?php echo isset($value)?$value->prp_organisasi:''?>">
                      </div>
                      <label class="col-sm-2 control-label">Alamat Org/Kantor</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="prp_alamat_org" value="<?php echo isset($value)?$value->prp_alamat_org:''?>">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kategori Pihak</label>
                      <div class="col-sm-4">
                         <?php echo $this->master->get_master_custom(array('table'=>'mst_kategori_pengadu', 'where'=>array('active'=>'Y'), 'id'=>'kpd_id', 'name'=>'kpd_name'), isset($value->kpd_id)?$value->kpd_id:'','kpd_id','kpd_id', 'form-control','required','inline')?>
                      </div>
                      <label class="col-sm-2 control-label">Partai Politik</label>
                      <div class="col-sm-4">
                         <?php echo $this->master->get_master_custom(array('table'=>'mst_parpol', 'where'=>array('active'=>'Y'), 'id'=>'parpol_id', 'name'=>'parpol_name'), isset($value->parpol_id)?$value->parpol_id:'','parpol_id','parpol_id', 'form-control','required','inline')?>
                      </div>
                    </div>
                    
                  </div>


                <div class="form-actions center">

                  <a onclick="backlist()" href="#" class="btn btn-sm btn-inverse">
                    <i class="ace-icon fa fa-arrow-left icon-on-right bigger-110"></i>
                    Back to list
                  </a>
                  <a id="btn_add_para_pihak" <?php echo isset( $value ) ? '' : 'style="display:none"' ;?> href="#" class="btn btn-sm btn-primary">
                    <i class="ace-icon fa fa-plus icon-on-right bigger-110"></i>
                    Create new
                  </a>
                  <button type="reset" id="btnReset" class="btn btn-sm btn-danger">
                    <i class="ace-icon fa fa-refresh icon-on-right bigger-110"></i>
                    Reset
                  </button>
                  <button type="submit" id="btnSave" name="submit" class="btn btn-sm btn-info">
                    <i class="ace-icon fa fa-check-square-o icon-on-right bigger-110"></i>
                    Submit
                  </button>
                </div>

          </form>

        </div>
      </div>
    
  </div>
</div>
<!-- PAGE CONTENT ENDS -->
<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url()?>assets/js/custom/para_pihak_custom.js"></script>
