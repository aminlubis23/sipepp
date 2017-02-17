<!-- page specific plugin styles -->
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/ui.jqgrid.css" />

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


<!-- PAGE CONTENT BEGINS -->
<div class="row">
  <div class="col-xs-12">

    <!-- button add  -->
    <div class="clearfix" style="float:left">
      <button class="btn btn-sm btn-primary" id="btn_add_registrasi" ><i class="glyphicon glyphicon-plus"></i> Registrasi Baru</button>
      <a href="javascript:void(0)" class="btn btn-sm btn-danger" id="button_delete_multiple"> <i class="fa fa-trash-o"></i> Hapus yang dipilih</a>
    </div>
    <!-- end button add  -->

    <br>
    <hr class="sparator">

    <!-- form search data -->
    <form class="form-inline" id="form_search_registrasi">

      <!-- label form search by -->
      <label class="inline">
        Search by : 
        <select id="search_by" class="form-control" style="height:33px;min-width:200px">
          <option value="pgd_tahun">Tahun</option>
          <option value="pgd_id">No Pendaftaran</option>
          <option value="pgd_tempat">Tempat Pengaduan</option>
          <option value="tp_name">Tipe Pengaduan</option>
          <option value="ktp_nama_lengkap">Nama Para Pihak</option>
          <option value="ktp_nik">NIK</option>
          <option value="prp_no_hp">No HP</option>
          <option value="prp_email">Email</option>

        </select>
      </label>
      <!-- end label form search by -->

      <!-- label form keyword -->
      <label class="inline">
        &nbsp;&nbsp; Keyword : 
        <input type="text" id="keyword" style="width: 200px" class="input-small" placeholder="Keyword" />
      </label>
      <!-- end label form keyword -->

      <!-- button search and reset grid-->
      <button type="button" id="btn_search_registrasi" class="btn btn-inverse btn-sm">
        <i class="ace-icon fa fa-search bigger-110"></i>Search
      </button> 
      <button type="button" id="btn_reset_registrasi" class="btn btn-danger btn-sm">
        <i class="ace-icon fa fa-refresh bigger-110"></i>Reset
      </button> 
      <!-- end button search and reset grid -->

      <br><br>

      <!-- grid table -->
      <!-- <b><i><div id="data_pgd">*Data Pengaduan Tahun 2017</div></i></b> -->
      <table id="grid-table"></table>
      <!-- grid pager -->
      <div id="grid-pager"></div>

    </form>
    Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
    <!-- end form search data -->

  </div>
</div>
<!-- END PAGE CONTENT BEGINS -->

<!-- for this page only -->
<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url()?>assets/js/custom/registrasi_custom.js"></script>