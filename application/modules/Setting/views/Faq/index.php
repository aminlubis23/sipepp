<div class="page-header">
  <h1>
    <?php echo $title?>
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      <?php echo $subtitle?>
    </small>
  </h1>
</div><!-- /.page-header -->

<div class="row">
  <div class="col-xs-12">

    <!-- PAGE CONTENT BEGINS -->
   
    <div class="row">
      <div class="col-xs-12">

        <div class="clearfix">
          <button class="btn btn-sm btn-primary" onclick="add()"><i class="glyphicon glyphicon-plus"></i> Tambah Faq </button><div class="pull-right tableTools-container"></div>
        </div>

        <div>

          <table id="dynamic-table" class="table table-striped table-bordered table-hover">
             <thead>
              <tr>  
                <th class="center"></th>
                <th>Question</th>
                <th>Description</th>
                <th>Tabs</th>
                <th style="width:100px">Aksi</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  <!-- PAGE CONTENT ENDS -->
  </div><!-- /.col -->
</div><!-- /.row -->

<script src="<?php echo base_url().'assets/js/custom/faq.js'?>"></script>
