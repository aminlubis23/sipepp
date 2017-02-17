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
          <form class="form-horizontal" method="post" id="form_user" action="<?php echo site_url('user/process')?>">
            <br>

            <div class="form-group">
              <label class="control-label col-md-2">ID</label>
              <div class="col-md-1">
                <input name="id" id="id" value="<?php echo isset($value)?$value->id_user:0?>" placeholder="Auto" class="form-control" type="text" readonly>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Fullname</label>
              <div class="col-md-6">
                <input name="fullname" id="fullname" value="<?php echo isset($value)?$value->fullname:''?>" placeholder="Fullname" class="form-control" type="text">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Username</label>
              <div class="col-md-4">
                <input name="email" id="email" placeholder="Username" value="<?php echo isset($value)?$value->email:''?>" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">Password</label>
              <div class="col-md-3">
                <input name="password" id="password" placeholder="Password" value="<?php echo isset($value)?$this->encryption->decrypt_password_callback($value->password, SECURITY_KEY):''?>" class="form-control" type="password">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Password Confirmation</label>
              <div class="col-md-3">
                <input name="confirm_password" id="confirm_password" placeholder="Password Confirmation" class="form-control" type="password">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Role</label>
              <div class="col-md-3">
                <?php echo $this->master->get_master_role(isset($value)?$value->id_role:'','role','role','chosen-select form-control','required','inline');?>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">is Active ?</label>
              <div class="col-md-9">
                <div class="radio">
                      <label>
                        <input name="active" type="radio" class="ace" value="Y" <?php echo isset($value) ? ($value->active == 'Y') ? 'checked="checked"' : '' : 'checked="checked"'; ?>  />
                        <span class="lbl"> Ya</span>
                      </label>
                      <label>
                        <input name="active" type="radio" class="ace" value="N" <?php echo isset($value) ? ($value->active == 'N') ? 'checked="checked"' : '' : ''; ?>/>
                        <span class="lbl">Tidak</span>
                      </label>
                </div>
              </div>
            </div>

            <div class="form-actions center">

              <a onclick="backlist()" href="#" class="btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-arrow-left icon-on-right bigger-110"></i>
                Back to list
              </a>
              <a id="btn_add_user" <?php echo isset( $value ) ? '' : 'style="display:none"' ;?> href="#" class="btn btn-sm btn-primary">
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

<script src="<?php echo base_url()?>assets/js/custom/user_custom.js"></script>
