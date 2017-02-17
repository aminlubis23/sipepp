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
          <form class="form-horizontal" method="post" id="form_subdistrict" action="<?php echo site_url('Regional/M_subdistrict/process')?>">
            <br>

            <div class="form-group">
              <label class="control-label col-md-2">Subdistrict ID</label>
              <div class="col-md-1">
                <input name="id" id="id" value="<?php echo isset($value)?$value->subdistrict_id:''?>" placeholder="ID" class="form-control" type="text">
              </div>
            </div>


            <div class="form-group">
              <label class="control-label col-md-2">Subdistrict Name</label>
              <div class="col-md-4">
                <input name="subdistrict_name" id="subdistrict_name" value="<?php echo isset($value)?$value->subdistrict_name:''?>" placeholder="Subdistrict Name" class="form-control" type="text">
              </div>
            </div>

            <div class="form-group" id="form-provinsi">
              <label class="control-label col-md-2">Province</label>
              <div class="col-md-3">
                <?php   
                  echo $this->master->get_master_province(isset($value)?$value->province_id:'','province_id','province_id','form-control','required','inline');?>
              </div>

              <label class="control-label col-md-1">City</label>
              <div class="col-md-3">
                <?php 
                  echo $this->master->get_change_master_city(isset($value)?$value->city_id:'','city_id','city_id','form-control','required','inline');?>
              </div>
            </div>

            <div class="form-group" id="form-provinsi">
              <label class="control-label col-md-2">District</label>
              <div class="col-md-3">
                <?php 
                  echo $this->master->get_change_master_district(isset($value)?$value->district_id:'','district_id','district_id','form-control','required','inline');?>
              </div>
            </div>


            <div class="form-group">
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
            </div>

            <div class="form-actions center">

              <a onclick="backlist()" href="#" class="btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-arrow-left icon-on-right bigger-110"></i>
                Back to list
              </a>
              <a id="btn_add_subdistrict" <?php echo isset( $value ) ? '' : 'style="display:none"' ;?> href="#" class="btn btn-sm btn-primary">
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

<script src="<?php echo base_url()?>assets/js/custom/subdistrict_custom.js"></script>
