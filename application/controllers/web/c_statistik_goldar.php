<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_goldar extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_goldar');
        $this->load->model('m_logo');
    }  

   function index()
    {	
		////////////////////////////////////////////////////////
		$goldar[] = $this->m_goldar->getDataGoldar();		  
		$json = json_encode($goldar);	
		$json =	$this->m_goldar->highchartJson($json);
		$data['json'] = $json;
		////////////////////////////////////////////////////////
		
		$data['result'] = $this->m_goldar->getDataGoldarTable();	
		
		$data['jumlah'] = $this->m_goldar->getJumlahGoldar(); 
		
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);		
		$data['statistik'] = $this->load->view('web/content/java_statistik/goldar', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/goldar',$data,TRUE);
		
		$this->load->view('templateStatistik',$temp);
		
    }
}