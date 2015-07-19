<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_anggaran extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_anggaran');
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
        $colModel['id_anggaran'] = array('ID',20,TRUE,'center',0);	
		$colModel['nomor'] = array('Nomor',50,TRUE,'left',2);
		$colModel['id_apbdes'] = array('ID APBDes',80,TRUE,'left',2);
		$colModel['nama'] = array('Nama',220,TRUE,'left',2);
		$colModel['jumlah'] = array('Jumlah',220,TRUE,'left',2);
		$colModel['keterangan'] = array('Keterangan',240,TRUE,'left',2);
        $colModel['aksi'] = array('Aksi',60,FALSE,'center',0);
		
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

        $grid_js = build_grid_js('flex1',site_url('apbdes/c_anggaran/load_data'),$colModel,'id_anggaran','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'Anggaran';		
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('anggaran/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {	
		$this->load->library('flexigrid');
        $valid_fields = array('id_anggaran','nomor', 'id_apbdes', 'nama', 'jumlah', 'keterangan');

		$this->flexigrid->validate_post('id_anggaran','ASC',$valid_fields);
		$records = $this->m_anggaran->get_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->id_anggaran,
				$row->id_anggaran,
				$row->nomor,
				$row->id_apbdes,
				$row->nama,
				$row->jumlah,
				$row->keterangan,
				'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_anggaran(\''.$row->id_anggaran.'\')"/><i class="fa fa-pencil"></i></button>'
			);  
		}
		//Print please
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
    
    function add(){		
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{			
			$data['page_title'] = 'Tambah Anggaran';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('anggaran/v_tambah', $data, TRUE);
		
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan() {
		$nomor = $this->input->post('nomor', TRUE);
		$id_apbdes = $this->input->post('id_apbdes', TRUE);
		$nama = $this->input->post('nama', TRUE);
		$jumlah = $this->input->post('jumlah', TRUE);
		$keterangan = $this->input->post('keterangan', TRUE);
		
		$this->form_validation->set_rules('nomor', 'Nomor', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('id_apbdes', 'APBDes', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
					'nomor' => $nomor,
					'id_apbdes' => $id_apbdes,
					'nama' => $nama,
					'jumlah' => $jumlah,
					'keterangan' => $keterangan
				);
	
			$this->m_anggaran->insert($data);	
			redirect('apbdes/c_anggaran','refresh');
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['hasil'] = $this->m_anggaran->getById($id);
			$data['page_title'] = 'Edit Anggaran';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('anggaran/v_ubah', $data, TRUE);
        
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update() {	
		$id = $this->input->post('id_anggaran', TRUE);

		$nomor = $this->input->post('nomor', TRUE);
		$id_apbdes = $this->input->post('id_apbdes', TRUE);
		$nama = $this->input->post('nama', TRUE);
		$jumlah = $this->input->post('jumlah', TRUE);
		$keterangan = $this->input->post('keterangan', TRUE);
		
		$this->form_validation->set_rules('nomor', 'Nomor', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('id_apbdes', 'APBDes', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
					'nomor' => $nomor,
					'id_apbdes' => $id_apbdes,
					'nama' => $nama,
					'jumlah' => $jumlah,
					'keterangan' => $keterangan
				);
	
		  	$result = $this->m_anggaran->update(array('id_anggaran' => $id), $data);
			
		  	redirect('apbdes/c_anggaran','refresh');
		}
		else $this->edit($id);
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_anggaran->delete($id);
            $sucess++;
        }
		
        redirect('apbdes/c_anggaran', 'refresh');
    }
	


}
?>
