<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_gizi_buruk extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_gizi_buruk');
        
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
		$query = $this->m_gizi_buruk->get_dataForExportExcel();
		$this->excel_generator->getActiveSheet()->setCellValue('A1', 'Data Gizi Buruk');
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
		$this->excel_generator->set_header(array('ID Gizi Buruk', 'Nik', 'Nama', 'Berat Badan', 'Tinggi Badan', 'Tanggal Timbang'));
		$this->excel_generator->set_column(array('id_gizi_buruk', 'nik', 'nama', 'berat_badan', 'tinggi_badan', 'tgl_timbang'));
        $this->excel_generator->set_width(array(15, 20, 20, 15, 15, 20));
		
        $this->excel_generator->exportTo2007('Data Gizi Buruk');
	}
	
    function lists() {
        $colModel['id_gizi_buruk'] = array('ID',20,TRUE,'left',0);	
		$colModel['tbl_keluarga.no_kk'] = array('No KK',150,TRUE,'left',2);
		$colModel['tbl_penduduk.nik'] = array('NIK',150,TRUE,'left',2);
		$colModel['tbl_penduduk.nama'] = array('Nama',150,TRUE,'left',2);
		$colModel['berat_badan'] = array('Berat Badan (kg)',150,TRUE,'center',2);
		$colModel['tinggi_badan'] = array('Tinggi Badan (cm)',150,TRUE,'center',2);
		$colModel['tanggal_timbang'] = array('Tanggal Timbang',150,TRUE,'center',0);
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

        $grid_js = build_grid_js('flex1',site_url('datapenduduk/c_gizi_buruk/load_data'),$colModel,'id_gizi_buruk','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA GIZI BURUK';		
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('gizi_buruk/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {	
	
		$this->load->library('flexigrid');
        $valid_fields = array('id_gizi_buruk','tbl_keluarga.no_kk','tbl_penduduk.nik','tbl_penduduk.nama','berat_badan','tinggi_badan','tanggal_timbang');

		$this->flexigrid->validate_post('id_gizi_buruk','ASC',$valid_fields);
		$records = $this->m_gizi_buruk->get_gizi_buruk_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->id_gizi_buruk,
				$row->id_gizi_buruk,
				$row->no_kk,
				$row->nik,
				$row->nama,
				$row->berat_badan,
				$row->tinggi_badan,
				date('j-m-Y ',strtotime($row->tgl_timbang)),
//				'<input type="button" value="Edit" class="ubah" onclick="edit_gizi_buruk(\''.$row->id_gizi_buruk.'\')"/>'
'<button type="submit" class="btn btn-default btn-xs" title="Edit Data Gizi Buruk" onclick="edit_gizi_buruk(\''.$row->id_gizi_buruk.'\')"/><i class="fa fa-pencil"></i></button>'
			);  
		}
		//Print please
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
    
    function add(){		
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{			
			$data['page_title'] = 'Tambah GIZI BURUK';
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('gizi_buruk/v_tambah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_gizi_buruk() {
	
		$nik = $this->input->post('nik', TRUE);
		$nama = $this->input->post('nama', TRUE);
		$berat_badan = $this->input->post('berat_badan', TRUE);		
		$tinggi_badan = $this->input->post('tinggi_badan', TRUE);	
		$tgl_timbang = $this->input->post('tgl_timbang', TRUE);
		
		$this->form_validation->set_rules('nik', 'Nik', 'required');		
		$this->form_validation->set_rules('nama', 'Nama', 'required');		
		$this->form_validation->set_rules('berat_badan', 'Berat Badan', 'required');
		$this->form_validation->set_rules('tinggi_badan', 'Tinggi Badan', 'required');
		$this->form_validation->set_rules('tgl_timbang', 'Tanggal Menimbang', 'required');
		
		

		if ($this->form_validation->run() == TRUE)
		{							
			$id_penduduk = $this->m_gizi_buruk->getIdPendudukByNIK($nik);
			$result['hasil'] = $this->m_gizi_buruk->cekFIleExist($id_penduduk);
			
			if ($result['hasil'] == NULL) {				
				$data = array(
					'berat_badan' => $berat_badan,
					'tinggi_badan' => $tinggi_badan,
					'tgl_timbang' => date('Y-m-d', strtotime($tgl_timbang)),
					'id_penduduk' => $id_penduduk					
				);

				$this->m_gizi_buruk->insertGiziBuruk($data);	
				redirect('datapenduduk/c_gizi_buruk','refresh');
			}			
			else $this->add();
			/* Handle ketika nomer gizi_buruk telah digunakan */
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['hasil']		= $this->m_gizi_buruk->getGiziBurukByIdGiziBuruk($id);
			$data['penduduk']	= $this->m_gizi_buruk->getPendudukByIdGiziBuruk($id);
			$data['page_title'] = 'Edit Data GIZI BURUK';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('gizi_buruk/v_ubah', $data, TRUE);
		   
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update_gizi_buruk() {	
	
		$id_gizi_buruk = $this->input->post('id_gizi_buruk', TRUE);
		
		$berat_badan = $this->input->post('berat_badan', TRUE);		
		$tinggi_badan = $this->input->post('tinggi_badan', TRUE);	
		$tgl_timbang = $this->input->post('tgl_timbang', TRUE);
			
		$this->form_validation->set_rules('berat_badan', 'Berat Badan', 'required');
		$this->form_validation->set_rules('tinggi_badan', 'Tinggi Badan', 'required');
		$this->form_validation->set_rules('tgl_timbang', 'Tanggal Menimbang', 'required');
		
		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
					'berat_badan' => $berat_badan,
					'tinggi_badan' => $tinggi_badan,
					'tgl_timbang' => date('Y-m-d', strtotime($tgl_timbang))			
				);
	
		  	$result = $this->m_gizi_buruk->updateGiziBuruk(array('id_gizi_buruk' => $id_gizi_buruk), $data);
			
		  	redirect('datapenduduk/c_gizi_buruk','refresh');
		}
		else $this->edit($id_gizi_buruk);
    }
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_gizi_buruk->deleteGiziBuruk($id);
            $sucess++;
        }
		
        redirect('admin/c_gizi_buruk', 'refresh');
    }
	
	public function autocomplete_Nik()
    {
        $nik = $this->input->post('nik',TRUE);
        $rows = $this->m_gizi_buruk->get_NikPenduduk($nik);
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
        $rows = $this->m_gizi_buruk->get_NamaPenduduk($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->nik.' | '.$row->nama;
		}
        return json_encode($json_array);
    }
}
?>