<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_peta extends CI_Controller {

    function __construct()
    {
        parent::__construct();
       
        $this->load->helper('form');
        $this->load->model('m_peta');
        $this->load->helper('url');
    }  
    
  function index()    
	{
		
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['page_title'] = 'PETA DESA';		
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			
			$data['peta'] = $this->m_peta->getPeta();
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('peta/v_ubah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}
		else
			redirect('c_login', 'refresh');
    }
	
	function update_peta() {	
	
		$embed = $this->input->post('embed', TRUE);	
		$embed = html_entity_decode($embed);
			$dataLogo = array(
				'embed' =>  $embed,
				);			
			$this->m_peta->updatePeta(array('id_peta' => 1), $dataLogo);
			
		
		redirect('admin/c_peta','refresh');
			
    }
	
		
}

/* End of file chart.php */
/* Location: ./application/controllers/chart.php */