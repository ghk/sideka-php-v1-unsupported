<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class C_visimisi extends CI_Controller {

    public function  __construct()
    {
		parent::__construct();
		$this->load->model('m_visimisi');
		$this->load->model('m_logo');
    }
	
	function index()
    {		
		$data['visimisi'] = $this->m_visimisi->getVisimisiByIdvisimisi('1');
		/* $data['menu'] = $this->load->view('web/menu/visimisi', $data, TRUE);
		$temp['content'] = $this->load->view('web/visimisi',$data,TRUE);
		$this->load->view('templateHome',$temp); */
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$data['content'] = $this->load->view('web/visimisi',$data,TRUE);
		$temp['footer'] = $this->load->view('v_footer',$data,TRUE);
		$this->load->view('templateHome',$temp);
	}
}
?>