<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_smart extends CI_Controller {

	
    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        //$this->load->helper('flexigrid_helper');
       // $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_smart');	
        $this->load->model('m_penduduk');	
        $this->load->model('m_keluarga');	
		$this->load->helper('form'); 
        $this->load->helper('url');
    }

    function index()    {
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$this->form_smart();
		}else
			redirect('c_login', 'refresh');   
        	
    }

    function form_smart()
	{
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$s['cek'] = $this->session->userdata('logged_in');
			
			$data['id_pekerjaan'] = $this->m_smart->get_pekerjaan();		
			$data['id_pendidikan'] = $this->m_smart->get_pendidikan();		
			$data['id_agama'] = $this->m_smart->get_agama();
			$data['id_goldar'] = $this->m_smart->get_goldar();
			$data['id_jen_kel'] = $this->m_smart->get_jen_kel();
			$data['id_kewarganegaraan'] = $this->m_smart->get_kewarganegaraan();
			$data['id_status_kawin'] = $this->m_smart->get_status_kawin();
			$data['id_status_penduduk'] = $this->m_smart->get_status_penduduk();
			$data['id_status_tinggal'] = $this->m_smart->get_status_tinggal();
			$data['id_difabilitas'] = $this->m_smart->get_difabilitas();
			$data['id_kelas_sosial'] = $this->m_smart->get_kelas_sosial();
			
			$data['page_title'] = 'Pencarian Pintar';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('smart/v_smart', $data, TRUE);		
			$this->load->view('utama', $data);
		}
		else
		{
			redirect('c_login', 'refresh');
		}
        
    }
	
	function load_data()
	{
		$arrInput 	= array();
		$arrUtuh 	= array();
		$countArr 	= 0;
		//POST DATA
		if($this->input->post('id_jen_kel', TRUE) != NULL)
		{			
			$arrInput[$countArr]  =  array(
			'id_jen_kel',
			$this->input->post('id_jen_kel', TRUE),
			$this->input->post('radio1', TRUE)
			);
			$countArr++;			
		}		
		else if($this->input->post('tempat_lahir', TRUE) != NULL)
		{
			$arrInput[$countArr]  = array(
			'tempat_lahir',
			$this->input->post('tempat_lahir', TRUE),
			$arrInput[$countArr]  = $this->input->post('radio2', TRUE)
			);
			$countArr++;
		}		
		else if($this->input->post('id_goldar', TRUE) != NULL)
		{
			$arrInput[$countArr]  = array(
			'id_goldar',
			$this->input->post('id_goldar', TRUE),
			$this->input->post('radio3', TRUE)
			);
			$countArr++;
		}
		else if($this->input->post('id_kewarganegaraan', TRUE) != NULL)
		{
			$arrInput[$countArr]  =array( 
			'id_kewarganegaraan',
			$this->input->post('id_kewarganegaraan', TRUE),
			$this->input->post('radio4', TRUE)
			);
			$countArr++;
		}
		else if($this->input->post('id_pendidikan', TRUE) != NULL)
		{
			$arrInput[$countArr]  = array(
			'id_pendidikan',
			$this->input->post('id_pendidikan', TRUE),
			$this->input->post('radio5', TRUE)
			);
			$countArr++;
		}
		else if($this->input->post('id_agama', TRUE) != NULL)
		{
			$arrInput[$countArr]  =array( 
			 'id_agama',
			$this->input->post('id_agama', TRUE),
			$this->input->post('radio6', TRUE)
			);
			$countArr++;
		}
		else if($this->input->post('id_pekerjaan', TRUE) != NULL)
		{
			$arrInput[$countArr]  = array(
			'id_pekerjaan',
			$this->input->post('id_pekerjaan', TRUE),
			$this->input->post('radio7', TRUE)
			);
			$countArr++;
		}
		else if($this->input->post('id_status_kawin', TRUE) != NULL)
		{
			$arrInput[$countArr]  = array(
			 'id_status_kawin',
			$this->input->post('id_status_kawin', TRUE),
			$this->input->post('radio8', TRUE)
			);
			$countArr++;
		}
		else if($this->input->post('id_status_penduduk', TRUE) != NULL)
		{
			$arrInput[$countArr]  = array(
			'id_status_penduduk',
			$this->input->post('id_status_penduduk', TRUE),
			$this->input->post('radio9', TRUE)
			);
			$countArr++;
		}
		else if($this->input->post('id_status_tinggal', TRUE) != NULL)
		{
			$arrInput[$countArr]  = array(
			'id_status_tinggal',
			$this->input->post('id_status_tinggal', TRUE),
			$this->input->post('radio10', TRUE)
			);
			$countArr++;
		}
		else if($this->input->post('id_difabilitas', TRUE) != NULL)
		{
			$arrInput[$countArr]  = array(
			'id_difabilitas',
			$this->input->post('id_difabilitas', TRUE),
			$this->input->post('radio11', TRUE)
			);
			$countArr++;
		}
		else if($this->input->post('is_bsm', TRUE) != NULL)
		{
			$arrInput[$countArr]  = array(
			'is_bsm',
			$this->input->post('is_bsm', TRUE),
			$this->input->post('radio12', TRUE)
			);
			$countArr++;
		}
		else if($this->input->post('is_raskin', TRUE) != NULL)
		{
			$arrInput[$countArr]  = array(
			'is_raskin',
			$this->input->post('is_raskin', TRUE),
			$this->input->post('radio13', TRUE)
			);
			$countArr++;
		}
		else if($this->input->post('is_jamkesmas', TRUE) != NULL)
		{
			$arrInput[$countArr]  = array(
			'is_jamkesmas',
			$this->input->post('is_jamkesmas', TRUE),
			$this->input->post('radio14', TRUE)
			);
			$countArr++;
		}
		else if($this->input->post('is_pkh', TRUE) != NULL)
		{
			$arrInput[$countArr]  = array(
			'is_pkh',
			$this->input->post('is_pkh', TRUE),
			$this->input->post('radio15', TRUE)
			);
			$countArr++;
		}
		else if($this->input->post('id_kelas_sosial', TRUE) != NULL)
		{
			$arrInput[$countArr]  = array(
			'id_kelas_sosial',
			$this->input->post('id_kelas_sosial', TRUE),
			$this->input->post('radio16', TRUE)
			);
			$countArr++;
		}
		else redirect('smart/c_smart/', 'refresh');   
						
	    //POST RADIO 
		
	
		$count = 0;
		$countUtuh = $countArr-1;
	
		$data['js_grid'] = $this->m_smart->get_smart_flexigrid($arrInput, $countUtuh);
		
        $data['page_title'] = 'HASIL PENCARIAN';		
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('smart/v_list', $data, TRUE);
        $this->load->view('utama', $data);
	}
	
	function detil($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$s['cek'] = $this->session->userdata('logged_in');
			$x = $s['cek']->id_pengguna;
				
			
			$data['result'] = $this->m_penduduk->getDataPendudukByIdPenduduk($id);
			$data['keluarga'] = $this->m_penduduk->getDataHubunganKeluargaByIdPenduduk($id);
			
			$data['nama_dusun'] = $this->m_keluarga->get_dusun();
			$data['nomor_rw'] = $this->m_keluarga->get_rw();
			$data['nomor_rt'] = $this->m_keluarga->get_rt();
			$data['id_pekerjaan'] = $this->m_keluarga->get_pekerjaan();		
			$data['id_pendidikan'] = $this->m_keluarga->get_pendidikan();		
			$data['id_agama'] = $this->m_keluarga->get_agama();
			$data['id_goldar'] = $this->m_keluarga->get_goldar();
			$data['id_jen_kel'] = $this->m_keluarga->get_jen_kel();
			$data['id_kewarganegaraan'] = $this->m_keluarga->get_kewarganegaraan();
			$data['id_pekerjaan_ped'] = $this->m_keluarga->get_pekerjaan_ped();
			$data['id_kompetensi'] = $this->m_keluarga->get_kompetensi();
			$data['id_status_kawin'] = $this->m_keluarga->get_status_kawin();
			$data['id_status_penduduk'] = $this->m_keluarga->get_status_penduduk();
			$data['id_status_tinggal'] = $this->m_keluarga->get_status_tinggal();
			$data['id_difabilitas'] = $this->m_keluarga->get_difabilitas();
			$data['id_kontrasepsi'] = $this->m_keluarga->get_kontrasepsi();
			$data['id_status_keluarga'] = $this->m_keluarga->get_status_keluarga();
			
			
			$data['page_title'] = 'Detil Data Penduduk';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('smart/v_detil', $data, TRUE);
        
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
}
?>