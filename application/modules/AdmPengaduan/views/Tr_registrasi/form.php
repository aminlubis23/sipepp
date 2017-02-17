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
                      /*$('<li class="active-result" data-option-array-index="'+o.city_id+'">'+o.city_name+'</li>').appendTo($('#city_id_chosen ul .chosen-results'));*/
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
                  $('#subdistrict_id option').remove()
                  $('<option value="">(Select Subdistrict)</option>').appendTo($('#subdistrict_id'));
                  $.each(data, function(i, o) {
                      $('<option value="'+o.subdistrict_id+'">'+o.subdistrict_name+'</option>').appendTo($('#subdistrict_id'));
                  });

              });
          } else {
              $('#subdistrict_id option').remove()
              $('<option value="">(Select Subdistrict)</option>').appendTo($('#subdistrict_id'));
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
          <form class="form-horizontal" method="post" id="form_registrasi" action="<?php echo site_url('AdmPengaduan/Tr_registrasi/process')?>">
            <br>

            <div class="form-group">
              <label class="control-label col-md-2">ID</label>
              <div class="col-md-1">
                <input name="id" id="id" value="<?php echo isset($value)?$value->pgd_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
              </div>
              <label class="control-label col-md-2">Tanggal Pengaduan</label>
                <div class="col-md-2">
                  <div class="input-group">
                    <input class="form-control date-picker" name="pgd_tanggal" id="pgd_tanggal" type="text" data-date-format="yyyy-mm-dd" value="<?php echo isset($value)?$value->pgd_tanggal:date('Y-m-d')?>"/>
                    <span class="input-group-addon">
                      <i class="fa fa-calendar bigger-110"></i>
                    </span>
                  </div>
                </div>

            </div>


            <div class="form-group">
              <label class="control-label col-md-2">Kategori Pemilu</label>
              <div class="col-md-4">
                <?php echo $this->master->get_master_custom(array('table'=>'mst_kategori_pemilu', 'where'=>array('active'=>'Y'), 'id'=>'kp_id', 'name'=>'kp_name'), isset($value->kp_id)?$value->kp_id:'','kp_id','kp_id', 'chosen-select form-control','required','inline')?>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">Tipe Pengaduan</label>
              <div class="col-md-6">
                <?php echo $this->master->get_master_custom(array('table'=>'mst_tipe_pengaduan', 'where'=>array('active'=>'Y'), 'id'=>'tp_id', 'name'=>'tp_name'), isset($value->tp_id)?$value->tp_id:'','tp_id','tp_id', 'chosen-select form-control','required','inline')?>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Tempat Pengaduan</label>
              <div class="col-md-4">
                <input name="pgd_tempat" id="pgd_tempat" value="<?php echo isset($value)?$value->pgd_tempat:''?>" class="form-control" type="text">
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
                <?php echo $this->master->get_change_master_sub_district(isset($value->subdistrict_id)?$value->subdistrict_id:'','subdistrict_id','subdistrict_id', 'form-control','required','inline')?>
              </div>
            </div>


            <!-- <div class="form-group">
              <label class="control-label col-md-2">Is active? ?</label>
              <div class="col-md-9">
                <div class="radio">
                      <label>
                        <input name="active" type="radio" class="ace" value="Y" <?php echo isset($value) ? ($value->active == 'Y') ? 'checked="checked"' : '' : 'checked="checked"'; ?>  />
                        <span class="lbl"> Yes</span>
                      </label>
                      <label>
                        <input name="active" type="radio" class="ace" value="N" <?php echo isset($value) ? ($value->active == 'N') ? 'checked="checked"' : '' : ''; ?>/>
                        <span class="lbl">No</span>
                      </label>
                </div>
              </div>
            </div> -->

            <div class="form-actions center">

              <a onclick="backlist()" href="#" class="btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-arrow-left icon-on-right bigger-110"></i>
                Back to list
              </a>
              <a id="btn_add_registrasi" <?php echo isset( $value ) ? '' : 'style="display:none"' ;?> href="#" class="btn btn-sm btn-primary">
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
<script src="<?php echo base_url()?>assets/js/custom/registrasi_custom.js"></script>
