<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_berita extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('text');
        $this->load->model('m_berita');
		$this->load->model('m_user');
		$this->load->model('m_pages');
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
	
	$colModel['No'] = array('No',35,TRUE,'center',0);
    $colModel['judul_berita'] = array('Judul Berita',400,TRUE,'center',2);
	
	$colModel['waktu'] = array('Waktu Berita',100,TRUE,'center',2);
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
            'height' => 400,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('admin/c_berita/load_data'),$colModel,'waktu','desc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'BERITA DESA';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('berita/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {

        $this->load->library('flexigrid');
        $valid_fields = array('judul_berita','isi_berita','waktu');

		$this->flexigrid->validate_post('judul_berita','DESC',$valid_fields);
		$records = $this->m_berita->get_berita_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		$counter=0;
		foreach ($records['records']->result() as $row)
		{
			$counter++;
			$record_items[] = array(
				$row->id_berita,
				$counter,
                $row->judul_berita,
				//substr($row->isi_berita,0,10),
				date('j-m-Y ',strtotime($row->waktu)),
//				'<input type="button" value="Edit" class="ubah" onclick="edit_berita(\''.$row->id_berita.'\')"/>'
				'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_berita(\''.$row->id_berita.'\')"/>
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
			$data['page_title'] = 'TAMBAH BERITA';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('berita/v_tambah', $data, TRUE);		
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
        
    }
	
	function simpan_berita() {
	
		$judul = $this->input->post('judul', TRUE);
		$gambar = $this->input->post('gambar', TRUE);
		$berita = $this->input->post('isi', TRUE);
		$user = $this->input->post('id_pengguna', TRUE);
		 
		$this->form_validation->set_rules('judul', 'Judul Berita', 'required');

		
		//UPLOAD GAMBAR BERITA
		$newfile = $this->input->post('image-data', TRUE);
		
		define('UPLOAD_DIR', 'uploads/berita/');
		$img = $newfile;
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);		
		
		
		$namaFile = str_replace(' ', '+', $judul);
		$file = UPLOAD_DIR . $namaFile . '.jpg';
		$success = file_put_contents($file, $data);
		
		$path_gambar_berita = $file;
		
		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
				'id_pengguna' => $user,
				'gambar' => $path_gambar_berita,
				'judul_berita' => $judul,
				'isi_berita' => $berita
			);
	
			$this->m_berita->insertBerita($data);
			$url='web/c_home/get_detail_berita/';
			$dataPages = array(
				'url' => $url.mysql_insert_id(),
				'title' => $judul,
				'content' => $berita	
			);
			$this->m_pages->insertPages($dataPages);
			
			
			redirect('admin/c_berita','refresh');
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
			$data['hasil'] = $this->m_berita->getBeritaByIdberita($id);        		
			$data['page_title'] = 'UBAH BERITA';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('berita/v_ubah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
    }
	
	function update_berita() {	
		$idb = $this->input->post('id_berita', TRUE);
		$nama = $this->input->post('id_pengguna', TRUE);		
		$gambar = $this->input->post('gambar', TRUE);
		$judulB = $this->input->post('judul_berita', TRUE);
		$berita = $this->input->post('isi_berita', TRUE);
		
		$this->form_validation->set_rules('judul_berita', 'Judul Berita', 'required');
		
		//UPLOAD GAMBAR BERITA
		$newfile = $this->input->post('image-data', TRUE);
		
		define('UPLOAD_DIR', 'uploads/berita/');
		$img = $newfile;
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);		
		
		
		$namaFile = str_replace(' ', '+', $judulB);
		$file = UPLOAD_DIR . $namaFile . '.jpg';
		$success = file_put_contents($file, $data);
		
		$path_gambar_berita = $file;
		
		if ($this->form_validation->run() == TRUE){
			$data = array(
			'id_berita' => $idb,
			'id_pengguna' => $nama,
			'gambar' => $path_gambar_berita,
			'judul_berita' => $judulB,
			'isi_berita' => $berita
			);
			$result = $this->m_berita->updateBerita(array('id_berita' => $idb), $data);
			$url='web/c_home/get_detail_berita/';
			$dataPages = array(
				'url' => $url.$idb,
				'title' => $judulB,
				'content' => $berita	
			);
			$result = $this->m_pages->updatePages(array('url' => $url.$idb), $dataPages);
			
			redirect('admin/c_berita','refresh');
		}
		else $this->edit($idb);
    }
	
    function delete(){
	$url='web/c_home/get_detail_berita/';
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $urlx=$url.$id;
            $this->m_pages->deletePages($urlx);
            $this->m_berita->deleteBerita($id);
	    		
            $sucess++;
        }
		
        redirect('admin/c_berita', 'refresh');
    }
}
?>