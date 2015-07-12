<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_kelas_sosial extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_kelas_sosial');
        $this->load->model('m_logo');
    }  

   function index()
    {	
		$data['jumlah_sangat_miskin'] 	= $this->m_kelas_sosial->getKeluargaByIdKelasSosial('4');
		$data['jumlah_miskin'] 			= $this->m_kelas_sosial->getKeluargaByIdKelasSosial('3');
		$data['jumlah_sedang'] 			= $this->m_kelas_sosial->getKeluargaByIdKelasSosial('2');
		$data['jumlah_kaya'] 			= $this->m_kelas_sosial->getKeluargaByIdKelasSosial('1');
		
		$data['total_kelas_sosial']				= $this->m_kelas_sosial->getTotalKeluarga();
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);	
		$data['statistik'] = $this->load->view('web/content/java_statistik/kelas_sosial', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/kelas_sosial',$data,TRUE);
		
		$this->load->view('templateStatistik',$temp);
		
    }
		

}