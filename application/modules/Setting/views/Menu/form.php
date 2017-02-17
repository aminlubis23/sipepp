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
          <form class="form-horizontal" method="post" id="form_menu" action="<?php echo site_url('menu/process')?>">
            <br>

            <div class="form-group">
              <label class="control-label col-md-2">ID</label>
              <div class="col-md-1">
                <input name="id" id="id" value="<?php echo isset($value)?$value->id_menu:0?>" placeholder="Auto" class="form-control" type="text" readonly>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Menu Name</label>
              <div class="col-md-6">
                <input name="name" id="name" value="<?php echo isset($value)?$value->name:''?>" placeholder="Nama Menu" class="form-control" type="text">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Class</label>
              <div class="col-md-4">
                <input name="class" id="class" placeholder="Class" value="<?php echo isset($value)?$value->class:''?>" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">Link</label>
              <div class="col-md-3">
                <input name="link" id="link" placeholder="Link" value="<?php echo isset($value) ? $value->link : ''?>" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">Icon</label>
              <div class="col-md-3">
                <input name="icon" id="icon" placeholder="Icon" value="<?php echo isset($value) ? $value->icon : ''?>" class="form-control" type="text"><small>ex : menu-icon fa fa-leaf <i class="menu-icon fa fa-leaf"></i></small>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">Counter</label>
              <div class="col-md-3">
                <input name="counter" id="counter" placeholder="Counter" value="<?php echo isset($value) ? $value->counter : ''?>" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">Parent Menu</label>
              <div class="col-md-3">
                <?php echo $this->master->get_master_menu(isset($value)?$value->parent_menu:'','parent_menu','parent_menu','chosen-select form-control','required','inline');?>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Apps Role</label>
              <div class="col-md-3">
                <?php echo $this->master->get_master_custom(array('table'=>'m_apps','where'=>array('active'=>'Y'),'name'=>'apps_name','id'=>'apps_id'),isset($value)?$value->apps_id:'','apps_id','apps_id','chosen-select form-control','required','inline');?>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Description</label>
              <div class="col-md-8">
                <input name="description" id="description" placeholder="Deskripsi" value="<?php echo isset($value) ? $value->description : ''?>" class="form-control" type="text">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Set Notif ?</label>
              <div class="col-md-9">
                <div class="radio">
                      <label>
                        <input name="set_notif" type="radio" class="ace" value="Y" <?php echo isset($value) ? ($value->set_notif == 'Y') ? 'checked="checked"' : '' : 'checked="checked"'; ?>  />
                        <span class="lbl"> Ya</span>
                      </label>
                      <label>
                        <input name="set_notif" type="radio" class="ace" value="N" <?php echo isset($value) ? ($value->set_notif == 'N') ? 'checked="checked"' : '' : ''; ?>/>
                        <span class="lbl">Tidak</span>
                      </label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Set Shortcut ?</label>
              <div class="col-md-9">
                <div class="radio">
                      <label>
                        <input name="set_shortcut" type="radio" class="ace" value="Y" <?php echo isset($value) ? ($value->set_shortcut == 'Y') ? 'checked="checked"' : '' : 'checked="checked"'; ?>  />
                        <span class="lbl"> Ya</span>
                      </label>
                      <label>
                        <input name="set_shortcut" type="radio" class="ace" value="N" <?php echo isset($value) ? ($value->set_shortcut == 'N') ? 'checked="checked"' : '' : ''; ?>/>
                        <span class="lbl">Tidak</span>
                      </label>
                </div>
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
              <a id="btn_add_menu" <?php echo isset( $value ) ? '' : 'style="display:none"' ;?> href="#" class="btn btn-sm btn-primary">
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

<script src="<?php echo base_url()?>assets/js/custom/menu_custom.js"></script>
