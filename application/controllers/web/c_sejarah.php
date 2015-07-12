<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class C_sejarah extends CI_Controller {

    public function  __construct()
    {
		parent::__construct();
		$this->load->model('m_sejarah');
		$this->load->model('m_logo');
		$this->load->helper('text');
    }
	
	function index()
    {		
		/* $data['sejarah'] = $this->m_sejarah->getSejarahByIdsejarah('1');
		//$data['sejarah'] = $this->m_sejarah->get_sejarah();
		$data['menu'] = $this->load->view('web/menu/sejarah', $data, TRUE);
		$temp['content'] = $this->load->view('web/sejarah',$data,TRUE);
		$this->load->view('templateHome',$temp); */
		
		/* $data['base_url']=$this->config->item('base_url');
		$datasejarah['sejarah'] = $this->m_sejarah->getSejarahByIdsejarah('1');
		$this->load->view('v_header',$data);
		$this->load->view('v_navbar');
		
		$this->load->view('web/sejarah', $datasejarah);
		$this->load->view('v_footer', $data); */
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['sejarah'] = $this->m_sejarah->getSejarahByIdsejarah('1');
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$data['content'] = $this->load->view('web/sejarah',$data,TRUE);
		$temp['footer'] = $this->load->view('v_footer',$data,TRUE);
		$this->load->view('templateHome',$temp);
		
	}
}
?>