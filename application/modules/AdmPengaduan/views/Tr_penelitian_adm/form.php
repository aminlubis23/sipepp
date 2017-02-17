<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
<script src="<?php echo base_url()?>assets/ckeditor/ckeditor.js" type="text/javascript"></script>

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
          <div class="col-xs-12 col-sm-12 widget-container-col">
            <div class="widget-box widget-color-orange">
              <!-- #section:custom/widget-box.options -->
              <div class="widget-header">
                <h5 class="widget-title bigger lighter">
                  <i class="ace-icon fa fa-eye"></i>
                  Formulir Pengaduan No <?php echo $pgd->pgd_id?>
                </h5>
              </div>

              <!-- /section:custom/widget-box.options -->
              <div class="widget-body">
                <div class="widget-main no-padding">
                  <table class="table table-striped table-bordered table-hover">
                    <tbody>
                      <tr>
                        <td class="" style="width:20%">No Registrasi</td>
                        <td class="left">
                          <?php echo $pgd->pgd_id?>
                          <input type="hidden" name="pgd_id" id="pgd_id" value="<?php echo $pgd->pgd_id?>">
                        </td>
                        <td class="" style="width:20%">Tanggal</td>
                        <td class="left"><?php echo $this->tanggal->formatDate($pgd->pgd_tanggal)?></td>
                      </tr>
                      <tr>
                        <td class="" style="width:20%">Tempat Pengaduan</td>
                        <td class="left"><?php echo $pgd->pgd_tempat?></td>
                         <td class="" style="width:20%">Kategori Pemilu</td>
                        <td class="left"><?php echo $pgd->kp_name?></td>
                      </tr>
                      <tr>
                        <td class="" style="width:20%">Tipe Pengaduan</td>
                        <td class="left" colspan="3"><?php echo $pgd->tp_name?></td>
                      </tr>
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

