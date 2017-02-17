<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
<script type="text/javascript">
   
  $(function() {
      //new
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
<div class="page-header">

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
          <form class="form-horizontal" method="post" id="form_pegawai" action="<?php echo site_url('Kepegawaian/Mst_pegawai/process')?>">
            <br>

                <div class="form-group">
                 <div class="form-group">
                  <label class="control-label col-md-2">ID KTP</label>
                  <div class="col-md-1">
                    <input name="ktp_id" id="ktp_id" value="<?php echo isset($value)?$value->ktp_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                  </div>

                </div>

                <h3 class="lighter block green">Data Pribadi <small> (Sesuai dengan KTP) </small></h3>

                <div class="form-group">
                  <label class="control-label col-md-2">Upload Foto</label>
                  <div class="col-md-6">
                    <input name="fupload" id="member_photo" placeholder="Foto Profile" type="file">
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
                        <input class="form-control date-picker" name="ktp_tanggal_lahir" id="ktp_tanggal_lahir" type="text" data-date-format="yyyy-mm-dd" />
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
                      <label class="control-label col-md-2">RW</label>
                      <div class="col-md-1">
                        <input name="ktp_rw" id="ktp_rw" value="<?php echo isset($value)?$value->ktp_rw:''?>" placeholder="" class="form-control" type="text">
                      </div>
                    </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Provinsi</label>
                  <div class="col-md-3">

                    <?php echo $this->master->get_master_custom(array('table'=>'m_province', 'where'=>array('active'=>'Y'), 'id'=>'province_id', 'name'=>'province_name'), isset($value->province_id)?$value->province_id:'','province_id','province_id', 'chosen-select form-control','required','inline')?>
                  </div>
                  <label class="control-label col-md-2">Kab/Kota</label>
                  <div class="col-md-3">
                    <?php echo $this->master->get_change_master_city(isset($value->city_id)?$value->city_id:'','city_id','city_id', 'form-control','required','inline')?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Kecamatan</label>
                  <div class="col-md-3">
                    <?php echo $this->master->get_change_master_district(isset($value->district_id)?$value->district_id:'','district_id','district_id', 'form-control','required','inline')?>
                  </div>
                  <label class="control-label col-md-2">Kelurahan</label>
                  <div class="col-md-3">
                    <?php echo $this->master->get_change_master_sub_district(isset($value->sub_district_id)?$value->sub_district_id:'','sub_district_id','sub_district_id', 'form-control','required','inline')?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Status Marital</label>
                  <div class="col-md-2">
                    <?php echo $this->master->get_master_custom(array('table'=>'m_marital_status', 'where'=>array('active'=>'Y'), 'id'=>'ms_id', 'name'=>'ms_name'), isset($value->ms_id)?$value->ms_id:'','ms_id','ms_id', 'chosen-select form-control','required','inline')?>
                  </div>
                  <label class="control-label col-md-2">Agama</label>
                  <div class="col-md-2">
                    <?php echo $this->master->get_master_custom(array('table'=>'m_religion', 'where'=>array('active'=>'Y'), 'id'=>'religion_id', 'name'=>'religion_name'), isset($value->religion_id)?$value->religion_id:'','religion_id','religion_id', 'chosen-select form-control','required','inline')?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Pekerjaan</label>
                  <div class="col-md-2">
                    <?php echo $this->master->get_master_custom(array('table'=>'m_job', 'where'=>array('active'=>'Y'), 'id'=>'job_id', 'name'=>'job_name'), isset($value->job_id)?$value->job_id:'','job_id','job_id', 'chosen-select form-control','required','inline')?>
                  </div>
                  <label class="control-label col-md-2">Gol.Darah</label>
                  <div class="col-md-2">
                    <?php echo $this->master->get_master_custom(array('table'=>'m_type_blood', 'where'=>array('active'=>'Y'), 'id'=>'tb_id', 'name'=>'tb_name'), isset($value->tb_id)?$value->tb_id:'','tb_id','tb_id', 'chosen-select form-control','required','inline')?>
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

                <h3 class="lighter block green"> Data Kepegawaian </h3>

                <div class="form-group">
                  <label class="control-label col-md-2">ID</label>
                  <div class="col-md-1">
                    <input name="pg_id" id="pg_id" value="<?php echo isset($value)?$value->pg_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">NIP</label>
                  <div class="col-md-2">
                    <input name="pg_nip" id="pg_nip" value="<?php echo isset($value)?$value->pg_nip:''?>" placeholder="" class="form-control" type="text">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Jabatan</label>
                  <div class="col-md-5">

                    <?php echo $this->master->get_master_custom(array('table'=>'mst_jabatan', 'where'=>array('active'=>'Y'), 'id'=>'jabatan_id', 'name'=>'jabatan_name'), isset($value->jabatan_id)?$value->jabatan_id:'','jabatan_id','jabatan_id', 'chosen-select form-control','required','inline')?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">No Telp</label>
                  <div class="col-md-2">
                    <input name="pg_no_telp" id="pg_no_telp" value="<?php echo isset($value)?$value->pg_no_telp:''?>" placeholder="" class="form-control" type="text">
                  </div>
                  <label class="control-label col-md-2">No HP</label>
                  <div class="col-md-2">
                    <input name="pg_no_hp" id="pg_no_hp" value="<?php echo isset($value)?$value->pg_no_hp:''?>" placeholder="" class="form-control" type="text">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Email</label>
                  <div class="col-md-2">
                    <input name="pg_email" id="pg_email" value="<?php echo isset($value)?$value->pg_email:''?>" placeholder="" class="form-control" type="text">
                  </div>
                </div>

                

                <div class="form-group">
                  <label class="control-label col-md-2">Status Aktif ?</label>
                  <div class="col-md-9">
                    <div class="radio">
                          <label>
                            <input name="tr_pegawai_active" type="radio" class="ace" value="Y" <?php echo isset($value) ? ($value->tr_pegawai_active == 'Y') ? 'checked="checked"' : '' : 'checked="checked"'; ?>  />
                            <span class="lbl"> Yes</span>
                          </label>
                          <label>
                            <input name="tr_pegawai_active" type="radio" class="ace" value="N" <?php echo isset($value) ? ($value->tr_pegawai_active == 'N') ? 'checked="checked"' : '' : ''; ?>/>
                            <span class="lbl">No</span>
                          </label>
                    </div>
                  </div>
                </div>

                <div class="form-actions center">

                  <a onclick="backlist()" href="#" class="btn btn-sm btn-inverse">
                    <i class="ace-icon fa fa-arrow-left icon-on-right bigger-110"></i>
                    Back to list
                  </a>
                  <a id="btn_add_pegawai" <?php echo isset( $value ) ? '' : 'style="display:none"' ;?> href="#" class="btn btn-sm btn-primary">
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
<script src="<?php echo base_url()?>assets/js/custom/pegawai_custom.js"></script>
