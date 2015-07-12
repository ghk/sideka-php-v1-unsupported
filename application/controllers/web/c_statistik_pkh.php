<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_pkh extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_pkh');
        $this->load->model('m_logo');
    }  
 
   function index()
    {	
		$data['menerimaSangatMiskin'] 	=  $this->m_pkh->getMenerimaBantuanByKelasSosial('4','is_pkh');
		$data['menerimaMiskin'] 		=  $this->m_pkh->getMenerimaBantuanByKelasSosial('3','is_pkh');
		$data['menerimaSedang'] 		=  $this->m_pkh->getMenerimaBantuanByKelasSosial('2','is_pkh');
		$data['menerimaKaya'] 			=  $this->m_pkh->getMenerimaBantuanByKelasSosial('1','is_pkh');
		
		$data['totalSangatMiskin'] 	= $this->m_pkh->getTotalKeluargaByKelasSosial('4');
		$data['totalMiskin'] 		= $this->m_pkh->getTotalKeluargaByKelasSosial('3');
		$data['totalSedang'] 		= $this->m_pkh->getTotalKeluargaByKelasSosial('2');
		$data['totalKaya'] 			= $this->m_pkh->getTotalKeluargaByKelasSosial('1');
		
		$data['totalKepalaKeluarga']	= $this->m_pkh->getDataTotal();
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);				
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);
		$data['statistik'] = $this->load->view('web/content/java_statistik/pkh', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/pkh',$data,TRUE);
		
		$this->load->view('templateStatistik',$temp);
		
    }

}