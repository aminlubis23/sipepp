<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message {

    
    static function _set($id=FALSE,$msg1,$msg2) {
        
        $_SESSION['message']['title'] = ($id)?'Success':'Error';
        $_SESSION['message']['content'] = ($id)?$msg1:$msg2;
        $_SESSION['message']['icon'] = ($id)?'fa-smile-o':'fa-frown-o';
    }


    static function _modal($title, $content,$icon) {

       

        $html = '<div id="alerttopright" class="kode-alert alert3 kode-alert-top-right">
           
            <a class="closed" onclick="messageOut(\'alerttopright\');" href="#">×</a>
            <h4> <i class="fa '.$icon.'"></i> ' . $title . '</h4>
            <h4>' . $content . '</h4>
          </div>
          <!-- End an Alert -->
    ';



        if (isset($_SESSION['message'])) {
            echo $html;
            unset($_SESSION['message']);
        }
    }

}

?>