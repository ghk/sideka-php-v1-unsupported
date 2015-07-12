<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_gizi_buruk extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_gizi_buruk');
        $this->load->model('m_logo');
    }  
 
   function index()
    {			
		$data['total_anak'] = $this->m_gizi_buruk->getAnakByUmur('0','9');		
		$data['total_anak_gizi_buruk'] = $this->m_gizi_buruk->getAnakGiziBurukByUmur('0','9');		
		$data['total_anak_gizi_buruk_laki'] = $this->m_gizi_buruk->getGiziBurukByKelamin('1','0','9');
		$data['total_anak_gizi_buruk_perempuan'] = $this->m_gizi_buruk->getGiziBurukByKelamin('2','0','9');
		
		$data['total_anak_0_4'] = $this->m_gizi_buruk->getAnakByUmur('0','4');
		$data['jumlah_gizi_buruk_0_4'] = $this->m_gizi_buruk->getAnakGiziBurukByUmur('0','4');		
		$data['jumlah_gizi_buruk_laki_0_4'] = $this->m_gizi_buruk->getGiziBurukByKelamin('1','0','4');
		$data['jumlah_gizi_buruk_perempuan_0_4'] = $this->m_gizi_buruk->getGiziBurukByKelamin('2','0','4');
		
		$data['total_anak_5_9'] = $this->m_gizi_buruk->getAnakByUmur('5','9');
		$data['jumlah_gizi_buruk_5_9'] = $this->m_gizi_buruk->getAnakGiziBurukByUmur('5','9');
		$data['jumlah_gizi_buruk_laki_5_9'] = $this->m_gizi_buruk->getGiziBurukByKelamin('1','5','9');
		$data['jumlah_gizi_buruk_perempuan_5_9'] = $this->m_gizi_buruk->getGiziBurukByKelamin('2','5','9');
		
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);				
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);
		$data['statistik'] = $this->load->view('web/content/java_statistik/gizi_buruk', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/gizi_buruk',$data,TRUE);
		
		$this->load->view('templateStatistik',$temp);
		
    }
		

}