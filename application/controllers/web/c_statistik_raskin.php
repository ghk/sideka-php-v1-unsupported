<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_raskin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_raskin');
        $this->load->model('m_logo');


    }  
 
   function index()
    {	
		$data['menerimaSangatMiskin'] 	=  $this->m_raskin->getMenerimaBantuanByKelasSosial('4','is_raskin');
		$data['menerimaMiskin'] 		=  $this->m_raskin->getMenerimaBantuanByKelasSosial('3','is_raskin');
		$data['menerimaSedang'] 		=  $this->m_raskin->getMenerimaBantuanByKelasSosial('2','is_raskin');
		$data['menerimaKaya'] 			=  $this->m_raskin->getMenerimaBantuanByKelasSosial('1','is_raskin');
		
		$data['totalSangatMiskin'] 	= $this->m_raskin->getTotalKeluargaByKelasSosial('4');
		$data['totalMiskin'] 		= $this->m_raskin->getTotalKeluargaByKelasSosial('3');
		$data['totalSedang'] 		= $this->m_raskin->getTotalKeluargaByKelasSosial('2');
		$data['totalKaya'] 			= $this->m_raskin->getTotalKeluargaByKelasSosial('1');
		
		$data['totalKepalaKeluarga']	= $this->m_raskin->getDataTotal();
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);				
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);
		$data['statistik'] = $this->load->view('web/content/java_statistik/raskin', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/raskin',$data,TRUE);
		
		$this->load->view('templateStatistik',$temp);
		
    }

}