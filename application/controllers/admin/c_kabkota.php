<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_kabkota extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_kabkota');
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
        $colModel['no'] = array('No',30,TRUE,'center',0);
		$colModel['kode_kab_kota_bps'] = array('Kode Kab (BPS)',130,TRUE,'left',2);
		$colModel['kode_kab_kota_kemendagri'] = array('Kode Kab (Kemendagri)',130,TRUE,'left',2);
		$colModel['nama_kab_kota'] = array('Nama Kabupaten Kota',160,TRUE,'center',2);
		$colModel['luas_wilayah'] = array('Luas Wilayah (Ha)',100,TRUE,'center',2);
		$colModel['id_provinsi'] = array('Nama Provinsi',200,TRUE,'left',0);
        $colModel['aksi'] = array('AKSI',60,FALSE,'center',0);
	
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

        $grid_js = build_grid_js('flex1',site_url('admin/c_kabkota/load_data'),$colModel,'kode_kab_kota_bps','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA KABUPATEN KOTA';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('kabkota/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {
	
		$this->load->library('flexigrid');
        $valid_fields = array('id_kab_kota','kode_kab_kota_bps','kode_kab_kota_kemendagri','nama_kab_kota','luas_wilayah','id_provinsi');

		$this->flexigrid->validate_post('id_kab_kota','ASC',$valid_fields);
		$records = $this->m_kabkota->get_kabkota_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		$counter=0;
		foreach ($records['records']->result() as $row)
		{
			$counter++;
			$record_items[] = array(
				$row->id_kab_kota,
				$counter,
                $row->kode_kab_kota_bps,
                $row->kode_kab_kota_kemendagri,				
				$row->nama_kab_kota,
				$row->luas_wilayah,
                $row->nama_provinsi,
//				'<input type="button" value="Edit" class="ubah" onclick="edit_kabkota(\''.$row->id_kab_kota.'\')"/>'
				'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_kabkota(\''.$row->id_kab_kota.'\')"/><i class="fa fa-pencil"></i></button>'
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
			$data['nama_provinsi']=$this->m_kabkota->get_provinsi();
			$data['page_title'] = 'Tambah Kabupaten Kota';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('kabkota/v_tambah', $data, TRUE);
								
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_kabkota() {
		$kode_kab_kota_bps = $this->input->post('kode_kab_kota_bps', TRUE);
		$kode_kab_kota_kemendagri = $this->input->post('kode_kab_kota_kemendagri', TRUE);
		$nama_kab_kota = $this->input->post('nama_kab_kota', TRUE);		
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
		$id_provinsi = $this->input->post('id_provinsi', TRUE);
		
		
		$this->form_validation->set_rules('kode_kab_kota_bps', 'Kode BPS', 'required');
		$this->form_validation->set_rules('kode_kab_kota_kemendagri', 'Kode 2', 'required');
		$this->form_validation->set_rules('nama_kab_kota', 'Nama Kabupaten Kota', 'required');
		$this->form_validation->set_rules('luas_wilayah', 'luas_wilayah', 'required');
		$this->form_validation->set_rules('id_provinsi', 'Provinsi', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$result['hasil'] = $this->m_kabkota->cekFIleExistByKodeBPS($kode_kab_kota_bps);
			
			if ($result['hasil'] == NULL) {
				$data = array(
					'kode_kab_kota_bps' => $kode_kab_kota_bps,
					'kode_kab_kota_kemendagri' => $kode_kab_kota_kemendagri,
					'nama_kab_kota' => $nama_kab_kota,
					'luas_wilayah' => $luas_wilayah,
					'id_provinsi' => $id_provinsi
				);
		
				$this->m_kabkota->insertKabkota($data);	
				redirect('admin/c_kabkota','refresh');
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
			$data['hasil'] = $this->m_kabkota->getKabkotaByIdkabkota($id);
			$data['nama_provinsi']=$this->m_kabkota->get_provinsi();		
			$data['page_title'] = 'Edit Data Kabupaten Kota';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('kabkota/v_ubah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}
		else
			redirect('c_login', 'refresh');
    }
	
	function update_kabkota() {	
		$id_kab_kota = $this->input->post('id_kab_kota', TRUE);
		$kode_kab_kota_bps = $this->input->post('kode_kab_kota_bps', TRUE);
		$kode_kab_kota_kemendagri = $this->input->post('kode_kab_kota_kemendagri', TRUE);
		$nama_kab_kota = $this->input->post('nama_kab_kota', TRUE);		
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
		$id_provinsi = $this->input->post('id_provinsi', TRUE);
		
		$this->form_validation->set_rules('kode_kab_kota_bps', 'Kode BPS', 'required');
		$this->form_validation->set_rules('kode_kab_kota_kemendagri', 'Kode 2', 'required');
		$this->form_validation->set_rules('nama_kab_kota', 'Nama Kabupaten Kota', 'required');
		$this->form_validation->set_rules('luas_wilayah', 'luas_wilayah', 'required');
		$this->form_validation->set_rules('id_provinsi', 'Provinsi', 'required');
	
		if ($this->form_validation->run() == TRUE)
		{			
			$data = array(
				'kode_kab_kota_bps' => $kode_kab_kota_bps,
				'kode_kab_kota_kemendagri' => $kode_kab_kota_kemendagri,
				'nama_kab_kota' => $nama_kab_kota,
				'luas_wilayah' => $luas_wilayah,
				'id_provinsi' => $id_provinsi
			);
	
			$result = $this->m_kabkota->updateKabkota(array('id_kab_kota' => $id_kab_kota), $data);
			
			redirect('admin/c_kabkota','refresh');			
		}
		else $this->edit($id_kab_kota);
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_kabkota->deleteKabkota($id);
            $sucess++;
        }
		
        redirect('admin/c_kabkota', 'refresh');
    }
}
?>