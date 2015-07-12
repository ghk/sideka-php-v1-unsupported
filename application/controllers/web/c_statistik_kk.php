<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_kk extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_kk');
        $this->load->model('m_logo');
    }  
 
   function index()
    {	
		$data['jumlah_kk_perempuan'] = $this->m_kk->getKkPerempuan();
		$data['jumlah_kk_laki'] = $this->m_kk->getKkLaki();
		
		$data['totalKepalaKeluarga']	= $this->m_kk->getDataTotal();
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);		
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);		
		$data['statistik'] = $this->load->view('web/content/java_statistik/kk', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/kk',$data,TRUE);
		
		$this->load->view('templateStatistik',$temp);
		
    }
		

}