<br>     
<div class="row">
  <div class="col-xs-12">
      <div class="widget-body">
        <div class="widget-main no-padding">
          
          <div class="page-header">
            <h1>Form Verifikasi Administrasi Pengaduan DKPP</h1>
          </div>

          <!-- BEGIN FORM -->
          <form class="form-horizontal" method="post" id="form_registrasi" action="<?php echo site_url('AdmPengaduan/Tr_registrasi/process')?>">
            <br>

            <div class="form-group">
              <label class="control-label col-md-2">No Pengaduan</label>
              <div class="col-md-1">
                <input name="pgd_no" id="pgd_no" value="<?php echo isset($pgd)?$pgd->pgd_no:0?>" class="form-control" type="text">
              </div>
              <label class="control-label col-md-2">Tanggal Verifikasi</label>
                <div class="col-md-2">
                  <div class="input-group">
                    <input class="form-control date-picker" name="pgdhpa_tanggal_penelitian" id="pgdhpa_tanggal_penelitian" type="text" data-date-format="yyyy-mm-dd" value="<?php echo isset($value)?$value->pgdhpa_tanggal_penelitian:date('Y-m-d')?>"/>
                    <span class="input-group-addon">
                      <i class="fa fa-calendar bigger-110"></i>
                    </span>
                  </div>
                </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">Penerima Pengaduan</label>
              <div class="col-md-4">
                <?php echo $this->master->get_master_custom(array('table'=>'vw_pegawai', 'where'=>array(), 'id'=>'pg_id', 'name'=>'ktp_nama_lengkap'), isset($value->pg_id)?$value->pg_id:'','pg_id','pg_id', 'chosen-select form-control','required','inline')?>
              </div>
            </div>

            <div class="page-header">
              <h1>Kelengkapan Administrasi</h1>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Kelengkapan form? </label>
              <div class="col-md-9">
                <div class="radio">
                      <label>
                        <input name="pgdhpa_kelengkapan_form" type="radio" class="ace" value="lengkap" <?php echo isset($value) ? ($value->pgdhpa_kelengkapan_form == 'lengkap') ? 'checked="checked"' : '' : 'checked="checked"'; ?>  />
                        <span class="lbl"> Lengkap </span>
                      </label>
                      <label>
                        <input name="pgdhpa_kelengkapan_form" type="radio" class="ace" value="tidak lengkap" <?php echo isset($value) ? ($value->pgdhpa_kelengkapan_form == 'tidak lengkap') ? 'checked="checked"' : '' : ''; ?>/>
                        <span class="lbl">Tidak Lengkap</span>
                      </label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">2 (dua) alat/barang bukti</label>
              <div class="col-md-9">
                <span class="btn btn-sm btn-primary" id="addalatbukti" style="cursor:pointer"> <i class="fa fa-plus"></i> Tambah </span>
                    <span class="btn btn-sm btn-danger" id="cancelalatbukti" style="cursor:pointer"> <i class="glyphicon glyphicon-remove"></i> Batalkan </span>
                <br>

                <div class="widget-box widget-color-dark">
                    <!-- #section:custom/widget-box.options -->
                    <div class="widget-header">
                      <h5 class="widget-title bigger lighter">
                        <i class="ace-icon fa fa-file"></i>
                        Alat/Barang Bukti
                      </h5>
                    </div>

                    <!-- /section:custom/widget-box.options -->
                    <div class="widget-body">
                      <div class="widget-main no-padding">
                        <table class="table table-striped table-bordered table-hover">
                          <tbody>
                            <?php 
                              if(!empty($bukti)) {
                                $no=0;
                                foreach($bukti as $rowbukti){
                                  $no++;
                                  if(!empty($rowbukti->pgdb_keterangan)):
                            ?>
                            <tr id="<?php echo $rowbukti->pgdb_id?>">
                              <td class="center" width="50px"><?php echo $no;?></td>
                              <td class="" width="60%"><?php echo $rowbukti->pgdb_keterangan?></td>
                              <td class=""><?php echo ucwords(str_replace('_',' ',$rowbukti->flag))?></td>
                              <td class=""><?php echo $this->tanggal->formatDateTime($rowbukti->created_date)?></td>
                              <td class="center" width="10%"><?php echo ($rowbukti->fullpath)?$rowbukti->fullpath:'Tidak ada lampiran'?> </td>
                              <td class="center"><a href="#" onclick="delete_file_lampiran(<?php echo $rowbukti->pgdb_id?>)"><i class="fa fa-times-circle red"></i></a></td>
                            </tr>
                          <?php endif; } } else{ echo '<tr><td>Tidak ada file</td></tr>'; }?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
              </div>
            </div>

            <div class="form-group" id="showforminput" style="display:none">
              <label class="control-label col-md-2">&nbsp;</label>
              <div class="col-md-10">
                <b><i>Silahkan tambah alat bukti :</i></b>
                <br>
                <p class="phone">
                  <label class="inline"> 
                    <input type="text" name="addbukti[]" id="addbukti" style="width: 300px" class="input-small" placeholder="Keterangan bukti" />
                  </label>
                  <label class="inline" style="padding-top:2px"> 
                    <input type="file" name="addbukti[]" id="addbukti" style="width: 250px" class="form-control"/>
                  </label>
                  <a href="#" class="copy btn btn-sm btn-primary" rel=".phone"><i class="fa fa-plus"></i> Add Row </a>
                </p>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Surat kuasa hukum <br> (Jika dikuasakan) dan bermaterai cukup </label>
              <div class="col-md-9">
                <div class="radio">
                      <label>
                        <input name="pgdhpa_status_kuasa" type="radio" class="ace" value="lengkap" <?php echo isset($value) ? ($value->pgdhpa_status_kuasa == 'lengkap') ? 'checked="checked"' : '' : 'checked="checked"'; ?>  />
                        <span class="lbl"> Lengkap </span>
                      </label>
                      <label>
                        <input name="pgdhpa_status_kuasa" type="radio" class="ace" value="tidak lengkap" <?php echo isset($value) ? ($value->pgdhpa_status_kuasa == 'tidak lengkap') ? 'checked="checked"' : '' : ''; ?>/>
                        <span class="lbl">Tidak Lengkap</span>
                      </label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-2">Pokok Pengaduan</label>
              <div class="col-md-8">
                <textarea id="myTextarea" class="ckeditor form-control" name="pgdhpa_pokok_pengaduan" rows="10" ></textarea>
              </div>
            </div>

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
<script src="<?php echo base_url()?>assets/js/custom/penelitian_adm_custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/relCopy.jquery.js"></script>
<script>

  $(function(){
      var removeLink = ' <a class="remove btn btn-sm btn-danger" href="#" onclick="$(this).parent().remove(); return false"><i class="glyphicon glyphicon-remove"></i></a>';
    $('a.copy').relCopy({limit: 5, append: removeLink});  
  });

  $(document).ready(function() {    

      $('#addalatbukti').click(function () { 
          $('#showforminput').show('fast');
      });

      $('#cancelalatbukti').click(function () { 
                $('#showforminput').hide('fast');
                $('#showforminput').reomve();
            });


  });
</script>


