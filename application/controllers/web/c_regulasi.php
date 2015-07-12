<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class C_regulasi extends CI_Controller {

    public function  __construct()
    {
		parent::__construct();
		$this->load->helper('download');
		$this->load->model('m_logo');
		$this->load->model('m_regulasi');
		
    }
	
	function index()
    {		
     	$data['konten_logo'] = $this->m_logo->getLogo();
		$data['regulasi'] = $this->m_regulasi->getRegulasi();
		$data['base_url'] = $this->config->item('base_url');
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$data['content'] = $this->load->view('web/regulasi',$data,TRUE);
		$temp['footer'] = $this->load->view('v_footer',$data,TRUE);
		$this->load->view('templateHome',$temp);
	}
	
	function downloadRegulasiByIdRegulasi($id)
	{
		$file_regulasi = $this->m_regulasi->getFileRegulasiByIdRegulasi($id_regulasi);
		$nama_file = str_replace('uploads/files/','', $file_regulasi);
		$data = file_get_contents("uploads/files/".$nama_file);
		
		force_download($nama_file,$data);
	}
	
	function get_detail_berita($id){
	
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['berita'] = $this->m_berita->getBeritaByIdberita($id);
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('web/menu/berita', $data, TRUE);		
		$data['content'] = $this->load->view('web/detail_berita',$data,TRUE);
		$temp['footer'] = $this->load->view('v_footer',$data,TRUE);
		$this->load->view('templateHome',$temp);
	}
	
	
}
?>