<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

final Class Master {

    function get_tahun($nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		$year = array();
		$now = date('Y');
		for ($i=$now-2; $i < $now+2 ; $i++) { 
			$year[] = $i;
		}
		$data = $year;

		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="0" '.$selected.'> - Please Select - </option>';

				foreach($data as $row){
					$sel = $nid==$row?'selected':'';
					$field.='<option value="'.$row.'" '.$sel.' >'.strtoupper($row).'</option>';
				}	
			
		$field.='
		</select>
		'.$fieldsetend;
		
		return $field;
		
    }

    function get_bulan($nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		$tanggal = $CI->load->library('tanggal', TRUE);
		$year = array();
		for ($i=1; $i < 13 ; $i++) { 
			$list = array(
				'key' => $i,
				'value' => $CI->tanggal->getBulan($i),
				);
			$year[] = $list;
		}
		$data = $year;

		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="0" '.$selected.'> - Please Select - </option>';

				foreach($data as $row){
					$sel = $nid==$row?'selected':'';
					$field.='<option value="'.$row['key'].'" '.$sel.' >'.strtoupper($row['value']).'</option>';
				}	
			
		$field.='
		</select>
		'.$fieldsetend;
		
		return $field;
		
    }

    
    function get_master_role($nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
		$db->from('m_role');
		$db->join('m_apps','m_apps.apps_id=m_role.apps_id','left');

		/*if( in_array($CI->session->userdata('data_user')->id_role, array('1','2')) ){

			$db->where(array('active'=>'Y'));

		}else{

			$db->where_not_in('id_role', array('1','2'));

		}
*/
        $data = $db->get()->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="0" '.$selected.'> - Please Select - </option>';

				foreach($data as $row){
					$sel = $nid==$row['id_role']?'selected':'';
					$field.='<option value="'.$row['id_role'].'" '.$sel.' >'.strtoupper($row['role_name']).' - '.$row['apps_name'].'</option>';
				}	
			
		$field.='
		</select>
		'.$fieldsetend;
		
		return $field;
		
    }

    function get_master_province($nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
		/*if( isset($CI->session->userdata('data_user')->id_provinsi) ){
			$db->where(array('id_provinsi'=>$CI->session->userdata('data_user')->id_provinsi));
		}*/

        $data = $db->get('m_province')->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="0" '.$selected.'> - Please Select - </option>';

				foreach($data as $row){
					$sel = $nid==$row['province_id']?'selected':'';
					$field.='<option value="'.$row['province_id'].'" '.$sel.' >'.strtoupper($row['province_name']).'</option>';
				}	
			
		$field.='
		</select>
		'.$fieldsetend;
		
		return $field;
		
    }

    function get_change_master_sub_district($nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
		/*if( $nid != '' ) {
			$qry = $db->get_where('m_subdistrict', array('subdistrict_id'=>$nid));
			$district_id = (count($qry->num_rows()) > 0) ? $qry->row()->district_id : 0;
			if($district_id != 0){
				$db->where(array('district_id'=>$district_id));
			}
		}*/


		$data = $db->get('m_subdistrict')->result_array();
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="0" '.$selected.'> - Please Select - </option>';
				if($nid==''){
					$field.='<option value="#" >(Select Subdistrict)</option>';
				}else{
					foreach($data as $row){
						$sel = $nid==$row['subdistrict_id']?'selected':'';
						$field.='<option value="'.$row['subdistrict_id'].'" '.$sel.' >'.strtoupper($row['subdistrict_name']).'</option>';
					}
				}
								
			
		$field.='
		</select>
		'.$fieldsetend;
		
		return $field;
		
    }

    function get_change_master_district($nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
		/*if( $nid != '' ) {
			$qry = $db->get_where('m_district', array('district_id'=>$nid));
			$city_id = (count($qry->num_rows()) > 0) ? $qry->row()->city_id : 0;
			if($city_id != 0){
				$db->where(array('city_id'=>$city_id));
			}
		}*/


		$data = $db->get('m_district')->result_array();

		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="0" '.$selected.'> - Please Select - </option>';
				if($nid==''){
					$field.='<option value="#" >(Select District)</option>';
				}else{
					foreach($data as $row){
						$sel = $nid==$row['district_id']?'selected':'';
						$field.='<option value="'.$row['district_id'].'" '.$sel.' >'.strtoupper($row['district_name']).'</option>';
					}
				}
								
			
		$field.='
		</select>
		'.$fieldsetend;
		
		return $field;
		
    }

    function get_change_master_city($nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
		/*if( $nid != '' ) {
			$qry = $db->get_where('m_city', array('city_id'=>$nid));
			$province_id = (count($qry->num_rows()) > 0) ? $qry->row()->province_id : 0;
			if($province_id != 0){
				$db->where(array('province_id'=>$province_id));
			}
		}*/

		$data = $db->get('m_city')->result_array();

		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="0" '.$selected.'> - Please Select - </option>';
				if($nid==''){
					$field.='<option value="#" >(Select City)</option>';
				}else{
					foreach($data as $row){
						$sel = $nid==$row['city_id']?'selected':'';
						$field.='<option value="'.$row['city_id'].'" '.$sel.' >'.strtoupper($row['city_name']).'</option>';
					}
				}
								
			
		$field.='
		</select>
		'.$fieldsetend;
		
		return $field;
		
    }

    
    function get_master_custom($custom=array(), $nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
        $data = $db->where($custom['where'])->get($custom['table'])->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.='
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="0" '.$selected.'> - Please Select - </option>';

				foreach($data as $row){
					$sel = $nid==$row[$custom['id']]?'selected':'';
					$field.='<option value="'.$row[$custom['id']].'" '.$sel.' >'.strtoupper($row[$custom['name']]).'</option>';
				}	
			
		$field.='
		</select>
		';
		
		return $field;
		
    }
    
    

    function get_master_menu($nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
        $data = $db->get('m_menu')->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="0" '.$selected.'> - Please Select - </option>';

				foreach($data as $row){
					$sel = $nid==$row['id_menu']?'selected':'';
					$field.='<option value="'.$row['id_menu'].'" '.$sel.' >'.strtoupper($row['name']).'</option>';
				}	
			
		$field.='
		</select>
		'.$fieldsetend;
		
		return $field;
		
    }

    function get_menu_data($params='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		$getData = array();
		
		if(isset($params)){
			if($params['apps_id'] != 0){
				if($params['apps_id'] != 1){
					$db->where($params);
				}
			}
		}

        $data = $db->where(array('active'=>'Y', 'parent_menu'=>0))->get('m_menu')->result_array();
        foreach($data as $rowdata){
        	$submenu = $db->where(array('active'=>'Y', 'parent_menu'=>$rowdata['id_menu']))->get('m_menu')->result_array();
        	$rowdata['submenu'] = $submenu;
        	$getData[] = $rowdata;
        }
		
		return $getData;
		
    }

    function get_func_action_data() {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
        $data = $db->where(array('active'=>'Y'))->get('m_func_action')->result_array();
		
		return $data;
		
    }

    

    function get_custom_data($params) {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		$data = $db->where($params['where'])->get($params['table'])->result_array();
		
		return $data;
		
    }

    function params_query($params) {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		$data = $db->where($params['where'])->get($params['table']);
		
		return $data;
		
    }

	
}

?> 