<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_visimisi extends CI_Controller {

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
		$this->load->model('m_visimisi');
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
	
		$colModel['visimisi_desa'] = array('Visi Dan Misi Desa',500,TRUE,'center',2);
		$colModel['waktu'] = array('Waktu',100,TRUE,'center',2);
		$colModel['foto_banner'] = array('Foto Banner',100,TRUE,'center',2);
		$colModel['aksi'] = array('AKSI',60,FALSE,'center',0);
		
		//Populate flexigrid buttons..
        $buttons[] = array('Select All','check','btn');
		$buttons[] = array('separator');
        $buttons[] = array('DeSelect All','uncheck','btn');
        $buttons[] = array('separator');
//		$buttons[] = array('Add','add','btn');
//        $buttons[] = array('separator');
//		$buttons[] = array('Delete Selected Items','delete','btn');
//        $buttons[] = array('separator');
       		
        $gridParams = array(
            'height' => 400,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('admin/c_visimisi/load_data'),$colModel,'id_visimisi','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'VISI DAN MISI DESA';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('visimisi/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {

        $this->load->library('flexigrid');
        $valid_fields = array('isi_visi_misi');

		$this->flexigrid->validate_post('isi_visi_misi','DESC',$valid_fields);
		$records = $this->m_visimisi->get_visimisi_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->id_visi_misi,
                $row->isi_visi_misi,
				date('j-m-Y ',strtotime($row->waktu)),
				$row->foto_banner,
			//	'<input type="button" value="Edit" class="ubah" onclick="edit_visimisi(\''.$row->id_visi_misi.'\')"/>'
			'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_visimisi(\''.$row->id_visi_misi.'\')"/>
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
			$data['page_title'] = 'Visi Dan Misi Desa';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('visimisi/v_tambah', $data, TRUE);		
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
        
    }
	
	function simpan_visimisi() {
	
		$visimisi = $this->input->post('visimisi_desa', TRUE);
		$user = $this->input->post('id_pengguna', TRUE);
		
		$this->form_validation->set_rules('visimisi_desa', 'Visi Dan Misi', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
				'id_pengguna' => $user,
				'visimisi_desa' => $visimisi
			);
	
			$this->m_visimisi->insertVisimisi($data);
			
		
			
			redirect('admin/c_visimisi','refresh');
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
			$data['hasil'] = $this->m_visimisi->getVisimisiByIdvisimisi($id);        		
			$data['page_title'] = 'UBAH VISI DAN MISI DESA';
			
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('visimisi/v_ubah', $data, TRUE);
        
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
    }
	
	function update_visimisi() {
	
		$id_visi_misi = $this->input->post('id_visi_misi', TRUE);
		$nama = $this->input->post('id_pengguna', TRUE);
		$isi_visi_misi = $this->input->post('isi_visi_misi', TRUE);
		$newfile = $this->input->post('image-data', TRUE);
		
		define('UPLOAD_DIR', 'uploads/web/');
		$img = $newfile;
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = UPLOAD_DIR . 'foto_banner_visimisi' . '.jpg';
		$success = file_put_contents($file, $data);
		
		$path = $file;
		
		
		$data = array(
			'waktu' => date("Y-m-d H:i:s"),
			'isi_visi_misi' => $isi_visi_misi,
			'foto_banner' => $path
		);

		$result = $this->m_visimisi->updatevisimisi(array('id_visi_misi' => $id_visi_misi), $data);
		//f
			$url='web/c_visimisi';
			$dataPages = array(
				'content' => $isi_visi_misi	
			);
			$result = $this->m_pages->updatePages(array('url' => $url), $dataPages);
			/////////////////////////////////////
		
		redirect('admin/c_visimisi','refresh');
		
    }
	
    function delete(){
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_visimisi->deleteVisimisi($id);
            $sucess++;
        }
		if ($sucess > 0 ){
            echo 'Berhasil Menghapus '.$sucess.' item(s).';
        }else{
            echo 'No delete items';
        }
        redirect('admin/c_visimisi', 'refresh'); 
    }
}
?>