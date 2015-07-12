<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_rw extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_rw');
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
        //$colModel['id_rw'] = array('ID',30,TRUE,'center',2);
        $colModel['nomor_rw'] = array('Nomor RW',80,TRUE,'center',2);
		$colModel['luas_wilayah'] = array('Luas Wilayah (Ha)',100,TRUE,'center',2);
		$colModel['ref_dusun.nama_dusun'] = array('Dusun',100,TRUE,'center',2);		
		$colModel['id_penduduk'] = array('Nik Ketua RW',150,TRUE,'center',0);
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
            'height' => 300,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('admin/c_rw/load_data'),$colModel,'ref_dusun.nama_dusun','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA RW';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('rw/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {	
		$this->load->library('flexigrid');
        $valid_fields = array('id_rw','nomor_rw','luas_wilayah','ref_dusun.nama_dusun','id_penduduk');

		$this->flexigrid->validate_post('id_rw','ASC',$valid_fields);
		$records = $this->m_rw->get_rw_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				//$row->id_rw,
                $row->id_rw,
                $row->nomor_rw,
				$row->luas_wilayah,
				$row->nama_dusun,
				$this->m_rw->getNIKByIdPenduduk($row->id_penduduk),
//				'<input type="button" value="Edit" class="ubah" onclick="edit_rw(\''.$row->id_rw.'\')"/>'
				 '<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_rw(\''.$row->id_rw.'\')"/><i class="fa fa-pencil"></i></button>'
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
			$data['nama_dusun']= $this->m_rw->get_dusun();
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['page_title'] = 'Tambah RW';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('rw/v_tambah', $data, TRUE);
							
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_rw() {
		$nomor_rw = $this->input->post('nomor_rw', TRUE);
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
		$id_dusun = $this->input->post('id_dusun', TRUE);		
		$nik = $this->input->post('nik', TRUE);
		
		$this->form_validation->set_rules('nomor_rw', 'Nomor RW', 'required');
		$this->form_validation->set_rules('luas_wilayah', 'luas_wilayah', 'required');
		$this->form_validation->set_rules('id_dusun', 'Nama Dusun', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			if($nik==NULL) {$id_penduduk=NULL;}
			else
			{
				$id_penduduk	 =	$this->m_rw->getIdPendudukByNIK($nik);
			}
			
			if ($id_penduduk != 'tidak ditemukan') {				
				$data = array(
					'nomor_rw' => $nomor_rw,
					'luas_wilayah' => $luas_wilayah,
					'id_dusun' => $id_dusun,
					'id_penduduk' => $id_penduduk
				);

			$this->m_rw->insertRw($data);	
			redirect('admin/c_rw','refresh');
			}			
			else $this->add();
			/* Handle ketika nomer rw telah digunakan */
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['hasil'] = $this->m_rw->getRwByIdrw($id);
			$data['nama_dusun'] = $this->m_rw->get_dusun();	
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['nik']	= $this->m_rw->getNIKByIdPenduduk($data['hasil']->id_penduduk);
			$data['nama']	= $this->m_rw->getNamaByIdPenduduk($data['hasil']->id_penduduk);	
			$data['page_title'] = 'Edit Data RW';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('rw/v_ubah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update_rw() {	
	
		$id_rw = $this->input->post('id_rw', TRUE);
		$nomor_rw = $this->input->post('nomor_rw', TRUE);
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
		$id_dusun = $this->input->post('id_dusun', TRUE);		
		$nik = $this->input->post('nik', TRUE);
		
		$this->form_validation->set_rules('nomor_rw', 'Nomor RW', 'required');
		$this->form_validation->set_rules('luas_wilayah', 'luas_wilayah', 'required');
		$this->form_validation->set_rules('id_dusun', 'Nama Dusun', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			if($nik==NULL) {$id_penduduk=NULL;}
			else
			{
				$id_penduduk	 =	$this->m_rw->getIdPendudukByNIK($nik);
			}			
			if($id_penduduk != 'tidak ditemukan') 
			{
				$data = array(
						'nomor_rw' => $nomor_rw,
						'luas_wilayah' => $luas_wilayah,
						'id_dusun' => $id_dusun,
						'id_penduduk' => $id_penduduk	
					);
		
				$result = $this->m_rw->updateRw(array('id_rw' => $id_rw), $data);				
				redirect('admin/c_rw','refresh');
			}
			else
			{				
				$this->edit($id_desa); //handle ketika id_penduduk tidak ditemukan
			}
		}
		else $this->edit($id_rw);
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_rw->deleteRw($id);
            $sucess++;
        }
		
        redirect('admin/c_rw', 'refresh');
    }
    
       public function autocomplete_Nik()
    {
        $nik = $this->input->post('nik',TRUE);
        $rows = $this->m_rw->get_NikPenduduk($nik);
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
        $rows = $this->m_rw->get_NamaPenduduk($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->nik.' | '.$row->nama;
		}
        return json_encode($json_array);
    }
	

}
?>