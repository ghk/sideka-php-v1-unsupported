<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_piramida extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_piramida');
        $this->load->model('m_logo');
    }  
 
   function index()
    {
		
		$json_laki 			= $this->getDataDataUmur('1');	
		$json_perempuan 	= $this->getDataDataUmur('2');
		
		$data['dataLaki'] 			= json_decode($json_laki, true);
		$data['dataPerempuan'] 		= json_decode($json_perempuan, true);
		
		$json_laki_highchart 		= $this->m_piramida->highchartJsonLaki($json_laki);		
		$json_perempuan_highchart 	= $this->m_piramida->highchartJsonPerempuan($json_perempuan);
		
		$data['dataLakiHighchart'] 		= $json_laki_highchart;	
		$data['dataPerempuanHighchart'] = $json_perempuan_highchart;
		
		$data['totalLaki']			= $this->m_piramida->getDataLaki();
		$data['totalPerempuan']		= $this->m_piramida->getDataPerempuan();
		$data['totalPenduduk']		= $this->m_piramida->getDataTotal();
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);				
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);
		$data['statistik'] = $this->load->view('web/content/java_statistik/piramida', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/piramida',$data,TRUE);
		
		//$temp['content'] = $this->load->view('web/content/piramida',$data,TRUE);
		
		//$this->load->view('web/statistik/kelas_sosial',$temp);
		$this->load->view('templateStatistik',$temp);
		
    }
		
	function getDataDataUmur($idjenkel)
    {		
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'0','4');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'5','9');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'10','14');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'15','19');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'20','24');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'25','29');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'30','34');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'35','39');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'40','44');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'45','49');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'50','54');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'55','59');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'60','64');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'65','69');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'70','74');
		$data[] = $this->m_piramida->getJumlahPenduduk($idjenkel,'75','200');
		
		$json = json_encode($data);		
		return $json;
    }
	

	
	

}