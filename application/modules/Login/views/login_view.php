<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Form - Login</title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/font-awesome.css" />
    <link rel="icon" href="<?php echo base_url()?>assets/images/icon.png">
    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-fonts.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace.css" />
    <link href="<?php echo base_url()?>assets/captcha/css/style.css" rel="stylesheet">
    
  </head>

  <body class="login-layout">
    <div class="main-container">
      <div class="main-content">
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="login-container">

              <div class="center">
                <h1>
                  <!-- <i class="ace-icon fa fa-leaf green"></i>
                  <span class="red">Template CI v3.0</span> -->
                  <img src="<?php echo base_url().'assets/images/logo_garuda.png'?>" width="100px"><br>
                  <span class="white" id="id-text2">DKPP RI</span>
                </h1>
                <h3 class="white" id="id-text2">Dewan Kehormatan Penyelenggara Pemilu Republik Indonesia</h3>
                <h4 class="white" id="company-text">&copy; SIPEPP</h4>
              </div>

              <div class="space-6"></div>
              
              <div class="position-relative">
                <div id="login-box" class="login-box visible widget-box no-border">
                  <div class="widget-body">
                    <div class="widget-main">

                      <h4 class="header blue lighter bigger">
                        <i class="ace-icon fa fa-coffee green"></i>
                        Silahkan masukan akun anda
                      </h4>

                      <div class="space-6"></div>

                      <form method="post" action="<?php echo base_url().'login/process'?>" id="form-login">
                        <fieldset>
                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="text" class="form-control" placeholder="Username" name="username" id="username" value="<?php echo set_value('username')?>" />
                              <i class="ace-icon fa fa-user"></i>
                              <?php echo form_error('username'); ?>
                            </span>
                          </label>

                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="password" class="form-control" placeholder="Password" name="password" id="password" value="<?php echo set_value('password')?>" />
                              <i class="ace-icon fa fa-lock"></i>
                              <?php echo form_error('password'); ?>
                            </span>
                          </label>

                          <!-- <label for='message'>Masukan kode dibawah ini </label>
                          <center>
                          
                            <p id="captImg"><?php echo $captchaImg; ?></p>
                          </center>

                          <br>
                          <input type="text" class="form-control" placeholder="Validation code" name="captcha_code" id="captcha_code" value="" />
                          <?php echo form_error('captcha_code'); ?>
                          <br>
                          

                          Tidak dapat melihat gambar? Klik <a href="javascript:void(0);" class="refreshCaptcha" >disini</a> untuk refresh. -->
                          

                          <div class="space"></div>

                          <div class="clearfix">
                            <label class="inline">
                              <input type="checkbox" class="ace" />
                              <span class="lbl"> Ingatkan saya</span>
                            </label>

                            <button type="submit" id="button-login" name="Submit" value="submit" class="width-35 pull-right btn btn-sm btn-primary">
                              <i class="ace-icon fa fa-key"></i>
                              <span class="bigger-110">Masuk</span>
                            </button>
                          </div>
                          
                          <div class="space-4"></div>
                        </fieldset>
                      </form>
                      <br>
                     
                      <div class="space-6"></div>

                    </div><!-- /.widget-main -->
                  </div><!-- /.widget-body -->
                </div><!-- /.login-box -->

              </div><!-- /.position-relative -->

              <!-- <div class="navbar-fixed-top align-right">
                <br />
                &nbsp;
                <a id="btn-login-dark" href="#">Dark</a>
                &nbsp;
                <span class="blue">/</span>
                &nbsp;
                <a id="btn-login-blur" href="#">Blur</a>
                &nbsp;
                <span class="blue">/</span>
                &nbsp;
                <a id="btn-login-light" href="#">Light</a>
                &nbsp; &nbsp; &nbsp;
              </div> -->
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.main-content -->
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script type="text/javascript">
      window.jQuery || document.write("<script src='<?php echo base_url()?>assets/js/jquery.js'>"+"<"+"/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo base_url()?>assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
    <script type="text/javascript">
      if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url()?>assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
    </script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
      jQuery(function($) {
       $(document).on('click', '.toolbar a[data-target]', function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('.widget-box.visible').removeClass('visible');//hide others
        $(target).addClass('visible');//show target
       });

        $(document).ready(function(){
          $('.refreshCaptcha').on('click', function(){
            $.get('<?php echo base_url().'login/refreshCaptcha'; ?>', function(data){
              $('#captImg').html(data);
            });
          });
        });

      });
      
      
      
      //you don't need this, just used for changing background
      jQuery(function($) {
       $('#btn-login-dark').on('click', function(e) {
        $('body').attr('class', 'login-layout');
        $('#id-text2').attr('class', 'light');
        $('#id-company-text').attr('class', 'light');
        
        e.preventDefault();
       });
       $('#btn-login-light').on('click', function(e) {
        $('body').attr('class', 'login-layout light-login');
        $('#id-text2').attr('class', 'black');
        $('#id-company-text').attr('class', 'blue');
        
        e.preventDefault();
       });
       $('#btn-login-blur').on('click', function(e) {
        $('body').attr('class', 'login-layout blur-login');
        $('#id-text2').attr('class', 'white');
        $('#id-company-text').attr('class', 'light-blue');
        
        e.preventDefault();
       });
       
      });
    </script>
  </body>
</html>

