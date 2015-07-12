<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_lembaga_desa extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('text');
		$this->load->model('m_lembaga_desa');
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
	
		$colModel['lembaga_desa'] = array('Lembaga Desa',600,TRUE,'center',2);
		$colModel['waktu'] = array('Waktu',100,TRUE,'center',2);
		$colModel['aksi'] = array('AKSI',60,FALSE,'center',2);
		
		//Populate flexigrid buttons..
        $buttons[] = array('Select All','check','btn');
		$buttons[] = array('separator');
        $buttons[] = array('DeSelect All','uncheck','btn');
        $buttons[] = array('separator');
//		$buttons[] = array('Add','add','btn');
//      $buttons[] = array('separator');
//		$buttons[] = array('Delete Selected Items','delete','btn');
//      $buttons[] = array('separator');
       		
        $gridParams = array(
            'height' => 400,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('admin/c_lembaga_desa/load_data'),$colModel,'id_lembaga_desa','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'LEMBAGA DESA';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('lembaga_desa/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {

        $this->load->library('flexigrid');
        $valid_fields = array('isi_lembaga_desa');

		$this->flexigrid->validate_post('isi_lembaga_desa','DESC',$valid_fields);
		$records = $this->m_lembaga_desa->get_lembaga_desa_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->isi_lembaga_desa,
                $row->isi_lembaga_desa,
				date('d-m-Y',strtotime($row->waktu)),
					
			'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_lembaga_desa(\''.$row->id_lembaga_desa.'\')"/>
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
			$x = $s['cek']->id_pengguna;
			
			$data['hasil'] = $this->m_user->getUserByIdPengguna($x);
			$data['page_title'] = 'Lembaga Desa';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('lembaga_desa/v_tambah', $data, TRUE);		
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
        
    }
	
	function simpan_lembaga_desa() {
	
		$lembaga_desa = $this->input->post('lembaga_desa', TRUE);
		$user = $this->input->post('id_pengguna', TRUE);
		
		$this->form_validation->set_rules('lembaga_desa', 'Lembaga Desa', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
				'id_pengguna' => $user,
				'lembaga_desa' => $lembaga_desa
			);
	
			$this->m_lembaga_desa->insertLembaga_desa($data);
			
	
			
			redirect('admin/c_lembaga_desa','refresh');
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
			$data['hasil'] = $this->m_lembaga_desa->getLembaga_desaByIdlembaga($id);        		
			$data['page_title'] = 'UBAH LEMBAGA DESA';
			
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('lembaga_desa/v_ubah', $data, TRUE);			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');   
    }
	
	function update_lembaga_desa() {
	
		$ids = $this->input->post('id_lembaga_desa', TRUE);
		$nama = $this->input->post('id_pengguna', TRUE);
		$isi_lembaga_desa = $this->input->post('isi_lembaga_desa', TRUE);
		
		$data = array(
			'id_lembaga_desa' => $ids,
			'id_pengguna' => $nama,
			'isi_lembaga_desa' => $isi_lembaga_desa
		);

		$result = $this->m_lembaga_desa->updateLembaga_desa(array('id_lembaga_desa' => $ids), $data);
		//f
			$url='web/c_lembaga_desa';
			$dataPages = array(
				'content' => $isi_lembaga_desa	
			);
			$result = $this->m_pages->updatePages(array('url' => $url), $dataPages);
			/////////////////////////////////////

		redirect('admin/c_lembaga_desa','refresh');
		
    }
	
    function delete(){
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_lembaga_desa->deleteLembaga_desa($id);
            $sucess++;
        }
		
        redirect('admin/c_lembaga_desa', 'refresh'); 
    }
}
?>