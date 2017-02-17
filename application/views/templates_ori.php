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

            <!-- #section:basics/sidebar.horizontal -->
            <div id="sidebar" class="sidebar      h-sidebar                navbar-collapse collapse">
                <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
                </script>

                

                <!--sidebar-->
                <?php echo $_sidebar?>
                <!--end sidebar-->

                <!-- #section:basics/sidebar.layout.minimize -->

                <!-- /section:basics/sidebar.layout.minimize -->
                <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
                </script>
            </div>

            <!-- /section:basics/sidebar.horizontal -->
            <div class="main-content">
                <div class="main-content-inner">
                    <div class="page-content">
                        <!-- #section:settings.box -->
                        <div class="ace-settings-container" id="ace-settings-container">
                            <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                                <i class="ace-icon fa fa-cog bigger-130"></i>
                            </div>

                            <div class="ace-settings-box clearfix" id="ace-settings-box">
                                <div class="pull-left width-50">
                                    <!-- #section:settings.skins -->
                                    <div class="ace-settings-item">
                                        <div class="pull-left">
                                            <select id="skin-colorpicker" class="hide">
                                                <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                                <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                                <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                                <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                            </select>
                                        </div>
                                        <span>&nbsp; Choose Skin</span>
                                    </div>

                                    <!-- /section:settings.skins -->

                                    <!-- #section:settings.navbar -->
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                                        <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                                    </div>

                                    <!-- /section:settings.navbar -->

                                    <!-- #section:settings.sidebar -->
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                                        <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                                    </div>

                                    <!-- /section:settings.sidebar -->

                                    <!-- #section:settings.breadcrumbs -->
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                                        <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                                    </div>

                                    <!-- /section:settings.breadcrumbs -->

                                    <!-- #section:settings.rtl -->
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                                        <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                                    </div>

                                    <!-- /section:settings.rtl -->

                                    <!-- #section:settings.container -->
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                                        <label class="lbl" for="ace-settings-add-container">
                                            Inside
                                            <b>.container</b>
                                        </label>
                                    </div>

                                    <!-- /section:settings.container -->
                                </div><!-- /.pull-left -->

                                <div class="pull-left width-50">
                                    <!-- #section:basics/sidebar.options -->
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
                                        <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
                                        <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
                                        <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                                    </div>

                                    <!-- /section:basics/sidebar.options -->
                                </div><!-- /.pull-left -->
                            </div><!-- /.ace-settings-box -->
                        </div><!-- /.ace-settings-container -->

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
        
        <!--[if !IE]> -->
        <script type="text/javascript">
            window.jQuery || document.write("<script src='<?php echo $js?>/jquery.js'>"+"<"+"/script>");
        </script>

        <!-- <![endif]-->

        <!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='../assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
        <script type="text/javascript">
            if('ontouchstart' in document.documentElement) document.write("<script src='../assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
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
        
        <!-- <script src="../docs/assets/js/rainbow.js"></script>
        <script src="../docs/assets/js/language/generic.js"></script>
        <script src="../docs/assets/js/language/html.js"></script>
        <script src="../docs/assets/js/language/css.js"></script>
        <script src="../docs/assets/js/language/javascript.js"></script> -->
    </body>
</html>
