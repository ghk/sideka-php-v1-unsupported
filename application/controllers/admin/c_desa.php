<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_desa extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_desa');
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
        $colModel['no'] = array('No',30,TRUE,'center',0);
		$colModel['kode_desa_bps'] = array('Kode Desa (BPS)',130,TRUE,'center',2);
		$colModel['kode_desa_kemendagri'] = array('Kode Desa (Kemendagri)',130,TRUE,'center',2);
        $colModel['nama_desa'] = array('Nama Desa',100,TRUE,'center',2);
        $colModel['alamat'] = array('Alamat',100,TRUE,'center',2);
		$colModel['luas_wilayah'] = array('Luas Wilayah (Ha)',100,TRUE,'center',2);
		$colModel['id_kecamatan'] = array('Kecamatan',150,TRUE,'center',0);		
		$colModel['id_penduduk'] = array('Nik Kepala Desa',150,TRUE,'center',0);
		//kurang penduduk
        $colModel['aksi'] = array('AKSI',60,FALSE,'center',0);
		
		//Populate flexigrid buttons..
       // $buttons[] = array('Select All','check','btn');
		//$buttons[] = array('separator');
        //$buttons[] = array('DeSelect All','uncheck','btn');
        //$buttons[] = array('separator');
		//$buttons[] = array('Add','add','btn');
        //$buttons[] = array('separator');
        //$buttons[] = array('Delete Selected Items','delete','btn');
        $buttons[] = array('separator');
       		
        $gridParams = array(
            'height' => 300,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('admin/c_desa/load_data'),$colModel,'kode_desa_bps','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA DESA';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('desa/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {		
        $this->load->library('flexigrid');
        $valid_fields = array('id_desa','kode_desa_bps','kode_desa_kemendagri','nama_desa','alamat','luas_wilayah','id_kecamatan','id_penduduk');

		$this->flexigrid->validate_post('id_desa','ASC',$valid_fields);
		$records = $this->m_desa->get_desa_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		$number = 0;
		foreach ($records['records']->result() as $row)
		{
			$number++;
			$record_items[] = array(
				$row->id_desa,
				$number,
                $row->kode_desa_bps,
                $row->kode_desa_kemendagri,
                $row->nama_desa,				
				$row->alamat_desa,
				$row->luas_wilayah,
                $row->nama_kecamatan,				
                $this->m_desa->getNIKByIdPenduduk($row->id_penduduk),
//				'<input type="button" value="Edit" class="ubah" onclick="edit_desa(\''.$row->id_desa.'\')"/>'
				'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_desa(\''.$row->id_desa.'\')"/><i class="fa fa-pencil"></i></button>'
			);  
		}
		//Print please
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
    
    function add(){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['nama_kec']= $this->m_desa->get_kec();
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['page_title'] = 'Tambah Desa';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('desa/v_tambah', $data, TRUE);
			
					
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
        
    }
	
	function simpan_desa() {
	
		$kode_desa_bps = $this->input->post('kode_desa_bps', TRUE);
		$kode_desa_kemendagri = $this->input->post('kode_desa_kemendagri', TRUE);
		$nama_desa = $this->input->post('nama_desa', TRUE);
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
		$id_kecamatan = $this->input->post('id_kecamatan', TRUE);		
		$nik = $this->input->post('nik', TRUE);
		
		$this->form_validation->set_rules('kode_desa_bps', 'Kode BPS', 'required');
		$this->form_validation->set_rules('kode_desa_kemendagri', 'Kode Kemendegri', 'required');
		$this->form_validation->set_rules('nama_desa', 'Nama Desa', 'required');
		//$this->form_validation->set_rules('luas_wilayah', 'luas_wilayah', 'required');
		$this->form_validation->set_rules('id_kecamatan', 'Kecamatan', 'required');		
		//$this->form_validation->set_rules('nik', 'NIK Kepala Desa', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$result['hasil'] = $this->m_desa->cekFIleExistByKodeBPS($kode_desa_bps);
			
			if($nik==NULL) {$id_penduduk=NULL;}
			else
			{
				$id_penduduk	 =	$this->m_desa->getIdPendudukByNIK($nik);
			}
			
			if ($result['hasil'] == NULL AND $id_penduduk != 'tidak ditemukan') {
			
				$data = array(
					'kode_desa_bps' => $kode_desa_bps,
					'kode_desa_kemendagri' => $kode_desa_kemendagri,
					'nama_desa' => $nama_desa,
					'luas_wilayah' => $luas_wilayah,
					'id_kecamatan' => $id_kecamatan,
					'id_penduduk' => $id_penduduk					
				);
	
			$this->m_desa->insertDesa($data);	
			redirect('admin/c_desa','refresh');
			}
			else $this->add();
			/* Handle ketika kode bps telah digunakan */
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['hasil'] = $this->m_desa->getDesaByIddesa($id);
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['nama_kecamatan'] = $this->m_desa->get_kec();	
			$data['nik']	= $this->m_desa->getNIKByIdPenduduk($data['hasil']->id_penduduk);
			$data['nama']	= $this->m_desa->getNamaByIdPenduduk($data['hasil']->id_penduduk);
			$data['page_title'] = 'Edit Data Desa';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('desa/v_ubah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
    }
	
	function update_desa() {	
	
		$id_desa = $this->input->post('id_desa', TRUE);
		$kode_desa_bps = $this->input->post('kode_desa_bps', TRUE);
		$kode_desa_kemendagri = $this->input->post('kode_desa_kemendagri', TRUE);
		$nama_desa = $this->input->post('nama_desa', TRUE);
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
		$id_kecamatan = $this->input->post('id_kecamatan', TRUE);		
		$nik = $this->input->post('nik', TRUE);
		$alamat_desa = $this->input->post('alamat_desa', TRUE);		
		$kode_pos = $this->input->post('kode_pos', TRUE);
		
		$this->form_validation->set_rules('kode_desa_bps', 'Kode BPS', 'required');
		$this->form_validation->set_rules('kode_desa_kemendagri', 'Kode 2', 'required');
		$this->form_validation->set_rules('nama_desa', 'Nama Desa', 'required');
		//$this->form_validation->set_rules('luas_wilayah', 'luas_wilayah', 'required');
		$this->form_validation->set_rules('id_kecamatan', 'Kecamatan', 'required');	
		//$this->form_validation->set_rules('nik', 'NIK Kepala Desa', 'required');
		
		
		if ($this->form_validation->run() == TRUE)
		{			
			if($nik==NULL) {$id_penduduk=NULL;}
			else
			{

				$id_penduduk	 =	$this->m_desa->getIdPendudukByNIK($nik);
			}			
			if($id_penduduk != 'tidak ditemukan') 
			{
				$data = array(
						'kode_desa_bps' => $kode_desa_bps,
						'kode_desa_kemendagri' => $kode_desa_kemendagri,
						'nama_desa' => $nama_desa,
						'luas_wilayah' => $luas_wilayah,
						'id_kecamatan' => $id_kecamatan,
						'id_penduduk' => $id_penduduk,
						'alamat_desa' => $alamat_desa,
						'kode_pos' => $kode_pos
							
					);		
				$result = $this->m_desa->updateDesa(array('id_desa' => $id_desa), $data);
				redirect('admin/c_desa','refresh');
			}
			else
			{				
				$this->edit($id_desa); //handle ketika id_penduduk tidak ditemukan
			}
		}
		else $this->edit($id_desa);
		
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_desa->deleteDesa($id);
            $sucess++;
        }
		
        redirect('admin/c_desa', 'refresh');
    }

    public function autocomplete_Nik()
    {
        $nik = $this->input->post('nik',TRUE);
        $rows = $this->m_desa->get_NikPenduduk($nik);
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
        $rows = $this->m_desa->get_NamaPenduduk($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->nik.' | '.$row->nama;
		}
        return json_encode($json_array);
    }
}
?>