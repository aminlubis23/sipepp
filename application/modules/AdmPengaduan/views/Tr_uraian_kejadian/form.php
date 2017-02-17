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
          <form class="form-horizontal" method="post" id="form_uraian" action="<?php echo site_url('AdmPengaduan/Tr_uraian_kejadian/process')?>">
            <br>
                <div class="form-group">
                    <label class="control-label col-md-2">ID</label>
                    <div class="col-md-1">
                      <input name="pgdu_id" id="pgdu_id" value="<?php echo isset($value)?$value->pgdu_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
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
                    Uraian Singkat Kejadian
                  </h1>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Uraian Singkat Kejadian</label>
                  <div class="col-md-8">
                    <textarea name="pgdu_uraian_kejadian" id="pgdu_uraian_kejadian" placeholder="Uraian singkat kejadian..." class="form-control" rows="13"><?php echo isset($value)?$value->pgdu_uraian_kejadian:''?></textarea>
                  </div>
                </div>

                <?php if($pgd->last_proses == 1) :?>
                <div class="form-actions center">
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
                        $html .='[ <i class="fa fa-info"></i> ] Pengaduan sedang dalam proses <b><i>"'.$this->registrasi->getStatusPengaduan($pgd_id).'", </i></b>'; 
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
<script src="<?php echo base_url()?>assets/js/custom/uraian_custom.js"></script>
