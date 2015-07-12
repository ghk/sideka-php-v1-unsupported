<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_statistik_buruh_migran extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('statistik/m_buruh_migran');
        $this->load->model('m_logo');
    }  

   function index()
    {	
		$data['jumlah_buruh_migran_perempuan'] 	= $this->m_buruh_migran->getTotalBuruhMigranByJenisKelamin('2');
		$data['jumlah_buruh_migran_laki'] 		= $this->m_buruh_migran->getTotalBuruhMigranByJenisKelamin('1');
		
		$data['total_buruh_migran']				= $this->m_buruh_migran->getTotalBuruhMigran();
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);		
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);		
		$data['footer'] = $this->load->view('v_footer', $data, TRUE);		
		$data['statistik'] = $this->load->view('web/content/java_statistik/buruh_migran', $data, TRUE);
		$temp['content'] = $this->load->view('web/content/buruh_migran',$data,TRUE);
		
		$this->load->view('templateStatistik',$temp);
		
    }
		

}