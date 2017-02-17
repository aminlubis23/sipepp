<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

final Class Lib_menus {

    
    function get_menus_shortcut() {
        
        $CI =&get_instance();
        $db = $CI->load->database('default', TRUE);
        
        $getData = array();
        $sess_menu = $db->order_by('updated_date', 'DESC')->limit(4)->get_where('m_menu', array('set_shortcut'=>'Y'))->result_array(); //print_r($this->db->last_query());die;

        //$sess_menu = $this->get_hak_akses_menu_role($this->session->userdata('data_user')->id_role);

        if($sess_menu){
            foreach ($sess_menu as $key => $value) {
                # code...
                $getData[] = $value;
            }
        }        

        return $getData;
        
    }

    function get_menus() {
		
		$CI =&get_instance();
        $db = $CI->load->database('default', TRUE);
		$sess = $CI->load->library('session');
		
		$getData = array();
		$sess_menu = $this->get_hak_akses_menu_role($CI->session->userdata('data_user')->id_role);

        if($sess_menu){
            foreach ($sess_menu as $key => $value) {
                # code...
                $getData[] = $value;
            }
        }        

		return $getData;
		
    }


    public function get_hak_akses_menu_role($id_role){

        $getData = array();
        // get menu role
        $menu_role = $this->qry_main_menu($id_role);

        foreach ($menu_role->result_array() as $key => $value) {

            if( ($value['parent_menu'] == 0) && ($value['link'] == '#') ){

                $value['submenu'] = $this->qry_submenu($id_role, $value['id_menu']);

            }else{
                
                $code_action = $this->get_code_action(array('id_role'=>$id_role, 'id_menu'=>$value['id_menu']));

                $value['submenu'] = array();
                $value['action'] = $code_action;
            }

            
            $getData[] = $value;
        }

        return $getData;
    }

    public function get_code_action($where){

        $CI =&get_instance();
        $db = $CI->load->database('default', TRUE);
        $sess = $CI->load->library('session');

        $code_action = $db->select('code')->get_where('t_menu_role', $where)->result_array();
        foreach ($code_action as $key => $value) {
            # code...
            $arr_code[] = $value['code'];
        }

        return $arr_code;
    }

    public function qry_submenu($id_role, $id_menu){

        $CI =&get_instance();
        $db = $CI->load->database('default', TRUE);
        $sess = $CI->load->library('session');

        $db->select('m_menu.*,t_menu_role.id_role');
        $db->from('t_menu_role');
        $db->join('m_menu', 'm_menu.id_menu=t_menu_role.id_menu', 'left');
        $db->group_by('t_menu_role.id_menu');
        $db->order_by('m_menu.counter','ASC');
        $db->where(array('id_role'=>$id_role, 'parent_menu'=>$id_menu, 'm_menu.active'=>'Y'));
        $submenu = $db->get()->result_array();
        $arr_submenu = array();
        if( count($submenu) > 0 ){
            foreach ($submenu as $row_submenu) {

                $code_action = $this->get_code_action(array('id_role'=>$id_role, 'id_menu'=>$row_submenu['id_menu']));

                $row_submenu['action'] = $code_action;
                $arr_submenu[] = $row_submenu;

            }
        }
        

        return $arr_submenu;
    }

    public function qry_main_menu($id_role){

        $CI =&get_instance();
        $db = $CI->load->database('default', TRUE);
        $sess = $CI->load->library('session');

        $query = "SELECT tbl_menu.*,t_menu_role.id_role
                    FROM t_menu_role
                    JOIN (SELECT * FROM m_menu WHERE parent_menu = 0 AND active='Y' ORDER BY counter ASC)AS tbl_menu ON tbl_menu.id_menu=t_menu_role.id_menu
                    WHERE t_menu_role.id_role = ".$id_role."
                    GROUP BY t_menu_role.`id_menu`
                    ORDER BY tbl_menu.counter ASC";
        $menu_role = $db->query($query);

        return $menu_role;
    }

    function get_sub_menu($class){

        $CI =&get_instance();
        $db = $CI->load->database('default', TRUE);
        $sess = $CI->load->library('session');

        $query = "SELECT * FROM t_menu_role 
                    LEFT JOIN m_menu ON m_menu.id_menu=t_menu_role.`id_menu`
                    WHERE t_menu_role.`id_role`='".$CI->session->userdata('data_user')->id_role."' AND m_menu.`active`='Y' AND m_menu.parent_menu IN (SELECT id_menu FROM m_menu WHERE class='".$class."')
                    GROUP BY t_menu_role.id_menu ORDER BY m_menu.counter ASC ";
        $menu_role = $db->query($query);

        return $menu_role;
    }


	
}

?> 