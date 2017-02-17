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

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
          <div class="widget-body">
            <div class="widget-main no-padding">
              <form class="form-horizontal" method="post" id="form_permission_role" action="<?php echo site_url('Setting/Role/processSetPermission')?>">
                <br>

                <div class="form-group">
                  <label class="control-label col-md-2">ID</label>
                  <div class="col-md-1">
                    <input name="id" id="id" value="<?php echo isset($value)?$value->id_role:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Role Name</label>
                  <div class="col-md-6">
                    <input name="role_name" id="role_name" value="<?php echo isset($value)?strtoupper($value->role_name):''?>" placeholder="Nama Role" class="form-control" type="text" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Permission Module</label>
                  <div class="col-md-9">
                    <table class="table table-striped table-bordered">
                          <thead>
                            <tr style="color:black">
                              <th class="center">Nama Menu</th>
                              <?php 
                                $no = 0;
                                $func = $this->master->get_func_action_data();
                                foreach ($func as $key => $values) {
                              ?>
                              <th class="center"><?php echo strtoupper($values['name']). '<br>[ '.$values['code'].' ]'?></th>
                              <?php $no++; }?>
                            </tr>
                          </thead>

                          <tbody>
                            <?php
                              $menu = $this->master->get_menu_data(array('apps_id'=>isset($value->apps_id)?$value->apps_id:0)); //echo '<pre>';print_r($menu);die;
                              foreach ($menu as $key2 => $row) {
                            ?>
                            <tr>
                              <td><?php echo ucfirst($row['name'])?></td>

                               <?php 
                                $no = 0;
                                $func_row = $this->master->get_func_action_data();
                                foreach ($func_row as $key3 => $func_row) {
                              ?>

                              <td class="center">
                                <label class="pos-rel">
                                  <?php if($row['link'] != '#'){?>
                                    <input type="checkbox" name="chk[]" value="<?php echo $row['id_menu']?>-<?php echo $func_row['code']?>" class="ace" <?php echo $this->role->get_checked_form($row['id_menu'], $value->id_role, $func_row['code'])?>/>
                                    <span class="lbl"></span>
                                  <?php }?>
                                </label>
                              </td>

                              <?php $no++; }?>

                            </tr>
                            <?php foreach ($row['submenu'] as $rowsubmenu) {?>
                                <tr>
                                <td>&nbsp;&nbsp;&nbsp;<i class="fa fa-check"></i> <?php echo ucfirst($rowsubmenu['name'])?></td>

                                 <?php 
                                  $no = 0;
                                  $func_row = $this->master->get_func_action_data();
                                  foreach ($func_row as $key3 => $func_row) {
                                ?>

                                <td class="center">
                                  <label class="pos-rel">
                                    <input type="checkbox" name="chk[]" value="<?php echo $rowsubmenu['id_menu']?>-<?php echo $func_row['code']?>" class="ace" <?php echo $this->role->get_checked_form($rowsubmenu['id_menu'], $value->id_role, $func_row['code'])?>/>
                                    <span class="lbl"></span>
                                  </label>
                                </td>

                                <?php $no++; }?>

                              </tr>

                              <?php }?>
                            
                            <?php }?>
                        </tbody>
                    </table>
                  </div>
                </div>
                

                <div class="form-actions center">

                  <a onclick="backlist()" href="#" class="btn btn-sm btn-inverse">
                    <i class="ace-icon fa fa-arrow-left icon-on-right bigger-110"></i>
                    Back to list
                  </a>
                  <a type="submit" id="btnSavePermission" name="submit" class="btn btn-sm btn-info">
                    <i class="ace-icon fa fa-check-square-o icon-on-right bigger-110"></i>
                    Submit
                  </a>
                </div>
              </form>
            </div>
          </div>
    
    <!-- PAGE CONTENT ENDS -->
  </div><!-- /.col -->
</div><!-- /.row -->


<script src="<?php echo base_url().'assets/js/custom/role_custom.js'?>"></script>
