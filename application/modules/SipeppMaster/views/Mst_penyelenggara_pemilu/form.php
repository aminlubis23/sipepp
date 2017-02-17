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
          <form class="form-horizontal" method="post" id="form_penyelenggara_pemilu" action="<?php echo site_url('Reference/Mst_penyelenggara_pemilu/process')?>">
            <br>

            <div class="form-group">
              <label class="control-label col-md-2">ID</label>
              <div class="col-md-1">
                <input name="id" id="id" value="<?php echo isset($value)?$value->pp_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
              </div>
            </div>


            <div class="form-group">
              <label class="control-label col-md-2">Nama Penyelenggara Pemilu</label>
              <div class="col-md-4">
                <input name="pp_name" id="pp_name" value="<?php echo isset($value)?$value->pp_name:''?>" placeholder="Nama Penyelenggara Pemilu" class="form-control" type="text">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Kategori</label>
              <div class="col-md-9">
                <div class="radio">
                      <label>
                        <input name="flag" type="radio" class="ace" value="BAWASLU" <?php echo isset($value) ? ($value->flag == 'BAWASLU') ? 'checked="checked"' : '' : 'checked="checked"'; ?>  />
                        <span class="lbl"> BAWASLU </span>
                      </label>
                      <label>
                        <input name="flag" type="radio" class="ace" value="KPU" <?php echo isset($value) ? ($value->flag == 'KPU') ? 'checked="checked"' : '' : ''; ?>/>
                        <span class="lbl">KPU</span>
                      </label>
                </div>
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
              <a id="btn_add_penyelenggara_pemilu" <?php echo isset( $value ) ? '' : 'style="display:none"' ;?> href="#" class="btn btn-sm btn-primary">
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

<script src="<?php echo base_url()?>assets/js/custom/penyelenggara_pemilu_custom.js"></script>
