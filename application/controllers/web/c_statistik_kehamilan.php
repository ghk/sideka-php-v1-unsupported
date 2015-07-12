<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_kehamilan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_kehamilan');
        $this->load->model('m_logo');
    }  
 
   function index()
    {		
		$data['total_kehamilan'] = $this->m_kehamilan->getKehamilan();		
		$data['total_kehamilan_resti'] = $this->m_kehamilan->getKehamilanResti('Y');		
		$data['total_kehamilan_normal'] = $this->m_kehamilan->getKehamilanResti('N');
		$data['konten_logo'] = $this->m_logo->getLogo();		
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);			
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);	
		$data['statistik'] = $this->load->view('web/content/java_statistik/kehamilan', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/kehamilan',$data,TRUE);
		
		$this->load->view('templateStatistik',$temp);
		
    }
		

}