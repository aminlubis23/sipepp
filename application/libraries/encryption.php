<?php

require_once 'encrypt_2015.php';

class Encryption {
	
	function encrypt_password_callback($password) {        
         $encrypt = new Encrypt_2015();         
         $ress = $encrypt->_base64_encrypt($password, SECURITY_KEY);
         return $ress;
     }
     
     function decrypt_password_callback($password) {        
         $encrypt = new Encrypt_2015();         
         $ress = $encrypt->_base64_decrypt($password, SECURITY_KEY);
         return $ress;
     }
	 
}