<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_kondisi_kehamilan extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_kondisi_kehamilan');
    }

    function index()    {
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$this->lists();
		}else
			redirect('c_login', 'refresh');
        	
    }

	public function ExportToExcel()
	{
		$query = $this->m_kondisi_kehamilan->get_dataForExportExcel();
		$this->excel_generator->getActiveSheet()->setCellValue('A1', 'Data Kondisi Kehamilan');
		$this->excel_generator->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel_generator->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel_generator->getActiveSheet()->mergeCells('A1:F1');
		$this->excel_generator->getActiveSheet()->getStyle('A1:F300')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
					)
			)
		);
		$this->excel_generator->getActiveSheet()->getStyle('A3:F16')->applyFromArray($styleArray);
		unset($styleArray);
		
		$this->excel_generator->start_at(3);
		$this->excel_generator->set_header(array('ID', 'Nik', 'Nama', 'Hari Perkiraan Lahir', 'Resiko Tinggi', 'Keterangan'));
		$this->excel_generator->set_column(array('id_kondisi_kehamilan', 'nik', 'nama', 'tgl_hpl', 'is_resti', 'keterangan'));
        $this->excel_generator->set_width(array(15, 20, 20, 20, 15, 20));
        $this->excel_generator->exportTo2007('Data Kondisi Kehamilan');
	}

    function lists() {
        $colModel['id_kondisi_kehamilan'] = array('ID',20,TRUE,'left',0);	
		$colModel['tbl_penduduk.nik'] = array('NIK',150,TRUE,'left',2);
		$colModel['tbl_penduduk.nama'] = array('Nama',150,TRUE,'left',2);
		$colModel['tgl_hpl'] = array('Hari Perkiraan Lahir',150,TRUE,'center',0);
		$colModel['is_resti'] = array('Resiko Tinggi',150,TRUE,'center',2);
		$colModel['keterangan'] = array('Keterangan',200,TRUE,'center',2);
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
            'height' => 300,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('datapenduduk/c_kondisi_kehamilan/load_data'),$colModel,'id_kondisi_kehamilan','desc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA KONDISI KEHAMILAN';		
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('kondisi_kehamilan/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {	
	
		$this->load->library('flexigrid');
        $valid_fields = array('id_kondisi_kehamilan','tbl_penduduk.nik','tbl_penduduk.nama','tgl_hpl','is_resti','keterangan');

		$this->flexigrid->validate_post('id_kondisi_kehamilan','ASC',$valid_fields);
		$records = $this->m_kondisi_kehamilan->get_kondisi_kehamilan_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->id_kondisi_kehamilan,
				$row->id_kondisi_kehamilan,
				$row->nik,
				$row->nama,
				date('j-m-Y ',strtotime($row->tgl_hpl)),
				$this->ubahYesNo($row->is_resti),
				$row->keterangan,
//				'<input type="button" value="Edit" class="ubah" onclick="edit_kondisi_kehamilan(\''.$row->id_kondisi_kehamilan.'\')"/>'
'<button type="submit" class="btn btn-default btn-xs" title="Edit Data Kondisi Kehamilan" onclick="edit_kondisi_kehamilan(\''.$row->id_kondisi_kehamilan.'\')"/><i class="fa fa-pencil"></i></button>'				
			);  
		}
		//Print please
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
	function ubahYesNo($yesno)
	{
		if($yesno == 'Y')
		{return 'Ya';}
		else if($yesno == 'N')
		{return 'Tidak';}
	}
    
    function add(){		
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{			
			$data['page_title'] = 'Tambah KONDISI KEHAMILAN';
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('kondisi_kehamilan/v_tambah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_kondisi_kehamilan() {
	
		$nik = $this->input->post('nik', TRUE);
		$nama = $this->input->post('nama', TRUE);
		$is_resti = $this->input->post('is_resti', TRUE);		
		$keterangan = $this->input->post('keterangan', TRUE);	
		$tgl_hpl = $this->input->post('tgl_hpl', TRUE);
		
		$this->form_validation->set_rules('nik', 'Nik', 'required');		
		$this->form_validation->set_rules('nama', 'Nama', 'required');		
		$this->form_validation->set_rules('is_resti', 'Resiko Tinggi', 'required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
		$this->form_validation->set_rules('tgl_hpl', 'Tanggal Perkiraan Kelahiran', 'required');
		
		

		if ($this->form_validation->run() == TRUE)
		{							
			$id_penduduk = $this->m_kondisi_kehamilan->getIdPendudukByNIK($nik);
			$result['hasil'] = $this->m_kondisi_kehamilan->cekFIleExist($id_penduduk);
			
			if ($result['hasil'] == NULL) {				
				$data = array(
					'is_resti' => $is_resti,
					'keterangan' => $keterangan,
					'tgl_hpl' => date('Y-m-d', strtotime($tgl_hpl)),
					'id_penduduk' => $id_penduduk					
				);

				$this->m_kondisi_kehamilan->insertKondisiKehamilan($data);	
				redirect('datapenduduk/c_kondisi_kehamilan','refresh');
			}			
			else $this->add();
			/* Handle ketika nomer kondisi_kehamilan telah digunakan */
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['hasil']		= $this->m_kondisi_kehamilan->getKondisiKehamilanByIdKondisiKehamilan($id);
			$data['penduduk']	= $this->m_kondisi_kehamilan->getPendudukByIdKondisiKehamilan($id);
			$data['page_title'] = 'Edit Data KONDISI KEHAMILAN';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('kondisi_kehamilan/v_ubah', $data, TRUE);
        
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update_kondisi_kehamilan() {	
	
		$id_kondisi_kehamilan = $this->input->post('id_kondisi_kehamilan', TRUE);
				
		$is_resti = $this->input->post('is_resti', TRUE);		
		$keterangan = $this->input->post('keterangan', TRUE);	
		$tgl_hpl = $this->input->post('tgl_hpl', TRUE);
					
		$this->form_validation->set_rules('is_resti', 'Resiko Tinggi', 'required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
		$this->form_validation->set_rules('tgl_hpl', 'Tanggal Perkiraan Kelahiran', 'required');
		
		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
					'is_resti' => $is_resti,
					'keterangan' => $keterangan,
					'tgl_hpl' => date('Y-m-d', strtotime($tgl_hpl))		
				);
	
		  	$result = $this->m_kondisi_kehamilan->updateKondisiKehamilan(array('id_kondisi_kehamilan' => $id_kondisi_kehamilan), $data);
			
		  	redirect('datapenduduk/c_kondisi_kehamilan','refresh');
		}
		else $this->edit($id_kondisi_kehamilan);
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_kondisi_kehamilan->deleteKondisiKehamilan($id);
            $sucess++;
        }
		
        redirect('admin/c_kondisi_kehamilan', 'refresh');
    }
	
	public function autocomplete_Nik()
    {
        $nik = $this->input->post('nik',TRUE);
        $rows = $this->m_kondisi_kehamilan->get_NikPenduduk($nik);
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
        $rows = $this->m_kondisi_kehamilan->get_NamaPenduduk($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->nik.' | '.$row->nama;
		}
        return json_encode($json_array);
    }
}
?>