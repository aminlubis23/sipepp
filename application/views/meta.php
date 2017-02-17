<?php $temp = $this->apps->get_template_content();?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?php echo isset($temp->header_title)?$temp->header_title:'Header Title'?></title>

        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="<?php echo $css?>/bootstrap.css" />
        <link rel="stylesheet" href="<?php echo $css?>/font-awesome.css" />
        <link rel="icon" href="<?php echo base_url()?>assets/images/icon.png">

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <link rel="stylesheet" href="<?php echo $css?>/ace-fonts.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="<?php echo $css?>/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

        <!-- ace settings handler -->
        <script src="<?php echo $js?>/ace-extra.js"></script>

        <!--jquery ui custom-->
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery-ui.custom.css" />

        <!--css gritter-->
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery.gritter.css" />

        <!--choosen-->
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/chosen.css" />

        <!--validation-->
        <link rel="stylesheet" href="<?php echo base_url()?>assets/validation/css/screen.css" />

        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/select2.css" />

        
