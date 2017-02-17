<!DOCTYPE html>
<html lang="en">
    <!--APP CONFIG-->
    <?php 
        $temp = Apps::get_template_content();
    ?>
    <!--END APP CONFIG-->
    <head>
        
        <!--meta-->
        <?php echo $_meta?>
        <!--end meta-->
        
    </head>

    <body class="no-skin">

        <!-- #section:basics/navbar.layout -->
        <?php echo $_topbar?>
        <!-- /section:basics/navbar.layout -->
        
        <div class="main-container" id="main-container">

            <script type="text/javascript">
                try{ace.settings.check('main-container' , 'fixed')}catch(e){}
            </script>

            <!-- #section:basics/sidebar -->
            <div id="sidebar" class="sidebar responsive">

                <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
                </script>

                <!--sidebar-->
                <?php echo $_sidebar?>
                <!--end sidebar-->

                <!-- #section:basics/sidebar.layout.minimize -->
                <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                </div>

                <!-- /section:basics/sidebar.layout.minimize -->
                <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
                </script>

            </div>

            <!-- /section:basics/sidebar -->
            <div class="main-content">
                <div class="main-content-inner">

                    <!-- #section:basics/content.breadcrumbs -->
                    <?php echo $_breadcrumb?>
                    <!-- /section:basics/content.breadcrumbs -->
                    
                    <div class="page-content">
                        
                        <!-- #section:settings.box -->
                        <?php echo $_style?>
                        <!-- /section:settings.box -->

                        <div class="row">
                            <div class="col-xs-12">

                                <!-- PAGE CONTENT BEGINS -->
                                <div id="page-area-content">
                                        
                                        <div class="page-header">
                                            <h1>
                                                FAQ
                                                <small>
                                                    <i class="ace-icon fa fa-angle-double-right"></i>
                                                    frequently asked questions
                                                </small>
                                            </h1>
                                        </div><!-- /.page-header -->
                                        
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <!-- PAGE CONTENT BEGINS -->
                                                <div class="alert alert-block alert-success">
                                                    <button type="button" class="close" data-dismiss="alert">
                                                        <i class="ace-icon fa fa-times"></i>
                                                    </button>

                                                    <i class="ace-icon fa fa-check green"></i>

                                                    Selamat datang
                                                    <strong class="green">
                                                        <?php echo ucwords($this->session->userdata('data_user')->fullname)?>
                                                    </strong>
                                                    <!-- anda masuk sebagai <?php echo $this->session->userdata('data_user')->id_role?> -->
                                                </div>
                                                
                                                <div class="tabbable">
                                                    <!-- #section:pages/faq -->
                                                    <ul class="nav nav-tabs padding-18 tab-size-bigger" id="myTab">
                                                        <li class="active">
                                                            <a data-toggle="tab" href="#faq-tab-1">
                                                                <i class="blue ace-icon fa fa-question-circle bigger-120"></i>
                                                                General
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a data-toggle="tab" href="#faq-tab-2">
                                                                <i class="green ace-icon fa fa-user bigger-120"></i>
                                                                Tutorial
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a data-toggle="tab" href="#faq-tab-3">
                                                                <i class="orange ace-icon fa fa-credit-card bigger-120"></i>
                                                                Lainnya
                                                            </a>
                                                        </li>

                                                    </ul>

                                                    <!-- /section:pages/faq -->
                                                    <div class="tab-content no-border padding-24">
                                                        <div id="faq-tab-1" class="tab-pane fade in active">
                                                            <h4 class="blue">
                                                                <i class="ace-icon fa fa-check bigger-110"></i>
                                                                General Questions
                                                            </h4>


                                                            <div class="space-8"></div>

                                                            <div id="faq-list-1" class="panel-group accordion-style1 accordion-style2">
                                                                <?php
                                                                    $general = Master::get_custom_data(array('table'=>'m_faq', 'where'=>array('active'=>'Y', 'faq_flag'=>'general')));
                                                                    foreach ($general as $row_general) {
                                                                ?>
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <a href="#<?php echo $row_general['faq_id']?>" data-parent="#faq-list-1" data-toggle="collapse" class="accordion-toggle collapsed">
                                                                            <i class="ace-icon fa fa-chevron-left pull-right" data-icon-hide="ace-icon fa fa-chevron-down" data-icon-show="ace-icon fa fa-chevron-left"></i>

                                                                            <i class="ace-icon fa fa-circle-o bigger-130"></i> &nbsp; 
                                                                            <?php echo $row_general['faq_title']?>
                                                                        </a>
                                                                    </div>

                                                                    <div class="panel-collapse collapse" id="<?php echo $row_general['faq_id']?>">
                                                                        <div class="panel-body">
                                                                            <?php echo $row_general['faq_description']?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php }?>

                                                            </div>
                                                        </div>

                                                        <div id="faq-tab-2" class="tab-pane fade">
                                                            <h4 class="blue">
                                                                <i class="green ace-icon fa fa-user bigger-110"></i>
                                                                Tutorial Usage
                                                            </h4>

                                                            <div class="space-8"></div>

                                                            <div id="faq-list-2" class="panel-group accordion-style1 accordion-style2">

                                                                <?php
                                                                    $tutorial = Master::get_custom_data(array('table'=>'m_faq', 'where'=>array('active'=>'Y', 'faq_flag'=>'tutorial')));
                                                                    foreach ($tutorial as $row_tutorial) {
                                                                ?>
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <a href="#<?php echo $row_tutorial['faq_id']?>" data-parent="#faq-list-2" data-toggle="collapse" class="accordion-toggle collapsed">
                                                                            <i class="ace-icon fa fa-chevron-right smaller-80" data-icon-hide="ace-icon fa fa-chevron-down align-top" data-icon-show="ace-icon fa fa-chevron-right"></i>&nbsp;<?php echo $row_tutorial['faq_title']?>
                                                                        </a>
                                                                    </div>

                                                                    <div class="panel-collapse collapse" id="<?php echo $row_tutorial['faq_id']?>">
                                                                        <div class="panel-body">
                                                                            <?php echo $row_tutorial['faq_description']?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php }?>

                                                            </div>
                                                        </div>

                                                        <div id="faq-tab-3" class="tab-pane fade">
                                                            <h4 class="blue">
                                                                <i class="orange ace-icon fa fa-credit-card bigger-110"></i>
                                                                Other Querstion
                                                            </h4>

                                                            <div class="space-8"></div>

                                                            <div id="faq-list-3" class="panel-group accordion-style1 accordion-style2">

                                                            <?php
                                                                $other = Master::get_custom_data(array('table'=>'m_faq', 'where'=>array('active'=>'Y', 'faq_flag'=>'lainnya')));
                                                                foreach ($other as $row_other) {
                                                            ?>

                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <a href="#<?php echo $row_other['faq_id']?>" data-parent="#faq-list-3" data-toggle="collapse" class="accordion-toggle collapsed">
                                                                        <i class="ace-icon fa fa-plus smaller-80" data-icon-hide="ace-icon fa fa-minus" data-icon-show="ace-icon fa fa-plus"></i>&nbsp;
                                                                            <?php echo $row_other['faq_title']?>
                                                                    </a>
                                                                </div>

                                                                <div class="panel-collapse collapse" id="<?php echo $row_other['faq_id']?>">
                                                                    <div class="panel-body">
                                                                        <?php echo $row_other['faq_description']?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <?php }?>

                                                                
                                                            </div>
                                                        </div>

                                                        
                                                    </div>
                                                </div>

                                                <!-- PAGE CONTENT ENDS -->
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->

                                </div>
                                <!-- PAGE CONTENT ENDS -->


                            </div><!-- /.col -->
                        </div><!-- /.row -->

                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <!--footer-->
            <?php echo $_footer?>
            <!--end footer-->

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->
        <script type="text/javascript">
            window.jQuery || document.write("<script src='<?php echo $js?>/jquery.js'>"+"<"+"/script>");
        </script>

        <script type="text/javascript">
            if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo $js?>/jquery.mobile.custom.js'>"+"<"+"/script>");
        </script>
        <script src="<?php echo $js?>/bootstrap.js"></script>

        <!-- page specific plugin scripts -->


        <!-- ace scripts -->
        <script src="<?php echo $js?>/ace/elements.scroller.js"></script>
        <script src="<?php echo $js?>/ace/elements.colorpicker.js"></script>
        <script src="<?php echo $js?>/ace/elements.fileinput.js"></script>
        <script src="<?php echo $js?>/ace/elements.typeahead.js"></script>
        <script src="<?php echo $js?>/ace/elements.wysiwyg.js"></script>
        <script src="<?php echo $js?>/ace/elements.spinner.js"></script>
        <script src="<?php echo $js?>/ace/elements.treeview.js"></script>
        <script src="<?php echo $js?>/ace/elements.wizard.js"></script>
        <script src="<?php echo $js?>/ace/elements.aside.js"></script>
        <script src="<?php echo $js?>/ace/ace.js"></script>
        <script src="<?php echo $js?>/ace/ace.ajax-content.js"></script>
        <script src="<?php echo $js?>/ace/ace.touch-drag.js"></script>
        <script src="<?php echo $js?>/ace/ace.sidebar.js"></script>
        <script src="<?php echo $js?>/ace/ace.sidebar-scroll-1.js"></script>
        <script src="<?php echo $js?>/ace/ace.submenu-hover.js"></script>
        <script src="<?php echo $js?>/ace/ace.widget-box.js"></script>
        <script src="<?php echo $js?>/ace/ace.settings.js"></script>
        <script src="<?php echo $js?>/ace/ace.settings-rtl.js"></script>
        <script src="<?php echo $js?>/ace/ace.settings-skin.js"></script>
        <script src="<?php echo $js?>/ace/ace.widget-on-reload.js"></script>
        <script src="<?php echo $js?>/ace/ace.searchbox-autocomplete.js"></script>

        <!-- inline scripts related to this page -->
       

        <!-- the following scripts are used in demo only for onpage help and you don't need them -->
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace.onpage-help.css" />

        <script type="text/javascript"> ace.vars['base'] = '..'; </script>
        <script src="<?php echo $js?>/ace/elements.onpage-help.js"></script>
        <script src="<?php echo $js?>/ace/ace.onpage-help.js"></script>

        <!-- page specific plugin scripts jqgrid-->
        <script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
        <script src="<?php echo base_url()?>assets/js/jqGrid/jquery.jqGrid.src.js"></script>
        <script src="<?php echo base_url()?>assets/js/jqGrid/i18n/grid.locale-en.js"></script>

        <script src="<?php echo base_url('assets/datatables/jquery/jquery-2.1.4.min.js')?>"></script>
        <script src="<?php echo base_url('assets/datatables/bootstrap/js/bootstrap.min.js')?>"></script>
        <script src="<?php echo base_url('assets/datatables/datatables/js/jquery.dataTables.min.js')?>"></script>
        <script src="<?php echo base_url('assets/datatables/datatables/js/dataTables.bootstrap.js')?>"></script>

        <!--jquery ui -custom-->
        <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.js"></script>

        <!-- jquery choosen-->
        <script src="<?php echo base_url()?>assets/js/chosen.jquery.js"></script>

        <!--gritter-->
        <script src="<?php echo base_url()?>assets/js/jquery.gritter.js"></script>

        <!-- jquery validate-->
        <script src="<?php echo base_url()?>assets/validation/dist/jquery.validate.js"></script>

        <script src="<?php echo base_url()?>assets/js/custom/gritter.js"></script>

        <!-- page specific plugin scripts for jqgrid-->
        <script src="<?php echo base_url()?>assets/js/jqGrid/jquery.jqGrid.src.js"></script>
        <script src="<?php echo base_url()?>assets/js/jqGrid/i18n/grid.locale-id.js"></script>

    </body>
</html>
