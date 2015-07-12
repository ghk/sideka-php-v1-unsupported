<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class C_lembaga_desa extends CI_Controller {

    public function  __construct()
    {
		parent::__construct();
		$this->load->model('m_lembaga_desa');
		$this->load->model('m_logo');
    }
	
	function index()
    {		
		/* $data['lembaga_desa'] = $this->m_lembaga_desa->getLembaga_desaByIdlembaga('1');
		$data['menu'] = $this->load->view('web/menu/lembaga_desa', $data, TRUE);
		$temp['content'] = $this->load->view('web/lembaga_desa',$data,TRUE);
		$this->load->view('templateHome',$temp); */
		$data['konten_logo'] = $this->m_logo->getLogo();
		//$data['kepala_desa'] = $this->m_lembaga_desa->getKepalaDesa();
		$data['perangkat_desa'] = $this->m_lembaga_desa->getPerangkatDesa();
		$data['kepala_dusun'] = $this->m_lembaga_desa->getKepalaDusun();
		//$data['lembaga_desa'] = $this->m_lembaga_desa->getLembaga_desaByIdlembaga('1');
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$data['footer'] = $this->load->view('v_footer',$data,TRUE);
		$temp['content'] = $this->load->view('web/lembaga_desa',$data,TRUE);
		
		$this->load->view('templateHome',$temp);
	}
}
?>