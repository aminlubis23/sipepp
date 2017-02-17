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

<form class="form-horizontal" method="post" id="form_bukti" action="<?php echo site_url('AdmPengaduan/Tr_bukti/process')?>" enctype="multipart/form-data">
  <br>
      <div class="form-group">
          <label class="control-label col-md-2">ID</label>
          <div class="col-md-1">
            <input name="pgdb_id" id="pgdb_id" value="<?php echo isset($value)?$value->pgdb_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-2">*No Registrasi</label>
        <div class="col-md-2">
          <input name="pgd_id" id="pgd_id" value="<?php echo isset($value)?$value->pgd_id:$pgd_id?>" class="form-control" type="text"><i>*Wajib diisi</i>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2">Penjelasan alat/barang bukti</label>
        <div class="col-md-6">
          <textarea name="pgdb_keterangan" id="pgdb_keterangan" class="form-control" rows="3"><?php echo isset($value)?$value->pgdb_keterangan:''?></textarea>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2">File lampiran</label>
        <div class="col-md-8">
          <input  type="file" name="file[]" id="file" multiple />
        </div>
      </div>

      <?php if(isset($value)) :?>
        <div class="form-group">
          <label class="control-label col-md-2">&nbsp;</label>
          <div class="col-md-10">
            <div class="widget-body">
              <div class="widget-main no-padding">
                <div class="col-xs-12 col-sm-10 widget-container-col">
                  <div class="widget-box widget-color-orange">
                    <!-- #section:custom/widget-box.options -->
                    <div class="widget-header">
                      <h5 class="widget-title bigger lighter">
                        <i class="ace-icon fa fa-file"></i>
                        File Lampiran
                      </h5>
                    </div>

                    <!-- /section:custom/widget-box.options -->
                    <div class="widget-body">
                      <div class="widget-main no-padding">
                        <table class="table table-striped table-bordered table-hover">
                          <tbody>
                            <?php 
                              if(!empty($files)) {
                                foreach($files as $rowfiles){
                            ?>
                            <tr id="<?php echo $rowfiles->attc_id?>">
                              <td class=""><a href="<?php echo base_url().$rowfiles->attc_fullpath?>"  target="_blank"><?php echo $rowfiles->attc_name?></a></td>
                              <td class=""><?php echo $rowfiles->attc_type?></td>
                              <td class=""><?php echo $rowfiles->attc_size.' kb'?></td>
                              <td class=""><?php echo $rowfiles->attc_owner?></td>
                              <td class=""><?php echo $this->tanggal->formatDateTime($rowfiles->created_date)?></td>
                              <td class=""><?php echo ucwords(str_replace('_',' ',$rowfiles->flag))?></td>
                              <td class="center"><a href="#" onclick="delete_file_lampiran(<?php echo $rowfiles->attc_id?>)"><i class="fa fa-times-circle red"></i></a></td>
                            </tr>
                          <?php } } else{ echo '<tr><td>Tidak ada file</td></tr>'; }?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        
      <?php endif;?>
      <div class="form-group">
        <label class="control-label col-md-2">Tipe bukti</label>
        <div class="col-md-9">
          <div class="radio">
              <label>
                <input name="flag" type="radio" class="ace" value="alat_bukti" <?php echo isset($value) ? ($value->flag == 'alat_bukti') ? 'checked="checked"' : '' : 'checked="checked"'; ?>  />
                <span class="lbl"> Alat Bukti </span>
              </label>
              <label>
                <input name="flag" type="radio" class="ace" value="barang_bukti" <?php echo isset($value) ? ($value->flag == 'barang_bukti') ? 'checked="checked"' : '' : ''; ?>/>
                <span class="lbl">Barang Bukti</span>
              </label>
          </div>
        </div>
      </div>

      <?php if($pgd->last_proses == 1) :?>
      <div class="form-actions center">

        <a onclick="backlist(<?php echo $pgd_id?>)" href="#" class="btn btn-sm btn-inverse">
          <i class="ace-icon fa fa-arrow-left icon-on-right bigger-110"></i>
          Back to list
        </a>
        <a id="btn_add_bukti" <?php echo isset( $value ) ? '' : 'style="display:none"' ;?> href="#" class="btn btn-sm btn-primary">
          <i class="ace-icon fa fa-plus icon-on-right bigger-110"></i>
          Create new
        </a>
        <button type="reset" id="btnReset" class="btn btn-sm btn-danger">
          <i class="ace-icon fa fa-refresh icon-on-right bigger-110"></i>
          Reset
        </button>
        <!-- <button type="submit" id="btnSave" name="submit" class="btn btn-sm btn-info">
          <i class="ace-icon fa fa-check-square-o icon-on-right bigger-110"></i>
          Submit
        </bitton> -->
        <a href="#" id="btnSave" name="submit" class="btn btn-sm btn-info">
          <i class="ace-icon fa fa-check-square-o icon-on-right bigger-110"></i>
          Submit
        </a>
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

<!-- ace scripts -->
<script src="<?php echo base_url()?>/assets/js/bootstrap.js"></script>
<script src="<?php echo base_url()?>/assets/js/ace-elements.js"></script>
<script src="<?php echo base_url()?>/assets/js/ace.js"></script>
<script src="<?php echo base_url()?>assets/js/custom/bukti_custom.js"></script>
