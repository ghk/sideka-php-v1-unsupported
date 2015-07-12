<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class C_rt_rw extends CI_Controller {

    public function  __construct()
    {
		parent::__construct();
		$this->load->model('m_lembaga_desa');
		$this->load->model('m_logo');
    }
	
	function index()
    {		
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['ketua_RW'] = $this->m_lembaga_desa->getKetuaRW();
		$data['ketua_RT'] = $this->m_lembaga_desa->getKetuaRT();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);
		$temp['content'] = $this->load->view('web/rt_rw',$data,TRUE);
		$this->load->view('templateHome',$temp);
	}
}
?>