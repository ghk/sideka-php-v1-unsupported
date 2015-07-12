<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class C_home extends CI_Controller {

    public function  __construct()
    {
		parent::__construct();
		$this->load->model('m_berita');
		$this->load->model('m_logo');
		$this->load->model('m_slider_beranda');
		$this->load->helper('text');
    }
	
	function index()
    {
		/* $data['berita'] = $this->m_berita->get_recent_berita();
		$data['menu'] = $this->load->view('web/menu/home', $data, TRUE);		
		$temp['content'] = $this->load->view('web/home',$data,TRUE);
		$this->load->view('templateHome',$temp); */
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['slider_row'] = $this->m_slider_beranda->getSliderBerandaRow();
		$data['slider_beranda'] = $this->m_slider_beranda->getSliderBeranda();
		
		$data['berita'] = $this->m_berita->get_recent_berita();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$data['slider'] = $this->load->view('v_slider', $data, TRUE);
		$data['content'] = $this->load->view('web/home',$data,TRUE);
		$temp['footer'] = $this->load->view('v_footer',$data,TRUE);
		$this->load->view('templateHome',$temp);
	}
	
	function get_detail_berita($id){
		$data['konten_logo'] = $this->m_logo->getLogo();
		/* $data['berita'] = $this->m_berita->getBeritaByIdberita($id);
		$data['menu'] = $this->load->view('web/menu/berita', $data, TRUE);		
		$temp['content'] = $this->load->view('web/detail_berita',$data,TRUE);
		$this->load->view('templateHome',$temp); */
		$data['berita'] = $this->m_berita->getBeritaByIdberita($id);
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$data['content'] = $this->load->view('web/detail_berita',$data,TRUE);
		$temp['footer'] = $this->load->view('v_footer',$data,TRUE);
		$this->load->view('templateHome',$temp);
	}
}
?>