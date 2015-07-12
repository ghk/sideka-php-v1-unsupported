<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class C_login extends CI_Controller {

    function  __construct()
    {
		parent::__construct();
        $this->load->helper('form');
		$this->load->model('m_login');
		$this->load->library('encrypt');
    }
	
	function index()
    {
		if($this->session->userdata('logged_in'))
		{
		  	$role['role'] = $this->session->userdata('logged_in');
			if($role['role']->role == 'Administrator')
			{
				redirect('admin/c_admin/');
			}
			else
			if($role['role']->role == 'Pengelola Data')
			{
				redirect('c_pengelolaData/');
			}
			
		}
		else{
				$data['cek'] = '1';
				$this->load->view('v_login',$data);
			}
	}

    function check_login() {
	
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
		//$password = MD5($password);
		
		$password = sha1($password);
		
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
		
		if ($this->form_validation->run() == TRUE)
		{		
			$data['hasil'] = $this->m_login->login($username,$password);
			if($data['hasil'] == NULL )
			{
				$data['cek'] = '0';
				$this->load->view('v_login',$data);
			}
			else
			{
				redirect('c_login', 'refresh');
			}
		}
		else 
		$this->load->view('v_login',TRUE);
    }

    function logout()
    {
        $this->session->unset_userdata('logged_in');
		
		session_destroy();
        redirect('c_login', 'refresh');
    }
}
?>
