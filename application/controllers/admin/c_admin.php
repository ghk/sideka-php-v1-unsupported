<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start();

class C_admin extends CI_Controller {

    function  __construct()
    {
		parent::__construct();
        $this->load->helper('form'); 
		$this->load->model('m_user');   
		$this->load->model('m_kalkulasi'); 
		$this->load->model('statistik/m_kk');
		$this->load->model('m_logo');			
    }

	function index()
    {				
		$data['page_title'] = 'Administrator';
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['jumlah_penduduk'] = $this->m_kalkulasi->getTotalPenduduk();
		$data['jumlah_penduduk_laki'] = $this->m_kalkulasi->getTotalPendudukByKelamin('1');
		$data['jumlah_penduduk_perempuan'] = $this->m_kalkulasi->getTotalPendudukByKelamin('2');		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);	

		$data['jumlah_kk_perempuan'] = $this->m_kk->getKkPerempuan();
		$data['jumlah_kk_laki'] = $this->m_kk->getKkLaki();		
		//$data['statistik'] = $this->load->view('web/content/java_statistik/kk', $data, TRUE);
		
		$data['content'] = $this->load->view('v_admin', $data, TRUE);
		
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');        
    }
}
?>