<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_surat extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_surat');
		
		$this->load->helper('url');
		
		$this->load->config('pdf_config');
        $this->load->library('fpdf');
		//$this->load->library('image_lib');
		$this->load->helper('date');
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
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
	
	
    function lists() {
    $colModel['id_surat'] = array('ID Surat',50,TRUE,'center',0);
    $colModel['nomor_surat'] = array('Nomor Surat',100,TRUE,'center',2);
    $colModel['judul_surat'] = array('Judul Surat',150,TRUE,'center',2);
    $colModel['tgl_awal'] = array('Tgl Awal Berlaku',100,TRUE,'center',2);
    $colModel['tgl_akhir'] = array('Tgl Akhir Berlaku',100,TRUE,'center',2);
    //$colModel['nomor_registrasi'] = array('No Reg',50,TRUE,'center',2);
    $colModel['keterangan'] = array('Keperluan',150,TRUE,'center',2);
    $colModel['deskripsi'] = array('Kategori Surat',150,TRUE,'center',2);
    $colModel['aksi'] = array('AKSI',96,FALSE,'center',0);
		
		//Populate flexigrid buttons..
        $buttons[] = array('Select All','check','btn');
		$buttons[] = array('separator');
        $buttons[] = array('DeSelect All','uncheck','btn');
        $buttons[] = array('separator');
		$buttons[] = array('Add','add','btn');
        $buttons[] = array('separator');
        //$buttons[] = array('Delete Selected Items','delete','btn');
        //$buttons[] = array('separator');
       		
        $gridParams = array(
            'height' => 400,
            'rp' => 15,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('surat/c_surat/load_data'),$colModel,'id_surat','desc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA SURAT';		
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('surat/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {

        $this->load->library('flexigrid');
        $valid_fields = array('id_surat','nomor_surat','judul_surat','tgl_awal','tgl_akhir','keterangan','deskripsi');

		$this->flexigrid->validate_post('id_surat','ASC',$valid_fields);
		$records = $this->m_surat->get_surat_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
                $row->id_surat,
                $row->id_surat,
                $row->nomor_surat,
                $row->judul_surat,
                date('j-m-Y',strtotime($row->tgl_awal)),
                date('j-m-Y',strtotime($row->tgl_akhir)),
                //$row->nomor_registrasi,
		$row->keterangan,
		$row->deskripsi,
		'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_surat(\''.$row->id_surat.'\')"/><i class="fa fa-pencil"></i></button>
		<button data-toggle="modal" href="#dialog-print" type="submit" class="btn btn-primary btn-xs" title="Cetak Kartu Keluarga" onclick="cetak(\''.$row->id_surat.'\')"/><i class="fa fa-print"></i></button>
		'
			);  
		}
		//Print please
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
    
    //Page header
	function Header()
	{
		$this->fpdf->Open();
        $this->fpdf->AddPage();
		
		$image = base_url().'uploads/web/logo_kabupaten.jpg';
		$this->fpdf->Image($image,10,10,25); 
		
		//Times New Roman 15
		$this->fpdf->SetFont('Times','',15);
		//pindah ke posisi ke tengah untuk membuat judul
		$this->fpdf->Cell(80);
		//judul
		$kabupaten = strtoupper($this->m_surat->getKabupaten());
		$kecamatan = strtoupper($this->m_surat->getKecamatan());
		$desa = strtoupper($this->m_surat->getDesa());
		$alamat_desa = $this->m_surat->getAlamatDesa();
		
		$this->fpdf->Cell(30,10,'PEMERINTAH KABUPATEN '.$kabupaten,0,0,'C');
		
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(80);
		$this->fpdf->Cell(30,10,'KECAMATAN '.$kecamatan,0,0,'C');
		
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(80);
		$this->fpdf->Cell(30,10,'DESA '.$desa,0,0,'C');
		
		//Times New Roman 15
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(80);
		$this->fpdf->Cell(30,10,$alamat_desa,0,0,'C');
		//pindah baris
		$this->fpdf->Ln(20);
		//buat garis horisontal
		$this->fpdf->Line(40,34,200,34);
	}
	
	//Page Content
	function Content($nik,$keterangan,$tgl_surat,$nomor_surat,$kata_penutup,$id_perangkat,$tgl_awal,$tgl_akhir,$judul_surat)
	{
			//Data Penduduk
			$NIP = $this->m_surat->getNIP($id_perangkat);
			$provinsi = $this->m_surat->getProvinsi();
			$kabupaten = $this->m_surat->getKabupaten();
			$kecamatan = $this->m_surat->getKecamatan();
			$desa = $this->m_surat->getDesa();
			
			$jabatan=$this->m_surat->getJabatanByIdPerangkat($id_perangkat);
			$nama_pamong=$this->m_surat->getNamaByIdPerangkat($id_perangkat);
			
			$penduduk = $this->m_surat->getPendudukByNIK($nik);
			$jen_kel = $this->m_surat->getJenKelById($penduduk->id_jen_kel);
			$alamat=$this->m_surat->getAlamatById($penduduk->id_penduduk);
			$agama= $this->m_surat->getAgamaById($penduduk->id_agama);
			$status= $this->m_surat->getStatusById($penduduk->id_status_kawin);
			$pendidikan=$this->m_surat->getPendidikanById($penduduk->id_pendidikan);
			$pekerjaan=$this->m_surat->getPekerjaanById($penduduk->id_pekerjaan);
			$kewarganegaraan=$this->m_surat->getKWById($penduduk->id_kewarganegaraan);
			
			
			//Jenis Surat
			$this->fpdf->SetFont('Times','U',15);
			$this->fpdf->Cell(0,0,'SURAT '.strtoupper($judul_surat),0,1,'C');
			
			
			//Nomor Surat
			$this->fpdf->SetFont('Times','',13);
			$this->fpdf->Cell(0,10,'Nomor: '.$nomor_surat,0,1,'C');
			
			//Isi Surat
			$jenis = '         Yang bertanda tangan dibawah ini '. $jabatan.' '.$desa.', Kecamatan '.$kecamatan.', Kabupaten '.$kabupaten.', Provinsi '.$provinsi.' menerangkan dengan sebenarnya bahwa:';
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(3);
			$this->fpdf->MultiCell(0,5,$jenis,'',"L");
			
			if($judul_surat=='Kelahiran')
			{
				$kelahiran= $this->m_surat->getSuratKelahiran($penduduk->id_penduduk);
				
				$this->fpdf->Ln(6);
				$this->fpdf->Cell(0,5,'Nama Bayi',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kelahiran->nama_bayi,0,1,'L');
				
				$this->fpdf->Cell(0,5,'Tempat Tgl. Lahir',0,0,'L');		
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kelahiran->tempat_lahir.', '.date('j/m/Y',strtotime($kelahiran->tgl_kelahiran)),0,1,'L');
				
				$this->fpdf->Cell(0,5,'Berat Bayi',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kelahiran->berat_bayi.' kg',0,1,'L');
				
				$this->fpdf->Cell(0,5,'Panjang Bayi',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kelahiran->panjang_bayi.' cm',0,1,'L');
				
				$this->fpdf->Cell(0,5,'Jenis Kelamin',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kelahiran->deskripsi,0,1,'L');
				
				$this->fpdf->Cell(0,5,'Nama Ayah ',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kelahiran->nama_ayah,0,1,'L');
				$this->fpdf->Cell(0,5,'Nama Ibu ',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kelahiran->nama_ibu,0,1,'L');
				
				$this->fpdf->Cell(0,5,'Lokasi Kelahiran',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kelahiran->lokasi_lahir,0,1,'L');
				$this->fpdf->Cell(0,5,'Tempat Lahir ',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kelahiran->tempat_lahir,0,1,'L');
				$this->fpdf->Cell(0,5,'Penolong',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kelahiran->penolong,0,1,'L');
				$this->fpdf->Cell(0,5,'Keperluan',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$keterangan,0,1,'L');
			}
			else if($judul_surat=='Kematian')
			{
				$kematian= $this->m_surat->getSuratKematian($penduduk->id_penduduk);
				$this->fpdf->Ln(6);
				$this->fpdf->Cell(0,5,'Nama Lengkap',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$penduduk->nama,0,1,'L');
				$this->fpdf->Cell(0,5,'NIK',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$penduduk->nik,0,1,'L');
				
				$this->fpdf->Cell(0,5,'Tanggal Kematian',0,0,'L');		
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.date('j/m/Y',strtotime($kematian->tgl_meninggal)),0,1,'L');
				
				$this->fpdf->Cell(0,5,'Penyebab Kematian',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kematian->sebab,0,1,'L');
				
				$this->fpdf->Cell(0,5,'Penentu Kematian',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kematian->penentu_kematian,0,1,'L');
				
				$this->fpdf->Cell(0,5,'Tempat Kematian',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kematian->tempat_kematian,0,1,'L');
				
				$this->fpdf->Cell(0,5,'Keperluan',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$keterangan,0,1,'L');
			}
			else
			{
				//Pindah Baris Isi Surat
				$this->fpdf->Ln(6);
				$this->fpdf->Cell(0,5,'Nama Lengkap',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$penduduk->nama,0,1,'L');
				$this->fpdf->Cell(0,5,'NIK',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$penduduk->nik,0,1,'L');
				$this->fpdf->Cell(0,5,'Tempat Tgl. Lahir',0,0,'L');		
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$penduduk->tempat_lahir.', '.date('j/m/Y',strtotime($penduduk->tanggal_lahir)),0,1,'L');
				$this->fpdf->Cell(0,5,'Jenis Kelamin',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$jen_kel,0,1,'L');
				$this->fpdf->Cell(0,5,'Alamat',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  ','',"L");
				$this->fpdf->Cell(-152);
				$this->fpdf->MultiCell(0,5,$alamat,'',"L");
				$this->fpdf->Cell(0,5,'Agama',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$agama,0,1,'L');
				$this->fpdf->Cell(0,5,'Status',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$status,0,1,'L');
				$this->fpdf->Cell(0,5,'Pendidikan',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$pendidikan,0,1,'L');
				$this->fpdf->Cell(0,5,'Pekerjaan',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$pekerjaan,0,1,'L');
				$this->fpdf->Cell(0,5,'Kewarganegaraan',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$kewarganegaraan,0,1,'L');
				$this->fpdf->Cell(0,5,'Keperluan',0,0,'L');
				$this->fpdf->Cell(-155);
				$this->fpdf->Cell(0,5,':  '.$keterangan,0,1,'L');
				
				if($tgl_awal=='0000-00-00 00:00:00' and $tgl_akhir=='0000-00-00 00:00:00')
					$this->fpdf->Cell(0,0,' ',0,1,'L');
				else
				{
					$this->fpdf->Cell(0,5,'Berlaku mulai',0,0,'L');
					$this->fpdf->Cell(-155);
					$this->fpdf->Cell(0,5,':  '.date('j/m/Y',strtotime($tgl_awal)).' '.'sampai dengan '.date('j/m/Y',strtotime($tgl_akhir)),0,1,'L');
				}
			}
			
			
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(3);
			$this->fpdf->MultiCell(0,5,$kata_penutup,'',"L");
			
			$this->fpdf->Ln(30);
			$this->fpdf->Cell(134);
			$this->fpdf->Cell(0,5,$kabupaten.','.date('j/m/Y',strtotime($tgl_awal)),0,0,'C');
			
			$this->fpdf->Ln(8);
			$this->fpdf->Cell(134);
			$this->fpdf->Cell(0,5,$jabatan.' '.$desa,0,0,'C');
			
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(134);
			$this->fpdf->Cell(0,5,'Kec. '.$kecamatan,0,0,'C');
			
			$this->fpdf->SetFont('Times','BU',11);
			$this->fpdf->Ln(30);
			$this->fpdf->Cell(134);
			$this->fpdf->Cell(0,5,$nama_pamong,0,0,'C');
			
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(134);
			$this->fpdf->Cell(0,5,'NIP. '.$NIP,0,0,'C');
	}
	
	//Page footer
	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->fpdf->SetY(-15);
		//Arial italic 9
		$this->fpdf->SetFont('Arial','I',9);
		//nomor halaman
		//$this->fpdf->Cell(0,5,'Pemerintah Gunungkidul',0,0,'R');
	}
    
    function add()
	{
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['deskripsi_kode_surat']=$this->m_surat->get_kode_surat();
			$data['nama_pamong']=$this->m_surat->get_pamong();
			$data['page_title'] = 'Tambah Surat';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('surat/v_tambah', $data, TRUE);		
			$this->load->view('utama', $data);
		}
		else
			redirect('c_login', 'refresh');
    }
	
	function simpan_surat() 
	{
		$tgl_surat = date('d/m/Y');
		$tgl_awal= $this->input->post('tgl_awal', TRUE);
		$tgl_akhir= $this->input->post('tgl_akhir', TRUE);
		$keterangan = $this->input->post('keperluan', TRUE);
		$kode_surat = $this->input->post('kode_surat', TRUE);
		$kata_penutup = $this->input->post('kata_penutup', TRUE);
		$nik = $this->input->post('nik', TRUE);	
		$id_perangkat= $this->input->post('id_perangkat', TRUE);
		$judul_surat= $this->input->post('judul_surat', TRUE); 
		 
		 $this->form_validation->set_rules('judul_surat', 'Judul Surat', 'required');
		 $this->form_validation->set_rules('kata_penutup', 'Kata Penutup', 'required');
		 $this->form_validation->set_rules('keperluan', 'Keperluan', 'required');
		 if ($this->form_validation->run() == TRUE)
		{  
			$nomor_max=$this->m_surat->getNoSuratMax(); //2
			$nomor_max_increment=$this->m_surat->getNoSuratMaxIncrement();//3
			
			$cekNoSurat = $this->m_surat->cekFIleExistByNoSurat($nomor_max_increment);			
			$id_penduduk = $this->m_surat->getIdPendudukByNIK($nik);			
			$result['cek_nik'] = $this->m_surat->cekNIKExist($nik);
			
			
			 if ($cekNoSurat == NULL && $result['cek_nik']!=NULL) 
			{ 	
				
				$supra_kode=$this->m_surat->getSupraKodeSuratById($kode_surat);
				$nomor_surat=$nomor_max_increment.'/'.$supra_kode.'/'.date('Y');
				
				$data = array
				(
					'nomor_surat' => $nomor_surat,
					'tgl_surat' => date('Y-m-d'),
					'tgl_awal' => date('Y-m-d',strtotime($tgl_awal)),
					'tgl_akhir' => date('Y-m-d',strtotime($tgl_akhir)),
					'nomor_registrasi' => $nomor_max_increment,
					'judul_surat' => $judul_surat,
					'keterangan' => $keterangan,
					'kata_penutup' => $kata_penutup,
					'kode_surat' => $kode_surat,
					'id_perangkat' => $id_perangkat,
					'id_penduduk' => $id_penduduk
				);
				
				$this->m_surat->insertSurat($data);	
				redirect('surat/c_surat','refresh');				
				//$this->cetakSurat($nik,$keterangan,$tgl_surat,$nomor_surat,$kata_penutup,$id_perangkat,$tgl_awal,$tgl_akhir,$judul_surat);
			}
			else
			{
				$this->add();
			} 		
        }
		 else $this->add(); 
    }
	function cetakById($id_surat)
	{	
		$data['surat'] = $this->m_surat->getSuratLengkap($id_surat);
		$this->Header();
		$i=0;
		foreach($data['surat'] as $rows)
		{
			$i++;
			$this->Content($rows->nik,$rows->keterangan,$rows->tgl_surat,$rows->nomor_surat,$rows->kata_penutup,$rows->id_perangkat,$rows->tgl_awal,$rows->tgl_akhir,$rows->judul_surat);
		}
		$this->Footer();
		$this->fpdf->Output();
	}
	function cetakSurat($nik,$keterangan,$tgl_surat,$nomor_surat,$kata_penutup,$id_perangkat,$tgl_awal,$tgl_akhir,$judul_surat)
	{	
		$this->Header();
		$this->Content($nik,$keterangan,$tgl_surat,$nomor_surat,$kata_penutup,$id_perangkat,$tgl_awal,$tgl_akhir,$judul_surat);
		$this->Footer();
		//$this->fpdf->Output('Surat Izin.pdf','D');
		$this->fpdf->Output();
	}
	
    function edit($id)
    {	
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['hasil'] = $this->m_surat->getSuratByIdSurat($id);
			$id_penduduk = $this->m_surat->getIdPendudukByIdSurat($id);
			$data['penduduk'] = $this->m_surat->getPendudukByIdPenduduk($id_penduduk);
			$data['json_array_nik'] = $this->autocomplete_Nik();			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			$data['nama_pamong']=$this->m_surat->get_pamong();
			$data['deskripsi_kode_surat']=$this->m_surat->get_kode_surat();		
			$data['page_title'] = 'Edit Data Surat';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('surat/v_ubah', $data, TRUE);
       
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    	}
	
	function update_surat() {
		$tgl_surat = date('d/m/Y');
		$id_surat = $this->input->post('id_surat', TRUE);
		$nomor_surat = $this->input->post('nomor_surat', TRUE);
		$tgl_awal= $this->input->post('tgl_awal', TRUE);
		$tgl_akhir= $this->input->post('tgl_akhir', TRUE);
		$keterangan = $this->input->post('keperluan', TRUE);
		$kode_surat = $this->input->post('kode_surat', TRUE);
		$kata_penutup = $this->input->post('kata_penutup', TRUE);
		$nik = $this->input->post('nik', TRUE);	
		$id_perangkat= $this->input->post('id_perangkat', TRUE);
		$judul_surat= $this->input->post('judul_surat', TRUE); 
		$nomor_registrasi= $this->input->post('nomor_registrasi', TRUE); 
		
		$this->form_validation->set_rules('judul_surat', 'Judul Surat', 'required');
		$this->form_validation->set_rules('keperluan', 'Keterangan', 'required');
		$this->form_validation->set_rules('kata_penutup', 'Kata Penutup', 'required');
		
		if ($this->form_validation->run() == TRUE){		
			$id_penduduk = $this->m_surat->getIdPendudukByNIK($nik);
			$data = array(
				'nomor_surat' => $nomor_surat,
				'kode_surat' => $kode_surat,
				'judul_surat' => $judul_surat,
				'keterangan' => $keterangan,
				'kata_penutup' => $kata_penutup,
				'tgl_surat' => date('Y-m-d'),
				'id_penduduk' => $id_penduduk,
				'tgl_awal' => date('Y-m-d',strtotime($tgl_awal)),
				'tgl_akhir' => date('Y-m-d',strtotime($tgl_akhir)),
				'nomor_registrasi' => $nomor_registrasi,
				'id_perangkat' => $id_perangkat
			);
		  	$result = $this->m_surat->updateSurat(array('id_surat' => $id_surat), $data);
		  	redirect('surat/c_surat','refresh');
		}
		else $this->edit($id_surat);
    }
	
    function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_surat->deleteSurat($id);
            $sucess++;
        }
		
        redirect('surat/c_surat', 'refresh'); 
    }
	
	public function autocomplete_Nik()
    {
        $nik = $this->input->post('nik',TRUE);
        $rows = $this->m_surat->get_NikPenduduk($nik);
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
        $rows = $this->m_surat->get_NamaPenduduk($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->nik.' | '.$row->nama;
		}
        return json_encode($json_array);
    }
}
?>