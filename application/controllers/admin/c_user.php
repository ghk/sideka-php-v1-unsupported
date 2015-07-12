<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_user extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');        
        $this->load->model('m_user');
		$this->load->library('encrypt');
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
        $colModel['nama_pengguna'] = array('NAMA PENGGUNA',120,TRUE,'left',2);
        $colModel['nik'] = array('NIK',100,TRUE,'left',2);
        $colModel['nama'] = array('NAMA',150,TRUE,'left',2);
		$colModel['no_telepon'] = array('NOMER TELEPON',120,TRUE,'left',2);
		$colModel['role'] = array('ROLE',120,TRUE,'left',2);
		
        $colModel['aksi'] = array('AKSI',60,FALSE,'center',2);
//		$colModel['aksi2'] = array('AKSI',60,FALSE,'left',2);
		
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

        $grid_js = build_grid_js('flex1',site_url('admin/c_user/load_data'),$colModel,'no','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA PENGGUNA';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('user/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {

        $this->load->library('flexigrid');
        $valid_fields = array('id_pengguna','nama_pengguna','nik','nama','no_telepon','role');

		$this->flexigrid->validate_post('id_pengguna','ASC',$valid_fields);
		$records = $this->m_user->get_user_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		$counter=0;
		foreach ($records['records']->result() as $row)
		{
			$counter++;
			$record_items[] = array(
                $row->id_pengguna,
                $row->nama_pengguna,
                $row->nik,
                $row->nama,
				$row->no_telepon,
				$row->role,
				'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_user(\''.$row->id_pengguna.'\')"/><i class="fa fa-pencil"></i></button>'
//				'<i class="fa fa-user fa-fw"></i> <input type="button" value="Edit" class="ubah btn btn-info btn-xs" onclick="edit_user(\''.$row->nama_pengguna.'\')"/>'
//				'<input type="button" value="Reset" class="ubah" onclick="edit_user(\''.$row->nama_pengguna.'\')"/>'
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
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['page_title'] = 'Tambah Pengguna';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('user/v_tambah', $data, TRUE);		
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
        
    }
	
	function simpan_user() {
	
        $username = $this->input->post('username', TRUE);
		$nik = $this->input->post('nik', TRUE);
		$nama = $this->input->post('nama', TRUE);
		$no_telepon = $this->input->post('telp', TRUE);
		$role = $this->input->post('role', TRUE);
		
		$password = MD5('sidekapass');
		$password = MD5($password);		
		$password = sha1($password);
		
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('nik', 'nik', 'required');
		$this->form_validation->set_rules('nama', 'nama', 'required');
		$this->form_validation->set_rules('telp', 'nomer telepon', 'required');
		$this->form_validation->set_rules('role', 'role', 'required');		

		if ($this->form_validation->run() == TRUE)
		{
			$result['hasil'] = $this->m_user->getUserByNamaPengguna($username);

			if ($result['hasil'] == NULL) {
				$data = array(
					'nama_pengguna' => $username,
					'nik' => $nik,
					'nama' => $nama,
					'no_telepon' => $no_telepon,
					'role' => $role,
					'password' => $password
				);
	
				$this->m_user->insertUser($data);
				//$this->session->set_flashdata('message', '1 data berhasil ditambahkan.');
				redirect('admin/c_user');
			}
			else
			{
				
			//	$this->session->set_flashdata('exist', 'username sudah ada.');
				$this->add();
			}	
        }
		else $this->add();
    }

    function edit($id){
        $session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['hasil'] = $this->m_user->getUserByIdPengguna($id);
					
			$data['page_title'] = 'Edit Data Pengguna';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('user/v_ubah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
    }
	
	function update_user() {	  		
	
		$id_pengguna = $this->input->post('id_pengguna', TRUE);
		$username = $this->input->post('username', TRUE);
		$nik = $this->input->post('nik', TRUE);
		$nama = $this->input->post('nama', TRUE);
		$no_telepon = $this->input->post('telp', TRUE);
		$role = $this->input->post('role', TRUE);
		
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('nama', 'nama', 'required');
		$this->form_validation->set_rules('telp', 'nomer telepon', 'required');
		$this->form_validation->set_rules('role', 'role', 'required');		
		
		if ($this->form_validation->run() == TRUE)
		{
				$data = array(
					'nama_pengguna' => $username,
					'nik' => $nik,
					'nama' => $nama,
					'no_telepon' => $no_telepon,
					'role' => $role
				);
	
				$result = $this->m_user->updateUser(array('id_pengguna' => $id_pengguna), $data);
				$this->session->set_flashdata('message', '1 data berhasil diubah.');
				redirect('admin/c_user');
		}		
		else{$this->edit($id);}
		redirect('admin/c_user');
    }
	
    function delete()    {
		$data['hasil'] = $this->session->userdata('logged_in');
		$id_cek = $data['hasil']->id_pengguna;
		
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){			
			$this->m_user->deleteUser($id);				
			$sucess++;			
        }
        redirect('admin/c_user', 'refresh');
    }

    	public function autocomplete_Nik()
    {
        $nik = $this->input->post('nik',TRUE);
        $rows = $this->m_user->get_NikPenduduk($nik);
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
        $rows = $this->m_user->get_NamaPenduduk($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->nik.' | '.$row->nama;
		}
        return json_encode($json_array);
    }
}
?>