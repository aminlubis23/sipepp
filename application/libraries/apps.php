<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

final Class Apps {

   
    function get_template_content() {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
        $temp = $db->where(array('id_conf_application'=>1))->get('conf_application')->row();
				
		return $temp;
		
    }

    public  function formatNoReg($input) {
        if (empty($input)) {
            $exis = "-";
        } else {
            //$exis = 'REG-'.str_replace(',', '-', number_format($input)).''; OLD
            $exis = $input;
        }

        return $exis;
    }
	
}

?> 