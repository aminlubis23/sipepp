<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {

        parent::__construct();

        /*Load model*/
        $this->load->model('encryption');
        $this->load->model('Setting/User_model', 'user');
        /*load library*/
        $this->load->library('encrypt_2015');
        $this->load->library('session');
        $this->load->library('regex');
        $this->load->library('form_validation');
        /*load helper*/
        $this->load->helper('captcha');

    }

	public function index()
	{ 
        /*sess destroy before doing something*/
        $this->session->sess_destroy();
        $data = array();
        /*create captcha*/
        $captcha = $this->create_captcha();
        /*Send captcha image to view*/
        $data['captchaImg'] = $captcha['image'];
        /*load login view*/
		$this->load->view('login_view', $data);

	}

    public function create_captcha(){
        /*function for creating captcha*/
        /*params to generate captcha*/
        $config = array(
            'img_path'      => 'captcha_images/',
            'img_url'       => base_url().'captcha_images/',
            'img_width'     => '250',
            'img_height'    => 100,
            'word_length'   => 8,
            'font_size'     => 40
        );
        /*generate captcha*/
        $captcha = create_captcha($config);
        $this->session->unset_userdata('captcha_code');
        $this->session->set_userdata('captcha_code',$captcha['word']); 
        $this->session->set_userdata('captcha',$captcha); 

        return $captcha;
    }

    public function refreshCaptcha(){
        /*function to refresh captcha*/
        $captcha = $this->create_captcha();
        /*show captcha image*/
        echo $captcha['image'];
    }

    public function validate_captcha(){
        /*function to validate captcha*/
        if(empty($this->session->userdata('captcha_code') ) || strcasecmp($this->session->userdata('captcha_code'), $this->input->post('captcha_code')) != 0){  
           $this->form_validation->set_message('validate_captcha', 'Kode yang anda masukan salah, apakah anda robot?');
           return false;    
        }else{
            /*Captcha verification is Correct. Final Code Execute here!*/      
            return true;     
        }

    }

    public function process(){

        // Post form
        $username = $this->regex->_genRegex($this->input->post('username'), 'REGEXALNUM');
        $password = $this->encryption->encrypt_password_callback($this->input->post('password'), SECURITY_KEY);

        // form validation
        $this->form_validation->set_rules('username', 'Username', 'trim|required[m_user.email]|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        //$this->form_validation->set_rules('captcha_code', 'Captcha', 'callback_validate_captcha');

        // set message error
        $this->form_validation->set_message('alpha_numeric', "\"%s\" harus diisi dengan angka atau huruf tidak boleh menggunakan spesial karakter");
        $this->form_validation->set_message('required', "Silahkan isi field \"%s\"");
        $this->form_validation->set_message('min_length', "\"%s\" minimal 6 karakter");

        if ($this->form_validation->run() == FALSE)
        {

            $this->form_validation->set_error_delimiters('<div style="color:red"><i>', '</i></div>');
            $captcha = $this->create_captcha();
            $data['captchaImg'] = $captcha['image'];
            $this->load->view('login_view', $data);
        }
        else
        {                       
            //set session expire time, after that user should login again
            $this->session->sess_expiration = '1800'; // expiration 30 minutes
            $this->session->sess_expire_on_close = 'true';

            //cek user account
            $user_account = $this->_checkAccount($username, $password);

            // jika username dan password true response 1
            if($user_account->response == 1){

                //check session terlebih dahulu
                $sess_exis = $this->_checkSessionId($this->session->userdata('session_id'));

                //jika session belum berakhir
                if($sess_exis->response == 1){

                    //maka redirect ke main dan session tetap tersimpan
                    redirect(base_url().'dashboard');

                }else{

                    // save captcha to table
                    /*$data = array(
                            'captcha_time'  => $this->session->userdata('captcha')['time'],
                            'ip_address'    => $this->input->ip_address(),
                            'word'          => $this->session->userdata('captcha_code'),
                    );
                    $query = $this->db->insert_string('captcha', $data);
                    $this->db->query($query);*/

                    //session user
                    $all_data_user = $this->user->get_by_id($user_account->data->id_user);
                    /*session for kcfinder*/
                    $kcfinder = array(
                        'disabled' => true,
                        'uploadURL' => "../content_upload",
                        );
                    $session_user = array(
                        'data_user' => $all_data_user,
                        'user_id' => $user_account->data->id_user,
                        'login' => TRUE,
                        'ses_kcfinder' => $kcfinder,
                        );

                    $this->session->set_userdata($session_user);
                    redirect(base_url().'dashboard');
                }

            }else{

                redirect(base_url().'login?m=wrong');

            }
        
        }

    }

    public function _checkAccount($username, $password) {
        /*function to validate or check account user*/
         $check = $this->db->get_where('m_user', array('email' => $username, 'password' => $password));
         
         $result = new stdClass();
         $result->response = ($check->num_rows() > 0) ? TRUE : FALSE;
         $result->data = $check->row();

         return $result;

     }

	public function _checkSessionId($sessId) {
        /*function to check session ID*/
         $check = $this->db->get_where('ci_sessions', array('session_id' => $sessId));
		 
		 $result = new stdClass();
         $result->response = ($check->num_rows() > 0) ? TRUE : FALSE;
         $result->data = $check->row();

         return $result;

     }

	public function logout()
	{    
		/*function logout and destroy session*/
        $this->session->sess_destroy();
         /*redirect login*/
        redirect(base_url().'?m=out');
	}

	
}

/* End of file Login.php */
/* Location: ./application/modules/Login/controllers/Login.php */