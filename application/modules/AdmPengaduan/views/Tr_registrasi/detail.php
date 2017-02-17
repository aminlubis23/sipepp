<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
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
                      /*$('<li class="active-result" data-option-array-index="'+o.city_id+'">'+o.city_name+'</li>').appendTo($('#city_id_chosen ul .chosen-results'));*/
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

      $('select[name="district_id"]').change(function() {
          if ($(this).val()) {
              $.getJSON("<?php echo site_url('Regional/M_district/get_sub_district_by_district') ?>/" + $(this).val(), '', function(data) {
                  $('#subdistrict_id option').remove()
                  $('<option value="">(Select Subdistrict)</option>').appendTo($('#subdistrict_id'));
                  $.each(data, function(i, o) {
                      $('<option value="'+o.subdistrict_id+'">'+o.subdistrict_name+'</option>').appendTo($('#subdistrict_id'));
                  });

              });
          } else {
              $('#subdistrict_id option').remove()
              $('<option value="">(Select Subdistrict)</option>').appendTo($('#subdistrict_id'));
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
      <form id="form-detail">
        <div class="widget-body">
          <div class="widget-main no-padding">
            <div class="col-xs-12 col-sm-12 widget-container-col">
              <div class="widget-box widget-color-blue">
                <!-- #section:custom/widget-box.options -->
                <div class="widget-header">
                  <h5 class="widget-title bigger lighter">
                    <i class="ace-icon fa fa-eye"></i>
                    Formulir Pengaduan No <?php echo $value->pgd_id?>
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
                            <?php echo $value->pgd_id?>
                            <input type="hidden" name="pgd_id" id="pgd_id" value="<?php echo $value->pgd_id?>">
                            <input type="hidden" name="status" id="status" value="<?php echo $value->last_proses?>">
                          </td>
                          <td class="" style="width:20%">Tanggal</td>
                          <td class="left"><?php echo $this->tanggal->formatDate($value->pgd_tanggal)?></td>
                        </tr>
                        <tr>
                          <td class="" style="width:20%">Tempat Pengaduan</td>
                          <td class="left"><?php echo $value->pgd_tempat?></td>
                           <td class="" style="width:20%">Kategori Pemilu</td>
                          <td class="left"><?php echo $value->kp_name?></td>
                        </tr>
                        <tr>
                          <td class="" style="width:20%">Tipe Pengaduan</td>
                          <td class="left"><?php echo $value->tp_name?></td>
                          <td class="" style="width:20%">Status Pengaduan</td>
                          <td class="left"><?php echo $this->registrasi->getStatusPengaduan($value->pgd_id)?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>

  </div>
</div>
<hr class="separator">

<!-- BEGIN TAB FORM -->
<div class="row">
  <div class="col-sm-12">
    <!-- #section:elements.tab -->
    <div class="tabbable">
      <ul class="nav nav-tabs" id="myTab">
        <li>
          <a id="tab_para_pihak" rel="<?php echo $value->pgd_id?>" data-toggle="tab" href="#para_pihak">
            <i class="green ace-icon fa fa-users bigger-120"></i>
            Para Pihak
          </a>
        </li>

        <li>
          <a id="tab_peristiwa_aduan" rel="<?php echo $value->pgd_id?>" data-toggle="tab" href="#peristiwa_aduan">
            <i class="red ace-icon fa fa-history bigger-120"></i>
            Peristiwa Aduan
          </a>
        </li>

        <li>
          <a id="tab_alat_brg_bukti" rel="<?php echo $value->pgd_id?>" data-toggle="tab" href="#alat_barang_bukti">
            <i class="pink ace-icon fa fa-file bigger-120"></i>
            Alat dan Barang Bukti
          </a>
        </li>

        <li>
          <a id="tab_uraian_kejadian" rel="<?php echo $value->pgd_id?>" data-toggle="tab" href="#uraian">
            <i class="ace-icon fa fa-circle-o bigger-120"></i>
            Uraian Kejadian
          </a>
        </li>

        
      </ul>

      <div class="tab-content">
        <div id="para_pihak" class="tab-pane fade in active">
          <div id="content_tab_custom" style="padding-right:-20px">
            <div class="alert alert-info">[ <i class="fa fa-info"></i> ] Silahkan lengkapi Formulir Pengaduan pada tabs diatas</div>
          </div>
        </div>
      </div>

    </div>

  </div><!-- /.col -->
</div>
<!-- END TAB FORM -->   
<!-- PAGE CONTENT ENDS -->
<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url()?>assets/js/custom/registrasi_custom.js"></script>
