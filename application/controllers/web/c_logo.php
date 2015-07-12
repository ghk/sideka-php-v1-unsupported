<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class C_logo extends CI_Controller {

    public function  __construct()
    {
		parent::__construct();
		$this->load->model('m_logo');
    }
	
	function index()
    {	
		$data['konten_logo'] = $this->m_logo->getLogo();
		$this->load->view('v_logo', $data);
	}
}
?>