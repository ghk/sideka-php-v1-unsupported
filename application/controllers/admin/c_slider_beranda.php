<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_slider_beranda extends CI_Controller {
	function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_slider_beranda');
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
		$colModel['id_slider_beranda'] = array('ID',30,TRUE,'center',2);
        $colModel['konten_background'] = array('Konten Background',250,TRUE,'left',2);
        $colModel['konten_teks'] = array('Konten Teks',150,TRUE,'left',2);
		$colModel['konten_logo'] = array('Konten Logo',250,TRUE,'left',2);
		$colModel['aksi'] = array('AKSI',50,FALSE,'center',2);
		
		//Populate flexigrid buttons..
        
        //$buttons[] = array('Delete Selected Items','delete','btn');
        $buttons[] = array('Select All','check','btn');
		$buttons[] = array('separator');
        $buttons[] = array('DeSelect All','uncheck','btn');
        $buttons[] = array('separator');
		$buttons[] = array('Add','add','btn');
        $buttons[] = array('separator');
        $buttons[] = array('Delete Selected Items','delete','btn');
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

        $grid_js = build_grid_js('flex1',site_url('admin/c_slider_beranda/load_data'),$colModel,'id_slider_beranda','asc',$gridParams,$buttons);
		
		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'SLIDER BERANDA DESA';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('slider_beranda/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() 
	{
        $this->load->library('flexigrid');
		$valid_fields = array('id_slider_beranda','konten_background','konten_teks','konten_logo');
		//$valid_fields = array('id_keluarga');
		$this->flexigrid->validate_post('id_slider_beranda','asc',$valid_fields);
		$records = $this->m_slider_beranda->get_slider_beranda_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();	
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->id_slider_beranda,
                $row->id_slider_beranda,
				$row->konten_background,
				$row->konten_teks,
                $row->konten_logo,		
			'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_slider_beranda(\''.$row->id_slider_beranda.'\')"/>
			<i class="fa fa-pencil"></i>
			</button>'
			);  
		}
		//Print please
		
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }

    function add()
    {
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$s['cek'] = $this->session->userdata('logged_in');
			
			$data['page_title'] = 'Tambah Slider Beranda';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('slider_beranda/v_tambah', $data, TRUE);		
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login','refresh');
    }

    function simpan_slider_beranda() {

		$konten_background = $this->input->post('konten_background', TRUE);
		$konten_logo = $this->input->post('konten_logo', TRUE);
		$konten_teks = $this->input->post('konten_teks', TRUE);

		$this->form_validation->set_rules('konten_teks', 'Konten Teks', 'required');
		
		if ($this->form_validation->run() == TRUE)
		{
    	$generate= substr(sha1(uniqid(rand(), true)), 0, 3);

		//UPLOAD KONTEN BACKGROUND
		$config['upload_path']   =   "./uploads/web/slider_beranda/";
		$config['allowed_types'] =   "gif|jpg|jpeg|png";
		$config['file_name'] = 'background_'.$generate;	
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);
		$this->upload->initialize($config); 
		if(!$this->upload->do_upload('konten_background'))
		{         
			$path_konten_background = $path_konten_background = "uploads/web/slider_beranda/defaultSlider.jpg";    
		}
		else
		{
		  	$upload_konten_background = $this->upload->data();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $upload_konten_background['full_path'];
			$config['maintain_ratio'] = TRUE;
			$config['width']     = 570;
			$config['height']   = 225;
			$this->load->library('image_lib', $config); 
			$path_konten_background = "uploads/web/slider_beranda/".$upload_konten_background['file_name'];
		}
		//END UPLOAD KONTEN BACKGROUND
		
		//UPLOAD KONTEN LOGO
		$config['upload_path']   =   "./uploads/web/slider_beranda/";
		$config['allowed_types'] =   "gif|jpg|jpeg|png";
		$config['file_name'] = 'logo_'.$generate;	
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);
		$this->upload->initialize($config); 
		if(!$this->upload->do_upload('konten_logo'))
		{         
			$path_konten_logo = $path_konten_logo = "uploads/web/slider_beranda/defaultLogo.jpg";    
		}
		else
		{
		  	$upload_konten_logo = $this->upload->data();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $upload_konten_logo['full_path'];
			$config['maintain_ratio'] = TRUE;
			$config['width']     = 150;
			$config['height']   = 150;
			$this->load->library('image_lib', $config); 	
			$path_konten_logo = "uploads/web/slider_beranda/".$upload_konten_logo['file_name'];
		}
		//END UPLOAD KONTEN LOGO
		
			$dataSliderBeranda = array(
				'konten_background' =>  $path_konten_background,
				'konten_logo' =>  $path_konten_logo,
				'konten_teks' => $konten_teks
				);			
			$this->m_slider_beranda->insertSliderBeranda($dataSliderBeranda);
				
			redirect('admin/c_slider_beranda','refresh');
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['id_slider_beranda'] = $id;
			
			/* $konten_background = $this->m_slider_beranda->getKontenBackgroundByIdSliderBeranda($id);
			$konten_logo = $this->m_slider_beranda->getKontenLogoByIdSliderBeranda($id);
			
			$konten_background = str_replace('uploads/web/slider_beranda/','', $konten_background);
			$konten_logo = str_replace('uploads/web/slider_beranda/','', $konten_logo);
			
			$data['konten_background'] = $konten_background;
			$data['konten_logo'] = $konten_logo;
			 */
			
			$data['page_title'] = 'UBAH SLIDER BERANDA';
			$data['hasil'] = $this->m_slider_beranda->getSliderBerandaByIdSliderBeranda($id);
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('slider_beranda/v_ubah', $data, TRUE);

			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }

    function update_slider_beranda()
    {
    	$id_slider_beranda = $this->input->post('id_slider_beranda', TRUE);
		$konten_background = $this->input->post('konten_background', TRUE);
		$konten_logo = $this->input->post('konten_logo', TRUE);
		$konten_teks = $this->input->post('konten_teks', TRUE);

		
		$konten_background = $this->m_slider_beranda->getKontenBackgroundByIdSliderBeranda($id_slider_beranda);
		$konten_logo = $this->m_slider_beranda->getKontenLogoByIdSliderBeranda($id_slider_beranda);
		
		$konten_background = str_replace('uploads/web/slider_beranda/','', $konten_background);
		$konten_logo = str_replace('uploads/web/slider_beranda/','', $konten_logo);
		
		$this->form_validation->set_rules('konten_teks', 'Konten Teks', 'required');
		if ($this->form_validation->run() == TRUE)
		{
		//UPLOAD KONTEN BACKGROUND
		$config['upload_path']   =   "./uploads/web/slider_beranda/";
		$config['allowed_types'] =   "gif|jpg|jpeg|png";
		$config['file_name'] = $konten_background;	
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);
		$this->upload->initialize($config); 
		if(!$this->upload->do_upload('konten_background'))
		{         
			$path_konten_background = $path_konten_background = "uploads/web/slider_beranda/".$konten_background;    
		}
		else
		{
		  	$upload_konten_background = $this->upload->data();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $upload_konten_background['full_path'];
			$config['maintain_ratio'] = TRUE;
			$config['width']     = 200;
			$config['height']   = 125;
			$this->load->library('image_lib', $config); 
			$path_konten_background = "uploads/web/slider_beranda/".$upload_konten_background['file_name'];
		}
		//END UPLOAD KONTEN BACKGROUND
		
		//UPLOAD KONTEN LOGO
		$config['upload_path']   =   "./uploads/web/slider_beranda/";
		$config['allowed_types'] =   "gif|jpg|jpeg|png";
		$config['file_name'] = $konten_logo;	
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);
		$this->upload->initialize($config); 
		if(!$this->upload->do_upload('konten_logo'))
		{         
			$path_konten_logo = $path_konten_logo = "uploads/web/slider_beranda/".$konten_logo;    
		}
		else
		{
		  	$upload_konten_logo = $this->upload->data();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $upload_konten_logo['full_path'];
			$config['maintain_ratio'] = TRUE;
			$config['width']     = 150;
			$config['height']   = 150;
			$this->load->library('image_lib', $config); 	
			$path_konten_logo = "uploads/web/slider_beranda/".$upload_konten_logo['file_name'];
		}
		//END UPLOAD KONTEN LOGO
		

		$dataSliderBeranda = array(
				'id_slider_beranda' => $id_slider_beranda,
				'konten_background' =>  $path_konten_background,
				'konten_logo' =>  $path_konten_logo,
				'konten_teks' => $konten_teks
				);	
		$this->m_slider_beranda->updateSliderBeranda(array('id_slider_beranda' => $id_slider_beranda), $dataSliderBeranda);
		redirect('admin/c_slider_beranda','refresh');
		}
		else $this->edit($id_slider_beranda);
    }

    function delete()   
    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_slider_beranda->deleteSliderBeranda($id);
            $sucess++;
        }
		
        redirect('admin/c_slider_beranda', 'refresh');
    }
}