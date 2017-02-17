<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Kerangka{
protected $_ci;
var $path;
function __construct(){
	$this->_ci=&get_instance();
	$this->_ci->config->load('config');
	$this->_ci->load->library('lib_menus');
	$this->path=array(
		'css'=>$this->_ci->config->item('css_path'),
		'js'=>$this->_ci->config->item('js_path'),
		'img'=>$this->_ci->config->item('img_path'),
		'font'=>$this->_ci->config->item('font_path'),
		'docs'=>$this->_ci->config->item('docs_path'),
		'base_url'=>$this->_ci->config->item('base_url'),
		'vendors'=>$this->_ci->config->item('vendors')
		);
	
	}
function site($view,$data=null){
	$data['_meta']=$this->_ci->load->view('meta',$this->path,true);
	$data['_topbar']=$this->_ci->load->view('topbar',$data,true);
	//$data['_sidebar']=$this->_ci->load->view('sidebar',$data,true);
	$data['_sidebar']=$this->_ci->load->view('sidebar',$data,true);
	$data['_breadcrumb']=$this->_ci->load->view('breadcrumb',$data,true);
	$data['_style']=$this->_ci->load->view('style_setting',$data,true);
	$data['_content']=$this->_ci->load->view($view,$data,true);
	$data['_footer']=$this->_ci->load->view('footer',$data,true);
	//$this->_ci->load->view("templates.php", $data);
	$this->_ci->load->view("templates.php", $data);
	}
}