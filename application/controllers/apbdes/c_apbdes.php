<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_apbdes extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_apbdes');
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
        $colModel['id_apbdes'] = array('ID',20,TRUE,'center',0);	
		$colModel['tahun'] = array('Tahun',220,TRUE,'left',2);
		$colModel['is_perubahan'] = array('Perubahan?',220,TRUE,'left',2);
		$colModel['nama'] = array('Nama',220,TRUE,'left',2);
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

        $grid_js = build_grid_js('flex1',site_url('apbdes/c_apbdes/load_data'),$colModel,'id_apbdes','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'APBDes';		
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('apbdes/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {	
		$this->load->library('flexigrid');
        $valid_fields = array('id_apbdes','tahun', 'is_perubahan', 'nama');

		$this->flexigrid->validate_post('id_apbdes','ASC',$valid_fields);
		$records = $this->m_apbdes->get_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->id_apbdes,
				$row->id_apbdes,
				$row->tahun,
				$row->is_perubahan,
				$row->nama,
				'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_apbdes(\''.$row->id_apbdes.'\')"/><i class="fa fa-pencil"></i></button>'
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
			$data['page_title'] = 'Tambah APBDes';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('apbdes/v_tambah', $data, TRUE);
		
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan() {
		$tahun = $this->input->post('tahun', TRUE);
		$is_perubahan = $this->input->post('is_perubahan', TRUE);
		$nama = $this->input->post('nama', TRUE);
		
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
					'tahun' => $tahun,
					'is_perubahan' => $is_perubahan,
					'nama' => $nama
				);
	
			$this->m_apbdes->insert($data);	
			redirect('apbdes/c_apbdes','refresh');
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['hasil'] = $this->m_apbdes->getById($id);
			$data['page_title'] = 'Edit APBDes';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('apbdes/v_ubah', $data, TRUE);
        
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update() {	
	
		$id = $this->input->post('id_apbdes', TRUE);
		$tahun = $this->input->post('tahun', TRUE);
		$is_perubahan = $this->input->post('is_perubahan', TRUE);
		$nama = $this->input->post('nama', TRUE);
		
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
					'tahun' => $tahun,
					'is_perubahan' => $is_perubahan,
					'nama' => $nama
				);
	
		  	$result = $this->m_apbdes->update(array('id_apbdes' => $id), $data);
			
		  	redirect('apbdes/c_apbdes','refresh');
		}
		else $this->edit($id);
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_apbdes->delete($id);
            $sucess++;
        }
		
        redirect('apbdes/c_apbdes', 'refresh');
    }
	


}
?>
