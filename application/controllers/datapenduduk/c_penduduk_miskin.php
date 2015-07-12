<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_penduduk_miskin extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_penduduk_miskin');
    }

    function index()    {
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$this->lists();
		}else
			redirect('c_login', 'refresh');
        	
    }

    function lists() {
        $colModel['id_keluarga'] = array('ID',20,TRUE,'left',0);			
		$colModel['no_kk'] = array('No KK',150,TRUE,'left',2);
		$colModel['tbl_penduduk.nik'] = array('NIK Kepala Keluarga',150,TRUE,'left',2);
		$colModel['tbl_penduduk.nama'] = array('Nama',150,TRUE,'left',2);
		$colModel['is_raskin'] = array('Raskin',80,TRUE,'center',2);
		$colModel['is_jamkesmas'] = array('Jamkesmas',80,TRUE,'center',2);
		$colModel['is_pkh'] = array('PKH',80,TRUE,'center',2);		
		$colModel['ref_kelas_sosial.deskripsi'] = array('Status Ekonomi',150,TRUE,'center',2);
        //$colModel['aksi'] = array('AKSI',60,FALSE,'left',2);
		
		//Populate flexigrid buttons..
       /*  $buttons[] = array('Select All','check','btn');
		$buttons[] = array('separator');
        $buttons[] = array('DeSelect All','uncheck','btn');
        $buttons[] = array('separator');
		$buttons[] = array('Add','add','btn');
        $buttons[] = array('separator');
        $buttons[] = array('Delete Selected Items','delete','btn'); */
        $buttons[] = array('separator');
       		
        $gridParams = array(
            'height' => 400,
            'rp' => 15,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('datapenduduk/c_penduduk_miskin/load_data'),$colModel,'id_keluarga','asc',$gridParams,$buttons);
		
		
		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA PENERIMA PROGRAM PERLINDUNGAN SOSIAL';		
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('penduduk_miskin/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {	
	
		//$data['id_kelas_sosial'] = $this->m_keluarga->get_kelas_sosial();
		
		$this->load->library('flexigrid');
        $valid_fields = array('id_keluarga','no_kk','tbl_penduduk.nik','tbl_penduduk.nama','is_raskin','is_jamkesmas','is_pkh','ref_kelas_sosial.deskripsi');

		$this->flexigrid->validate_post('id_keluarga','asc',$valid_fields);
		$records = $this->m_penduduk_miskin->get_penduduk_miskin_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->id_keluarga,
				$row->id_keluarga,
				$row->no_kk,
				$row->nik,
				$row->nama,	
				$this->ubahYesNo($row->is_raskin),
				$this->ubahYesNo($row->is_jamkesmas),
				$this->ubahYesNo($row->is_pkh),	
				$row->kelas_sosial
				//'<input type="button" value="Edit" class="ubah" onclick="edit_penduduk_miskin(\''.$row->id_keluarga.'\')"/>'
			);  
		}
		//Print please
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
    
	function ubahYesNo($yesno)
	{
		if($yesno == 'Y')
		{return 'Dapat';}
		else if($yesno == 'N')
		{return '-';}
	}
	
    function add(){		
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{			
			$data['page_title'] = 'Tambah GIZI BURUK';
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('penduduk_miskin/v_tambah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_penduduk_miskin() {
	
		$nik = $this->input->post('nik', TRUE);
		$nama = $this->input->post('nama', TRUE);
		$berat_badan = $this->input->post('berat_badan', TRUE);		
		$tinggi_badan = $this->input->post('tinggi_badan', TRUE);	
		$tgl_timbang = $this->input->post('tgl_timbang', TRUE);
		
		$this->form_validation->set_rules('nik', 'Nik', 'required');		
		$this->form_validation->set_rules('nama', 'Nama', 'required');		
		$this->form_validation->set_rules('berat_badan', 'Berat Badan', 'required');
		$this->form_validation->set_rules('tinggi_badan', 'Tinggi Badan', 'required');
		$this->form_validation->set_rules('tgl_timbang', 'Tanggal Menimbang', 'required');
		
		

		if ($this->form_validation->run() == TRUE)
		{							
			$id_penduduk = $this->m_penduduk_miskin->getIdPendudukByNIK($nik);
			$result['hasil'] = $this->m_penduduk_miskin->cekFIleExist($id_penduduk);
			
			if ($result['hasil'] == NULL) {				
				$data = array(
					'berat_badan' => $berat_badan,
					'tinggi_badan' => $tinggi_badan,
					'tgl_timbang' => date('Y-m-d', strtotime($tgl_timbang)),
					'id_penduduk' => $id_penduduk					
				);

				$this->m_penduduk_miskin->insertGiziBuruk($data);	
				redirect('datapenduduk/c_penduduk_miskin','refresh');
			}			
			else $this->add();
			/* Handle ketika nomer penduduk_miskin telah digunakan */
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['hasil']		= $this->m_penduduk_miskin->getGiziBurukByIdGiziBuruk($id);
			$data['penduduk']	= $this->m_penduduk_miskin->getPendudukByIdGiziBuruk($id);
			$data['page_title'] = 'Edit Data GIZI BURUK';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('penduduk_miskin/v_ubah', $data, TRUE);
        
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update_penduduk_miskin() {	
	
		$id_penduduk_miskin = $this->input->post('id_penduduk_miskin', TRUE);
		
		$berat_badan = $this->input->post('berat_badan', TRUE);		
		$tinggi_badan = $this->input->post('tinggi_badan', TRUE);	
		$tgl_timbang = $this->input->post('tgl_timbang', TRUE);
			
		$this->form_validation->set_rules('berat_badan', 'Berat Badan', 'required');
		$this->form_validation->set_rules('tinggi_badan', 'Tinggi Badan', 'required');
		$this->form_validation->set_rules('tgl_timbang', 'Tanggal Menimbang', 'required');
		
		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
					'berat_badan' => $berat_badan,
					'tinggi_badan' => $tinggi_badan,
					'tgl_timbang' => date('Y-m-d', strtotime($tgl_timbang))			
				);
	
		  	$result = $this->m_penduduk_miskin->updateGiziBuruk(array('id_penduduk_miskin' => $id_penduduk_miskin), $data);
			
		  	redirect('datapenduduk/c_penduduk_miskin','refresh');
		}
		else $this->edit($id_penduduk_miskin);
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_penduduk_miskin->deleteGiziBuruk($id);
            $sucess++;
        }
		
        redirect('admin/c_penduduk_miskin', 'refresh');
    }
	
	public function autocomplete_Nik()
    {
        $nik = $this->input->post('nik',TRUE);
        $rows = $this->m_penduduk_miskin->get_NikPenduduk($nik);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]=$row->nik;
		}
        return json_encode($json_array);
    }
	
	public function autocomplete_NamaPenduduk()
    {
        $nama = $this->input->post('nama',TRUE);
        $rows = $this->m_penduduk_miskin->get_NamaPenduduk($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->nik.' | '.$row->nama;
		}
        return json_encode($json_array);
    }
}
?>