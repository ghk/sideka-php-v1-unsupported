<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_kelahiran extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->helper('string');
		$this->load->database();
		$this->load->model('m_kelahiran');
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

	//Surat
	
	//Page header
	function Header()
	{
		$this->fpdf->Open();
        	$this->fpdf->AddPage();
		
		//Logo
		/* $image_src = base_url().'assetku/img/logo_gk.jpg';
		$jpeg = imagecreatefromjpeg(base_url().'assetku/img/logo_gk.jpg');
		list($width, $height) = getimagesize(base_url().'assetku/img/logo_gk.jpg');
		$newwidth=80;
		$newheight=120;
		$out = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($out, $jpeg, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagejpeg($out, 'out.jpg', 100); */
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
			$tgl_kelahiran,
			$nama_bayi,
			$id_jen_kel,
			$berat_bayi,
			$panjang_bayi,
			$nama_ayah,
			$nama_ibu,
			$lokasi_lahir,
			$tempat_lahir,
			$penolong,
			$id_perangkat,
			$keterangan,
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
			
			$jen_kel = $this->m_surat->getJenKelById($id_jen_kel);
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
			$this->fpdf->Cell(0,5,'Nama Bayi',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$nama_bayi,0,1,'L');
			
			$this->fpdf->Cell(0,5,'Tempat Tgl. Lahir',0,0,'L');		
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$tempat_lahir.', '.date('j/m/Y',strtotime($tgl_kelahiran)),0,1,'L');
			
			$this->fpdf->Cell(0,5,'Berat Bayi',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$berat_bayi.' kg',0,1,'L');
			
			$this->fpdf->Cell(0,5,'Panjang Bayi',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$panjang_bayi.' cm',0,1,'L');
			
			$this->fpdf->Cell(0,5,'Jenis Kelamin',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$jen_kel,0,1,'L');
			
			$this->fpdf->Cell(0,5,'Nama Ayah ',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$nama_ayah,0,1,'L');
			$this->fpdf->Cell(0,5,'Nama Ibu ',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$nama_ibu,0,1,'L');
			
			$this->fpdf->Cell(0,5,'Lokasi Kelahiran',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$lokasi_lahir,0,1,'L');
			$this->fpdf->Cell(0,5,'Tempat Lahir ',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$tempat_lahir,0,1,'L');
			$this->fpdf->Cell(0,5,'Penolong',0,0,'L');
			$this->fpdf->Cell(-155);
			$this->fpdf->Cell(0,5,':  '.$penolong,0,1,'L');
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
	
	//END Surat
	
    function lists() {
        $colModel['id_kelahiran'] = array('ID',30,TRUE,'center',0);
		
        $colModel['tgl_kelahiran'] = array('Tanggal Lahir',80,TRUE,'left',2);
        $colModel['nama_bayi'] = array('Nama Bayi',120,TRUE,'left',2);
        $colModel['ref_jen_kel.deskripsi'] = array('Jenis Kelamin',80,TRUE,'center',2);
		$colModel['berat_bayi'] = array('Berat Bayi',60,TRUE,'center',2);
        $colModel['panjang_bayi'] = array('Panjang Bayi',75,TRUE,'center',2);
		$colModel['nama_ayah'] = array('Nama Ayah',100,TRUE,'left',2);
		$colModel['nama_ibu'] = array('Nama Ibu',100,TRUE,'left',2);
		$colModel['is_kembar'] = array('Kembar?',70,TRUE,'center',2);
		//$colModel['lokasi_lahir'] = array('Lokasi Lahir',85,TRUE,'left',2);
        $colModel['tempat_lahir'] = array('Tempat Lahir',80,TRUE,'left',2);
        $colModel['penolong'] = array('Penolong',110,TRUE,'left',2);
	//	$colModel['id_keluarga'] = array('ID Keluarga',70,TRUE,'left',2);
        //$colModel['nama_pelapor'] = array('Nama Pelapor',100,TRUE,'left',2);
		//$colModel['id_pelapor'] = array('Hubungan Pelapor', 100,TRUE,'left',2);
		//$colModel['id_penduduk'] = array('ID Penduduk',150,TRUE,'left',2);
		//$colModel['id_surat'] = array('ID Surat', 100,TRUE,'left',2);
		$colModel['aksi'] = array('AKSI',60,FALSE,'center',0);
		
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
            'height' => 300,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('peristiwa/c_kelahiran/load_data'),$colModel,'id_kelahiran','desc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;
		
        $data['page_title'] = 'DATA KELAHIRAN';		
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('kelahiran/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {	
		$this->load->library('flexigrid');
       $valid_fields = array(
					'id_kelahiran',
					'tgl_kelahiran',
					'nama_bayi',
					'ref_jen_kel.deskripsi',
					'berat_bayi',
					'panjang_bayi',
					'nama_ayah',
					'nama_ibu',
					'is_kembar',
					'lokasi_lahir',
					'tempat_lahir',
					'penolong',
					'id_keluarga',
					'nama_pelapor',
					'id_pelapor',
					'id_surat'
		);

		$this->flexigrid->validate_post('id_kelahiran','ASC',$valid_fields);
		$records = $this->m_kelahiran->get_kelahiran_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
		
			$record_items[] = array(
                $row->id_kelahiran,
				 $row->id_kelahiran,
				date('d-m-Y',strtotime($row->tgl_kelahiran)),
				$row->nama_bayi,
				$row->jenis_kelamin,
                $row->berat_bayi.' kg',
				$row->panjang_bayi.' cm',
				$row->nama_ayah,
				$row->nama_ibu,
				$this->ubahYesNo($row->is_kembar),
                //$row->lokasi_lahir,
                $row->tempat_lahir,
				$row->penolong,
		//		$row->id_keluarga,
                //$row->nama_pelapor,
                //$row->pelapor,
				//$row->id_penduduk,
				//$row->id_surat,
				'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_kelahiran(\''.$row->id_kelahiran.'\')"/><i class="fa fa-pencil"></i></button>
				<button data-toggle="modal" href="#dialog-print" type="submit" class="btn btn-primary btn-xs" title="Cetak Surat Kelahiran" onclick="cetak(\''.$row->id_kelahiran.'\')"/><i class="fa fa-print"></i></button>
		',
                
				
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
			$data['json_array_kk'] = $this->autocomplete_KepalaKeluarga();
			
			$data['pelapor'] = $this->m_kelahiran->get_pelapor();
			$data['jenis_kelamin'] = $this->m_kelahiran->get_jenisKelamin();
			$data['nama_pamong']=$this->m_kelahiran->get_pamong();
			
			$data['page_title'] = 'Tambah Kelahiran';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('kelahiran/v_tambah', $data, TRUE);
			$this->load->view('utama', $data);
			
		}else
			redirect('c_login', 'refresh'); 
        
    }
	
	function simpan_kelahiran() 
	{
		$id_kelahiran  = $this->input->post('id_kelahiran', TRUE);
		$tgl_kelahiran = $this->input->post('tgl_kelahiran', TRUE);
		$nama_bayi = $this->input->post('nama_bayi', TRUE);
		$id_jen_kel = $this->input->post('id_jen_kel', TRUE);
		$berat_bayi = $this->input->post('berat_bayi', TRUE);
		$panjang_bayi = $this->input->post('panjang_bayi', TRUE);
		
		$is_kembar = $this->input->post('is_kembar', TRUE);
		$lokasi_lahir = $this->input->post('lokasi_lahir', TRUE);
		$tempat_lahir = $this->input->post('tempat_lahir', TRUE);
		
		/* $nik_ayah = $this->input->post('nik_ayah', TRUE);
		$nik_ibu = $this->input->post('nik_ibu', TRUE); */
		
		$no_kk = $this->input->post('no_kk', TRUE);
		
		$nama_ayah = $this->input->post('nama_ayah', TRUE);
		$nama_ibu = $this->input->post('nama_ibu', TRUE);
		
		$id_keluarga = $this->input->post('id_keluarga', TRUE);
		
		$penolong = $this->input->post('penolong', TRUE);
		$nama_pelapor = $this->input->post('nama_pelapor', TRUE);
		$pelapor = $this->input->post('pelapor', TRUE);
		$kodesurat = $this->input->post('kodesurat', TRUE);
		$id_pelapor = $this->input->post('id_pelapor', TRUE);
		$id_penduduk = $this->input->post('id_penduduk', TRUE);
		$id_surat = $this->input->post('id_surat', TRUE);
		
		$this->form_validation->set_rules('tgl_kelahiran', 'Tanggal Kelahiran', 'required');
		$this->form_validation->set_rules('nama_bayi', 'Nama Bayi', 'required');
		$this->form_validation->set_rules('berat_bayi', 'Berat Bayi', 'required');
		$this->form_validation->set_rules('panjang_bayi', 'Panjang Bayi', 'required');
	
		if ($this->form_validation->run() == TRUE)
		 {  
			$id_keluarga = $this->m_kelahiran->getIdKeluargaByNoKK($no_kk);
			$id_penduduk_kk = $this->m_kelahiran->getIdPendudukByIdKeluarga($id_keluarga);
			
			$id_dusun=$this->m_kelahiran->getDusunByIdPenduduk($id_penduduk_kk);
			$id_rw=$this->m_kelahiran->getRwByIdPenduduk($id_penduduk_kk);
			$id_rt=$this->m_kelahiran->getRtByIdPenduduk($id_penduduk_kk); 
			
			$generate= substr(sha1(uniqid(rand(), true)), 0, 10);
			
			//STEP 1: INSERT KE TABEL PENDUDUK
			$data1 = array(
						'tanggal_lahir' => date('Y-m-d', strtotime($tgl_kelahiran)),
						'nama' => $nama_bayi,
						'id_jen_kel' => $id_jen_kel,
						'tempat_lahir' => $tempat_lahir,
						'nik' => $generate,
						'id_dusun' => $id_dusun,
						'id_rw' => $id_rw,
						'id_rt' => $id_rt,
					);
				$this->m_kelahiran->insertPenduduk($data1);
			
			$id_penduduk = $this->m_kelahiran->get_IdPendudukByNIK($generate);
			$id_kepala_keluarga = $this->m_kelahiran->get_IdKepalaKeluargaByIdKeluarga($id_keluarga);
					
			
			//STEP 2: INSERT KE TABEL HUBUNGAN KELUARGA
			$deskripsi = "Anak";
			$id_status_keluarga = $this->m_kelahiran->get_IdStatusKeluargaByDeskripsi($deskripsi);
			
			$data2 = array(
						'id_keluarga' => $id_keluarga,					
						'nama_ayah' => $nama_ayah,					
						'nama_ibu' => $nama_ibu,					
						'id_penduduk' => $id_penduduk,					
						'id_status_keluarga' => $id_status_keluarga,					
			);
			$this->m_kelahiran->insertHubKeluarga($data2);			
			
			//STEP 3: INSERT KE TABEL SURAT
			$deskripsi = "Kelahiran";
			$kode_surat = $this->m_kelahiran->get_KodeSuratByDeskripsi($deskripsi);
			$supra_kode = $this->m_kelahiran->get_SupraKodeByKodeSurat($kode_surat);
			$nomor_max_increment=$this->m_kelahiran->getNoSuratMaxIncrement();//3
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
					'nomor_registrasi' => $nomor_max_increment,
					'keterangan' => $keterangan,
					'kode_surat' => $kode_surat,
					'id_perangkat' => $id_perangkat,
					'judul_surat' => $judul_surat,
					'kata_penutup' => $kata_penutup,
					'id_penduduk' => $id_penduduk,
					'tgl_awal' => $tgl_awal
				);
				
			$this->m_kelahiran->insertSurat($data3);	
			
		 
			//STEP 4: INSERT KE TABEL KELAHIRAN
			
			$id_surat = $this->m_kelahiran->get_IdSuratByNomorSurat($nomor_surat);
			$id_penduduk = $this->m_kelahiran->get_IdPendudukByNIK($generate);
			$data4 = array(
						'id_kelahiran' => $id_kelahiran,
						'tgl_kelahiran' => date('Y-m-d', strtotime($tgl_kelahiran)),
						'nama_bayi' => $nama_bayi,
						'id_jen_kel' => $id_jen_kel,
						'berat_bayi' => $berat_bayi,
						'panjang_bayi' => $panjang_bayi,
						//'id_ayah' => $id_ayah,
						//'id_ibu' => $id_ibu,
						'id_keluarga' => $id_keluarga,
						'nama_ayah' => $nama_ayah,
						'nama_ibu' => $nama_ibu,
						'lokasi_lahir' => $lokasi_lahir,
						'tempat_lahir' => $tempat_lahir,
						'is_kembar' => $is_kembar,
						'penolong' => $penolong,
						'nama_pelapor' => $nama_pelapor,
						'id_pelapor' => $id_pelapor,
						'id_penduduk' => $id_penduduk,
						'id_surat' => $id_surat,
				);
			
			$this->m_kelahiran->insertKelahiran($data4); 
			
			
			redirect('peristiwa/c_kelahiran','refresh');
			
		 }
		else 
		{
			$this->add();   
		}
		
     
	}		
	

	function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['id_kelahiran']=$id;
			
			//$id_ayah = $this->m_kelahiran->get_IdAyahByIdKelahiran($id);
			//$id_ibu = $this->m_kelahiran->get_IdIbuByIdKelahiran($id);
			$id_surat = $this->m_kelahiran->get_IdSuratByIdKelahiran($id);
			$id_keluarga = $this->m_kelahiran->get_IdKeluargaByIdKelahiran($id);
			
			$id_perangkat = $this->m_kelahiran->get_IdPerangkatByIdSurat($id_surat);
			
			$data['hasil'] = $this->m_kelahiran->getKelahiranByIdKelahiran($id);
			
			//$data['ayah'] = $this->m_kelahiran->getPendudukByIdPenduduk($id_ayah);
			//$data['ibu'] = $this->m_kelahiran->getPendudukByIdPenduduk($id_ibu);
			$data['perangkat'] = $this->m_kelahiran->getPerangkatByIdPerangkat($id_perangkat);
			$data['kk'] = $this->m_kelahiran->getKepalaKeluargaByIdKeluarga($id_keluarga);
			
			$data['nama_pamong']=$this->m_kelahiran->get_pamong();
			$data['pelapor'] = $this->m_kelahiran->get_pelapor();
			$data['jenis_kelamin'] = $this->m_kelahiran->get_jenisKelamin();
			$data['page_title'] = 'Edit Data Kelahiran';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('kelahiran/v_ubah', $data, TRUE);
		   
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh'); 
    }
	
	function update_kelahiran() 
	{	
		$id_kelahiran  = $this->input->post('id_kelahiran', TRUE);
		$tgl_kelahiran = $this->input->post('tgl_kelahiran', TRUE);
		$nama_bayi = $this->input->post('nama_bayi', TRUE);
		$id_jen_kel = $this->input->post('id_jen_kel', TRUE);
		$berat_bayi = $this->input->post('berat_bayi', TRUE);
		$panjang_bayi = $this->input->post('panjang_bayi', TRUE);
		
		$is_kembar = $this->input->post('is_kembar', TRUE);
		$lokasi_lahir = $this->input->post('lokasi_lahir', TRUE);
		$tempat_lahir = $this->input->post('tempat_lahir', TRUE);
		
		/* $nik_ayah = $this->input->post('nik_ayah', TRUE);
		$nik_ibu = $this->input->post('nik_ibu', TRUE); */
		
		$no_kk = $this->input->post('no_kk', TRUE);
		
		$nama_ayah = $this->input->post('nama_ayah', TRUE);
		$nama_ibu = $this->input->post('nama_ibu', TRUE);
		
		$id_keluarga = $this->input->post('id_keluarga', TRUE);
		
		$penolong = $this->input->post('penolong', TRUE);
		$nama_pelapor = $this->input->post('nama_pelapor', TRUE);
		$pelapor = $this->input->post('pelapor', TRUE);
		$kodesurat = $this->input->post('kodesurat', TRUE);
		$id_pelapor = $this->input->post('id_pelapor', TRUE);
		$id_penduduk = $this->input->post('id_penduduk', TRUE);
		$id_surat = $this->input->post('id_surat', TRUE);
		
		$this->form_validation->set_rules('tgl_kelahiran', 'Tanggal Kelahiran', 'required');
		$this->form_validation->set_rules('nama_bayi', 'Nama Bayi', 'required');
		$this->form_validation->set_rules('berat_bayi', 'Berat Bayi', 'required');
		$this->form_validation->set_rules('panjang_bayi', 'Panjang Bayi', 'required');
	
		if ($this->form_validation->run() == TRUE)
		{   
			$id_keluarga = $this->m_kelahiran->get_IdKeluargaByIdKelahiran($id_kelahiran);
			$id_penduduk_kk = $this->m_kelahiran->getIdPendudukByIdKeluarga($id_keluarga);
			
			$id_dusun=$this->m_kelahiran->getDusunByIdPenduduk($id_penduduk_kk);
			$id_rw=$this->m_kelahiran->getRwByIdPenduduk($id_penduduk_kk);
			$id_rt=$this->m_kelahiran->getRtByIdPenduduk($id_penduduk_kk); 
			
			$id_penduduk = $this->m_kelahiran->get_IdPendudukByIdKelahiran($id_kelahiran);
			
			//STEP 1: UPDATE KE TABEL PENDUDUK
			$data1 = array(
						'tanggal_lahir' => date('Y-m-d', strtotime($tgl_kelahiran)),
						'nama' => $nama_bayi,
						'id_jen_kel' => $id_jen_kel,
						'tempat_lahir' => $tempat_lahir,
						'id_dusun' => $id_dusun,
						'id_rw' => $id_rw,
						'id_rt' => $id_rt,
					);
			$result = $this->m_kelahiran->updatePenduduk(array('id_penduduk' => $id_penduduk), $data1);
			
			//STEP 2: UPDATE TABEL HUB KELUARGA
			$deskripsi = "Anak";
			$id_status_keluarga = $this->m_kelahiran->get_IdStatusKeluargaByDeskripsi($deskripsi);
			
			$data2 = array(
						'id_keluarga' => $id_keluarga,					
						'nama_ayah' => $nama_ayah,					
						'nama_ibu' => $nama_ibu,					
						'id_penduduk' => $id_penduduk,					
						'id_status_keluarga' => $id_status_keluarga,					
			);
			$result = $this->m_kelahiran->updateHubKeluarga(array('id_keluarga' => $id_keluarga), $data2);
			
			//STEP 3: UPDATE TABEL SURAT
			$deskripsi = "Kelahiran";
			$kode_surat = $this->m_kelahiran->get_KodeSuratByDeskripsi($deskripsi);
			$supra_kode = $this->m_kelahiran->get_SupraKodeByKodeSurat($kode_surat);
			$nomor_max_increment=$this->m_kelahiran->getNoSuratMaxIncrement();//3
			$nomor_surat=$nomor_max_increment.'/'.$supra_kode.'/'.date('Y');
			$keterangan = 'Surat '.$deskripsi;
			$tgl_surat = date('Y-m-d');
			$tgl_awal = date('Y-m-d');
			$id_perangkat= $this->input->post('id_perangkat', TRUE);
			
			$id_surat = $this->m_kelahiran->get_IdSuratByIdKelahiran($id_kelahiran);
			$data3 = array
				(
					'nomor_surat' => $nomor_surat,
					'tgl_surat' => $tgl_surat,
					'nomor_registrasi' => $nomor_max_increment,
					'keterangan' => $keterangan,
					'kode_surat' => $kode_surat,
					'id_perangkat' => $id_perangkat,
					'tgl_awal' => $tgl_awal,
					
				);
		
			$result = $this->m_kelahiran->updateSurat(array('id_surat' => $id_surat), $data3);
			
			//STEP 4: UPDATE TABEL KELAHIRAN
			$data4 = array(
				'id_kelahiran' => $id_kelahiran,
				'id_keluarga' => $id_keluarga,
				'tgl_kelahiran' => date('Y-m-d', strtotime($tgl_kelahiran)),
				'nama_bayi' => $nama_bayi,
				'id_jen_kel' => $id_jen_kel,
				'berat_bayi' => $berat_bayi,
				'panjang_bayi' => $panjang_bayi,
				'nama_ayah' => $nama_ayah,
				'nama_ibu' => $nama_ibu,
				'lokasi_lahir' => $lokasi_lahir,
				'tempat_lahir' => $tempat_lahir,
				'is_kembar' => $is_kembar,
				'penolong' => $penolong,
				'nama_pelapor' => $nama_pelapor,
				'id_pelapor' => $id_pelapor,
				'id_surat' => $id_surat,
			);
			
		  	$result = $this->m_kelahiran->updateKelahiran(array('id_kelahiran' => $id_kelahiran), $data4);
			
		  	redirect('peristiwa/c_kelahiran','refresh');
 		  }
		else $this->edit($id_kelahiran);
    }
	
	function delete()    
	{
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
			/* $idPenduduk = $this->m->kelahiran->getIdPendudukByIdKelahiran($id);
			$this->m_kelahiran->deletePenduduk($idPenduduk); */
			$this->m_kelahiran->deleteKelahiran($id);
            $sucess++;
        }
		
        redirect('peristiwa/c_kelahiran', 'refresh');
    }
		
	
	public function autocomplete_KepalaKeluarga()
    {
        $nama = $this->input->post('nama',TRUE);
        $rows = $this->m_kelahiran->get_KepalaKeluarga($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->no_kk.' | '.$row->nama;
		}
        return json_encode($json_array);
    }
	
	function cetakById($id_kelahiran)
	{	
		$data['surat_kelahiran'] = $this->m_kelahiran->getSuratLengkap($id_kelahiran);
		$this->Header();
		$i=0;
		foreach($data['surat_kelahiran'] as $rows)
		{
			$i++;
			$this->Content(
				$rows->tgl_kelahiran,
				$rows->nama_bayi,
				$rows->id_jen_kel,
				$rows->berat_bayi,
				$rows->panjang_bayi,
				$rows->nama_ayah,
				$rows->nama_ibu,
				$rows->lokasi_lahir,
				$rows->tempat_lahir,
				$rows->penolong,
				$rows->id_perangkat,
				$rows->keterangan,
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
?>