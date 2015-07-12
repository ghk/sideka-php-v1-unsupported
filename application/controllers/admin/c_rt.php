<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_rt extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_rt');
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
        //$colModel['id_rt'] = array('ID',30,TRUE,'center',0);
        $colModel['nomor_rt'] = array('Nomor RT',80,TRUE,'center',2);
		$colModel['luas_wilayah'] = array('Luas Wilayah (Ha)',100,TRUE,'center',2);
		$colModel['ref_dusun.nama_dusun'] = array('Dusun',100,TRUE,'center',2);		
		$colModel['ref_rw.nomor_rw'] = array('Nomor RW',100,TRUE,'center',2);		
		$colModel['id_penduduk'] = array('Nik Ketua RT',150,TRUE,'center',0);
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
            'rp' => 15,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('admin/c_rt/load_data'),$colModel,'ref_dusun.nama_dusun','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA RT';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('rt/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {	
		$this->load->library('flexigrid');
        $valid_fields = array('id_rt','nomor_rt','luas_wilayah','ref_dusun.nama_dusun','ref_rw.nomor_rw','id_penduduk');

		$this->flexigrid->validate_post('id_rt','ASC',$valid_fields);
		$records = $this->m_rt->get_rt_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		foreach ($records['records']->result() as $row)
		{	
			$record_items[] = array(
				//$row->id_rt,
				$row->id_rt,
               	$row->nomor_rt,
				$row->luas_wilayah,
				$row->nama_dusun,
				$row->nomor_rw,
				$this->m_rt->getNIKByIdPenduduk($row->id_penduduk),
//				'<input type="button" value="Edit" class="ubah" onclick="edit_rt(\''.$row->id_rt.'\')"/>'
				'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_rt(\''.$row->id_rt.'\')"/><i class="fa fa-pencil"></i></button>'

			);  
		}
		//Print please
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
    
	function getRw(){	
			$id_dusun = $this->input->post('id_dusun');
			$data['nomor_rw'] = $this->m_rt->get_rw_dinamic($id_dusun);
			$this->load->view('rt/rw',$data);
	}
	
    function add(){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			//$data['nama_rw']= $this->m_rt->get_rw();
			$data['nama_dusun']= $this->m_rt->get_dusun();
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['page_title'] = 'Tambah RT';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('rt/v_tambah', $data, TRUE);
			
					
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_rt() {
		$nomor_rt = $this->input->post('nomor_rt', TRUE);
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
		$id_rw = $this->input->post('id_rw', TRUE);		
		$nik = $this->input->post('nik', TRUE);
		
		$this->form_validation->set_rules('nomor_rt', 'Nomor RT', 'required');
		$this->form_validation->set_rules('luas_wilayah', 'luas_wilayah', 'required');
		$this->form_validation->set_rules('id_rw', 'Nama RW', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			//$result['hasil'] = $this->m_rt->cekFIleExist($nomor_rt);				
			
			if($nik==NULL) {$id_penduduk=NULL;}
			else
			{
				$id_penduduk	 =	$this->m_rt->getIdPendudukByNIK($nik);
			}
			
			if ($id_penduduk != 'tidak ditemukan') {				
				$data = array(
					'nomor_rt' => $nomor_rt,
					'luas_wilayah' => $luas_wilayah,
					'id_rw' => $id_rw,
					'id_penduduk' => $id_penduduk
				);

			$this->m_rt->insertRt($data);	
			redirect('admin/c_rt','refresh');
			}			
			else $this->add();
			/* Handle ketika nomer rt telah digunakan */
        }
		else $this->add();
    }

	function getRwEdit(){	
			$id_dusun = $this->input->post('id_dusun');
			$data['nomor_rw_edit'] = $this->m_rt->get_rw_dinamic($id_dusun);
			$this->load->view('rt/rw_edit',$data);
	}
	
    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$data['hasil'] = $this->m_rt->getRtByIdrt($id);
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			//$data['nomor_rw'] = $this->m_rt->get_rw();	
			$data['nama_dusun'] = $this->m_rt->get_dusun();	
			$data['id_dusun_selected'] = $this->m_rt->get_dusunByIdRw($data['hasil']->id_rw);	
			$data['nik']	= $this->m_rt->getNIKByIdPenduduk($data['hasil']->id_penduduk);
			$data['nama']	= $this->m_rt->getNamaByIdPenduduk($data['hasil']->id_penduduk);
			
			$id_dusun = $data['id_dusun_selected'];
			$data['nomor_rw'] = $this->m_rt->get_rw_dinamic($id_dusun);
			
			$data['page_title'] = 'Edit Data RT';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('rt/v_ubah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update_rt() {	
	
		$id_rt = $this->input->post('id_rt', TRUE);
		$nomor_rt = $this->input->post('nomor_rt', TRUE);
		$luas_wilayah = $this->input->post('luas_wilayah', TRUE);
		$id_rw = $this->input->post('id_rw', TRUE);	
		$nik = $this->input->post('nik', TRUE);
		
		$this->form_validation->set_rules('nomor_rt', 'Nomor RT', 'required');
		$this->form_validation->set_rules('luas_wilayah', 'Luas Wilayah', 'required');
		//$this->form_validation->set_rules('id_rw', 'Nama RW', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			if($nik==NULL) {$id_penduduk=NULL;}
			else
			{
				$id_penduduk	 =	$this->m_rt->getIdPendudukByNIK($nik);
			}			
			if($id_penduduk != 'tidak ditemukan') 
			{
				$data = array(
						'nomor_rt' => $nomor_rt,
						'luas_wilayah' => $luas_wilayah,
						'id_rw' => $id_rw,
						'id_penduduk' => $id_penduduk
					);
		
				$result = $this->m_rt->updateRt(array('id_rt' => $id_rt), $data);
				
				redirect('admin/c_rt','refresh');
			}
			else
			{				
				$this->edit($id_desa); //handle ketika id_penduduk tidak ditemukan
			}
		}
		else $this->edit($id_rt);
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_rt->deleteRt($id);
            $sucess++;
        }
		
        redirect('admin/c_rt', 'refresh');
    }

       public function autocomplete_Nik()
    {
        $nik = $this->input->post('nik',TRUE);
        $rows = $this->m_rt->get_NikPenduduk($nik);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]=$row->nik;
		}
        return json_encode($json_array);
    }
	
	public function autocomplete_NamaPenduduk()
    {
        $nama = $this->input->post('nama',TRUE);
        $rows = $this->m_rt->get_NamaPenduduk($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->nik.' | '.$row->nama;
		}
        return json_encode($json_array);
    }
	

}
?>