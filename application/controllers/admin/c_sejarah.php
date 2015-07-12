<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_sejarah extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('text');
        $this->load->model('m_sejarah');
		$this->load->helper('url');
		$this->load->model('m_user');
		$this->load->model('m_pages');//f
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
	
		$colModel['isi_sejarah'] = array('Sejarah Desa',400,TRUE,'center',2);
		$colModel['waktu'] = array('Waktu',100,TRUE,'center',2);
		$colModel['foto_banner'] = array('Foto Banner',200,TRUE,'center',2);
		$colModel['aksi'] = array('AKSI',60,TRUE,'center',0);
		
		//$colModel['aksi'] = array('AKSI',60,FALSE,'left',2);
		
		//Populate flexigrid buttons..
        $buttons[] = array('Select All','check','btn');
		$buttons[] = array('separator');
        $buttons[] = array('DeSelect All','uncheck','btn');
        $buttons[] = array('separator');
	//	$buttons[] = array('Add','add','btn');
       // $buttons[] = array('separator');
	//	$buttons[] = array('Delete Selected Items','delete','btn');
       // $buttons[] = array('separator');
       		
        $gridParams = array(
            'height' => 300,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('admin/c_sejarah/load_data'),$colModel,'id_sejarah','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'SEJARAH DESA';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('sejarah/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {

        $this->load->library('flexigrid');
        $valid_fields = array('isi_sejarah','foto_banner');

		$this->flexigrid->validate_post('isi_sejarah','DESC',$valid_fields);
		$records = $this->m_sejarah->get_sejarah_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->isi_sejarah,
                $row->isi_sejarah,
		$row->waktu,
		$row->foto_banner,
//		'<input type="button" value="Edit" class="ubah" onclick="edit_sejarah(\''.$row->id_sejarah.'\')"/>'
		'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_sejarah(\''.$row->id_sejarah.'\')"/>
			<i class="fa fa-pencil"></i>
			</button>'
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
			$s['cek'] = $this->session->userdata('logged_in');
			$x = $s['cek']->id_pengguna;
			
			$data['hasil'] = $this->m_user->getUserByIdPengguna($x);
			$data['page_title'] = 'TAMBAH SEJARAH DESA';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('sejarah/v_tambah', $data, TRUE);		
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
        
    }
	
	function simpan_sejarah() {
	
		$sejarah = $this->input->post('sejarah_desa', TRUE);
		$user = $this->input->post('id_pengguna', TRUE);
		
		$this->form_validation->set_rules('sejarah_desa', 'Nama Provinsi', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
				'id_pengguna' => $user,
				'isi_sejarah' => $sejarah
			);
	
			$this->m_sejarah->insertSejarah($data);
			
	
			
			redirect('admin/c_sejarah','refresh');
        }
		else $this->add();
    }
	
	function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$s['cek'] = $this->session->userdata('logged_in');
			$x = $s['cek']->id_pengguna;
			
			$data['tempna'] = $this->m_user->getUserByIdPengguna($x);
			$data['hasil'] = $this->m_sejarah->getSejarahByIdsejarah($id);        		
			$data['page_title'] = 'UBAH SEJARAH DESA';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('sejarah/v_ubah', $data, TRUE);
        
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
    }
	
	function update_sejarah() {
	
		$ids = $this->input->post('id_sejarah', TRUE);
		$nama = $this->input->post('id_pengguna', TRUE);
		$sejarah = $this->input->post('isi_sejarah', TRUE);
		
		$newfile = $this->input->post('image-data', TRUE);
		
		define('UPLOAD_DIR', 'uploads/web/');
		$img = $newfile;
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = UPLOAD_DIR . 'foto_banner_sejarah' . '.jpg';
		$success = file_put_contents($file, $data);
		
		$path = $file;
		
		$dataSejarah = array(
			'id_sejarah' => $ids,
			'id_pengguna' => $nama,
			'isi_sejarah' => $sejarah,
			'foto_banner' => $path
		);

		$result = $this->m_sejarah->updateSejarah(array('id_sejarah' => $ids), $dataSejarah);
		//f
			$url='web/c_sejarah';
			$dataPages = array(
				'content' => $sejarah	
			);
			$result = $this->m_pages->updatePages(array('url' => $url), $dataPages);
			/////////////////////////////////////
		
		redirect('admin/c_sejarah','refresh');
		
    }
	
    function delete(){
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_sejarah->deleteSejarah($id);
            $sucess++;
        }
		if ($sucess > 0 ){
            echo 'Berhasil Menghapus '.$sucess.' item(s).';
        }else{
            echo 'No delete items';
        }
        redirect('admin/c_sejarah', 'refresh'); 
    }
}
?>