<div class="sidebar-shortcuts" id="sidebar-shortcuts">

    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
        
        <?php
        $menu_shortcut = $this->lib_menus->get_menus_shortcut(); //echo'<pre>';print_r($menu_shortcut);die;
            if(count($menu_shortcut) > 0){
            $no = 1; 
            foreach ($menu_shortcut as $key2 => $value2) {
                if($no == 1) { $btn_color = 'danger'; }elseif ($no == 2) { $btn_color = 'info'; }elseif ($no == 3) { $btn_color = 'warning'; }else{ $btn_color = 'success';}
                if($value2['link'] != '#') { $js_func = 'getMenu'; $val_js = $value2['link']; }else{ $js_func = 'getMainMenu'; $val_js = $value2['id_menu']; }
        ?>

        <a class="btn btn-<?php echo $btn_color?>" onclick="<?php echo $js_func?>('<?php echo $val_js; ?>')">
            <i class="<?php echo ($value2['icon'] != '#') ? $value2['icon'] : 'menu-icon fa fa-info' ; ?>"></i>
        </a>

        <?php $no++; } } ?>

        <!-- <button class="btn btn-success">
            <i class="ace-icon fa fa-signal"></i>
        </button>

        <button class="btn btn-info">
            <i class="ace-icon fa fa-pencil"></i>
        </button>

        #section:basics/sidebar.layout.shortcuts
        <button class="btn btn-warning">
            <i class="ace-icon fa fa-users"></i>
        </button>

        <button class="btn btn-danger">
            <i class="ace-icon fa fa-cogs"></i>
        </button> -->

        <!-- /section:basics/sidebar.layout.shortcuts -->
    </div>

    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
        <span class="btn btn-success"></span>

        <span class="btn btn-info"></span>

        <span class="btn btn-warning"></span>

        <span class="btn btn-danger"></span>
    </div>
</div><!-- /.sidebar-shortcuts -->

<ul class="nav nav-list">

    <li class="hover">
        <a href="<?php echo base_url().'dashboard'?>">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
        </a>

        <b class="arrow"></b>
    </li>

    <?php
        $menu = $this->lib_menus->get_menus(); //echo'<pre>';print_r($menu);die;
        if(count($menu) > 0){
        foreach ($menu as $key => $value) {
            $string_link = ''.$value['link'].'';
    ?>


    <li class="hover">
        <a href="#" <?php echo ( $value['link'] == '#' ) ? 'class="dropdown-toggle"' : '' ;?>  <?php if( $value['link'] != '#' ){?> onclick="getMenu('<?php echo $value['link']?>')" <?php }?>>
            <i class="<?php echo $value['icon']?>"></i>
            <span class="menu-text"> <?php echo $value['name']?> </span>
            <?php echo ( $value['link'] == '#' ) ? '<b class="arrow fa fa-angle-down"></b>' : '' ;?>
        </a>

        <b class="arrow"></b>
        <?php if( count($value['submenu']) != 0 ){?>
        <ul class="submenu">
            <?php foreach($value['submenu'] as $row_sub_menu){ ?>
            <li class="">
                <a href="#" onclick="getMenu('<?php echo $row_sub_menu['link']?>')">
                    <i class="menu-icon fa fa-caret-right"></i>
                    <?php echo $row_sub_menu['name']?>
                </a>

                <b class="arrow"></b>
            </li>
            <?php }?>
        </ul>
        <?php }?>

    </li>

    <?php } }?>

    <li>
        <a href="<?php echo base_url().'login/logout'?>">
            <i class="menu-icon fa fa-power-off"></i>
            <span class="menu-text"> Logout </span>
        </a>
        <b class="arrow"></b>
    </li>

</ul><!-- /.nav-list -->
<script src="<?php echo $js?>/custom/menu_load_page.js"></script>