<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_regulasi extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_regulasi');
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
        $colModel['no'] = array('No',30,TRUE,'center',2);
        $colModel['judul_regulasi'] = array('Judul Regulasi',150,TRUE,'center',2);
		$colModel['isi_regulasi'] = array('Isi Regulasi',200,TRUE,'center',2);
		$colModel['file_regulasi'] = array('File Regulasi',200,TRUE,'center',2);	
        $colModel['aksi'] = array('AKSI',60,FALSE,'center',2);
		
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

        $grid_js = build_grid_js('flex1',site_url('admin/c_regulasi/load_data'),$colModel,'no','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA REGULASI';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('regulasi/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {	
		$this->load->library('flexigrid');
        $valid_fields = array('id_regulasi','judul_regulasi','isi_regulasi','file_regulasi');

		$this->flexigrid->validate_post('id_regulasi','ASC',$valid_fields);
		$records = $this->m_regulasi->get_regulasi_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		$counter=0;
		foreach ($records['records']->result() as $row)
		{
			$counter++;
			$record_items[] = array(
				$row->id_regulasi,
                $counter,
                $row->judul_regulasi,
				$row->isi_regulasi,
				$row->file_regulasi,
//				'<input type="button" value="Edit" class="ubah" onclick="edit_regulasi(\''.$row->id_regulasi.'\')"/>'
				 '<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_regulasi(\''.$row->id_regulasi.'\')"/><i class="fa fa-pencil"></i></button>'
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
			$data['page_title'] = 'Tambah Regulasi';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('regulasi/v_tambah', $data, TRUE);
							
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_regulasi() {
		$judul_regulasi = $this->input->post('judul_regulasi', TRUE);
		$isi_regulasi = $this->input->post('isi_regulasi', TRUE);	
		
		$this->form_validation->set_rules('judul_regulasi', 'Judul Regulasi', 'required');
		$this->form_validation->set_rules('isi_regulasi', 'Isi Regulasi', 'required');

		if ($this->form_validation->run() == TRUE)
		{		
			$nama_file = str_replace(' ','-', $judul_regulasi);
			//UPLOAD FILE REGULASI
			$config['upload_path']   =   "./uploads/files/";
			$config['allowed_types'] =   'zip|pdf|doc|docx|xls|xlsx';
			$config['file_name'] = $nama_file;	
			$config['overwrite'] = TRUE;
			$this->load->library('upload',$config);
			$this->upload->initialize($config); 
			if(!$this->upload->do_upload("file_regulasi"))
			{   
				$this->data['error'] = $this->upload->display_errors();
				$path_file_regulasi = $path_file_regulasi = "uploads/files/sample.zip";    
			}
			else
			{
				$upload_file_regulasi = $this->upload->data();
				$path_file_regulasi = "uploads/files/".$upload_file_regulasi['file_name'];
			}
			//END UPLOAD FILE REGULASI
			$data = array(
				'judul_regulasi' => $judul_regulasi,
				'isi_regulasi' => $isi_regulasi,
				'file_regulasi' => $path_file_regulasi,
			);
			$this->m_regulasi->insertRegulasi($data);	
			redirect('admin/c_regulasi','refresh');
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['id_regulasi'] = $id;
			$data['page_title'] = 'UBAH REGULASI';
			$data['hasil'] = $this->m_regulasi->getRegulasiByIdregulasi($id);
			$data['file'] = $this->m_regulasi->getFileRegulasiByIdRegulasi($id);
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('regulasi/v_ubah', $data, TRUE);
        
			$this->load->view('utama', $data);
		}else
			$this->load->view('c_login',true);
        
    }
	
	function update_regulasi() {	
		$id_regulasi = $this->input->post('id_regulasi', TRUE);
		$judul_regulasi = $this->input->post('judul_regulasi', TRUE);
		$isi_regulasi = $this->input->post('isi_regulasi', TRUE);	
		$file_regulasi = $this->m_regulasi->getFileRegulasiByIdRegulasi($id_regulasi);
		
		$this->form_validation->set_rules('judul_regulasi', 'Judul Regulasi', 'required');
		$this->form_validation->set_rules('isi_regulasi', 'Isi Regulasi', 'required');

		if ($this->form_validation->run() == TRUE)
		{		
			$file_regulasi = $this->m_regulasi->getFileRegulasiByIdRegulasi($id_regulasi);
			$nama_file = str_replace(' ','-', $judul_regulasi);
			//UPLOAD FILE REGULASI
			$config['upload_path']   =   "./uploads/files/";
			$config['allowed_types'] =   'zip|pdf|doc|docx|xls|xlsx';
			$config['file_name'] = $nama_file;	
			$config['overwrite'] = TRUE;
			$this->load->library('upload',$config);
			$this->upload->initialize($config); 
			if(!$this->upload->do_upload("file_regulasi"))
			{   
				$this->data['error'] = $this->upload->display_errors();
				$path_file_regulasi = $path_file_regulasi = $file_regulasi;    
			}
			else
			{
				$upload_file_regulasi = $this->upload->data();
				$path_file_regulasi = "uploads/files/".$upload_file_regulasi['file_name'];
			}
			//END UPLOAD FILE REGULASI
			$data = array(
				'judul_regulasi' => $judul_regulasi,
				'isi_regulasi' => $isi_regulasi,
				'file_regulasi' => $path_file_regulasi,
			);
			$this->m_regulasi->updateRegulasi(array('id_regulasi' => $id_regulasi), $data);
			redirect('admin/c_regulasi','refresh');
        }
		else $this->edit($id_regulasi);
		
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_regulasi->deleteRegulasi($id);
            $sucess++;
        }
	
        redirect('admin/c_regulasi', 'refresh');
    }
    
      
}
?>