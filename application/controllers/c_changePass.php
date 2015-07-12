<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_changePass extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid');
        $this->load->library('flexigrid');
        $this->load->helper('form');        
        $this->load->model('m_user');
		$this->load->library('encrypt');
	
    }

    function index()
    {
		if($this->session->userdata('logged_in'))
		{			
			$data['cek'] = '1';
			$this->load->view('v_changePass',$data);		
		}else
			redirect('c_login', 'refresh');   
        	
    }
	
	function back()
	{
		if($this->session->userdata('logged_in'))
		{
		  	$data['hasil'] = $this->session->userdata('logged_in');
			$temp = $data['hasil']->role;
						
			if($temp == 'Administrator')
			{
				redirect('admin/c_admin/');					  
			}
			if($temp == 'Pengelola Data')
			{
				redirect('c_pengelolaData/');
			}
		}else
			redirect('c_login', 'refresh');   
	}

    function updatePass() {
		if($this->session->userdata('logged_in'))
			{
				$passLama	= $this->input->post('passlama', TRUE);
				$passLama 	= sha1($passLama);
				
				$passBaru 	= $this->input->post('passbaru', TRUE);
				$passBaru 	= sha1($passBaru);
				
				$konfirm 	= $this->input->post('password', TRUE);
				$konfirm 	= sha1($konfirm);
				
				$data['hasil'] = $this->session->userdata('logged_in');
				$id = $data['hasil']->id_pengguna;				
				$temp = $data['hasil']->password;
				
				if($passLama==$temp)
				{
					if($passBaru==$konfirm)
					{							
						$data = array(
							'password' => $konfirm			
						);		
						$this->m_user->updateUser(array('id_pengguna' => $id), $data);
						
						redirect('c_changePass/back');	
					}
					else {
							$data['cek'] = '0';
							$this->load->view('v_changePass',$data);
					}
				}
				else {
							$data['cek'] = '2';
							$this->load->view('v_changePass',$data);
				}
					
			}else
				redirect('c_login', 'refresh');   	       
    }
}
?>