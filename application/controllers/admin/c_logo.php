<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_logo extends CI_Controller {
	function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_logo');
        $this->load->helper('url');
    }
	
	function index()    
	{
		
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$this->lists();
		}
		else
			redirect('c_login', 'refresh');
    }
	
	function lists() 
	{
		$colModel['id_logo'] = array('ID',30,TRUE,'center',2);
        $colModel['konten_logo_desa'] = array('Logo Desa',200,TRUE,'left',2);
        $colModel['konten_logo_kabupaten'] = array('Logo Kabupaten',200,TRUE,'left',2);
		$colModel['path_css'] = array('Path CSS',200,TRUE,'left',2);
		$colModel['aksi'] = array('AKSI',50,FALSE,'center',2);
		
		//Populate flexigrid buttons..
        
        //$buttons[] = array('Delete Selected Items','delete','btn');
        $buttons[] = array('separator');
       		
        $gridParams = array(
            'height' => 200,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
			);

        $grid_js = build_grid_js('flex1',site_url('admin/c_logo/load_data'),$colModel,'id_logo','asc',$gridParams,$buttons);
		
		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'LOGO DESA';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('logo/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() 
	{
        $this->load->library('flexigrid');
		$valid_fields = array('id_logo','konten_logo_desa','konten_logo_kabupaten','path_css');
		//$valid_fields = array('id_keluarga');
		$this->flexigrid->validate_post('id_logo','asc',$valid_fields);
		$records = $this->m_logo->get_logo_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();	
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->id_logo,
                $row->id_logo,
				$row->konten_logo_desa,
				$row->konten_logo_kabupaten,
                $row->path_css,		
			'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_logo(\''.$row->id_logo.'\')"/>
			<i class="fa fa-pencil"></i>
			</button>');  
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
			
			$data['page_title'] = 'Tambah Logo';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('logo/v_tambah', $data, TRUE);		
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	function simpan_logo() {

		//UPLOAD LOGO DESA
		$config['upload_path']   =   "./uploads/web/";
		$config['allowed_types'] =   "gif|jpg|jpeg|png";
		$config['file_name'] = 'logo_desa';	
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);
		$this->upload->initialize($config); 
		if(!$this->upload->do_upload('logo_desa'))
		{         
			$path_logo_desa = $path_logo_desa = "uploads/web/defaultFotoPenduduk.jpg";    
		}
		else
		{
		  	$upload_logo_desa = $this->upload->data();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $upload_logo_desa['full_path'];
			$config['maintain_ratio'] = TRUE;
			$config['width']     = 300;
			$config['height']   = 100;
			$this->load->library('image_lib', $config); 
			$path_logo_desa = "uploads/web/".$upload_logo_desa['file_name'];
		}
		//END UPLOAD LOGO DESA
		
		//UPLOAD LOGO KABUPATEN
		$config['upload_path']   =   "./uploads/web/";
		$config['allowed_types'] =   "gif|jpg|jpeg|png";
		$config['file_name'] = 'logo_kabupaten';	
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);
		$this->upload->initialize($config); 
		if(!$this->upload->do_upload('logo_kabupaten'))
		{         
			$path_logo_kabupaten = $path_logo_kabupaten = "uploads/web/defaultFotoPenduduk.jpg";    
		}
		else
		{
		  	$upload_logo_kabupaten = $this->upload->data();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $upload_logo_kabupaten['full_path'];
			$config['maintain_ratio'] = TRUE;
			$config['width']     = 300;
			$config['height']   = 100;
			$this->load->library('image_lib', $config); 	
			$path_logo_kabupaten = "uploads/web/".$upload_logo_kabupaten['file_name'];
		}
		//END UPLOAD LOGO KABUPATEN

			$dataLogo = array(
				'konten_logo_desa' =>  $path_logo_desa,
				'konten_logo_kabupaten' =>  $path_logo_kabupaten,
				);			
			$this->m_logo->insertLogo($dataLogo);
				
			redirect('admin/c_logo','refresh');
        
    }
	
	function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['id_logo'] = $id;
			$data['page_title'] = 'UBAH LOGO DESA';
			$data['konten_logo'] = $this->m_logo->getLogo();
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('logo/v_ubah', $data, TRUE);
        
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update_logo() {	
		$id_logo = $this->input->post('id_logo', TRUE);
		$konten_logo_desa = $this->input->post('konten_logo_desa', TRUE);
		$konten_logo_kabupaten = $this->input->post('konten_logo_kabupaten', TRUE);
		$path_css = $this->input->post('path_css', TRUE);

		//UPLOAD LOGO DESA
		$config['upload_path']   =   "./uploads/web/";
		$config['allowed_types'] =   "gif|jpg|jpeg|png";
		$config['file_name'] = 'logo_desa';	
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);
		$this->upload->initialize($config); 
		if(!$this->upload->do_upload('logo_desa'))
		{         
			$path_logo_desa = $path_logo_desa = "uploads/web/logo_desa.png";    
		}
		else
		{
		  	$upload_logo_desa = $this->upload->data();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $upload_logo_desa['full_path'];
			$config['maintain_ratio'] = TRUE;
			$config['width']     = 300;
			$config['height']   = 100;
			$this->load->library('image_lib', $config); 
			$path_logo_desa = "uploads/web/".$upload_logo_desa['file_name'];
		}
		//END UPLOAD LOGO DESA
		
		//UPLOAD LOGO KABUPATEN
		$newfile = $this->input->post('image-data', TRUE);
		
		define('UPLOAD_DIR', 'uploads/web/');
		$img = $newfile;
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);		
		
		
		$file = UPLOAD_DIR . 'logo_kabupaten' . '.jpg';
		$success = file_put_contents($file, $data);
		
		$path_logo_kabupaten = $file;
		//END UPLOAD LOGO KABUPATEN

			$dataLogo = array(
				'konten_logo_desa' =>  $path_logo_desa,
				'konten_logo_kabupaten' =>  $path_logo_kabupaten,
				'path_css' =>  $path_css
				);			
			$this->m_logo->updateLogo(array('id_logo' => $id_logo), $dataLogo);
			
		
		redirect('admin/c_logo','refresh');
			
    }
	
	
	
	
}
?>