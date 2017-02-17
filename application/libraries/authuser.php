<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

final Class Authuser {


    function get_auth_action_user($classlink, $code) {
		        
        $CI =&get_instance();
        //check auth user for action code
        $menu = $CI->db->get_where('m_menu', array('class'=>$classlink))->row();
        $menu_role = $CI->db->get_where('t_menu_role', array('id_menu'=>$menu->id_menu, 'id_role'=>$CI->session->userdata('data_user')->id_role, 'code'=>$code));

        //print_r($access);die;

        if($menu_role->num_rows() > 0){
            return true;
        }else{
            echo '<div class="error-container">
                    <div class="well">
                        <h1 class="grey lighter smaller">
                            <span class="red bigger-125">
                                <i class="ace-icon fa fa-lock"></i>
                                403
                            </span>
                            You are not authorized
                        </h1>

                        <hr />
                        <h3 class="lighter smaller">Anda tidak memiliki hak akses untuk mengakses modul ini !</h3>

                        <div>

                            <ul class="list-unstyled spaced inline bigger-110 margin-15">
                                <li>
                                    <i class="ace-icon fa fa-hand-o-right blue"></i>
                                    Baca petunjuk penggunaan
                                </li>

                                <li>
                                    <i class="ace-icon fa fa-hand-o-right blue"></i>
                                    Hubungi administrator
                                </li>

                            </ul>
                        </div>

                        <hr />
                        <div class="space"></div>

                        <div class="center">
                            <a href="javascript:void()" onclick="getMenu('."'".$menu->link."'".')" class="btn btn-danger">
                                <i class="ace-icon fa fa-arrow-left"></i>
                                Kembali ke halaman '.$menu->name.'
                            </a>
                        </div>
                    </div>
                </div>';
            exit;
        }
		
    }

    function get_user_description(){

        $this->db->from('m_user');
        $this->db->join('m_role', 'm_role.id_role=m_user.id_role','left');
        $this->db->where(array('id_user'=>$this->session->userdata('data_user')->id_user));
        $value = $this->db->get()->row();
        
        $field = 'Anda login sebagai, ';
        if( $this->session->userdata('data_user')->id_role == 5 ){
            $field .= '<strong><i> Puskesmas : '.ucwords($value->nama_puskesmas_kab).' || Kab/Kota : '.ucwords($value->nama_kabupaten).' || Provinsi : '.ucwords($value->nama_provinsi).'</strong></i>';
        }elseif( $this->session->userdata('data_user')->id_role == 4 ){
            $field .= '<strong><i> Kab/Kota : '.ucwords($value->nama_kabupaten).' || Provinsi : '.ucwords($value->nama_provinsi).'</strong></i>';
        }elseif( $this->session->userdata('data_user')->id_role == 3 ){
            $field .= '<strong><i> Provinsi : '.ucwords($value->nama_provinsi).'</strong></i>';
        }else{
            $field .= '<strong><i> '.ucwords($value->role_name).'</strong></i>';
        }

        return $field;
    }

	function write_log($params='')
    {
        
        $CI =&get_instance();
      // Check message
      // Get IP address
      if( ($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
        $remote_addr = "REMOTE_ADDR_UNKNOWN";
      }
     
      // Get requested script
      if( ($request_uri = $_SERVER['REQUEST_URI']) == '') {
        $request_uri = "REQUEST_URI_UNKNOWN";
      }
     
      // Escape values
      $log = array(
        'id_user' => $CI->session->userdata('data_user')->id_user,
        'time' => date('Y-m-d H:i:s'),
        'status' => isset($params['status'])?$params['status']:'TRUE',
        'remote_addr' => $remote_addr,
        'request_uri' => $request_uri,
        'message' => isset($params['message'])?$params['message']:'Message is empty',
        'last_query' => isset($params['last_query'])?$params['last_query']:'No query executed',
        );
     
      // Construct query
     
      // Execute query and save data
      $result = $CI->db->insert('activities_history', $log);
     
      if($result) {
        return array('status' => true);  
      }
      else {
        return array('status' => false, 'message' => 'Unable to write to the database');
      }
    }

}

?> 