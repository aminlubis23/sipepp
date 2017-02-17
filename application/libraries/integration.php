<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

final Class Integration {

	// ================================= DASHBOARD =================================== //
	public function getStandarExisting($params)
	{
		$url = BASE_API_URL_SKM.'/getStandarExisting'; 
	    $data = array(
	    	"tahun" => isset($params['tahun'])?$params['tahun']:'',
	    	"id_provinsi" => isset($params['id_provinsi'])?$params['id_provinsi']:'',
	    	"id_kabupaten" => isset($params['id_kabupaten'])?$params['id_kabupaten']:'',
	    	"kode_rsu" => isset($params['kode_rsu'])?$params['kode_rsu']:'',
	    	"kategori_kelas" => isset($params['kategori_kelas'])?$params['kategori_kelas']:''
	    );

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		// execute!
		$response = curl_exec($ch);

		// close the connection, release resources used
		curl_close($ch);

		// do anything you want with your response
		return json_decode($response);
	}

	public function getSKM($params)
	{
		/*print_r($params);die;*/
		$url = BASE_API_URL_SKM.'/getSKM'; 
	    $data = $params;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		// execute!
		$response = curl_exec($ch);
		// close the connection, release resources used
		curl_close($ch);
		// do anything you want with your response
		return json_decode($response);
	}

}

?> 