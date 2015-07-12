<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_agama extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_agama');
        $this->load->model('m_logo');
    }  

   function index()
    {	
		////////////////////////////////////////////////////////
		$agama[] = $this->m_agama->getDataAgama();		  
		$json = json_encode($agama);	
		$json =	$this->m_agama->highchartJson($json);
		$data['json'] = $json;
		////////////////////////////////////////////////////////
		
		$data['result'] = $this->m_agama->getDataAgamaTable();	
		
		$data['jumlah'] = $this->m_agama->getJumlahAgama(); 
		
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);		
		$data['statistik'] = $this->load->view('web/content/java_statistik/agama', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/agama',$data,TRUE);
		
		$this->load->view('templateStatistik',$temp);
		
    }
}