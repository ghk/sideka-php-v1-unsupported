<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_pendapatan_dan_belanja extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('statistik/m_pendapatan_dan_belanja');
		$this->load->model('m_logo');
	}

	function index()
	{
		////////////////////////////////////////////////////////
		$pekerjaan[] = $this->m_pendapatan_dan_belanja->getDataPekerjaan();
		$json = json_encode($pekerjaan);
		$json =	$this->m_pendapatan_dan_belanja->highchartJson($json);
		$data['json'] = $json;
		////////////////////////////////////////////////////////

		$data['result'] = $this->m_pendapatan_dan_belanja->getDataPekerjaanTable();

		$data['jumlah'] = $this->m_pendapatan_dan_belanja->getJumlahPekerjaan();

		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);
		$data['statistik'] = $this->load->view('web/content/java_statistik/pendapatan', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/pendapatan',$data,TRUE);
		$this->load->view('templateStatistik',$temp);

	}

}