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
      <?php //echo $breadcrumbs?>
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
          <form class="form-horizontal" method="post" id="form_peristiwa" action="<?php echo site_url('AdmPengaduan/Tr_peristiwa/process')?>">
            <br>
                <div class="form-group">
                    <label class="control-label col-md-2">ID</label>
                    <div class="col-md-1">
                      <input name="pgdpp_id" id="pgdpp_id" value="<?php echo isset($value)?$value->pgdpp_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                    </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">*No Registrasi</label>
                  <div class="col-md-2">
                    <input name="pgd_id" id="pgd_id" value="<?php echo isset($value)?$value->pgd_id:$pgd_id?>" class="form-control" type="text"><i>*Wajib diisi</i>
                  </div>
                </div>

                <div class="page-header">
                  <h1>
                    Waktu dan tempat kejadian 
                  </h1>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Tempat Kejadian</label>
                  <div class="col-md-2">
                    <input name="pgdpp_tempat_kejadian" id="pgdpp_tempat_kejadian" value="<?php echo isset($value)?$value->pgdpp_tempat_kejadian:''?>" placeholder="" class="form-control" type="text">
                  </div>
                  <label class="control-label col-md-2">Tanggal</label>
                    <div class="col-md-2">
                      <div class="input-group">
                        <input class="form-control date-picker" name="pgdpp_tgl_kejadian" id="pgdpp_tgl_kejadian" type="text" data-date-format="yyyy-mm-dd" value="<?php echo isset($value)?$value->pgdpp_tgl_kejadian:''?>"/>
                        <span class="input-group-addon">
                          <i class="fa fa-calendar bigger-110"></i>
                        </span>
                      </div>
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
                    <?php echo $this->master->get_change_master_sub_district(isset($value->subdistrict_id)?$value->subdistrict_id:'','sub_district_id','sub_district_id', 'form-control','','inline')?>
                  </div>
                </div>

                <div class="page-header">
                  <h1>
                    Perbuatan yang dilakukan
                  </h1>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Uraian Perbuatan</label>
                  <div class="col-md-6">
                    <textarea name="pgdpp_perbuatan" id="pgdpp_perbuatan" class="form-control" rows="5"><?php echo isset($value)?$value->pgdpp_perbuatan:''?></textarea>
                  </div>
                </div>

                <div class="page-header">
                  <h1>
                    Peraturan yang dilanggar
                  </h1>
                </div>

                -
                
                <?php if($pgd->last_proses == 1) :?>
                <div class="form-actions center">

                  <a onclick="backlist(<?php echo $pgd_id?>)" href="#" class="btn btn-sm btn-inverse">
                    <i class="ace-icon fa fa-arrow-left icon-on-right bigger-110"></i>
                    Back to list
                  </a>
                  <a id="btn_add_peristiwa" <?php echo isset( $value ) ? '' : 'style="display:none"' ;?> href="#" class="btn btn-sm btn-primary">
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

                <?php 
                  else : 
                        $html =''; 
                        $html .='<center>'; 
                        $html .='<div class="alert alert-danger">'; 
                        $html .='[ <i class="fa fa-info"></i> ] Pengaduan sedang dalam proses <b><i>"'.$this->registrasi->getStatusPengaduan($pgd_id).'", </i></b> <a href="#" onclick="backlist('.$pgd_id.')">Kembali ke halaman sebelumnya</a>'; 
                        $html .='</div>'; 
                        $html .='</center>'; 
                        echo $html;
                  endif;
              ?>

          </form>

        </div>
      </div>
    
  </div>
</div>
<!-- PAGE CONTENT ENDS -->
<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url()?>assets/js/custom/peristiwa_custom.js"></script>
