<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_meninggal extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->helper('string');
		$this->load->database();
		$this->load->model('m_meninggal');
		$this->load->model('m_surat');
		$this->load->helper('url');
		$this->load->config('pdf_config');
        $this->load->library('fpdf');
		//$this->load->library('image_lib');
		$this->load->helper('date');
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
    }
	
	function index()
	{
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$this->lists();
		}else
			redirect('c_login', 'refresh'); 
        	
    }
	
	//FUNGSI CETAK SURAT
	//Page header
	function Header()
	{
		$this->fpdf->Open();
        $this->fpdf->AddPage();
		
		//Logo
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
	function Content(
			$tgl_meninggal,
			$nama,
			$nik,
			$sebab,
			$penentu_kematian,
			$tempat_kematian,
			$keterangan,
			$id_perangkat,
			$kode_surat,
			$tgl_surat,
			$tgl_awal,
			$nomor_surat)
	{
			//Data Kelahiran
			$NIP = $this->m_surat->getNIP($id_perangkat);
			$provinsi = $this->m_surat->getProvinsi();
			$kabupaten = $this->m_surat->getKabupaten();
			$kecamatan = $this->m_surat->getKecamatan();
			$desa = $this->m_surat->getDesa();
			
			$jabatan=$this->m_surat->getJabatanByIdPerangkat($id_perangkat);
			$nama_pamong=$this->m_surat->getNamaByIdPerangkat($id_perangkat);
			
			$jenis_surat=$this->m_surat->getDeskripsiKodeSuratById($kode_surat);
			
			
			//Jenis Surat
			$this->fpdf->SetFont('Times','U',15);
			$this->fpdf->Cell(0,0,'SURAT '.strtoupper($jenis_surat),0,1,'C');
			
			//Nomor Surat
			$this->fpdf->SetFont('Times','',13);
			$this->fpdf->Cell(0,10,'Nomor: '.$nomor_surat,0,1,'C');
			
			//Isi Surat
			$jenis = '         Yang bertanda tangan dibawah ini Kepala Desa '.$desa.', Kecamatan '.$kecamatan.', Kabupaten '.$kabupaten.', Provinsi '.$provinsi.' menerangkan dengan sebenarnya bahwa:';
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(3);
			$this->fpdf->MultiCell(0,5,$jenis,'',"L");
			
			//Pindah Baris Isi Surat
			$this->fpdf->Ln(6);
			$this->fpdf->Cell(0,5,'Nama',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$nama,0,1,'L');
			$this->fpdf->Cell(0,5,'NIK',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$nik,0,1,'L');
			
			$this->fpdf->Cell(0,5,'Tanggal Kematian',0,0,'L');		
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.date('j/m/Y',strtotime($tgl_meninggal)),0,1,'L');
			
			$this->fpdf->Cell(0,5,'Penyebab Kematian',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$sebab,0,1,'L');
			
			$this->fpdf->Cell(0,5,'Penentu Kematian',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$penentu_kematian,0,1,'L');
			
			$this->fpdf->Cell(0,5,'Tempat Kematian',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$tempat_kematian,0,1,'L');
			
			$this->fpdf->Cell(0,5,'Keperluan',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$keterangan,0,1,'L');
			
			//Akhir Surat
			$jenis = '         Demikian surat ini dibuat agar dapat digunakan sebagaimana mestinya. Atas perhatiannya kami ucapkan terima kasih.';
			$this->fpdf->SetFont('Times','',11);
			$this->fpdf->Ln(3);
			$this->fpdf->MultiCell(0,5,$jenis,'',"L");
			
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
	
	//END FUNGSI CETAK SURAT
	
	
	function lists() 
	{
        $colModel['id_meninggal'] = array('ID',20,TRUE,'left',0);
        $colModel['nama'] = array('Nama',100,TRUE,'left',2);
        $colModel['tgl_meninggal'] = array('Tanggal Meninggal',100,TRUE,'left',2);
        $colModel['sebab'] = array('Sebab',100,TRUE,'left',2);
	//	$colModel['id_penduduk'] = array('ID Penduduk',100,TRUE,'left',2);
        $colModel['penentu_kematian'] = array('Penentu Kematian',100,TRUE,'left',2);
		$colModel['tempat_kematian'] = array('Tempat Kematian',100,TRUE,'left',2);
	//	$colModel['id_pelapor'] = array('ID Pelapor', 70,TRUE,'left',2);
		$colModel['nama_pelapor'] = array('Nama Pelapor',100,TRUE,'left',2);
		$colModel['hubungan_pelapor'] = array('Hubungan Pelapor', 100,TRUE,'left',2);
	//	$colModel['id_surat'] = array('ID Surat', 70,TRUE,'left',2);
		$colModel['aksi'] = array('AKSI',60,FALSE,'center',0);
		
		//Populate flexigrid buttons..
        $buttons[] = array('Select All','check','btn');
		$buttons[] = array('separator');
        $buttons[] = array('DeSelect All','uncheck','btn');
        $buttons[] = array('separator');
		$buttons[] = array('Add','add','btn');
        $buttons[] = array('separator');
        //$buttons[] = array('Delete Selected Items','delete','btn');
       // $buttons[] = array('separator');
       		
        $gridParams = array(
            'height' => 300,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('peristiwa/c_meninggal/load_data'),$colModel,'id_meninggal','asc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;
		
        $data['page_title'] = 'DATA KEMATIAN';		
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('meninggal/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }
	
	function load_data() 
	{	
		$this->load->library('flexigrid');
		   $valid_fields = array(
			   'id_meninggal',
			   'nama',
			   'tgl_meninggal',
			   'sebab',
			   'id_penduduk',
			   'penentu_kematian',
			   'tempat_kematian',
			   'id_pelapor',
			   'nama_pelapor',
			   'hubungan_pelapor',
			   'id_surat'
			  );

		$this->flexigrid->validate_post('id_meninggal','ASC',$valid_fields);
		$records = $this->m_meninggal->get_meninggal_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
                $row->id_meninggal,
				$row->id_meninggal,
                $row->nama,
				date('d-m-Y',strtotime($row->tgl_meninggal)),
                $row->sebab,
		//		$row->id_penduduk,
				$row->penentu_kematian,
				$row->tempat_kematian,
		//		$row->id_pelapor,
                $row->nama_pelapor,
                $row->hubungan_pelapor,
		//		$row->id_surat,
				'
				<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_meninggal(\''.$row->id_meninggal.'\')"/><i class="fa fa-pencil"></i></button>
				<button data-toggle="modal" href="#dialog-print" type="submit" class="btn btn-primary btn-xs" title="Cetak Surat Kematian" onclick="cetak(\''.$row->id_meninggal.'\')"/><i class="fa fa-print"></i></button>
				'
			);  
		}
		//Print please
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
	
	function add()
	{		
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{							
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk();
			//$data['anggota_keluarga']=$this->m_meninggal->get_anggotaKeluarga($id_keluarga);
			$data['pelapor'] = $this->m_meninggal->get_pelapor(); 
			$data['nama_pamong']=$this->m_meninggal->get_pamong();
			$data['page_title'] = 'Tambah Kematian';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('meninggal/v_tambah', $data, TRUE);
			$this->load->view('utama', $data);
			
		}else
			redirect('c_login', 'refresh'); 
    }
	
	function simpan_meninggal() 
	{
		$id_meninggal  = $this->input->post('id_meninggal', TRUE);
		$nama = $this->input->post('nama', TRUE);
		$tgl_meninggal = $this->input->post('tgl_meninggal', TRUE);
		$sebab = $this->input->post('sebab', TRUE);
		$nik = $this->input->post('nik', TRUE);
		$penentu_kematian = $this->input->post('penentu_kematian', TRUE);
		$tempat_kematian = $this->input->post('tempat_kematian', TRUE);
		$nama_pelapor = $this->input->post('nama_pelapor', TRUE);
		$id_pelapor = $this->input->post('id_pelapor', TRUE);
		$ids = $this->input->post('ids', TRUE);
		$hubungan_pelapor = $this->input->post('hubungan_pelapor', TRUE);
		$id_surat = $this->input->post('id_surat', TRUE);
		$this->form_validation->set_rules('tgl_meninggal', 'Tanggal Kematian', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		
		$id_penduduk = $this->m_meninggal->getIdPendudukByNIK($nik);
		$id_keluarga = $this->m_meninggal->getIdKeluargaByIdPenduduk($id_penduduk);
		
		if($this->m_meninggal->cekKepalaKeluargaByIdPenduduk($id_penduduk) == TRUE)
		{
			if(!$this->m_meninggal->cekKesendirianByIdKeluarga($id_keluarga) == TRUE)
			{
				//1 - UPDATE KELUARGA
				$dataKeluarga = array(
						'id_kepala_keluarga' => $ids
					);
				$result = $this->m_meninggal->updateKeluarga(array('id_keluarga' => $id_keluarga), $dataKeluarga);
				//END UPDATE KELUARGA
				
				//2 - UPDATE HUBUNGAN KELUARGA
				$status_keluarga = 'Kepala Keluarga';
					$id_status_keluarga = $this->m_meninggal->getIdStatusKeluargaByDeskripsi($status_keluarga);
					$id_hub_kel = $this->m_meninggal->getIdHubKelByIdPenduduk($ids);
					$dataHubKel = array(
							'id_status_keluarga' => $id_status_keluarga
						);
					$result = $this->m_meninggal->updateHubKel(array('id_hub_kel' => $id_hub_kel), $dataHubKel);
				//END UPDATE HUBUNGAN KELUARGA
				
				//3 - UPDATE PENDUDUK
				$status_penduduk = 'Meninggal';
				$id_status_penduduk = $this->m_meninggal->getIdStatusPendudukByDeskripsi($status_penduduk);
				$dataPenduduk = array(
						'id_status_penduduk' => $id_status_penduduk
					);
				$result = $this->m_meninggal->updatePenduduk(array('id_penduduk' => $id_penduduk), $dataPenduduk);
				//END UPDATE PENDUDUK
				
				/* INSERT SURAT MENINGGAL JIKA YANG MENINGGAL KEPALA KELUARGA */
				$deskripsi = "Kematian";
				$kode_surat = $this->m_meninggal->get_KodeSuratByDeskripsi($deskripsi);
				$supra_kode = $this->m_meninggal->get_SupraKodeByKodeSurat($kode_surat);
				$nomor_max_increment=$this->m_meninggal->getNoSuratMaxIncrement();//3
				$nomor_surat=$nomor_max_increment.'/'.$supra_kode.'/'.date('Y');
				$keterangan = 'Surat '.$deskripsi;
				$tgl_surat = date('Y-m-d');
				$tgl_awal = date('Y-m-d');
				$id_perangkat= $this->input->post('id_perangkat', TRUE);
				$kata_penutup= '         Demikian surat ini dibuat agar dapat digunakan sebagaimana mestinya. Atas perhatiannya kami ucapkan terima kasih.';
				$judul_surat=$this->m_surat->getDeskripsiKodeSuratById($kode_surat);
				$dataSurat = array
					(
						'nomor_surat' => $nomor_surat,
						'tgl_surat' => $tgl_surat,
						'tgl_awal' => $tgl_awal,
						'nomor_registrasi' => $nomor_max_increment,
						'keterangan' => $keterangan,
						'kode_surat' => $kode_surat,
						'id_perangkat' => $id_perangkat,
						'judul_surat' => $judul_surat,
						'kata_penutup' => $kata_penutup,
						'id_penduduk' => $id_penduduk
					);
					
				$this->m_meninggal->insertSurat($dataSurat);	
				$id_surat = $this->m_meninggal->get_IdSuratByNomorSurat($nomor_surat);
				/* END INSERT SURAT MENINGGAL JIKA YANG MENINGGAL KEPALA KELUARGA */
				
				/* INSERT KE TBL MENINGGAL JIKA YANG MENINGGAL KEPALA KELUARGA */
					if ($this->form_validation->run() == TRUE)
					{  
						$id_penduduk = $this->m_meninggal->getIdPendudukByNIK($nik);
						$data = array(
								'id_meninggal' => $id_meninggal,
								'tgl_meninggal' => date('Y-m-d', strtotime($tgl_meninggal)),
								'nama' => $nama,
								'sebab' => $sebab,
								'id_penduduk' => $id_penduduk,
								'penentu_kematian' => $penentu_kematian,
								'tempat_kematian' => $tempat_kematian,
								'nama_pelapor' => $nama_pelapor,
								'id_pelapor' => $id_pelapor,
								'hubungan_pelapor' => $hubungan_pelapor = $this->m_meninggal->getHubunganPelaporByIdPelapor($id_pelapor),
								'id_surat' => $id_surat,
							);
						//insert kematian
						$this->m_meninggal->insertMeninggal($data); 
						
						redirect('peristiwa/c_meninggal','refresh');
					 }
					else $this->add(); 
				/* END INSERT KE TBL MENINGGAL JIKA YANG MENINGGAL KEPALA KELUARGA */
			}
			else
			{
				//3 - UPDATE PENDUDUK
				$status_penduduk = 'Meninggal';
				$id_status_penduduk = $this->m_meninggal->getIdStatusPendudukByDeskripsi($status_penduduk);
				$dataPenduduk = array(
						'id_status_penduduk' => $id_status_penduduk
					);
				$result = $this->m_meninggal->updatePenduduk(array('id_penduduk' => $id_penduduk), $dataPenduduk);
				//END UPDATE PENDUDUK
				
				/* INSERT SURAT MENINGGAL JIKA YANG MENINGGAL KEPALA KELUARGA */
				$deskripsi = "Kematian";
				$kode_surat = $this->m_meninggal->get_KodeSuratByDeskripsi($deskripsi);
				$supra_kode = $this->m_meninggal->get_SupraKodeByKodeSurat($kode_surat);
				$nomor_max_increment=$this->m_meninggal->getNoSuratMaxIncrement();//3
				$nomor_surat=$nomor_max_increment.'/'.$supra_kode.'/'.date('Y');
				$keterangan = 'Surat '.$deskripsi;
				$tgl_surat = date('Y-m-d');
				$tgl_awal = date('Y-m-d');
				$id_perangkat= $this->input->post('id_perangkat', TRUE);
				$kata_penutup= '         Demikian surat ini dibuat agar dapat digunakan sebagaimana mestinya. Atas perhatiannya kami ucapkan terima kasih.';
				$judul_surat=$this->m_surat->getDeskripsiKodeSuratById($kode_surat);
				$dataSurat = array
					(
						'nomor_surat' => $nomor_surat,
						'tgl_surat' => $tgl_surat,
						'tgl_awal' => $tgl_awal,
						'nomor_registrasi' => $nomor_max_increment,
						'keterangan' => $keterangan,
						'kode_surat' => $kode_surat,
						'id_perangkat' => $id_perangkat,
						'judul_surat' => $judul_surat,
						'kata_penutup' => $kata_penutup,
						'id_penduduk' => $id_penduduk
					);
					
				$this->m_meninggal->insertSurat($dataSurat);	
				$id_surat = $this->m_meninggal->get_IdSuratByNomorSurat($nomor_surat);
				/* END INSERT SURAT MENINGGAL JIKA YANG MENINGGAL KEPALA KELUARGA */
				
				/* INSERT KE TBL MENINGGAL JIKA YANG MENINGGAL KEPALA KELUARGA */
					if ($this->form_validation->run() == TRUE)
					{  
						$id_penduduk = $this->m_meninggal->getIdPendudukByNIK($nik);
						$data = array(
								'id_meninggal' => $id_meninggal,
								'tgl_meninggal' => date('Y-m-d', strtotime($tgl_meninggal)),
								'nama' => $nama,
								'sebab' => $sebab,
								'id_penduduk' => $id_penduduk,
								'penentu_kematian' => $penentu_kematian,
								'tempat_kematian' => $tempat_kematian,
								'nama_pelapor' => $nama_pelapor,
								'id_pelapor' => $id_pelapor,
								'hubungan_pelapor' => $hubungan_pelapor = $this->m_meninggal->getHubunganPelaporByIdPelapor($id_pelapor),
								'id_surat' => $id_surat,
							);
						//insert kematian
						$this->m_meninggal->insertMeninggal($data); 
						
						redirect('peristiwa/c_meninggal','refresh');
					 }
					else $this->add(); 
				/* END INSERT KE TBL MENINGGAL JIKA YANG MENINGGAL KEPALA KELUARGA */
			}
		}
		else
		{
			/* JIKA YANG MENINGGAL BUKAN KEPALA KELUARGA */
			if(!$this->m_meninggal->cekStatusPendudukMeninggakByIdPenduduk($id_penduduk) == TRUE)
			{
				$status_penduduk = 'Meninggal';
				$id_status_penduduk = $this->m_meninggal->getIdStatusPendudukByDeskripsi($status_penduduk);
				$dataPenduduk = array(
						'id_status_penduduk' => $id_status_penduduk
					);
				$result = $this->m_meninggal->updatePenduduk(array('id_penduduk' => $id_penduduk), $dataPenduduk);
				
				/* INSERT KE TBL SURAT JIKA YANG MENINGGAL KEPALA KELUARGA */
				$deskripsi = "Kematian";
				$kode_surat = $this->m_meninggal->get_KodeSuratByDeskripsi($deskripsi);
				$supra_kode = $this->m_meninggal->get_SupraKodeByKodeSurat($kode_surat);
				$nomor_max_increment=$this->m_meninggal->getNoSuratMaxIncrement();//3
				$nomor_surat=$nomor_max_increment.'/'.$supra_kode.'/'.date('Y');
				$keterangan = 'Surat '.$deskripsi;
				$tgl_surat = date('Y-m-d');
				$tgl_awal = date('Y-m-d');
				$id_perangkat= $this->input->post('id_perangkat', TRUE);
				$kata_penutup= '         Demikian surat ini dibuat agar dapat digunakan sebagaimana mestinya. Atas perhatiannya kami ucapkan terima kasih.';
				$judul_surat=$this->m_surat->getDeskripsiKodeSuratById($kode_surat);
				$data3 = array
					(
						'nomor_surat' => $nomor_surat,
						'tgl_surat' => $tgl_surat,
						'tgl_awal' => $tgl_awal,
						'nomor_registrasi' => $nomor_max_increment,
						'keterangan' => $keterangan,
						'kode_surat' => $kode_surat,
						'id_perangkat' => $id_perangkat,
						'judul_surat' => $judul_surat,
						'kata_penutup' => $kata_penutup,
						'id_penduduk' => $id_penduduk
					);
					
				$this->m_meninggal->insertSurat($data3);	
				$id_surat = $this->m_meninggal->get_IdSuratByNomorSurat($nomor_surat);
				/* END INSERT KE TBL SURAT JIKA YANG MENINGGAL KEPALA KELUARGA */
				
				/* INSERT KE TBL MENINGGAL JIKA YANG MENINGGAL KEPALA KELUARGA */
					if ($this->form_validation->run() == TRUE)
					{  
						$id_penduduk = $this->m_meninggal->getIdPendudukByNIK($nik);
						$data = array(
								'id_meninggal' => $id_meninggal,
								'tgl_meninggal' => date('Y-m-d', strtotime($tgl_meninggal)),
								'nama' => $nama,
								'sebab' => $sebab,
								'id_penduduk' => $id_penduduk,
								'penentu_kematian' => $penentu_kematian,
								'tempat_kematian' => $tempat_kematian,
								'nama_pelapor' => $nama_pelapor,
								'id_pelapor' => $id_pelapor,
								'hubungan_pelapor' => $hubungan_pelapor = $this->m_meninggal->getHubunganPelaporByIdPelapor($id_pelapor),
								'id_surat' => $id_surat,
							);
						
						//insert kematian
						$this->m_meninggal->insertMeninggal($data); 

						
						//delete di tabel meninggal sesuai nomer nik
						//$this->m_meninggal->deletePenduduk($id_penduduk);
						
						
						redirect('peristiwa/c_meninggal','refresh');
					 }
					else $this->add(); 
					/* END INSERT KE TBL MENINGGAL JIKA YANG MENINGGAL KEPALA KELUARGA */
			}
			/*END JIKA YANG MENINGGAL BUKAN KEPALA KELUARGA */
		}
	}	

	function ganti_kk($id_keluarga)
	{		
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{					
			$data['id_keluarga'] = $id_keluarga;
			$data['anggota_keluarga']=$this->m_meninggal->get_anggotaKeluarga($id_keluarga);
			$data['page_title'] = 'Ganti Kepala Keluarga';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('meninggal/v_ganti_kk', $data, TRUE);
			$this->load->view('utama', $data);
			
		}else
			redirect('c_login', 'refresh'); 
    }
	
	function ganti_kepala_keluarga() 
	{
		$id_penduduk  = $this->input->post('id_penduduk', TRUE);
		$id_keluarga  = $this->input->post('id_keluarga', TRUE);
		if ($this->form_validation->run() == TRUE)
		{  
			//1 - UPDATE KELUARGA
			$dataKeluarga = array(
					'id_kepala_keluarga' => $id_penduduk,
				);
			$result = $this->m_meninggal->updateKeluarga(array('id_keluarga' => $id_keluarga), $dataKeluarga);
			//END UPDATE KELUARGA
			
			//2 - UPDATE HUBUNGAN KELUARGA
			$id_hub_kel = $this->m_meninggal->getIdHubKelByIdPenduduk($id_penduduk);
			$dataHubKel = array(
					'id_penduduk' => $id_penduduk,
				);
			$result = $this->m_meninggal->updateKeluarga(array('id_hub_kel' => $id_hub_kel), $dataHubKel);
			//END UPDATE HUBUNGAN KELUARGA
			
			//3 - UPDATE PENDUDUK
			$status_penduduk = 'Meninggal';
			$id_status_penduduk = $this->m_meninggal->getIdStatusPendudukByDeskripsi($status_penduduk);
			$dataP = array(
					'id_status_penduduk' => $id_status_penduduk,
				);
			$result = $this->m_meninggal->updatePenduduk(array('id_penduduk' => $id_penduduk), $dataP);
			//END UPDATE PENDUDUK
			
			redirect('peristiwa/c_meninggal','refresh');
		 }
		else $this->ganti_kk($id_keluarga); 
	}
	
	function edit($id)
	{	
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['id_meninggal'] = $id;
			$id_penduduk = $this->m_meninggal->getIdPendudukByIdMeninggal($id);
			$id_surat = $this->m_meninggal->get_IdSuratByIdMeninggal($id);
			
			$id_perangkat = $this->m_meninggal->get_IdPerangkatByIdSurat($id_surat);
			
			$data['hasil'] = $this->m_meninggal->getMeninggalByIdMeninggal($id);
			$data['pelapor'] = $this->m_meninggal->get_pelapor();
			$data['penduduk'] = $this->m_meninggal->getPendudukByIdPenduduk($id_penduduk);
			$data['nama_pamong']=$this->m_meninggal->get_pamong();
			$data['perangkat'] = $this->m_meninggal->getPerangkatByIdPerangkat($id_perangkat);
			$data['page_title'] = 'Edit Data Kematian';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('meninggal/v_ubah', $data, TRUE);
		   
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh'); 
	}
	
	function update_meninggal() 
	{
		$id_meninggal  = $this->input->post('id_meninggal', TRUE);
		$nama = $this->input->post('nama', TRUE);
		$tgl_meninggal = $this->input->post('tgl_meninggal', TRUE);
		$sebab = $this->input->post('sebab', TRUE);
		$nik = $this->input->post('nik', TRUE);
		$penentu_kematian = $this->input->post('penentu_kematian', TRUE);
		$tempat_kematian = $this->input->post('tempat_kematian', TRUE);
		$nama_pelapor = $this->input->post('nama_pelapor', TRUE);
		$id_pelapor = $this->input->post('id_pelapor', TRUE);
		$hubungan_pelapor = $this->input->post('hubungan_pelapor', TRUE);
		$id_surat = $this->input->post('id_surat', TRUE);
		
		/* $this->form_validation->set_rules('tgl_meninggal', 'Tanggal Kematian', 'required');
		//$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('sebab', 'Sebab Kematian', 'required');
		//$this->form_validation->set_rules('id_penduduk', 'id_penduduk', 'required');
		$this->form_validation->set_rules('penentu_kematian', 'Penentu Kematian', 'required');
		$this->form_validation->set_rules('tempat_kematian', 'Tempat Kematian', 'required');
		$this->form_validation->set_rules('nama_pelapor', 'Nama Pelapor Kelahiran', 'required'); */
		

		/* if ($this->form_validation->run() == TRUE)
		{ */

			$deskripsi = "Kematian";
			$kode_surat = $this->m_meninggal->get_KodeSuratByDeskripsi($deskripsi);
			$supra_kode = $this->m_meninggal->get_SupraKodeByKodeSurat($kode_surat);
			$nomor_max_increment=$this->m_meninggal->getNoSuratMaxIncrement();//3
			$nomor_surat=$nomor_max_increment.'/'.$supra_kode.'/'.date('Y');
			$keterangan = 'Surat '.$deskripsi;
			$tgl_surat = date('Y-m-d');
			$tgl_awal = date('Y-m-d');
			$id_perangkat = '1';
			
			$id_surat = $this->m_meninggal->get_IdSuratByIdMeninggal($id_meninggal);
			$data1 = array
			(
					'nomor_surat' => $nomor_surat,
					'tgl_surat' => $tgl_meninggal,
					'tgl_awal' => $tgl_awal,
					'nomor_registrasi' => $nomor_max_increment,
					'keterangan' => $keterangan,
					'kode_surat' => $kode_surat,
					'id_perangkat' => $id_perangkat,
			);
			
			$result = $this->m_meninggal->updateSurat(array('id_surat' => $id_surat), $data1);
			$id_penduduk = $this->m_meninggal->getIdPendudukByNIK($nik);
			$data2 = array(
				'nama' => $nama,
				'tgl_meninggal' => date('Y-m-d', strtotime($tgl_meninggal)),
				'sebab' => $sebab,
				'id_penduduk' => $id_penduduk,
				'penentu_kematian' => $penentu_kematian,
				'tempat_kematian' => $tempat_kematian,
				'nama_pelapor' => $nama_pelapor,
				'id_pelapor' => $id_pelapor,
				'hubungan_pelapor' => $hubungan_pelapor = $this->m_meninggal->getHubunganPelaporByIdPelapor($id_pelapor),
				'id_surat' =>  $id_surat,
			);
	
		  	$result = $this->m_meninggal->updateMeninggal(array('id_meninggal' => $id_meninggal), $data2);
			
			$status_penduduk = 'Meninggal';
			$id_status_penduduk = $this->m_meninggal->getIdStatusPendudukByDeskripsi($status_penduduk);
			
			$dataP = array(
					'id_status_penduduk' => $id_status_penduduk,
				);
			$result = $this->m_meninggal->updatePenduduk(array('id_penduduk' => $id_penduduk), $dataP);
			
			
			
		  	redirect('peristiwa/c_meninggal','refresh');

		 /*  }
		else $this->edit($id_meninggal);   */		
	} 
	
	function delete()    
	{
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
			$this->m_meninggal->deleteMeninggal($id);
            $sucess++;
        }
		
        redirect('peristiwa/c_meninggal', 'refresh');
    }
		
	public function autocomplete_NamaPenduduk()
    {
        $nama = $this->input->post('nama',TRUE);
        $rows = $this->m_meninggal->get_NamaPenduduk($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->nik.' | '.$row->nama;
		}
        return json_encode($json_array);
    }
	
	function cek_kepala_keluarga()
	{	
		$nik = $this->input->post('nik');
		$id_penduduk = $this->m_meninggal->getIdPendudukByNIK($nik);
		$id_keluarga = $this->m_meninggal->getIdKeluargaByIdPenduduk($id_penduduk);
		
			/* 1 - CEK JIKA KEPALA KELUARGA */
			if($this->m_meninggal->cekKepalaKeluargaByIdPenduduk($id_penduduk) == TRUE)
			{
				/* 2- CEK JIKA DALAM KELUARGA HANYA ADA 1 ANGGOTA KELUARGA */
				if(!$this->m_meninggal->cekKesendirianByIdKeluarga($id_keluarga) == TRUE)
				{
					echo true;
				}
				// 2 - END
			}
			/* 1 -  END */
			else
			{
				echo false;
			}
	}	
	
	function get_anggotaKeluarga()
	{	
			$nik = $this->input->post('niklala');
			$id_penduduk = $this->m_meninggal->getIdPendudukByNIK($nik);
			$id_keluarga = $this->m_meninggal->getIdKeluargaByIdPenduduk($id_penduduk);
			
			$data['anggota_kel'] = $this->m_meninggal->getAnggotaKeluargaById($id_keluarga, $id_penduduk);
			$this->load->view('meninggal/v_ganti_kk',$data);
	}
	
	function cetakById($id_meninggal)
	{	
		$data['surat_kematian'] = $this->m_meninggal->getSuratLengkap($id_meninggal);
		$this->Header();
		$i=0;
		foreach($data['surat_kematian'] as $rows)
		{
			$i++;
			$this->Content(
				$rows->tgl_meninggal,
				$rows->nama,
				$rows->nik,
				$rows->sebab,
				$rows->penentu_kematian,
				$rows->tempat_kematian,
				$rows->keterangan,
				$rows->id_perangkat,
				$rows->kode_surat,
				$rows->tgl_surat,
				$rows->tgl_awal,
				$rows->nomor_surat
			);
		}
		$this->Footer();
		$this->fpdf->Output();
	}

	
}