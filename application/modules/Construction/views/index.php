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
   
    <div class="error-container">
      <div class="well">
        <h1 class="grey lighter smaller">
          <span class="blue bigger-125">
            <i class="ace-icon fa fa-random"></i>
            500
          </span>
          Something Went Wrong
        </h1>

        <hr />
        <h3 class="lighter smaller">
          But we are working
          <i class="ace-icon fa fa-wrench icon-animated-wrench bigger-125"></i>
          on it!
        </h3>

        <div class="space"></div>

        <div>
          <h4 class="lighter smaller">Meanwhile, try one of the following:</h4>

          <ul class="list-unstyled spaced inline bigger-110 margin-15">
            <li>
              <i class="ace-icon fa fa-hand-o-right blue"></i>
              Read the faq
            </li>

            <li>
              <i class="ace-icon fa fa-hand-o-right blue"></i>
              Give us more info on how this specific error occurred!
            </li>
          </ul>
        </div>

        <hr />
        <div class="space"></div>

        <div class="center">
          <a href="<?php echo base_url().'dashboard'?>" class="btn btn-primary">
            <i class="glyphicon glyphicon-refresh"></i>
            Reload Page
          </a>
        </div>
      </div>
    </div>

  <!-- PAGE CONTENT ENDS -->
  </div><!-- /.col -->
</div><!-- /.row -->
