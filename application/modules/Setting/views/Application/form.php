<title><?php echo $title?></title>
<!-- ajax layout which only needs content area -->
<div class="page-header">
  <h1>
    <?php echo $title?>
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      <?php echo $subtitle?>
    </small>
  </h1>
</div><!-- /.page-header -->

<style type="text/css">
label.error { color:red; }
tr.group,
tr.group:hover {
    background-color: #ddd !important;
}
.input {margin-top: -6px; margin-bottom: -6px}
</style>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
      <form class="form-horizontal" method="post" id="form_app" action="<?php echo site_url('pengaturan/aplikasi/proses_app')?>">
        <div class="col-xs-12 col-sm-12 widget-container-col">
          <div class="widget-box widget-color-blue">
          <!-- #section:custom/widget-box.options -->
          <div class="widget-header">
            <h5 class="widget-title bigger lighter">
              <i class="ace-icon fa fa-eye"></i>
              Profile Application
            </h5>
          </div>

          <!-- /section:custom/widget-box.options -->
          <div class="widget-body">
            <div class="widget-main no-padding">
              <table class="table table-striped table-bordered table-hover">
                <tbody>
                  <tr>
                    <td class="" style="width:20%">Application Name</td>
                    <td class="left">
                      <input type="hidden" name="uk_id" value="">
                      <input type="text" id="app_name" name="app_name" style="width:600px" value="<?php echo isset($value->app_name)?$value->app_name:''?>" class="input" /></td>
                  </tr>

                  <tr>
                    <td class="" style="width:20%">Header Title</td>
                    <td class="left"><input type="text" id="header_title" value="<?php echo isset($value->header_title)?$value->header_title:''?>" style="width:600px" name="header_title" class="input" /></td>
                  </tr>

                  <tr>
                    <td class="" style="width:20%">Footer Text</td>
                    <td class="left"><input type="text" id="text_footer" style="width:600px" class="input" value="<?php echo isset($value->footer_text)?$value->footer_text:''?>" name="text_footer" /></td>
                  </tr>

                  <tr>
                    <td class="" style="width:20%">Copyright</td>
                    <td class="left"><input type="text" id="copyright" class="input" value="<?php echo isset($value->copyright)?$value->copyright:''?>" name="copyright" /></td>
                  </tr>

                  <tr>
                    <td class="" style="width:20%">Logo/Icon</td>
                    <td class="left"><input type="file" id="form-field-1" name="icon" style="border:0px solid black" /></td>
                  </tr>

                  <tr>
                    <td class="" style="width:20%">Description</td>
                    <td class="left"><textarea name="description" id="description" class="input" cols="50"><?php echo isset($value->app_description)?$value->app_description:''?></textarea></td>
                  </tr>

                  <tr>
                    <td class="" style="width:20%">Autor Name</td>
                    <td class="left"><input type="text" id="auth_name" value="<?php echo isset($value->author)?$value->author:''?>" name="auth_name" class="input" /></td>
                  </tr>

                  <tr>
                    <td class="" style="width:20%">Company Name</td>
                    <td class="left"><input type="text" id="company_name" value="<?php echo isset($value->company_name)?$value->company_name:''?>" name="company_name" class="input" /></td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>


      <div class="form-actions center">
        <a href="<?php echo base_url().'dashboard'?>" class="btn btn-sm btn-success">
          <i class="ace-icon fa fa-refresh icon-on-right bigger-110"></i> 
          Reload
        </a>

        <button type="submit" id="btnSave" name="submit" class="btn btn-sm btn-info">
          <i class="ace-icon fa fa-check-square-o icon-on-right bigger-110"></i>
          Submit
        </button>
      </div>
    </form>
    
    <!-- PAGE CONTENT ENDS -->
  </div><!-- /.col -->
</div><!-- /.row -->

<script src="<?php echo base_url().'assets/js/custom/aplikasi.js'?>"></script>
