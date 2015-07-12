<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_pendidikan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_pendidikan');
        $this->load->model('m_logo');
    }  

   function index()
    {	
		////////////////////////////////////////////////////////
		$pendidikan[] = $this->m_pendidikan->getDataPendidikan();		  
		$json = json_encode($pendidikan);	
		$json =	$this->m_pendidikan->highchartJson($json);
		$data['json'] = $json;
		////////////////////////////////////////////////////////
		
		$data['result'] = $this->m_pendidikan->getDataPendidikanTable();	
		
		$data['jumlah'] = $this->m_pendidikan->getJumlahPendidikan(); 
		
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);		
		$data['statistik'] = $this->load->view('web/content/java_statistik/pendidikan', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/pendidikan',$data,TRUE);
		
		$this->load->view('templateStatistik',$temp);
		
    }
}