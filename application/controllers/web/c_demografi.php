<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class C_demografi extends CI_Controller {

    public function  __construct()
    {
		parent::__construct();
		$this->load->model('m_demografi');
		$this->load->model('m_logo');
    }
	
	function index()
    {		
		$data['demografi'] = $this->m_demografi->getDemografiByIddemografi('1');
	
		$data['penduduk'] = $this->m_demografi->getKependudukan();
		$data['keluarga'] = $this->m_demografi->getKeluarga();
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$temp['content'] = $this->load->view('web/demografi',$data,TRUE);
		$temp['footer'] = $this->load->view('v_footer',$data,TRUE);
		$this->load->view('templateHome',$temp);
	}
}
?>