<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_demografi extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('text');
		$this->load->helper('url');
        $this->load->model('m_demografi');
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
	
		$colModel['isi_demografi'] = array('Demografi Desa',500,TRUE,'center',2);
		$colModel['waktu'] = array('Waktu',110,TRUE,'center',2);
		$colModel['foto_banner'] = array('Foto Banner',200,TRUE,'center',2);
		$colModel['aksi'] = array('AKSI',45,FALSE,'center',0);
		
		//Populate flexigrid buttons..
		$buttons[] = array('Select All','check','btn');
		$buttons[] = array('separator');
		$buttons[] = array('DeSelect All','uncheck','btn');
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

        $grid_js = build_grid_js('flex1',site_url('admin/c_demografi/load_data'),$colModel,'id_demografi','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DEMOGRAFI DESA';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('demografi/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {

        $this->load->library('flexigrid');
        $valid_fields = array('isi_demografi');

		$this->flexigrid->validate_post('isi_demografi','DESC',$valid_fields);
		$records = $this->m_demografi->get_demografi_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->isi_demografi,
                $row->isi_demografi,
				$row->waktu,
				$row->foto_banner,
			//	'<input type="button" value="Edit" class="ubah" onclick="edit_demografi(\''.$row->id_demografi.'\')"/>'
			'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_demografi(\''.$row->id_demografi.'\')"/>
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
			$data['page_title'] = 'TAMBAH DEMOGRAFI DESA';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('demografi/v_tambah', $data, TRUE);		
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
        
    }
	
	function simpan_demografi() {
	
		$demografi = $this->input->post('demografi_desa', TRUE);
		$user = $this->input->post('id_pengguna', TRUE);
		
		$this->form_validation->set_rules('demografi_desa', 'Demografi', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
				'id_pengguna' => $user,
				'isi_demografi' => $demografi
			);
	
			$this->m_demografi->insertDemografi($data);
			
			
			redirect('admin/c_demografi','refresh');
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
			$data['hasil'] = $this->m_demografi->getDemografiByIddemografi($id);        		
			$data['page_title'] = 'UBAH DEMOGRAFI DESA';
			
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('demografi/v_ubah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
    }
	
	function update_demografi() {
	
		$ids = $this->input->post('id_demografi', TRUE);
		$nama = $this->input->post('id_pengguna', TRUE);
		$demografi = $this->input->post('isi_demografi', TRUE);
		$newfile = $this->input->post('image-data', TRUE);
		
		define('UPLOAD_DIR', 'uploads/web/');
		$img = $newfile;
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = UPLOAD_DIR . 'foto_banner_demografi' . '.jpg';
		$success = file_put_contents($file, $data);
		
		$path = $file;
		
		$data = array(
			'id_demografi' => $ids,
			'id_pengguna' => $nama,
			'isi_demografi' => $demografi,
			'foto_banner' => $path
		);

		$result = $this->m_demografi->updatedemografi(array('id_demografi' => $ids), $data);
		//f
			$url='web/c_demografi';
			$dataPages = array(
				'content' => $demografi	
			);
			$result = $this->m_pages->updatePages(array('url' => $url), $dataPages);
			/////////////////////////////////////

		redirect('admin/c_demografi','refresh');
		
    }
	
    function delete(){
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_demografi->deleteDemografi($id);
            $sucess++;
        }
	
        redirect('admin/c_demografi', 'refresh'); 
    }
}
?>