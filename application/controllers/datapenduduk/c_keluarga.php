<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_keluarga extends CI_Controller {

	
    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_keluarga');
		$this->load->model('m_penduduk');		
		$this->load->model('m_kondisi_kehamilan');		
		$this->load->model('m_log');
		$this->load->model('m_rt');
		$this->load->helper('form'); 
        $this->load->helper('url');
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
		$query = $this->m_keluarga->get_dataForExportExcel();
		$this->excel_generator->getActiveSheet()->setCellValue('A1', 'Data Kepala Keluarga');
		$this->excel_generator->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel_generator->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel_generator->getActiveSheet()->mergeCells('A1:G1');
		$this->excel_generator->getActiveSheet()->getStyle('A1:G300')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
					)
			)
		);
		$this->excel_generator->getActiveSheet()->getStyle('A3:G80')->applyFromArray($styleArray);
		unset($styleArray);
		
		$this->excel_generator->start_at(3);
		$this->excel_generator->set_header(array('ID', 'No KK', 'Nama KK', 'Alamat', 'Dusun', 'RW', 'RT'));
		$this->excel_generator->set_column(array('id_keluarga', 'no_kk' ,'nama', 'alamat_jalan', 'nama_dusun', 'nomor_rw', 'nomor_rt'));
        $this->excel_generator->set_width(array(10, 20, 20, 20, 15, 15, 15));
        $this->excel_generator->exportTo2007('Data Kepala Keluarga');
	}
	
	function tampil_anggota_keluarga($id)
	{
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			//Atribut Keluarga
			$data['id_keluarga'] = $id;
			
			$data['page_title'] = 'Tampil Data Keluarga';
			$data['keluarga'] = $this->m_keluarga->getAnggotaKeluargaByIdKeluarga($id);
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('keluarga/v_detil', $data, TRUE);
        
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
	}

    function lists() {
		$colModel['tbl_keluarga.id_keluarga'] = array('ID',30,TRUE,'left',0);
        $colModel['no_kk'] = array('No KK',150,TRUE,'left',2);
		$colModel['tbl_penduduk.nama'] = array('Nama kepala keluarga',200,TRUE,'left',1);
		$colModel['alamat_jalan'] = array('Alamat',150,TRUE,'left',1);
        $colModel['ref_rt.nomor_rt'] = array('RT',30,TRUE,'center',1);	
		$colModel['ref_rw.nomor_rw'] = array('RW',30,TRUE,'center',1);
        $colModel['ref_dusun.nama_dusun'] = array('Dusun',80,TRUE,'center',1);		
        $colModel['aksi'] = array('AKSI',120,FALSE,'center',0);
		
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

        $grid_js = build_grid_js('flex1',site_url('datapenduduk/c_keluarga/load_data'),$colModel,'tbl_keluarga.id_keluarga','desc',$gridParams,$buttons);
		
		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA KELUARGA';		
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('keluarga/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }

    function load_data() {
        $this->load->library('flexigrid');
		$valid_fields = array('tbl_keluarga.id_keluarga','no_kk','tbl_penduduk.nama','alamat_jalan','ref_rt.nomor_rt','ref_rw.nomor_rw','ref_dusun.nama_dusun');
		//$valid_fields = array('id_keluarga');
		$this->flexigrid->validate_post('tbl_keluarga.id_keluarga','asc',$valid_fields);
		$records = $this->m_keluarga->get_keluarga_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
			$record_items = array();	
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->id_keluarga,
                $row->id_keluarga,
				$row->no_kk,
                $row->nama,
				$row->alamat_jalan,
				$row->nomor_rt, 
                $row->nomor_rw,
                $row->nama_dusun,
//				'<input type="button" value="Edit" class="ubah" onclick="edit_keluarga(\''.$row->id_keluarga.'\')"/>			
//				<input type="button" value="Tambah Anggota Keluarga" class="tambah" onclick="tambah_anggota(\''.$row->id_keluarga.'\')"/>'
				
'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_keluarga(\''.$row->id_keluarga.'\')"/><i class="fa fa-pencil"></i></button>
<button type="submit" class="btn btn-success btn-xs" title="Tambah Anggota Keluarga" onclick="tambah_anggota(\''.$row->id_keluarga.'\')"/><i class="fa fa-plus-square"></i></button>
<button type="submit" class="btn btn-info btn-xs" title="Tampil Anggota Keluarga" onclick="tampil_anggota_keluarga(\''.$row->id_keluarga.'\')"/><i class="fa fa-eye"></i></button>
<button data-toggle="modal" href="#dialog-print" type="submit" class="btn btn-primary btn-xs" title="Cetak Kartu Keluarga" onclick="cetak(\''.$row->nik.'\')"/><i class="fa fa-print"></i></button>
'
			);  
		}
		//Print please
		
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
    
    function getRt(){	
			$id_rw = $this->input->post('id_rw');
			$data['nomor_rt'] = $this->m_keluarga->get_rt_dinamic($id_rw);
			$this->load->view('keluarga/rt',$data);
	}
	function getRtEdit(){	
			$id_rw = $this->input->post('id_rw');
			$data['nomor_rt_edit'] = $this->m_keluarga->get_rt_dinamic($id_rw);
			$this->load->view('keluarga/rt_edit',$data);
	}
	
	function getRw(){	
			$id_dusun = $this->input->post('id_dusun');
			$data['nomor_rw'] = $this->m_rt->get_rw_dinamic($id_dusun);
			$this->load->view('keluarga/rw',$data);
	}
	
	function getRwEdit(){	
			$id_dusun = $this->input->post('id_dusun');
			$data['nomor_rw_edit'] = $this->m_rt->get_rw_dinamic($id_dusun);
			$this->load->view('keluarga/rw_edit',$data);
	}
	
    function add(){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$s['cek'] = $this->session->userdata('logged_in');
			
			//Atribut Keluarga
			$data['nama_dusun'] = $this->m_keluarga->get_dusun();
			//$data['nomor_rw'] = $this->m_keluarga->get_rw();
			//$data['nomor_rt'] = $this->m_keluarga->get_rt();
			$data['id_pekerjaan'] = $this->m_keluarga->get_pekerjaan();		
			$data['id_pendidikan'] = $this->m_keluarga->get_pendidikan();		
			$data['id_agama'] = $this->m_keluarga->get_agama();
			$data['id_goldar'] = $this->m_keluarga->get_goldar();
			$data['id_jen_kel'] = $this->m_keluarga->get_jen_kel();
			$data['id_kewarganegaraan'] = $this->m_keluarga->get_kewarganegaraan();
			$data['id_pekerjaan_ped'] = $this->m_keluarga->get_pekerjaan_ped();
			$data['id_kompetensi'] = $this->m_keluarga->get_kompetensi();
			$data['id_status_kawin'] = $this->m_keluarga->get_status_kawin();
			$data['id_status_penduduk'] = $this->m_keluarga->get_status_penduduk();
			$data['id_status_tinggal'] = $this->m_keluarga->get_status_tinggal();
			$data['id_difabilitas'] = $this->m_keluarga->get_difabilitas();
			$data['id_kontrasepsi'] = $this->m_keluarga->get_kontrasepsi();
			$data['id_status_keluarga'] = $this->m_keluarga->get_status_keluarga();
			
			$data['id_kelas_sosial'] = $this->m_keluarga->get_kelas_sosial();
			$data['page_title'] = 'Tambah Keluarga';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('keluarga/v_tambah', $data, TRUE);		
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	
	function getdata(){
		if($this->session->userdata('logged_in'))
		{
			$s['cek'] = $this->session->userdata('logged_in');
			
			$id = $this->input->post('nik', TRUE);
			
			$data['penduduk'] = $this->m_penduduk->getPendudukByNIK($id);
			
			$data['page_title'] = 'Tambah keluarga';
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('keluarga/v_tambah', $data, TRUE);		
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_keluarga() {
	$no_kk_cek = $this->input->post('no_kk');
	$nik_cek = $this->input->post('nik');
	$cekNoKK = $this->m_keluarga->getNoKkExist($no_kk_cek);
	$cekNik = $this->m_keluarga->getNikExist($nik_cek);
	
	if($cekNoKK == FALSE AND $cekNik == FALSE)
	{
		/* POST HANDLING tbl_penduduk */
		$is_sementara_penduduk = $this->input->post('is_sementara_penduduk', TRUE);
		if($is_sementara_penduduk == 'Y')
		{
			$nik = substr(sha1(uniqid(rand(),true)),0,10); //'generate nik -> buat method uniqid';
		}
		else
		{
			$nik = $this->input->post('nik', TRUE);
		}
		
		$nama = $this->input->post('nama', TRUE);
		$tempat_lahir = $this->input->post('tempat_lahir', TRUE);
		$tanggal_lahir = $this->input->post('tanggal_lahir', TRUE);		
		$no_telp = $this->input->post('no_telp', TRUE);
		$email = $this->input->post('email', TRUE);
		$no_kitas = $this->input->post('no_kitas', TRUE);
		$no_paspor = $this->input->post('no_paspor', TRUE);
		$id_rt = $this->input->post('id_rt', TRUE);
		$id_rw = $this->input->post('id_rw', TRUE);
		$id_dusun = $this->input->post('id_dusun', TRUE);
		$id_agama = $this->input->post('id_agama', TRUE);
		$id_goldar = $this->input->post('id_goldar', TRUE);
		$id_pendidikan = $this->input->post('id_pendidikan', TRUE);
		$id_pendidikan_terakhir = $this->input->post('id_pendidikan_terakhir', TRUE);		
		$id_pekerjaan = $this->input->post('id_pekerjaan', TRUE);
		$id_pekerjaan_ped = $this->input->post('id_pekerjaan_ped', TRUE);
		$id_jen_kel = $this->input->post('id_jen_kel', TRUE);
		$id_kewarganegaraan = $this->input->post('id_kewarganegaraan', TRUE);
		$id_kompetensi = $this->input->post('id_kompetensi', TRUE);
		$id_status_kawin = $this->input->post('id_status_kawin', TRUE);
		$id_status_penduduk = $this->input->post('id_status_penduduk', TRUE);
		$id_status_tinggal = $this->input->post('id_status_tinggal', TRUE);
		$id_difabilitas = $this->input->post('id_difabilitas', TRUE);
		$id_kontrasepsi = $this->input->post('id_kontrasepsi', TRUE);
		$is_bsm = $this->input->post('is_bsm', TRUE);
		$pendapatan_per_bulan = $this->input->post('pendapatan_per_bulan', TRUE);
		if($pendapatan_per_bulan==NULL)
		{
			$pendapatan_per_bulan = 0;
		}
		
		$newfile = $this->input->post('image-data', TRUE);
		
		define('UPLOAD_DIR', 'uploads/');
		$img = $newfile;
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = UPLOAD_DIR . $nik . '.jpg';
		$success = file_put_contents($file, $data);
		
		$path = $file;		
		
		/* END OF POST HANDLING tbl_penduduk */	
		
		/* INSERT HANDLING tbl_penduduk */	
			$dataPenduduk = array(
				'is_sementara'=>$is_sementara_penduduk,
				'nik' => $nik,
				'nama' => strtoupper($nama),
				'tempat_lahir' => strtoupper($tempat_lahir),				
				'tanggal_lahir' => date('Y-m-d', strtotime($tanggal_lahir)),
				'no_telp' => $no_telp,
				'email' => $email,			
				'no_kitas' => $no_kitas,
				'no_paspor' => $no_paspor,
				'id_rt' => $id_rt,
				'id_rw' => $id_rw,
				'id_dusun' => $id_dusun,
				'id_agama' => $id_agama,
				'id_goldar' => $id_goldar,
				'id_pendidikan' => $id_pendidikan,
				'id_pendidikan_terakhir' => $id_pendidikan_terakhir,
				'id_pekerjaan' => $id_pekerjaan,
				'id_pekerjaan_ped' => $id_pekerjaan_ped,
				'id_jen_kel' => $id_jen_kel,
				'id_kewarganegaraan' => $id_kewarganegaraan,
				'id_kompetensi' => $id_kompetensi,
				'id_status_kawin' => $id_status_kawin,
				'id_status_penduduk' => $id_status_penduduk,
				'id_status_tinggal' => $id_status_tinggal,
				'id_difabilitas' => $id_difabilitas,
				'id_kontrasepsi' => $id_kontrasepsi,
				'is_bsm' => $is_bsm,
				'foto' =>  $path,
				'pendapatan_per_bulan' =>  $pendapatan_per_bulan
				);			
			$this->m_penduduk->insertPenduduk($dataPenduduk);
			/* LOG */
			$json = json_encode($dataPenduduk);			
			$this->log('simpan_keluarga','INSERT',$json,'tbl_penduduk');
			/* END OF LOG */
		/* END OF INSERT HANDLING tbl_penduduk */	
		
		/* POST HANDLING tbl_keluarga */
		$is_sementara_keluarga = $this->input->post('is_sementara_keluarga', TRUE);
		if($is_sementara_keluarga == 'Y')
		{
			$no_kk = substr(sha1(uniqid(rand(),true)),0,10);//'generate no kk -> buat method uniqid';
		}
		else
		{
			$no_kk = $this->input->post('no_kk', TRUE);
		}
		$alamat_jalan = $this->input->post('alamat_jalan', TRUE);
		$id_rt = $this->input->post('id_rt', TRUE);
		$id_rw = $this->input->post('id_rw', TRUE);
		$id_dusun = $this->input->post('id_dusun', TRUE);
		
		$is_raskin = $this->input->post('is_raskin', TRUE);
		$is_jamkesmas = $this->input->post('is_jamkesmas', TRUE);
		$is_pkh = $this->input->post('is_pkh', TRUE);
		$id_kelas_sosial = $this->input->post('id_kelas_sosial', TRUE);
	
		$temp_id_kepala_keluarga = $this->m_keluarga->getIdKepalaKeluargaByNIK($nik);
		foreach($temp_id_kepala_keluarga as $a)
		{
			$id_kepala_keluarga = $a->id_penduduk;
		}
		
		/* END OF POST HANDLING tbl_keluarga */
		
		/* INSERT HANDLING tbl_keluarga */
		$data = array(
				'is_sementara' => $is_sementara_keluarga,
				'no_kk' => $no_kk,
				'alamat_jalan' => strtoupper($alamat_jalan),
				'id_rt' => $id_rt,
				'id_rw' => $id_rw,
				'id_dusun' => $id_dusun,
				'id_kepala_keluarga' => $id_kepala_keluarga,
				'is_raskin' => $is_raskin,
				'is_jamkesmas' => $is_jamkesmas,
				'is_pkh' => $is_pkh,
				'id_kelas_sosial' => $id_kelas_sosial
			);
			$this->m_keluarga->insertKeluarga($data);
			/* LOG */
			$json = json_encode($data);			
			$this->log('simpan_keluarga','INSERT',$json,'tbl_keluarga');
			/* END OF LOG */
		/* END OF INSERT HANDLING tbl_keluarga */
		
		/* POST HANDLING tbl_hub_kel */
		$nama_ayah=$this->input->post('nama_ayah', TRUE);
		$nama_ibu=$this->input->post('nama_ibu', TRUE);
		
		$id_penduduk = $id_kepala_keluarga;
		
		$temp_id_keluarga = $this->m_keluarga->getIdKeluargaByNoKK($no_kk);
		foreach($temp_id_keluarga as $a)
		{
			$id_keluarga = $a->id_keluarga;
		}
		$id_status_keluarga = 1;
		/* END OF POST HANDLING tbl_hub_kel */
		
		/* INSERT HANDLING tbl_hub_kel */
			$data = array(
				'nama_ayah' => strtoupper($nama_ayah),
				'nama_ibu' => strtoupper($nama_ibu),
				'id_penduduk' => $id_penduduk,
				'id_keluarga' => $id_keluarga,
				'id_status_keluarga' => $id_status_keluarga
			);
			$this->m_keluarga->insertHubKel($data);
			/* LOG */
			$json = json_encode($data);			
			$this->log('simpan_keluarga','INSERT',$json,'tbl_hub_kel');
			/* END OF LOG */
		/* END OF INSERT HANDLING tbl_hub_kel */	
		
		/* POST HANDLING tbl_kondisi_kehamilan */
			$status_hamil = $this->input->post('hamil', TRUE);
			$is_resti = $this->input->post('is_resti', TRUE);		
			$keterangan = $this->input->post('keterangan', TRUE);	
			$tgl_hpl = $this->input->post('tgl_hpl', TRUE);
		/* END OF POST HANDLING tbl_kondisi_kehamilan */
		
		/* INSERT HANDLING tbl_kondisi_kehamilan */
		if($status_hamil=='Y'){
			$result['hasil'] = $this->m_kondisi_kehamilan->cekFIleExist($id_penduduk);
				
				if ($result['hasil'] == NULL) {				
					$data = array(
						'is_resti' => $is_resti,
						'keterangan' => strtoupper($keterangan),
						'tgl_hpl' => date('Y-m-d', strtotime($tgl_hpl)),
						'id_penduduk' => $id_penduduk					
					);
					$this->m_kondisi_kehamilan->insertKondisiKehamilan($data);	
				}	
				else{
					$id_kondisi_kehamilan = $this->m_kondisi_kehamilan->getIdKondisiKehamilanByIdPenduduk($id_penduduk);
					$this->m_kondisi_kehamilan->deleteKondisiKehamilan($id_kondisi_kehamilan);
					$data = array(
						'is_resti' => $is_resti,
						'keterangan' => strtoupper($keterangan),
						'tgl_hpl' => date('Y-m-d', strtotime($tgl_hpl)),
						'id_penduduk' => $id_penduduk					
					);
					$this->m_kondisi_kehamilan->insertKondisiKehamilan($data);
				}
				/* LOG */
				$json = json_encode($data);			
				$this->log('simpan_keluarga','INSERT',$json,'tbl_kondisi_kehamilan');	
				/* END OF LOG */
		}
		/* END OF INSERT HANDLING tbl_kondisi_kehamilan */	
		
	}
	redirect('datapenduduk/c_keluarga','refresh');
    
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			//Atribut Keluarga
			$data['id_keluarga'] = $id;
			$data['nama_dusun'] = $this->m_keluarga->get_dusun();
			//$data['nomor_rw'] = $this->m_keluarga->get_rw();
			//$data['nomor_rt'] = $this->m_keluarga->get_rt();
			$data['id_pekerjaan'] = $this->m_keluarga->get_pekerjaan();		
			$data['id_pendidikan'] = $this->m_keluarga->get_pendidikan();		
			$data['id_agama'] = $this->m_keluarga->get_agama();
			$data['id_goldar'] = $this->m_keluarga->get_goldar();
			$data['id_jen_kel'] = $this->m_keluarga->get_jen_kel();
			$data['id_kewarganegaraan'] = $this->m_keluarga->get_kewarganegaraan();
			$data['id_pekerjaan_ped'] = $this->m_keluarga->get_pekerjaan_ped();
			$data['id_kompetensi'] = $this->m_keluarga->get_kompetensi();
			$data['id_status_kawin'] = $this->m_keluarga->get_status_kawin();
			$data['id_status_penduduk'] = $this->m_keluarga->get_status_penduduk();
			$data['id_status_tinggal'] = $this->m_keluarga->get_status_tinggal();
			$data['id_difabilitas'] = $this->m_keluarga->get_difabilitas();
			$data['id_kontrasepsi'] = $this->m_keluarga->get_kontrasepsi();
			$data['id_status_keluarga'] = $this->m_keluarga->get_status_keluarga();
				
			$data['keluarga'] = $this->m_keluarga->getKeluargaById($id);
			$data['hub_kel'] = $this->m_keluarga->getHubKelById($id);
			$data['penduduk'] = $this->m_keluarga->getPendudukByIdKepalaKeluarga($id);
			
			$id_rw = $data['keluarga']->id_rw;
			$data['nomor_rt'] = $this->m_keluarga->get_rt_dinamic($id_rw);
			
			$id_dusun = $data['keluarga']->id_dusun;
			$data['nomor_rw'] = $this->m_rt->get_rw_dinamic($id_dusun);
			
			$data['id_kelas_sosial'] = $this->m_keluarga->get_kelas_sosial();
			$data['page_title'] = 'Edit Data Keluarga';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('keluarga/v_ubah', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update_keluarga() {	
		$id_keluarga = $this->input->post('id_keluarga', TRUE);
		/* POST HANDLING tbl_penduduk */
		
		$is_sementara_penduduk = $this->input->post('is_sementara_penduduk', TRUE);
		if($is_sementara_penduduk == 'Y')
		{
			$nik = $this->input->post('nik', TRUE); //'generate nik -> buat method uniqid';
		}
		else
		{
			$nik = $this->input->post('nik', TRUE);
		}
		
		$nama = $this->input->post('nama', TRUE);
		$tempat_lahir = $this->input->post('tempat_lahir', TRUE);
		$tanggal_lahir = $this->input->post('tanggal_lahir', TRUE);		
		$no_telp = $this->input->post('no_telp', TRUE);
		$email = $this->input->post('email', TRUE);
		$no_kitas = $this->input->post('no_kitas', TRUE);
		$no_paspor = $this->input->post('no_paspor', TRUE);
		$id_rt = $this->input->post('id_rt', TRUE);
		$id_rw = $this->input->post('id_rw', TRUE);
		$id_dusun = $this->input->post('id_dusun', TRUE);
		$id_agama = $this->input->post('id_agama', TRUE);
		$id_goldar = $this->input->post('id_goldar', TRUE);
		$id_pendidikan = $this->input->post('id_pendidikan', TRUE);
		$id_pendidikan_terakhir = $this->input->post('id_pendidikan_terakhir', TRUE);		
		$id_pekerjaan = $this->input->post('id_pekerjaan', TRUE);
		$id_pekerjaan_ped = $this->input->post('id_pekerjaan_ped', TRUE);
		$id_jen_kel = $this->input->post('id_jen_kel', TRUE);
		$id_kewarganegaraan = $this->input->post('id_kewarganegaraan', TRUE);
		$id_kompetensi = $this->input->post('id_kompetensi', TRUE);
		$id_status_kawin = $this->input->post('id_status_kawin', TRUE);
		$id_status_penduduk = $this->input->post('id_status_penduduk', TRUE);
		$id_status_tinggal = $this->input->post('id_status_tinggal', TRUE);
		$id_difabilitas = $this->input->post('id_difabilitas', TRUE);
		$id_kontrasepsi = $this->input->post('id_kontrasepsi', TRUE);
		$is_bsm = $this->input->post('is_bsm', TRUE);
		$pendapatan_per_bulan = $this->input->post('pendapatan_per_bulan', TRUE);
		if($pendapatan_per_bulan==NULL)
		{
			$pendapatan_per_bulan = 0;
		}
		
		
		$newfile = $this->input->post('image-data', TRUE);
		
		define('UPLOAD_DIR', 'uploads/');
		$img = $newfile;
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = UPLOAD_DIR . $nik . '.jpg';
		$success = file_put_contents($file, $data);
		
		$path = $file;
		
		/* END OF POST HANDLING tbl_penduduk */	
		$id_kepala_keluarga=$this->m_keluarga->getIdKepalaKeluargaByIdKeluarga($id_keluarga);
		/* UPDATE HANDLING tbl_penduduk */	
			$dataPenduduk = array(
				'is_sementara'=>$is_sementara_penduduk,
				'nik' => $nik,
				'nama' => strtoupper($nama),
				'tempat_lahir' => strtoupper($tempat_lahir),				
				'tanggal_lahir' => date('Y-m-d', strtotime($tanggal_lahir)),
				'no_telp' => $no_telp,
				'email' => $email,			
				'no_kitas' => $no_kitas,
				'no_paspor' => $no_paspor,
				'id_rt' => $id_rt,
				'id_rw' => $id_rw,
				'id_dusun' => $id_dusun,
				'id_agama' => $id_agama,
				'id_goldar' => $id_goldar,
				'id_pendidikan' => $id_pendidikan,
				'id_pendidikan_terakhir' => $id_pendidikan_terakhir,
				'id_pekerjaan' => $id_pekerjaan,
				'id_pekerjaan_ped' => $id_pekerjaan_ped,
				'id_jen_kel' => $id_jen_kel,
				'id_kewarganegaraan' => $id_kewarganegaraan,
				'id_kompetensi' => $id_kompetensi,
				'id_status_kawin' => $id_status_kawin,
				'id_status_penduduk' => $id_status_penduduk,
				'id_status_tinggal' => $id_status_tinggal,
				'id_difabilitas' => $id_difabilitas,
				'id_kontrasepsi' => $id_kontrasepsi,
				'is_bsm' => $is_bsm,
				'foto' =>  $path,
				'pendapatan_per_bulan' =>  $pendapatan_per_bulan
				);			
				$this->m_keluarga->updatePenduduk(array('id_penduduk' => $id_kepala_keluarga), $dataPenduduk);
			/* LOG */
			$json = json_encode($dataPenduduk);			
			$jsonWhere = json_encode(array('id_penduduk' => $id_kepala_keluarga));			
			$this->log('update_keluarga','UPDATE : '.$jsonWhere,$json,'tbl_penduduk');
			/* END OF LOG */
		/* END OF UPDATE HANDLING tbl_penduduk */		
		/* POST HANDLING tbl_keluarga */
		$is_sementara_keluarga = $this->input->post('is_sementara_keluarga', TRUE);
		if($is_sementara_keluarga == 'Y')
		{
			$no_kk = $this->input->post('no_kk', TRUE);//'generate no kk -> buat method uniqid';
		}
		else
		{
			$no_kk = $this->input->post('no_kk', TRUE);
		}
		$alamat_jalan = $this->input->post('alamat_jalan', TRUE);
		$id_rt = $this->input->post('id_rt', TRUE);
		$id_rw = $this->input->post('id_rw', TRUE);
		$id_dusun = $this->input->post('id_dusun', TRUE);
		
		$is_raskin = $this->input->post('is_raskin', TRUE);
		$is_jamkesmas = $this->input->post('is_jamkesmas', TRUE);
		$is_pkh = $this->input->post('is_pkh', TRUE);	
		$id_kelas_sosial = $this->input->post('id_kelas_sosial', TRUE);
		
		$temp_id_kepala_keluarga = $this->m_keluarga->getIdKepalaKeluargaByNIK($nik);
		foreach($temp_id_kepala_keluarga as $a)
		{
			$id_kepala_keluarga = $a->id_penduduk;
		}
		
		/* END OF POST HANDLING tbl_keluarga */
		
		/* UDPATE HANDLING tbl_keluarga */
		$data = array(
				'is_sementara' => $is_sementara_keluarga,
				'no_kk' => $no_kk,
				'alamat_jalan' => strtoupper($alamat_jalan),
				'id_rt' => $id_rt,
				'id_rw' => $id_rw,
				'id_dusun' => $id_dusun,
				'id_kepala_keluarga' => $id_kepala_keluarga,
				'is_raskin' => $is_raskin,
				'is_jamkesmas' => $is_jamkesmas,
				'is_pkh' => $is_pkh,
				'id_kelas_sosial' => $id_kelas_sosial
			);
			$this->m_keluarga->updateKeluarga(array('id_keluarga' => $id_keluarga),$data);
			/* LOG */
			$json = json_encode($data);						
			$jsonWhere = json_encode(array('id_keluarga' => $id_keluarga));
			$this->log('update_keluarga','UPDATE : '.$jsonWhere,$json,'tbl_keluarga');
			/* END OF LOG */
		/* END OF UDPATE HANDLING tbl_keluarga */
		
		/* POST HANDLING tbl_hub_kel */
		$nama_ayah=$this->input->post('nama_ayah', TRUE);
		$nama_ibu=$this->input->post('nama_ibu', TRUE);
		
		$id_penduduk = $id_kepala_keluarga;
		
		$temp_id_keluarga = $this->m_keluarga->getIdKeluargaByNoKK($no_kk);
		foreach($temp_id_keluarga as $a)
		{
			$id_keluarga = $a->id_keluarga;
		}
		/* END OF POST HANDLING tbl_hub_kel */
		
		/* UPDATE HANDLING tbl_hub_kel */
			$data = array(
				'nama_ayah' => strtoupper($nama_ayah),
				'nama_ibu' => strtoupper($nama_ibu)
			);
			$this->m_keluarga->updateHubKel(array('id_penduduk' => $id_penduduk),$data);
			
			/* LOG */
			$json = json_encode($data);						
			$jsonWhere = json_encode(array('id_penduduk' => $id_penduduk));
			$this->log('update_keluarga','UPDATE : '.$jsonWhere,$json,'tbl_hub_kel');
			/* END OF LOG */
		/* END OF UPDATE HANDLING tbl_hub_kel */	
		/* POST HANDLING tbl_kondisi_kehamilan */
			$status_hamil = $this->input->post('hamil', TRUE);
			$is_resti = $this->input->post('is_resti', TRUE);		
			$keterangan = $this->input->post('keterangan', TRUE);	
			$tgl_hpl = $this->input->post('tgl_hpl', TRUE);
		/* END OF POST HANDLING tbl_kondisi_kehamilan */
		
		/* UPDATE HANDLING tbl_kondisi_kehamilan */
		if($status_hamil=='Y'){
			$result['hasil'] = $this->m_kondisi_kehamilan->cekFIleExist($id_penduduk);
				
				if ($result['hasil'] == NULL) {				
					$data = array(
						'is_resti' => $is_resti,
						'keterangan' => $keterangan,
						'tgl_hpl' => date('Y-m-d', strtotime($tgl_hpl)),
						'id_penduduk' => $id_penduduk					
					);
					$this->m_kondisi_kehamilan->insertKondisiKehamilan($data);	
				}	
				else{
					$id_kondisi_kehamilan = $this->m_kondisi_kehamilan->getIdKondisiKehamilanByIdPenduduk($id_penduduk);
					$this->m_kondisi_kehamilan->deleteKondisiKehamilan($id_kondisi_kehamilan);
					$data = array(
						'is_resti' => $is_resti,
						'keterangan' => $keterangan,
						'tgl_hpl' => date('Y-m-d', strtotime($tgl_hpl)),
						'id_penduduk' => $id_penduduk					
					);
					$this->m_kondisi_kehamilan->insertKondisiKehamilan($data);
				}
				/* LOG */
					$json = json_encode($data);						
					$this->log('update_keluarga','INSERT',$json,'tbl_kondisi_kehamilan');
					/* END OF LOG */
		}
		/* END OF UPDATE HANDLING tbl_kondisi_kehamilan */		
		
		redirect('datapenduduk/c_keluarga','refresh');
			
    }
	
	
	function delete()
    {
        $post = explode(",", $this->input->post('items'));
        array($post); $sucess=-1;
		
        foreach($post as $id){
			
            $this->m_keluarga->deletekeluarga($id);
            /* LOG */
			$json = json_encode(array('id_keluarga' => $id));			
			$this->log('delete','DELETE',$json,'tbl_keluarga');
			/* END OF LOG */
            $sucess++;
        }
        redirect('c_keluarga', 'refresh');
    }
	
    function tambah_anggota($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			//Atribut Keluarga
			$data['id_keluarga'] = $id;
			
			$data['id_pekerjaan'] = $this->m_keluarga->get_pekerjaan();		
			$data['id_pendidikan'] = $this->m_keluarga->get_pendidikan();		
			$data['id_agama'] = $this->m_keluarga->get_agama();
			$data['id_goldar'] = $this->m_keluarga->get_goldar();
			$data['id_jen_kel'] = $this->m_keluarga->get_jen_kel();
			$data['id_kewarganegaraan'] = $this->m_keluarga->get_kewarganegaraan();
			$data['id_pekerjaan_ped'] = $this->m_keluarga->get_pekerjaan_ped();
			$data['id_kompetensi'] = $this->m_keluarga->get_kompetensi();
			$data['id_status_kawin'] = $this->m_keluarga->get_status_kawin();
			$data['id_status_penduduk'] = $this->m_keluarga->get_status_penduduk();
			$data['id_status_tinggal'] = $this->m_keluarga->get_status_tinggal();
			$data['id_difabilitas'] = $this->m_keluarga->get_difabilitas();
			$data['id_kontrasepsi'] = $this->m_keluarga->get_kontrasepsi();
			$data['id_status_keluarga'] = $this->m_keluarga->get_status_keluarga();
			
			//$data['nomor_rt'] = $this->m_keluarga->getNomorRtByIdKeluarga();
			//$data['nomor_rw'] = $this->m_keluarga->get_status_keluarga();
			//$data['nama_dusun'] = $this->m_keluarga->get_status_keluarga();
			
			$data['keluarga'] = $this->m_keluarga->getKeluargaById($id);
			$data['hub_kel'] = $this->m_keluarga->getHubKelById($id);
			$data['penduduk'] = $this->m_keluarga->getPendudukByIdKepalaKeluarga($id);
			
			$data['id_kelas_sosial'] = $this->m_keluarga->get_kelas_sosial();
			$data['page_title'] = 'Tambah Anggota Keluarga';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('keluarga/v_tambah_anggota', $data, TRUE);
			
		
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function simpan_tambah_anggota() {
	
	$nik_cek = $this->input->post('nik');
	$cekNik = $this->m_keluarga->getNikExist($nik_cek);
	
	if($cekNik == FALSE)
	{
		/* POST HANDLING tbl_penduduk */
		$is_sementara_penduduk = $this->input->post('is_sementara_penduduk', TRUE);
		if($is_sementara_penduduk == 'Y')
		{
			$nik = substr(sha1(uniqid(rand(),true)),0,10); //'generate nik -> buat method uniqid';
		}
		else
		{
			$nik = $this->input->post('nik', TRUE);
		}
		
		$nama = $this->input->post('nama', TRUE);
		$tempat_lahir = $this->input->post('tempat_lahir', TRUE);
		$tanggal_lahir = $this->input->post('tanggal_lahir', TRUE);		
		$no_telp = $this->input->post('no_telp', TRUE);
		$email = $this->input->post('email', TRUE);
		$no_kitas = $this->input->post('no_kitas', TRUE);
		$no_paspor = $this->input->post('no_paspor', TRUE);
		
		$id_rt = $this->input->post('id_rt', TRUE);
		$id_rw = $this->input->post('id_rw', TRUE);
		$id_dusun = $this->input->post('id_dusun', TRUE);
		
		$id_agama = $this->input->post('id_agama', TRUE);
		$id_goldar = $this->input->post('id_goldar', TRUE);
		$id_pendidikan = $this->input->post('id_pendidikan', TRUE);
		$id_pendidikan_terakhir = $this->input->post('id_pendidikan_terakhir', TRUE);		
		$id_pekerjaan = $this->input->post('id_pekerjaan', TRUE);
		$id_pekerjaan_ped = $this->input->post('id_pekerjaan_ped', TRUE);
		$id_jen_kel = $this->input->post('id_jen_kel', TRUE);
		$id_kewarganegaraan = $this->input->post('id_kewarganegaraan', TRUE);
		$id_kompetensi = $this->input->post('id_kompetensi', TRUE);
		$id_status_kawin = $this->input->post('id_status_kawin', TRUE);
		$id_status_penduduk = $this->input->post('id_status_penduduk', TRUE);
		$id_status_tinggal = $this->input->post('id_status_tinggal', TRUE);
		$id_difabilitas = $this->input->post('id_difabilitas', TRUE);
		$id_kontrasepsi = $this->input->post('id_kontrasepsi', TRUE);
		$is_bsm = $this->input->post('is_bsm', TRUE);
		$pendapatan_per_bulan = $this->input->post('pendapatan_per_bulan', TRUE);
		if($pendapatan_per_bulan==NULL)
		{
			$pendapatan_per_bulan = 0;
		}
		$newfile = $this->input->post('image-data', TRUE);
		
		define('UPLOAD_DIR', 'uploads/');
		$img = $newfile;
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = UPLOAD_DIR . $nik . '.jpg';
		$success = file_put_contents($file, $data);
		
		$path = $file;
		
		
		/* END OF POST HANDLING tbl_penduduk */	
		
		/* INSERT HANDLING tbl_penduduk */	
			$dataPenduduk = array(
				'is_sementara'=>$is_sementara_penduduk,
				'nik' => $nik,
				'nama' => strtoupper($nama),
				'tempat_lahir' => strtoupper($tempat_lahir),				
				'tanggal_lahir' => date('Y-m-d', strtotime($tanggal_lahir)),
				'no_telp' => $no_telp,
				'email' => $email,			
				'no_kitas' => $no_kitas,
				'no_paspor' => $no_paspor,
				'id_rt' => $id_rt,
				'id_rw' => $id_rw,
				'id_dusun' => $id_dusun,
				'id_agama' => $id_agama,
				'id_goldar' => $id_goldar,
				'id_pendidikan' => $id_pendidikan,
				'id_pendidikan_terakhir' => $id_pendidikan_terakhir,
				'id_pekerjaan' => $id_pekerjaan,
				'id_pekerjaan_ped' => $id_pekerjaan_ped,
				'id_jen_kel' => $id_jen_kel,
				'id_kewarganegaraan' => $id_kewarganegaraan,
				'id_kompetensi' => $id_kompetensi,
				'id_status_kawin' => $id_status_kawin,
				'id_status_penduduk' => $id_status_penduduk,
				'id_status_tinggal' => $id_status_tinggal,
				'id_difabilitas' => $id_difabilitas,
				'id_kontrasepsi' => $id_kontrasepsi,
				'is_bsm' => $is_bsm,
				'foto' =>  $path,
				'pendapatan_per_bulan' =>  $pendapatan_per_bulan
				);			
			$this->m_penduduk->insertPenduduk($dataPenduduk);
			/* LOG */
			$json = json_encode($dataPenduduk);			
			$this->log('simpan_tambah_anggota','INSERT',$json,'tbl_penduduk');
			/* END OF LOG */
		/* END OF INSERT HANDLING tbl_penduduk */	
		
		
		
		/* POST HANDLING tbl_hub_kel */
		$nama_ayah			=	$this->input->post('nama_ayah', TRUE);
		$nama_ibu			=	$this->input->post('nama_ibu', TRUE);
		$id_status_keluarga = $this->input->post('id_status_keluarga', TRUE);
		$id_keluarga		= $this->input->post('id_keluarga', TRUE);
		
		$id_penduduk		= $this->m_keluarga->getIdPendudukByNik($nik);
		
		
		/* END OF POST HANDLING tbl_hub_kel */
		
		/* INSERT HANDLING tbl_hub_kel */
			$data = array(
				'nama_ayah' => strtoupper($nama_ayah),
				'nama_ibu' => strtoupper($nama_ibu),
				'id_penduduk' => $id_penduduk,
				'id_keluarga' => $id_keluarga,
				'id_status_keluarga' => $id_status_keluarga
			);
			$this->m_keluarga->insertHubKel($data);
			/* LOG */
			$json = json_encode($data);			
			$this->log('simpan_tambah_anggota','INSERT',$json,'tbl_hub_kel');
			/* END OF LOG */
		/* END OF INSERT HANDLING tbl_hub_kel */	
		
		/* POST HANDLING tbl_kondisi_kehamilan */
			$status_hamil = $this->input->post('hamil', TRUE);
			$is_resti = $this->input->post('is_resti', TRUE);		
			$keterangan = $this->input->post('keterangan', TRUE);	
			$tgl_hpl = $this->input->post('tgl_hpl', TRUE);
		/* END OF POST HANDLING tbl_kondisi_kehamilan */
		
		/* INSERT HANDLING tbl_kondisi_kehamilan */
		if($status_hamil=='Y'){
			$result['hasil'] = $this->m_kondisi_kehamilan->cekFIleExist($id_penduduk);
				
				if ($result['hasil'] == NULL) {				
					$data = array(
						'is_resti' => $is_resti,
						'keterangan' => strtoupper($keterangan),
						'tgl_hpl' => date('Y-m-d', strtotime($tgl_hpl)),
						'id_penduduk' => $id_penduduk					
					);
					$this->m_kondisi_kehamilan->insertKondisiKehamilan($data);	
				}	
				else{
					$id_kondisi_kehamilan = $this->m_kondisi_kehamilan->getIdKondisiKehamilanByIdPenduduk($id_penduduk);
					$this->m_kondisi_kehamilan->deleteKondisiKehamilan($id_kondisi_kehamilan);
					$data = array(
						'is_resti' => $is_resti,
						'keterangan' => strtoupper($keterangan),
						'tgl_hpl' => date('Y-m-d', strtotime($tgl_hpl)),
						'id_penduduk' => $id_penduduk					
					);
					$this->m_kondisi_kehamilan->insertKondisiKehamilan($data);
				}
				/* LOG */
			$json = json_encode($data);			
			$this->log('simpan_tambah_anggota','INSERT',$json,'tbl_kondisi_kehamilan');
			/* END OF LOG */
		}
			
        
    }
		redirect('datapenduduk/c_keluarga','refresh');
}

	
	function showRW()
	{
		$data="";
		$dusun = $this->input->post('id_dusun');
		$tempRW = $this->m_dusun->get_RW($dusun);
		$data .="<option value = ''>-- Pilih --</option>";
		foreach($tempRW as $a)
		{
			$val=$a[id_RW];
			$data .="<option value = '$val'>$a[nama_RW]</option>\n";
		}
		echo $data;
	}
	
	function showRT()
	{
		$data="";
		$dusun = $this->input->post('id_dusun');
		$rw = $this->input->post('rw');
		
		$tempRT = $this->m_dusun->get_RT($dusun,$rw);
		$data .="<option value = ''>-- Pilih --</option>";
		foreach($tempRT as $a)
		{
			$val=$a[id_RT];
			$data .="<option value = '$val'>$a[nama_RT]</option>\n";
		}
		echo $data;
		//var_dump($dusun);
	}
	function _createThumbnail($filename)
    {
        $config['image_library']    = "gd2";    
        $config['source_image']     = "./uploads/" .$filename;   
        $config['create_thumb']     = TRUE;      
        $config['maintain_ratio']   = TRUE;      
        $config['width'] = "80";      
        $config['height'] = "80";
        $this->load->library('image_lib',$config);
        if(!$this->image_lib->resize())
        {
            echo $this->image_lib->display_errors();
        }      

    }
    function log($fungsi,$kegiatan,$kegiatan_rinci,$table)
	{
		$ip_address = $this->input->ip_address();
		$user_agent = $this->input->user_agent();				
		$session['session'] = $this->session->userdata('logged_in');
		$id_pengguna		= $session['session']->id_pengguna;
	
		$newdata = array(
			   'fungsi'  => $fungsi,
			   'kegiatan'  => $kegiatan,
			   'kegiatan_rinci'  => $kegiatan_rinci,
			   'ip_address'  => $ip_address,
			   'user_agent'  => $user_agent,
			   'id_pengguna'  => $id_pengguna,
			   'table'  => $table
		   );			   
		$this->m_log->insertLog($newdata);
	}
	
	function noKkExist()
	{	
		$no_kk = $this->input->post('no_kk');
		$cek = $this->m_keluarga->getNoKkExist($no_kk);
		if($cek == TRUE)
		{	echo true;	}
		else
		{	echo false;	}
	}
	
	function nikExist()
	{
		$nik = $this->input->post('nik');
		$cek = $this->m_keluarga->getNikExist($nik);
		if($cek == TRUE)
		{	echo true;	}
		else
		{	echo false;	}
	}
}
?>