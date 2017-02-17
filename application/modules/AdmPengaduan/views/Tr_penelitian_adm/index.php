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

    <!-- form search data -->
    <form class="form-inline" id="form_search_penelitian_adm">

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
      <button type="button" id="btn_search_penelitian_adm" class="btn btn-inverse btn-sm">
        <i class="ace-icon fa fa-search bigger-110"></i>Search
      </button> 
      <button type="button" id="btn_reset_penelitian_adm" class="btn btn-danger btn-sm">
        <i class="ace-icon fa fa-refresh bigger-110"></i>Reset
      </button> 
      <!-- end button search and reset grid -->

      <br><br>
      <div class="radio">
          <label>
            <input name="type_penelitian_adm" type="radio" class="ace" value="item" checked/>
            <span class="lbl"> Penelitian Administrasi </span>
          </label>
          &nbsp;&nbsp;&nbsp;
          <label>
            <input name="type_penelitian_adm" type="radio" class="ace" value="result"/>
            <span class="lbl"> Hasil Penelitian Administrasi </span>
          </label>
      </div>
      <br><br>

      <div id="item_penelitian_adm">
        <table id="grid-table"></table><div id="grid-pager"></div>
      </div>

      <div id="result_penelitian_adm" style="display:none">
        <div class="page-header"><h1>Data Hasil Penelitian Administrasi</h1></div>
        <table id="grid-table-result"></table><div id="grid-pager-result"></div>
      </div>

      

    </form>
    Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
    <!-- end form search data -->

  </div>
</div>
<!-- END PAGE CONTENT BEGINS -->

<!-- for this page only -->

<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url()?>assets/js/custom/penelitian_adm_custom.js"></script>