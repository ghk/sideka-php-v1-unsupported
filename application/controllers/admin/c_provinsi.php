<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_provinsi extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_provinsi');
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
        $colModel['kode_provinsi_bps'] = array('Kode Prov (BPS)',130,TRUE,'left',2);
		$colModel['kode_provinsi_kemendagri'] = array('Kode Prov (Kemendagri)',130,TRUE,'left',2);
		$colModel['nama_provinsi'] = array('Nama Provinsi',170,TRUE,'center',2);
		$colModel['luas_wilayah'] = array('Luas Wilayah (Ha)',100,TRUE,'center',2);
		
        $colModel['aksi'] = array('AKSI',60,FALSE,'center',2);
		
		//Populate flexigrid buttons..
        //$buttons[] = array('Select All','check','btn');
		//$buttons[] = array('separator');
        //$buttons[] = array('DeSelect All','uncheck','btn');
       // $buttons[] = array('separator');
		//$buttons[] = array('Add','add','btn');
        //$buttons[] = array('separator');
        //$buttons[] = array('Delete Selected Items','delete','btn');
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

        $grid_js = build_grid_js('flex1',site_url('admin/c_provinsi/load_data'),$colModel,'kode_provinsi_bps','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA PROVINSI';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('provinsi/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {

        $this->load->library('flexigrid');
        $valid_fields = array('id_provinsi','kode_provinsi_bps','kode_provinsi_kemendagri','nama_provinsi','luas_wilayah');

		$this->flexigrid->validate_post('id_provinsi','ASC',$valid_fields);
		$records = $this->m_provinsi->get_provinsi_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		$counter=0;
		foreach ($records['records']->result() as $row)
		{
			$counter++;
			$record_items[] = array(
                $row->id_provinsi,
                $counter,
                $row->kode_provinsi_bps,
                $row->kode_provinsi_kemendagri,
                $row->nama_provinsi,
				$row->luas_wilayah,
//				'<input type="button" value="Edit" class="ubah" onclick="edit_provinsi(\''.$row->id_provinsi.'\')"/>'
				'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_provinsi(\''.$row->id_provinsi.'\')"/><i class="fa fa-pencil"></i></button>'
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
			$data['page_title'] = 'Tambah Provinsi';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('provinsi/v_tambah', $data, TRUE);		
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_provinsi() {
	
		$kode_provinsi_bps = $this->input->post('kode_provinsi_bps', TRUE);
		$kode_provinsi_kemendagri = $this->input->post('kode_provinsi_kemendagri', TRUE);
		$nama_provinsi = $this->input->post('nama_provinsi', TRUE);
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
		
		$this->form_validation->set_rules('kode_provinsi_bps', 'Kode Provinsi BPS', 'required');
		$this->form_validation->set_rules('kode_provinsi_kemendagri', 'Kode Provinsi 2', 'required');
		$this->form_validation->set_rules('nama_provinsi', 'Nama Provinsi', 'required');
		$this->form_validation->set_rules('luas_wilayah', 'luas_wilayah', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$result['hasil'] = $this->m_provinsi->cekFIleExistByKodeBPS($kode_provinsi_bps);
			if ($result['hasil'] == NULL) {
				$data = array(
					'kode_provinsi_bps' => $kode_provinsi_bps,
					'kode_provinsi_kemendagri' => $kode_provinsi_kemendagri,
					'nama_provinsi' => $nama_provinsi,
					'luas_wilayah' => $luas_wilayah
				);
		
				$this->m_provinsi->insertProvinsi($data);
				
			
				redirect('admin/c_provinsi','refresh');
			}
			else
			{
				$this->add();
				/* Handle ketika kode bps telah digunakan */
			}
        }
		else $this->add();
    }

    function edit($id){
        $session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['hasil'] = $this->m_provinsi->getProvinsiByIdprov($id);
					
			$data['page_title'] = 'Edit Data Provinsi';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('provinsi/v_ubah', $data, TRUE);
		
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update_provinsi() {	
	
		$id_provinsi = $this->input->post('id_provinsi', TRUE);
		$kode_provinsi_bps = $this->input->post('kode_provinsi_bps', TRUE);
		$kode_provinsi_kemendagri = $this->input->post('kode_provinsi_kemendagri', TRUE);
		$nama_provinsi = $this->input->post('nama_provinsi', TRUE);
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
	
		$this->form_validation->set_rules('kode_provinsi_bps', 'Kode Provinsi BPS', 'required');
		$this->form_validation->set_rules('kode_provinsi_kemendagri', 'Kode Provinsi 2', 'required');
		$this->form_validation->set_rules('nama_provinsi', 'Nama Provinsi', 'required');
		$this->form_validation->set_rules('luas_wilayah', 'luas_wilayah', 'required');
		

		if ($this->form_validation->run() == TRUE){		
				
			$data = array(
				'kode_provinsi_bps' => $kode_provinsi_bps,
				'kode_provinsi_kemendagri' => $kode_provinsi_kemendagri,
				'nama_provinsi' => $nama_provinsi,
				'luas_wilayah' => $luas_wilayah
			);
	
		  	$result = $this->m_provinsi->updateProvinsi(array('id_provinsi' => $id_provinsi), $data);
			
			
		  	redirect('admin/c_provinsi','refresh');
		}
		else $this->edit($id_provinsi);
    }
	
    function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_provinsi->deleteProvinsi($id);
            $sucess++;
        }
		if ($sucess > 0 ){
            echo 'Success delete '.$sucess.' item(s).';
        }else{
            echo 'No delete items';
        }
        redirect('admin/c_provinsi', 'refresh'); 
    }
}
?>