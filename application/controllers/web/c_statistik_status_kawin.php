<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_status_kawin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_status_kawin');
        $this->load->model('m_logo');
    }  

   function index()
    {	
		////////////////////////////////////////////////////////
		$status_kawin[] = $this->m_status_kawin->getDataStatusKawin();		  
		$json = json_encode($status_kawin);	
		$json =	$this->m_status_kawin->highchartJson($json);
		$data['json'] = $json;
		////////////////////////////////////////////////////////
		
		$data['result'] = $this->m_status_kawin->getDataStatusKawinTable();	
		
		$data['jumlah'] = $this->m_status_kawin->getJumlahStatusKawin(); 
		
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);		
		$data['statistik'] = $this->load->view('web/content/java_statistik/status_kawin', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/status_kawin',$data,TRUE);
		
		$this->load->view('templateStatistik',$temp);
		
    }
}