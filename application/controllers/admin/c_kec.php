<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_kec extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_kec');
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
        $colModel['kode_kecamatan_bps'] = array('Kode Kec (BPS)',130,TRUE,'left',2);
		$colModel['kode_kecamatan_kemendagri'] = array('Kode Kec (Kemendagri)',130,TRUE,'left',2);
		$colModel['nama_kecamatan'] = array('Nama Kecamatan',160,TRUE,'center',2);		
		$colModel['luas_wilayah'] = array('Luas Wilayah (Ha)',100,TRUE,'center',2);
		$colModel['id_kab_kota'] = array('Nama Kabupaten Kota',160,TRUE,'left',0);
        $colModel['aksi'] = array('AKSI',60,FALSE,'center',0);
		
		//Populate flexigrid buttons..
        //$buttons[] = array('Select All','check','btn');
		//$buttons[] = array('separator');
        //$buttons[] = array('DeSelect All','uncheck','btn');
        //$buttons[] = array('separator');
		//$buttons[] = array('Add','add','btn');
       // $buttons[] = array('separator');
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

        $grid_js = build_grid_js('flex1',site_url('admin/c_kec/load_data'),$colModel,'kode_kecamatan_bps','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA KECAMATAN';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('kec/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {
        $this->load->library('flexigrid');
        $valid_fields = array('id_kecamatan','kode_kecamatan_bps','kode_kecamatan_kemendagri','nama_kecamatan','luas_wilayah','id_kab_kota');

		$this->flexigrid->validate_post('id_kecamatan','ASC',$valid_fields);
		$records = $this->m_kec->get_kec_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		$counter = 0;
		foreach ($records['records']->result() as $row)
		{	$counter++;
			$record_items[] = array(
				$row->id_kecamatan,
				$counter,
                $row->kode_kecamatan_bps,
                $row->kode_kecamatan_kemendagri,
				$row->nama_kecamatan,
                $row->luas_wilayah,				
                $row->nama_kab_kota,
//				'<input type="button" value="Edit" class="ubah" onclick="edit_kec(\''.$row->id_kecamatan.'\')"/>'
                '<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_kec(\''.$row->id_kecamatan.'\')"/><i class="fa fa-pencil"></i></button>'
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
			$data['nama_kab_kota']= $this->m_kec->get_kab_kota();
			$data['page_title'] = 'Tambah Kecamatan';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('kec/v_tambah', $data, TRUE);
								
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_kec() {
	
		$kode_kecamatan_bps = $this->input->post('kode_kecamatan_bps', TRUE);
		$kode_kecamatan_kemendagri = $this->input->post('kode_kecamatan_kemendagri', TRUE);
		$nama_kecamatan = $this->input->post('nama_kecamatan', TRUE);
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
		$id_kab_kota = $this->input->post('id_kab_kota', TRUE);
	
		
		$this->form_validation->set_rules('kode_kecamatan_bps', 'Kode BPS', 'required');
		$this->form_validation->set_rules('kode_kecamatan_kemendagri', 'Kode 2', 'required');
		$this->form_validation->set_rules('nama_kecamatan', 'Nama Kecamatan', 'required');
		$this->form_validation->set_rules('luas_wilayah', 'luas_wilayah', 'required');
		$this->form_validation->set_rules('id_kab_kota', 'Kabupaten Kota', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$result['hasil'] = $this->m_kec->cekFIleExistByKodeBPS($kode_kecamatan_bps);
			
			if ($result['hasil'] == NULL) {
			
				$data = array(
					'kode_kecamatan_bps' => $kode_kecamatan_bps,
					'kode_kecamatan_kemendagri' => $kode_kecamatan_kemendagri,
					'nama_kecamatan' => $nama_kecamatan,
					'luas_wilayah' => $luas_wilayah,
					'id_kab_kota' => $id_kab_kota
				);
		
				$this->m_kec->insertKec($data);	
				redirect('admin/c_kec','refresh');
			}
			else $this->add();
			/* Handle ketika kode bps telah digunakan */
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{		
			$data['hasil'] = $this->m_kec->getKecByIdkec($id);
			$data['nama_kab_kota'] = $this->m_kec->get_kab_kota();		
			$data['page_title'] = 'Edit Data Kecamatan';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('kec/v_ubah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update_kec() {	
	
		$id_kecamatan = $this->input->post('id_kecamatan', TRUE);
		$kode_kecamatan_bps = $this->input->post('kode_kecamatan_bps', TRUE);
		$kode_kecamatan_kemendagri = $this->input->post('kode_kecamatan_kemendagri', TRUE);
		$nama_kecamatan = $this->input->post('nama_kecamatan', TRUE);
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
		$id_kab_kota = $this->input->post('id_kab_kota', TRUE);
	
		
		$this->form_validation->set_rules('kode_kecamatan_bps', 'Kode BPS', 'required');
		$this->form_validation->set_rules('kode_kecamatan_kemendagri', 'Kode 2', 'required');
		$this->form_validation->set_rules('nama_kecamatan', 'Nama Kecamatan', 'required');
		$this->form_validation->set_rules('luas_wilayah', 'luas_wilayah', 'required');
		$this->form_validation->set_rules('id_kab_kota', 'Kabupaten Kota', 'required');
	
		if ($this->form_validation->run() == TRUE)
			{			
				$data = array(
					'kode_kecamatan_bps' => $kode_kecamatan_bps,
					'kode_kecamatan_kemendagri' => $kode_kecamatan_kemendagri,
					'nama_kecamatan' => $nama_kecamatan,
					'luas_wilayah' => $luas_wilayah,
					'id_kab_kota' => $id_kab_kota
				);		
				$result = $this->m_kec->updateKec(array('id_kecamatan' => $id_kecamatan), $data);
							
				redirect('admin/c_kec','refresh');
				
			}
			else $this->edit($id_kecamatan);
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_kec->deleteKec($id);
            $sucess++;
        }
		
        redirect('admin/c_kec', 'refresh');
    }
}
?>