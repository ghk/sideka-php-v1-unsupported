<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_jamkesmas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_jamkesmas');
        $this->load->model('m_logo');
    }  
 
   function index()
    {	
		$data['menerimaSangatMiskin'] 	=  $this->m_jamkesmas->getMenerimaBantuanByKelasSosial('4','is_jamkesmas');
		$data['menerimaMiskin'] 		=  $this->m_jamkesmas->getMenerimaBantuanByKelasSosial('3','is_jamkesmas');
		$data['menerimaSedang'] 		=  $this->m_jamkesmas->getMenerimaBantuanByKelasSosial('2','is_jamkesmas');
		$data['menerimaKaya'] 			=  $this->m_jamkesmas->getMenerimaBantuanByKelasSosial('1','is_jamkesmas');
		
		$data['totalSangatMiskin'] 	= $this->m_jamkesmas->getTotalKeluargaByKelasSosial('4');
		$data['totalMiskin'] 		= $this->m_jamkesmas->getTotalKeluargaByKelasSosial('3');
		$data['totalSedang'] 		= $this->m_jamkesmas->getTotalKeluargaByKelasSosial('2');
		$data['totalKaya'] 			= $this->m_jamkesmas->getTotalKeluargaByKelasSosial('1');
		
		$data['totalKepalaKeluarga']	= $this->m_jamkesmas->getDataTotal();
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);				
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);
		$data['statistik'] = $this->load->view('web/content/java_statistik/jamkesmas', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/jamkesmas',$data,TRUE);
		
		$this->load->view('templateStatistik',$temp);
		
    }

}