<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_ped_pertanian extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_ped_pertanian');
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
            'rp' => 10,
			'height' => 400,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('admin/c_ped_pertanian/load_data'),$colModel,'id_ped_pertanian','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA PERTANIAN';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('ped_pertanian/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {	
		$this->load->library('flexigrid');
		
        $valid_fields = array('id_ped_pertanian','deskripsi','penggarap','jumlah_penggarap','luas','lokasi','ref_dusun.nama_dusun');

		$this->flexigrid->validate_post('id_ped_pertanian','ASC',$valid_fields);
		$records = $this->m_ped_pertanian->get_ped_pertanian_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->id_ped_pertanian,
                $row->id_ped_pertanian,
                $row->deskripsi,
				$row->penggarap,
                $row->jumlah_penggarap,
				$row->luas,
				$row->lokasi,
				$row->nama_dusun,				
				'<button type="submit" class="btn btn-default btn-xs" title="Ubah" onclick="edit_ped_pertanian(\''.$row->id_ped_pertanian.'\')"/><i class="fa fa-pencil"></i></button>'
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
			$data['nama_dusun']= $this->m_ped_pertanian->get_dusun();
			$data['page_title'] = 'Tambah PERTANIAN';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('ped_pertanian/v_tambah', $data, TRUE);
		
					
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_ped_pertanian() {
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

			$this->m_ped_pertanian->insertPedPertanian($data);	
			redirect('admin/c_ped_pertanian','refresh');
			
			/* Handle ketika nomer ped_pertanian telah digunakan */
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
			{
			$data['hasil'] = $this->m_ped_pertanian->getPedPertanianByIdPedPertanian($id);
			$data['nama_dusun'] = $this->m_ped_pertanian->get_dusun();		
			$data['page_title'] = 'Edit Data PERTANIAN';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('ped_pertanian/v_ubah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update_ped_pertanian() {	
		$id_ped_pertanian = $this->input->post('id_ped_pertanian', TRUE);
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
		
			$result = $this->m_ped_pertanian->updatePedPertanian(array('id_ped_pertanian' => $id_ped_pertanian), $data);				
			redirect('admin/c_ped_pertanian','refresh');
		
		}
		else $this->edit($id_ped_pertanian);
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_ped_pertanian->deletePedPertanian($id);
            $sucess++;
        }
		if ($sucess > 0 ){
            //echo 'Success delete '.$sucess.' item(s).';
        }
		else{
            //echo 'No delete items';
        }
        redirect('admin/c_ped_pertanian', 'refresh');
    }
	

}
?>