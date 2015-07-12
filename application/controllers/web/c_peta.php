<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_peta extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
       $this->load->model('m_peta');
       $this->load->model('m_logo');
    }  
    
    public function index()
    {
		
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['peta'] = $this->m_peta->getPeta();
		$data['base_url']=$this->config->item('base_url');
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$data['content'] = $this->load->view('web/peta',$data,TRUE);
		$temp['footer'] = $this->load->view('v_footer',$data,TRUE);
		$this->load->view('templateHome',$temp);	
    }
    
}

/* End of file chart.php */
/* Location: ./application/controllers/chart.php */