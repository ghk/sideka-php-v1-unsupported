<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_perangkat extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_perangkat');
		$this->load->helper('url');
		$this->load->helper('date');
    }

    function index()    {
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$this->lists();
		}else
			redirect('c_login', 'refresh');     	
    }
	
	
    function lists() {
		$colModel['id_perangkat'] = array('ID',20,TRUE,'center',0);
        $colModel['nip'] = array('NIP',120,TRUE,'left',2);
		$colModel['nama'] = array('Nama',180,TRUE,'left',2);
		$colModel['niap'] = array('NIAP',120,TRUE,'left',2);
		$colModel['jabatan'] = array('Jabatan',100,TRUE,'center',2);	
		$colModel['is_aktif'] = array('Status',80,TRUE,'center',2);			
		$colModel['pangkat_gol'] = array('Golongan',60,TRUE,'center',2);
		$colModel['no_sk_angkat'] = array('No. SK Angkat',120,TRUE,'left',2);
		$colModel['tgl_angkat'] = array('Tanggal Angkat',90,TRUE,'center',2);
		$colModel['no_sk_berhenti'] = array('No. SK Berhenti',120,TRUE,'left',2);
		$colModel['tgl_berhenti'] = array('Tanggal Berhenti',90,TRUE,'center',2);
        $colModel['aksi'] = array('AKSI',60,FALSE,'center',0);
		
		//Populate flexigrid buttons..
        $buttons[] = array('Select All','check','btn');
		$buttons[] = array('separator');
        $buttons[] = array('DeSelect All','uncheck','btn');
        $buttons[] = array('separator');
		$buttons[] = array('Add','add','btn');
        $buttons[] = array('separator');
        $buttons[] = array('Delete Selected Items','delete','btn');
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

        $grid_js = build_grid_js('flex1',site_url('pustaka/c_perangkat/load_data'),$colModel,'id_perangkat','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA PERANGKAT DESA';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('perangkat/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {

        $this->load->library('flexigrid');
        $valid_fields = array('id_perangkat','nip','nama','niap','no_sk_angkat',
		'tgl_angkat','pangkat_gol','no_sk_berhenti','tgl_berhenti','jabatan');

		$this->flexigrid->validate_post('id_perangkat','ASC',$valid_fields);
		$records = $this->m_perangkat->get_perangkat_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
			$row->id_perangkat,
			$row->id_perangkat,
			$row->nip,
			$row->nama,
			$row->niap,
			$row->jabatan,
			$this->ubahAktif_NonAktif($row->is_aktif),
			$row->pangkat_gol,
			$row->no_sk_angkat,
			date('j-m-Y',strtotime($row->tgl_angkat)),
			$row->no_sk_berhenti,
			date('j-m-Y',strtotime($row->tgl_berhenti)),
			'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_perangkat(\''.$row->id_perangkat.'\')"/><i class="fa fa-pencil"></i></button>'
			);  
		}
		//Print please
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
    
	function ubahAktif_NonAktif($yesno)
	{
		if($yesno == 'Y')
		{return 'Aktif';}
		else if($yesno == 'N')
		{return 'Tidak Aktif';}
	}
	
    function add()
	{
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['deskripsi_jabatan']=$this->m_perangkat->get_jabatan();
			$data['deskripsi_pangkat_gol']=$this->m_perangkat->get_pangkat_gol();
			$data['page_title'] = 'Tambah Perangkat';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('perangkat/v_tambah', $data, TRUE);		
			$this->load->view('utama', $data);
		}
		else
			redirect('c_login', 'refresh'); 
    }
	
	function simpan_perangkat() 
	{
			$nip = $this->input->post('nip', TRUE);
			$niap = $this->input->post('niap', TRUE);
			$no_sk_angkat = $this->input->post('no_sk_angkat', TRUE);
			$tgl_angkat = $this->input->post('tgl_angkat', TRUE);
			$id_pangkat_gol = $this->input->post('id_pangkat_gol', TRUE);
			$no_sk_berhenti = $this->input->post('no_sk_berhenti', TRUE);
			
			$tgl_berhenti = $this->input->post('tgl_berhenti', TRUE);
			if($tgl_berhenti == null)
			{
				$tgl_berhenti = null;
			}
			else{
			$tgl_berhenti = date('Y-m-d',strtotime($tgl_berhenti));
			}
			
			$id_jabatan = $this->input->post('id_jabatan', TRUE);
			$nik = $this->input->post('nik', TRUE);
			$is_aktif = $this->input->post('is_aktif', TRUE);
			
			$this->form_validation->set_rules('nik', 'NIK', 'required');
			$this->form_validation->set_rules('nip', 'NIP', 'required');
			$this->form_validation->set_rules('niap', 'NIAP', 'required');
			$this->form_validation->set_rules('no_sk_angkat', 'No. SK Angkat', 'required');
			$this->form_validation->set_rules('tgl_angkat', 'Tgl. Angkat', 'required');
			$this->form_validation->set_rules('id_pangkat_gol', 'Pangkat Gol', 'required');
			$this->form_validation->set_rules('id_jabatan', 'Jabatan', 'required');
			
			if ($this->form_validation->run() == TRUE)
			{  	
				$id_penduduk=$this->m_perangkat->getIdPendudukByNIK($nik);
				$result['cek_nik'] = $this->m_perangkat->cekNIKExist($nik);
				$result['cek_id_penduduk'] = $this->m_perangkat->cekIdPendudukExist($id_penduduk);
				if ($result['cek_nik']!=NULL and $result['cek_id_penduduk']==NULL) 
				{ 	
					$data = array
					(
						'nip' => $nip,
						'niap' => $niap,
						'no_sk_angkat' => $no_sk_angkat,
						'tgl_angkat' => date('Y-m-d',strtotime($tgl_angkat)),
						'id_pangkat_gol' => $id_pangkat_gol,
						'no_sk_berhenti' => $no_sk_berhenti,
						'tgl_berhenti' => $tgl_berhenti,
						'id_jabatan' => $id_jabatan,
						'id_penduduk' => $id_penduduk,
						'is_aktif' => $is_aktif
					);
					
					$this->m_perangkat->insertPerangkat($data);	
					redirect('pustaka/c_perangkat','refresh');				
				}
				else
				{
					$this->add();
				} 
			}
			else
			{
				$this->add();
			} 		
    }

    function edit($id){	
        $session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['hasil'] = $this->m_perangkat->getPerangkatByIdPerangkat($id);
			$data['nik'] = $this->m_perangkat->getNIKByIdPerangkat($id);
			$data['nama'] = $this->m_perangkat->getNamaByIdPerangkat($id);
			$data['deskripsi_jabatan']=$this->m_perangkat->get_jabatan();
			$data['deskripsi_pangkat_gol']=$this->m_perangkat->get_pangkat_gol();	
			$data['page_title'] = 'EDIT PERANGAKAT DESA';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('perangkat/v_ubah', $data, TRUE);
        
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh'); 
    }
	
	function update_perangkat() {	
		$nip = $this->input->post('nip', TRUE);
		$niap = $this->input->post('niap', TRUE);
		$no_sk_angkat = $this->input->post('no_sk_angkat', TRUE);
		$tgl_angkat = $this->input->post('tgl_angkat', TRUE);
		$id_pangkat_gol = $this->input->post('id_pangkat_gol', TRUE);
		$no_sk_berhenti = $this->input->post('no_sk_berhenti', TRUE);
		$tgl_berhenti = $this->input->post('tgl_berhenti', TRUE);
		$id_jabatan = $this->input->post('id_jabatan', TRUE);
		$nik = $this->input->post('nik', TRUE);
		$id_perangkat = $this->input->post('id_perangkat', TRUE);
		$is_aktif = $this->input->post('is_aktif', TRUE);
		
		$this->form_validation->set_rules('nip', 'NIP', 'required');
		$this->form_validation->set_rules('niap', 'NIAP', 'required');
		$this->form_validation->set_rules('no_sk_angkat', 'No. SK Angkat', 'required');
		$this->form_validation->set_rules('id_pangkat_gol', 'Pangkat Gol', 'required');
		$this->form_validation->set_rules('id_jabatan', 'Jabatan', 'required');

		if ($this->form_validation->run() == TRUE)
		{		
					
			$data = array
			(
				'nip' => $nip,
				'niap' => $niap,
				'no_sk_angkat' => $no_sk_angkat,
				'tgl_angkat' =>date('Y-m-d',strtotime($tgl_angkat)),
				'id_pangkat_gol' => $id_pangkat_gol,
				'no_sk_berhenti' => $no_sk_berhenti,
				'tgl_berhenti' => date('Y-m-d',strtotime($tgl_berhenti)),
				'id_jabatan' => $id_jabatan,
				'is_aktif' => $is_aktif
				
			);
			$result = $this->m_perangkat->updatePerangkat(array('id_perangkat' => $id_perangkat), $data);
			redirect('pustaka/c_perangkat','refresh');
				
		  	
		}
		else $this->edit($id_perangkat);
    }
	
    function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_perangkat->deletePerangkat($id);
        }
        redirect('pustaka/c_perangkat', 'refresh'); 
    }
	
	public function autocomplete_Nik()
    {
        $nik = $this->input->post('nik',TRUE);
        $rows = $this->m_perangkat->get_NikPenduduk($nik);
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
        $rows = $this->m_perangkat->get_NamaPenduduk($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->nik.' | '.$row->nama;
		}
        return json_encode($json_array);
    }
}
?>