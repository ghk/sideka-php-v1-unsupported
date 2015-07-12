<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_bsm extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_bsm');
        $this->load->model('m_logo');
    }  

   function index()
    {	
		$data['jumlah_bsm_perempuan'] 	= $this->m_bsm->getTotalBsmByJenisKelamin('2');
		$data['jumlah_bsm_laki'] 		= $this->m_bsm->getTotalBsmByJenisKelamin('1');
		
		$data['total_bsm']				= $this->m_bsm->getTotalBsm();
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);	
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);		
		$data['statistik'] = $this->load->view('web/content/java_statistik/bsm', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/bsm',$data,TRUE);
		
		$this->load->view('templateStatistik',$temp);
		
    }
		

}