<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_data_apbdes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('statistik/m_data_apbdes');
		$this->load->model('m_logo');
	}

	function index()
	{
		//$data['result'] = $this->m_data_apbdes->getDataAkunPendapatan();
		//$data['jumlah'] = $this->m_data_apbdes->getJumlahPekerjaan();
		$data['result'] = $this->m_data_apbdes->getDataApbdesTable();

		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/data_apbdes',$data,TRUE);
		$this->load->view('templateStatistik',$temp);

	}

}