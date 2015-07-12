<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_ped_perkebunan extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_ped_perkebunan');
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
        $colModel['id_ped_pertanian'] = array('ID',20,TRUE,'left',0);
        $colModel['deskripsi'] = array('Deskripsi',150,TRUE,'left',2);
		$colModel['penggarap'] = array('Penggarap',150,TRUE,'center',2);
		$colModel['jumlah_penggarap'] = array('Jumlah Penggarap',100,TRUE,'center',2);		
		$colModel['luas'] = array('Luas (Ha)',100,TRUE,'center',2);	
		$colModel['lokasi'] = array('Lokasi',80,TRUE,'center',2);	
		$colModel['ref_dusun.nama_dusun'] = array('Nama Dusun',150,TRUE,'center',2);
        $colModel['aksi'] = array('AKSI',40,FALSE,'center',0);
		
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
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('admin/c_ped_perkebunan/load_data'),$colModel,'id_ped_perkebunan','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA PERKEBUNAN';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('ped_perkebunan/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {	
		$this->load->library('flexigrid');
		
        $valid_fields = array('id_ped_perkebunan','deskripsi','penggarap','jumlah_penggarap','luas','lokasi','ref_dusun.nama_dusun');

		$this->flexigrid->validate_post('id_ped_perkebunan','ASC',$valid_fields);
		$records = $this->m_ped_perkebunan->get_ped_perkebunan_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->id_ped_perkebunan,
                $row->id_ped_perkebunan,
                $row->deskripsi,
				$row->penggarap,
                $row->jumlah_penggarap,
				$row->luas,
				$row->lokasi,
				$row->nama_dusun,
				'<button type="submit" class="btn btn-default btn-xs" title="Ubah" onclick="edit_ped_perkebunan(\''.$row->id_ped_perkebunan.'\')"/><i class="fa fa-pencil"></i></button>'
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
			$data['nama_dusun']= $this->m_ped_perkebunan->get_dusun();
			$data['page_title'] = 'Tambah PERKEBUNAN';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('ped_perkebunan/v_tambah', $data, TRUE);
							
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_ped_perkebunan() {
		$deskripsi = $this->input->post('deskripsi', TRUE);
		$penggarap = $this->input->post('penggarap', TRUE);
		$jumlah_penggarap = $this->input->post('jumlah_penggarap', TRUE);
		$luas = $this->input->post('luas', TRUE);		
		$lokasi = $this->input->post('lokasi', TRUE);
		$id_dusun = $this->input->post('id_dusun', TRUE);		
		
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
		$this->form_validation->set_rules('penggarap', 'Penggarap', 'required');
		$this->form_validation->set_rules('jumlah_penggarap', 'Jumlah Jumlah', 'required');
		$this->form_validation->set_rules('luas', 'Luas', 'required');
		$this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
		$this->form_validation->set_rules('id_dusun', 'Nama Dusun', 'required');

		if ($this->form_validation->run() == TRUE)
		{
							
				$data = array(
					'deskripsi' => $deskripsi,
					'penggarap' => $penggarap,
					'jumlah_penggarap' => $jumlah_penggarap,
					'luas' => $luas,
					'lokasi' => $lokasi,
					'id_dusun' => $id_dusun
				);

			$this->m_ped_perkebunan->insertPedPerkebunan($data);	
			redirect('admin/c_ped_perkebunan','refresh');
			
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
		
			$data['hasil'] = $this->m_ped_perkebunan->getPedPerkebunanByIdPedPerkebunan($id);
			$data['nama_dusun'] = $this->m_ped_perkebunan->get_dusun();		
			$data['page_title'] = 'Edit Data PERKEBUNAN';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('ped_perkebunan/v_ubah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update_ped_perkebunan() {	
		$id_ped_perkebunan = $this->input->post('id_ped_perkebunan', TRUE);
		$deskripsi = $this->input->post('deskripsi', TRUE);
		$penggarap = $this->input->post('penggarap', TRUE);
		$jumlah_penggarap = $this->input->post('jumlah_penggarap', TRUE);
		$luas = $this->input->post('luas', TRUE);		
		$lokasi = $this->input->post('lokasi', TRUE);
		$id_dusun = $this->input->post('id_dusun', TRUE);		
		
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
		$this->form_validation->set_rules('penggarap', 'Penggarap', 'required');
		$this->form_validation->set_rules('jumlah_penggarap', 'Jumlah Jumlah', 'required');
		$this->form_validation->set_rules('luas', 'Luas', 'required');
		$this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
		$this->form_validation->set_rules('id_dusun', 'Nama Dusun', 'required');

		if ($this->form_validation->run() == TRUE)
		{	
			$data = array(
					'deskripsi' => $deskripsi,
					'penggarap' => $penggarap,
					'jumlah_penggarap' => $jumlah_penggarap,
					'luas' => $luas,
					'lokasi' => $lokasi,
					'id_dusun' => $id_dusun
				);
		
			$result = $this->m_ped_perkebunan->updatePedPerkebunan(array('id_ped_perkebunan' => $id_ped_perkebunan), $data);				
			redirect('admin/c_ped_perkebunan','refresh');
		
		}
		else $this->edit($id_ped_perkebunan);
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_ped_perkebunan->deletePedPerkebunan($id);
            $sucess++;
        }
		
        redirect('admin/c_ped_perkebunan', 'refresh');
    }
	

}
?>