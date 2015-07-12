<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_dusun extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_dusun');
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
        $colModel['id_dusun'] = array('ID',30,TRUE,'center',0);
        $colModel['kode_dusun_bps'] = array('Kode Dusun (BPS)',150,TRUE,'center',2);
		$colModel['kode_dusun_kemendagri'] = array('Kode Dusun (Kemendagri)',150,TRUE,'center',2);
		$colModel['nama_dusun'] = array('Nama Dusun',150,TRUE,'center',2);
		$colModel['luas_wilayah'] = array('Luas Wilayah (Ha)',100,TRUE,'center',2);
		$colModel['id_desa'] = array('Desa',100,TRUE,'center',0);		
		$colModel['id_penduduk'] = array('Nik Kepala Dusun',200,TRUE,'center',0);
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
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('admin/c_dusun/load_data'),$colModel,'kode_dusun_bps','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA DUSUN';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('dusun/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {	
		
        $this->load->library('flexigrid');
        $valid_fields = array('id_dusun','kode_dusun_bps','kode_dusun_kemendagri','nama_dusun','luas_wilayah','id_desa','id_penduduk');

		$this->flexigrid->validate_post('id_dusun','ASC',$valid_fields);
		$records = $this->m_dusun->get_dusun_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			
			$record_items[] = array(
				$row->id_dusun,
                $row->id_dusun,
                $row->kode_dusun_bps,
				$row->kode_dusun_kemendagri,
				$row->nama_dusun,
                $row->luas_wilayah,
				$row->nama_desa,								
                $this->m_dusun->getNIKByIdPenduduk($row->id_penduduk),
//				'<input type="button" value="Edit" class="ubah" onclick="edit_dusun(\''.$row->id_dusun.'\')"/>'
                '<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_dusun(\''.$row->id_dusun.'\')"/><i class="fa fa-pencil"></i></button>'
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
			$data['nama_desa']= $this->m_dusun->get_desa();
			$data['page_title'] = 'Tambah DUSUN';
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('dusun/v_tambah', $data, TRUE);
								
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_dusun() {
		$kode_dusun_bps = $this->input->post('kode_dusun_bps', TRUE);
		$kode_dusun_kemendagri = $this->input->post('kode_dusun_kemendagri', TRUE);
		$nama_dusun = $this->input->post('nama_dusun', TRUE);
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
		$id_desa = $this->input->post('id_desa', TRUE);
		$nik = $this->input->post('nik', TRUE);
		
		$this->form_validation->set_rules('kode_dusun_bps', 'Kode BPS', 'required');
		$this->form_validation->set_rules('kode_dusun_kemendagri', 'Kode Kemendagri', 'required');
		$this->form_validation->set_rules('nama_dusun', 'Nama Dusun', 'required');
		$this->form_validation->set_rules('luas_wilayah', 'luas_wilayah', 'required');
		$this->form_validation->set_rules('id_desa', 'Desa', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$result['hasil'] = $this->m_dusun->cekFIleExistByKodeBPS($kode_dusun_bps);				
			
			if($nik==NULL) {$id_penduduk=NULL;}
			else
			{
				$id_penduduk	 =	$this->m_dusun->getIdPendudukByNIK($nik);
			}
			
			if ($result['hasil'] == NULL AND $id_penduduk != 'tidak ditemukan') {				
				$data = array(
					'kode_dusun_bps' => $kode_dusun_bps,
					'kode_dusun_kemendagri' => $kode_dusun_kemendagri,
					'nama_dusun' => $nama_dusun,
					'luas_wilayah' => $luas_wilayah,
					'id_desa' => $id_desa,
					'id_penduduk' => $id_penduduk		
				);

			$this->m_dusun->insertDusun($data);	
			redirect('admin/c_dusun','refresh');
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
			$data['hasil'] = $this->m_dusun->getDusunByIddusun($id);
			$data['nama_desa'] = $this->m_dusun->get_desa();
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['nik']	= $this->m_dusun->getNIKByIdPenduduk($data['hasil']->id_penduduk);
			$data['nama']	= $this->m_dusun->getNamaByIdPenduduk($data['hasil']->id_penduduk);	
			$data['page_title'] = 'Edit Data Dusun';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('dusun/v_ubah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update_dusun() {	
	
		$id_dusun = $this->input->post('id_dusun', TRUE);
		$kode_dusun_bps = $this->input->post('kode_dusun_bps', TRUE);
		$kode_dusun_kemendagri = $this->input->post('kode_dusun_kemendagri', TRUE);
		$nama_dusun = $this->input->post('nama_dusun', TRUE);
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
		$id_desa = $this->input->post('id_desa', TRUE);
		$nik = $this->input->post('nik', TRUE);
		
		$this->form_validation->set_rules('kode_dusun_bps', 'Kode BPS', 'required');
		$this->form_validation->set_rules('kode_dusun_kemendagri', 'Kode 2', 'required');
		$this->form_validation->set_rules('nama_dusun', 'Nama Dusun', 'required');
		$this->form_validation->set_rules('luas_wilayah', 'luas_wilayah', 'required');
		$this->form_validation->set_rules('id_desa', 'Desa', 'required');
	
		if ($this->form_validation->run() == TRUE)
		{
			if($nik==NULL) {$id_penduduk=NULL;}
			else
			{
				$id_penduduk	 =	$this->m_dusun->getIdPendudukByNIK($nik);
			}			
			if($id_penduduk != 'tidak ditemukan') 
			{
				$data = array(
						'kode_dusun_bps' => $kode_dusun_bps,
						'kode_dusun_kemendagri' => $kode_dusun_kemendagri,
						'nama_dusun' => $nama_dusun,
						'luas_wilayah' => $luas_wilayah,
						'id_desa' => $id_desa,
						'id_penduduk' => $id_penduduk	
					);			
				$result = $this->m_dusun->updateDusun(array('id_dusun' => $id_dusun), $data);			
				redirect('admin/c_dusun','refresh');
			}
			else
			{				
				$this->edit($id_desa); //handle ketika id_penduduk tidak ditemukan
			}
		}
		else $this->edit($id_dusun);
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_dusun->deleteDusun($id);
            $sucess++;
        }
		
        redirect('admin/c_dusun', 'refresh');
    }

        public function autocomplete_Nik()
    {
        $nik = $this->input->post('nik',TRUE);
        $rows = $this->m_dusun->get_NikPenduduk($nik);
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
        $rows = $this->m_dusun->get_NamaPenduduk($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->nik.' | '.$row->nama;
		}
        return json_encode($json_array);
    }
	

}
?>