<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Class Account {

    
    public static function _valLogin() {
        
        if(!isset($_SESSION['login'])) {
            redirect('login/login/logout/');
        
        }
        
    }
    
    
    }
    
    
    ?>