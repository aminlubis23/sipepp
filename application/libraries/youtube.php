<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 *  Class yang berisi fungsi-fungsi untuk mendapatkan latitude dan longitude dari format google maps
 */

final class Youtube {
    
    function getIdVideoFromLink($link) {
            
        $temp = str_replace("http://www.youtube.com/watch?v=", "", $link);
        $temp = str_replace("https://www.youtube.com/watch?v=", "", $link);
        $temp = str_replace("&feature=g-user", "", $temp);
        
        $id_video = $temp; 
        
        return $id_video;
    }
    
   
    
}

?>
