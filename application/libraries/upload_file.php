<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

final Class upload_file {

    function doUpload($params, $inputname, $path)
    {
        $CI =&get_instance();
        $db = $CI->load->database('default', TRUE);

        $vdir_upload = ''.$path.'';
        $vfile_upload = $vdir_upload . $params['attc_path'];
        $tipe_file   = $_FILES['file']['type'];

        if(move_uploaded_file($_FILES[$inputname]["tmp_name"], $vfile_upload)){
            $params['created_date'] = date('Y-m-d H:i:s');
            $params['created_by'] = $CI->session->userdata('data_user')->fullname;
            $db->insert('tr_attachment', $params);
        }

        return true;
    }

    function doUploadMultiple($params, $inputname, $path)
    {
        $CI =&get_instance();
        $db = $CI->load->database('default', TRUE);
        $CI->load->library('upload');
        //$CI->load->library('image_lib'); 

        foreach ($_FILES[''.$inputname.'']['name'] as $i=>$values) {

              $_FILES['userfile']['name']     = $_FILES[''.$inputname.'']['name'][$i];
              $_FILES['userfile']['type']     = $_FILES[''.$inputname.'']['type'][$i];
              $_FILES['userfile']['tmp_name'] = $_FILES[''.$inputname.'']['tmp_name'][$i];
              $_FILES['userfile']['error']    = $_FILES[''.$inputname.'']['error'][$i];
              $_FILES['userfile']['size']     = $_FILES[''.$inputname.'']['size'][$i];

              $random = rand(1,99);
              $nama_file_unik = $random.$_FILES[''.$inputname.'']['name'][$i];
              $type_file = $_FILES[''.$inputname.'']['type'][$i];

              $config = array(
                'allowed_types' => '*',
                'file_name'     => $nama_file_unik,
                'max_size'      => '999999',
                'overwrite'     => TRUE,
                'remove_spaces' => TRUE,
                'upload_path'   => $path
              );

              $CI->upload->initialize($config);

              if ($_FILES['userfile']['tmp_name']) {

                  if ( ! $CI->upload->do_upload()) :
                    $error = array('error' => $CI->upload->display_errors());
                  else :

                    $data = array( 'upload_data' => $CI->upload->data() );

                    $datainsertattc = array(
                        'ref_id' => $params['ref_id'],
                        'ref_table' => $params['ref_table'],
                        'flag' => $params['flag'],
                        'attc_owner' => $CI->session->userdata('data_user')->fullname,
                        'attc_name' => $_FILES[''.$inputname.'']['name'][$i],
                        'attc_path' => $nama_file_unik,
                        'attc_fullpath' => $path.$nama_file_unik,
                        'attc_type' => $type_file,
                        'attc_size' => $_FILES[''.$inputname.'']['size'][$i],
                        'created_date' => date('Y-m-d H:i:s'),
                        'created_by' => $CI->session->userdata('data_user')->fullname,
                    );

                    $db->insert('tr_attachment', $datainsertattc);

                  endif;

              }
                
            }

            return true;
    } 

    function getUploadedFile($params, $type='', $path=''){

        $CI =&get_instance();
        $db = $CI->load->database('default', TRUE);
        $html = '';
        $files = $db->order_by('attc_id', 'ASC')->get_where('tr_attachment', $params)->result();
        foreach ($files as $key => $value) {
            $html .= '<a href="#" title="Delete file" onclick="delete_file_lampiran('.$value->attc_id.')"><i class="fa fa-times red"></i></a> &nbsp; <a href="'.base_url().$path.$value->attc_path.'" target="_blank">'.$value->attc_name.'</a> (<i>'.$value->attc_owner.'</i>)<br>';
        }
        if($type=='data'){
            return $files;
        }else{
            return $html;
        }

    }
	
}

?>
