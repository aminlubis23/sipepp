<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery-ui.custom.css" />
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
</style>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
          <div class="widget-body">
            <div class="widget-main no-padding">
              <form class="form-horizontal" method="post" id="form_faq" action="<?php echo site_url('pengaturan/faq/ajax_add')?>">
                <br>

                <div class="form-group">
                  <label class="control-label col-md-2">ID</label>
                  <div class="col-md-1">
                    <input name="id" id="id" value="<?php echo isset($value)?$value->faq_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Question</label>
                  <div class="col-md-6">
                    <input name="faq_title" id="faq_title" value="<?php echo isset($value)?$value->faq_title:''?>" class="form-control" type="text">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Answer</label>
                  <div class="col-md-6">
                    <div class="widget-box widget-color-blue">
                      <div class="widget-header widget-header-small">  </div>

                      <div class="widget-body">
                        <div class="widget-main no-padding">
                          <textarea name="faq_description" data-provide="markdown" data-iconlibrary="fa" rows="10"><?php echo isset($value)?$value->faq_description:''?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Flag </label>
                  <div class="col-md-9">
                    <div class="radio">
                          <label>
                            <input name="faq_flag" type="radio" class="ace" value="general" <?php echo isset($value) ? ($value->faq_flag == 'general') ? 'checked="checked"' : '' : ''; ?>  />
                            <span class="lbl"> General </span>
                          </label>
                          <label>
                            <input name="faq_flag" type="radio" class="ace" value="tutorial" <?php echo isset($value) ? ($value->faq_flag == 'tutorial') ? 'checked="checked"' : '' : ''; ?>/>
                            <span class="lbl"> Tutorial</span>
                          </label>
                          <label>
                            <input name="faq_flag" type="radio" class="ace" value="lainnya" <?php echo isset($value) ? ($value->faq_flag == 'lainnya') ? 'checked="checked"' : '' : ''; ?>/>
                            <span class="lbl"> Lainnya</span>
                          </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Status Aktif ?</label>
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

                  <!--hidden field-->
                  <!-- <input type="text" name="id" value="<?php echo isset($value)?$value->faq_id:0?>"> -->

                  <a onclick="getMenu('pengaturan/faq')" href="#" class="btn btn-sm btn-success">
                    <i class="ace-icon fa fa-arrow-left icon-on-right bigger-110"></i>
                    Kembali ke daftar
                  </a>
                  <a onclick="add()" id="btnAdd" <?php echo isset( $value ) ? '' : 'style="display:none"' ;?> href="#" class="btn btn-sm btn-primary">
                    <i class="ace-icon fa fa-plus icon-on-right bigger-110"></i>
                    Tambah baru
                  </a>
                  <button type="reset" id="btnReset" class="btn btn-sm btn-danger">
                    <i class="ace-icon fa fa-close icon-on-right bigger-110"></i>
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
    
    <!-- PAGE CONTENT ENDS -->
  </div><!-- /.col -->
</div><!-- /.row -->

<script src="<?php echo base_url().'assets/js/custom/faq.js'?>"></script>
<script src="<?php echo base_url()?>assets/js/jquery-ui.custom.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery-ui.custom.js"></script>
    <script src="<?php echo base_url()?>/assets/js/jquery.ui.touch-punch.js"></script>
    <script src="<?php echo base_url()?>/assets/js/markdown/markdown.js"></script>
    <script src="<?php echo base_url()?>/assets/js/markdown/bootstrap-markdown.js"></script>
    <script src="<?php echo base_url()?>/assets/js/jquery.hotkeys.js"></script>
    <script src="<?php echo base_url()?>/assets/js/bootstrap-wysiwyg.js"></script>
    <script src="<?php echo base_url()?>/assets/js/bootbox.js"></script>