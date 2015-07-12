<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_kode_surat extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_kode_surat');
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
        $colModel['kode_surat'] = array('Kode Surat',65,TRUE,'center',0);	
		$colModel['deskripsi'] = array('Deskripsi',200,TRUE,'left',2);		
		$colModel['supra_kode'] = array('Supra Kode',65,TRUE,'center',2);
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

        $grid_js = build_grid_js('flex1',site_url('pustaka/c_kode_surat/load_data'),$colModel,'kode_surat','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA KODE SURAT';		
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('kode_surat/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {	
		$this->load->library('flexigrid');
        $valid_fields = array('kode_surat','deskripsi','supra_kode');

		$this->flexigrid->validate_post('kode_surat','ASC',$valid_fields);
		$records = $this->m_kode_surat->get_kode_surat_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->kode_surat,
				$row->kode_surat,
				$row->deskripsi,			
				$row->supra_kode,
				'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_kode_surat(\''.$row->kode_surat.'\')"/><i class="fa fa-pencil"></i></button>'
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
			$data['page_title'] = 'Tambah Kode Surat';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('kode_surat/v_tambah', $data, TRUE);
		
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh'); 
        
    }
	
	function simpan_kode_surat() {
		$deskripsi = $this->input->post('deskripsi', TRUE);
		$supra_kode = $this->input->post('supra_kode', TRUE);
		
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
		$this->form_validation->set_rules('supra_kode', 'Supra Kode', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$result['hasil'] = $this->m_kode_surat->cekFIleExist($deskripsi);				
			
			if ($result['hasil'] == NULL) {				
				$data = array(
					'deskripsi' => $deskripsi,
					'supra_kode' => $supra_kode
				);

			$this->m_kode_surat->insertKodeSurat($data);	
			redirect('pustaka/c_kode_surat','refresh');
			}			
			else $this->add();
			/* Handle ketika nomer kode_surat telah digunakan */
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['hasil'] = $this->m_kode_surat->getKodeSuratByIdKodeSurat($id);
			$data['page_title'] = 'Edit Data Kode Surat';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('kode_surat/v_ubah', $data, TRUE);
        
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh'); 
    }
	
	function update_kode_surat() {	
	
		$kode_surat = $this->input->post('kode_surat', TRUE);
		$deskripsi = $this->input->post('deskripsi', TRUE);
		$supra_kode = $this->input->post('supra_kode', TRUE);
		
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
		$this->form_validation->set_rules('supra_kode', 'Supra Kode', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
					'deskripsi' => $deskripsi,
					'supra_kode' => $supra_kode
				);
	
		  	$result = $this->m_kode_surat->updateKodeSurat(array('kode_surat' => $kode_surat), $data);
			
		  	redirect('pustaka/c_kode_surat','refresh');
		}
		else $this->edit($kode_surat);
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_kode_surat->deleteKodeSurat($id);
            $sucess++;
        }
		
        redirect('admin/c_kode_surat', 'refresh');
    }
	

}
?>