<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_penduduk extends CI_Controller {

	
    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_penduduk');
		$this->load->model('m_user');
		$this->load->model('m_keluarga');		
		$this->load->model('m_kondisi_kehamilan');		
		$this->load->model('m_log');
        $this->load->helper('url');
        $this->load->helper('download');
        $this->load->helper('form');//f
        $this->load->helper('file');//f
		$this->load->helper('date');
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

	function download()
	{
		$name = 'ImportExcel.xls';
		$data = file_get_contents("ImportExample/ImportExcel.xls");
		
		force_download($name,$data);
	}
	public function ExportToExcel()
	{
		$query = $this->m_penduduk->get_dataForExportExcel();
		/* $this->excel_generator->getActiveSheet()->setCellValue('A1', 'Data Penduduk');
		$this->excel_generator->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel_generator->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel_generator->getActiveSheet()->mergeCells('A1:L1');
		$this->excel_generator->getActiveSheet()->getStyle('A1:AL1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 */
		 
		//SETTING FORMAT CELL
		$this->excel_generator->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('####################');
		$this->excel_generator->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$this->excel_generator->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('0###############');
		$this->excel_generator->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$this->excel_generator->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('00');
		$this->excel_generator->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('00');
		$this->excel_generator->getActiveSheet()->getStyle('Z')->getNumberFormat()->setFormatCode('####################');
	
	
		$this->excel_generator->getActiveSheet()->getStyle('A:AL')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//$this->excel_generator->getActiveSheet()->getStyle('A:AL')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		//END SETTING FORMAT CELL
		
		//BORDER BOTTOM HEADER
		$styleArray = array(
			'borders' => array(
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
					)
			)
		);
		$this->excel_generator->getActiveSheet()->getStyle('A1:AL1')->applyFromArray($styleArray);
		unset($styleArray);
		//END BORDER BOTTOM HEADER
		
		//AUTOSIZE CELL
		for ($col = 'A'; $col != 'AM'; $col++) {
		 $this->excel_generator->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		//END AUTOSIZE CELL
		
		
		$this->excel_generator->start_at(1);
		$this->excel_generator->set_header(array(
		'Nik', 'Nama Penduduk', 'Tempat Lahir', 'Tanggal Lahir (tgl/bln/thn)', 'Jenis Kelamin', 'No Telp', 'Email','No Kitas', 'No Paspor', 
		'Golongan Darah', 'RT', 'RW','Nama Dusun', 'Pendidikan', 'Pendidikan Terakhir', 'Agama', 'Status Kawin', 'Pekerjaan',
		'Pekerjaan PED', 'Kewarganegaraan', 'Kompetensi', 'Status Penduduk', 'Status Tinggal', 'Difabilitas', 'Kontrasepsi',
		'No KK', 'Alamat Jalan', 'Nama Ayah', 'Nama Ibu', 'Status Keluarga', 'is_kepala_keluarga', 'is_penduduk_sementara',
		'is_bsm', 'is_keluarga_sementara', 'is_raskin', 'is_jamkesmas', 'is_pkh', 'kelas_sosial'
		));
		
		$this->excel_generator->set_column(array(
		'nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'nama_jen_kel', 'no_telp', 'email','no_kitas', 'no_paspor',
		'nama_goldar', 'nomor_rt', 'nomor_rw', 'nama_dusun', 'nama_pendidikan', 'nama_pendidikan_terakhir', 'nama_agama', 'nama_status_kawin', 'nama_pekerjaan',
		'nama_pekerjaan_ped', 'nama_kewarganegaraan', 'nama_kompetensi', 'nama_status_penduduk', 'nama_status_tinggal', 'nama_difabilitas', 'nama_kontrasepsi',
		'no_kk', 'alamat_jalan', 'nama_ayah', 'nama_ibu', 'nama_status_keluarga', 'is_kepala_keluarga', 'is_penduduk_sementara',
		'is_bsm', 'is_keluarga_sementara', 'is_raskin', 'is_jamkesmas', 'is_pkh', 'nama_kelas_sosial'
		));
		
		/*
        	$this->excel_generator->set_width(array(
		20, 20, 20, 25, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20,20, 20, 20, 20, 20, 20, 20, 20, 20, 20,
		20, 20, 20, 20, 20, 20, 20, 20,20));
		*/

		$this->excel_generator->exportTo2003('Data Penduduk');
	}
	
    function lists() {
		$colModel['id_penduduk'] = array('ID',30,TRUE,'left',0);
        $colModel['nik'] = array('NIK',150,TRUE,'left',2); 
        $colModel['nama'] = array('Nama Penduduk',200,TRUE,'left',2);
		$colModel['tempat_lahir'] = array('Tempat Lahir', 100,TRUE,'left',2);
        $colModel['tanggal_lahir'] = array('Tanggal lahir',80,TRUE,'center',2);
		$colModel['ref_jen_kel.deskripsi'] = array('Jenis Kelamin',80,TRUE,'center',2);
		$colModel['no_telp'] = array('No Telp',85,TRUE,'center',2);	
		$colModel['ref_dusun.nama_dusun'] = array('Dusun',80,TRUE,'center',2);
		$colModel['ref_rw.nomor_rw'] = array('RW',30,TRUE,'center',2);
		$colModel['ref_rt.nomor_rt'] = array('RT',30,TRUE,'center',2);
		//$colModel['pendapatan_per_bulan'] = array('Pendapatan /bln',100,TRUE,'right',2);
		$colModel['aksi'] = array('AKSI',70,FALSE,'center',0);
       
		
		//Populate flexigrid buttons..
        $buttons[] = array('Select All','check','btn');
		//$buttons[] = array('separator');
        $buttons[] = array('DeSelect All','uncheck','btn');
       // $buttons[] = array('separator');
		//$buttons[] = array('Add','add','btn');
		$buttons[] = array('separator');
        $buttons[] = array('Delete Selected Items','delete','btn');
        $buttons[] = array('separator');
       		
        $gridParams = array(
        'height' => 400,
            'rp' => 15,
            'rpOptions' => '[10,20,30,40,50]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('datapenduduk/c_penduduk/load_data'),$colModel,'id_penduduk','desc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA PENDUDUK';		
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('penduduk/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }
    
    function ImportToExcel()//f
	{
		if($this->session->userdata('logged_in'))
		{
			$data['flashmessage'] = '1';
			$s['cek'] = $this->session->userdata('logged_in');
			$data['page_title'] = 'Import Data penduduk';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('penduduk/v_import_excel', $data, TRUE);		
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
	}
	
	function import_excel()//
	{
		$config['upload_path'] = "./temp_upload_excel/";
		$config['allowed_types'] = "xls|xlsx";
                
		$this->load->library('upload',$config);
		

		if ( ! $this->upload->do_upload())
		{
			if($this->session->userdata('logged_in'))
			{
				
				redirect('datapenduduk/c_penduduk', 'refresh');
			}else
				redirect('c_login', 'refresh');
		}
		else
		{
            $data = array('error' => false);
			$upload_data = $this->upload->data();

            $this->load->library('excel_reader');
			$this->excel_reader->setOutputEncoding('CP1251');

			$file =  $upload_data['full_path'];
			$this->excel_reader->read($file);
			error_reporting(E_ALL ^ E_NOTICE);

			// Sheet 1
			$data = $this->excel_reader->sheets[0] ;         
			for ($i = 2; $i <= $data['numRows']; $i++) 
			{
				if($data['cells'][$i][1] == '') 
				break;
				else
				{	$result['cek_nik'] = $this->m_penduduk->cekNIKExist($data['cells'][$i][1]);
					$is_kepala_keluarga = $data['cells'][$i][31];
					
					$id_jen_kel = $this->m_penduduk->getIdJenKel($data['cells'][$i][5]);
					$id_jen_kel = $this->cekNull($id_jen_kel);
					
					$id_goldar=$this->m_penduduk->getIdGolDar($data['cells'][$i][10]);
					$id_goldar = $this->cekNull($id_goldar);
					if($data['cells'][$i][12] <= 9)
					{
						$nomor_rw = '0'.$data['cells'][$i][12];
					}
					else
					{
						$nomor_rw = $data['cells'][$i][12];
					}
					$id_rw=$this->m_penduduk->getIdRw($nomor_rw);
					$id_rw = $this->cekNull($id_rw);
					
					if($data['cells'][$i][11] <= 9)
					{
						$nomor_rt = '0'.$data['cells'][$i][11];
					}
					else
					{
						$nomor_rt = $data['cells'][$i][11];
					}
					$id_rt=$this->m_penduduk->getIdRt($nomor_rt, $id_rw);
					//$id_rt=$this->m_penduduk->getIdRtByIdRw_($id_rw);
					$id_rt = $this->cekNull($id_rt);
					
					
					$id_dusun=$this->m_penduduk->getIdDusun($data['cells'][$i][13]);
					$id_dusun = $this->cekNull($id_dusun);
					
					$id_pendidikan=$this->m_penduduk->getIdPendidikan($data['cells'][$i][14]);///////
					$id_pendidikan = $this->cekNull($id_pendidikan);
					
					$id_pendidikan_terakhir=$this->m_penduduk->getIdPendidikan($data['cells'][$i][15]);////////////
					$id_pendidikan_terakhir = $this->cekNull($id_pendidikan_terakhir);
					
					$id_agama=$this->m_penduduk->getIdAgama($data['cells'][$i][16]);
					$id_agama = $this->cekNull($id_agama);
					
					$id_status_kawin=$this->m_penduduk->getIdStatusKawin($data['cells'][$i][17]);
					$id_status_kawin = $this->cekNull($id_status_kawin);
					
					$id_pekerjaan=$this->m_penduduk->getIdPekerjaan($data['cells'][$i][18]);
					$id_pekerjaan = $this->cekNull($id_pekerjaan);
					
					$id_pekerjaan_ped=$this->m_penduduk->getIdPekerjaanPED($data['cells'][$i][19]);/////////////
					$id_pekerjaan_ped = $this->cekNull($id_pekerjaan_ped);
					
					$id_kewarganegaraan=$this->m_penduduk->getIdKewarganegaraan($data['cells'][$i][20]);
					$id_kewarganegaraan = $this->cekNull($id_kewarganegaraan);
					
					$id_kompetensi=$this->m_penduduk->getIdKompetensi($data['cells'][$i][21]);//////
					$id_kompetensi = $this->cekNull($id_kompetensi);
					
					$id_status_penduduk=$this->m_penduduk->getIdStatusPenduduk($data['cells'][$i][22]);////////
					$id_status_penduduk = $this->cekNull($id_status_penduduk);
					
					$id_status_tinggal=$this->m_penduduk->getIdStatusTinggal($data['cells'][$i][23]);////////
					$id_status_tinggal = $this->cekNull($id_status_tinggal);
					
					$id_difabilitas=$this->m_penduduk->getIdDifabilitas($data['cells'][$i][24]);////////
					$id_difabilitas = $this->cekNull($id_difabilitas);
					
					$id_kontrasepsi=$this->m_penduduk->getIdKontrasepsi($data['cells'][$i][25]);////////
					$id_kontrasepsi = $this->cekNull($id_kontrasepsi);
					
					$id_status_keluarga = $this->m_penduduk->getIdStatusKeluarga($data['cells'][$i][30]);
					$id_status_keluarga = $this->cekNull($id_status_keluarga);
					
					$id_kelas_sosial = $this->m_penduduk->getIdKelasSosial($data['cells'][$i][38]);///////
					$id_kelas_sosial = $this->cekNull($id_kelas_sosial);
					
					
						
					$dateBisa = $data['cells'][$i][4];
					$dateBisa = str_replace("/","-", strval($dateBisa));
					$date = date('Y-m-d',strtotime($dateBisa));
					
					
					if($result['cek_nik']==NULL and $is_kepala_keluarga=='YA')
					{
						//Insert Data Kepala Keluarga
						$dataPenduduk = Array(
						'nik' => $data['cells'][$i][1],
						'nama' => $data['cells'][$i][2],
						'tempat_lahir' => $data['cells'][$i][3],
						//'tanggal_lahir' => PHPExcel_Style_NumberFormat::toFormattedString($data['cells'][$i][4], "YYYY/M/DD"),
						'tanggal_lahir' => $date,
						'id_jen_kel' => $id_jen_kel,
						'no_telp' => '0'.$data['cells'][$i][6],
						'email' => $data['cells'][$i][7],
						'no_kitas' => $data['cells'][$i][8],
						'no_paspor' => $data['cells'][$i][9],
						'id_goldar' => $id_goldar,
						'id_rt' => $id_rt,
						'id_rw' => $id_rw,
						'id_dusun' => $id_dusun,
						'id_pendidikan' => $id_pendidikan,
						'id_pendidikan_terakhir' => $id_pendidikan_terakhir,
						'id_agama' => $id_agama,
						'id_status_kawin' => $id_status_kawin,
						'id_pekerjaan' => $id_pekerjaan,
						'id_pekerjaan_ped' => $id_pekerjaan_ped,
						'id_kewarganegaraan' => $id_kewarganegaraan,
						'id_kompetensi' => $id_kompetensi,
						'id_status_penduduk' => $id_status_penduduk,
						'id_status_tinggal' => $id_status_tinggal,
						'id_difabilitas' => $id_difabilitas,
						'id_kontrasepsi' => $id_kontrasepsi,
						'is_sementara' => $this->cekEnum($data['cells'][$i][32]),////cekEnum
						'is_bsm' => $this->cekEnum($data['cells'][$i][33])////cekEnum
						);
						$this->m_penduduk->insertPenduduk($dataPenduduk);
						
						$id_penduduk = $this->m_penduduk->getIdPendudukByNIK($data['cells'][$i][1]);
						$dataKeluarga = Array(
							'no_kk' => $data['cells'][$i][26],
							'alamat_jalan' => $data['cells'][$i][27],
							'is_sementara' => $this->cekEnum($data['cells'][$i][34]),//cekEnum
							'is_raskin' => $this->cekEnum($data['cells'][$i][35]),//cekEnum
							'is_jamkesmas' => $this->cekEnum($data['cells'][$i][36]),//cekEnum
							'is_pkh' => $this->cekEnum($data['cells'][$i][37]),//cekEnum
							'id_kelas_sosial' => $id_kelas_sosial,
							'id_kepala_keluarga' => $id_penduduk,
							'id_rt' => $id_rt,
							'id_rw' => $id_rw,
							'id_dusun' => $id_dusun,
						);
						$this->m_penduduk->insertKeluarga($dataKeluarga);
						
						$id_keluarga = $this->m_penduduk->getIdKeluargaByNoKK($data['cells'][$i][26]);
						$dataHubKel = Array(
							'id_penduduk' => $id_penduduk,
							'nama_ayah' => $data['cells'][$i][28],
							'nama_ibu' => $data['cells'][$i][29],
							'id_keluarga' => $id_keluarga,
							'id_status_keluarga' => $id_status_keluarga
						);
						$this->m_penduduk->insertHubKel($dataHubKel);		
					}
					//Insert Anggota Keluarga
					else if($is_kepala_keluarga=='TIDAK')
					{
						$result['no_kk'] = $this->m_penduduk->cekNoKKExist($data['cells'][$i][26]);
						$dateBisa = $data['cells'][$i][4];						
						$dateBisa = str_replace("/","-", strval($dateBisa));
						$date = date('Y-m-d',strtotime($dateBisa));
						if($result['no_kk']!=NULL and $result['cek_nik']==NULL)
						{
							$dataPenduduk = Array(
							'nik' => $data['cells'][$i][1],
							'nama' => $data['cells'][$i][2],
							'tempat_lahir' => $data['cells'][$i][3],
							'tanggal_lahir' => $date,
							'id_jen_kel' => $id_jen_kel,
							'no_telp' => $data['cells'][$i][6],
							'email' => $data['cells'][$i][7],
							'no_kitas' => $data['cells'][$i][8],
							'no_paspor' => $data['cells'][$i][9],
							'id_goldar' => $id_goldar,
							'id_rt' => $id_rt,
							'id_rw' => $id_rw,
							'id_dusun' => $id_dusun,
							'id_pendidikan' => $id_pendidikan,
							'id_pendidikan_terakhir' => $id_pendidikan_terakhir,
							'id_agama' => $id_agama,
							'id_status_kawin' => $id_status_kawin,
							'id_pekerjaan' => $id_pekerjaan,
							'id_pekerjaan_ped' => $id_pekerjaan_ped,
							'id_kewarganegaraan' => $id_kewarganegaraan,
							'id_kompetensi' => $id_kompetensi,
							'id_status_penduduk' => $id_status_penduduk,
							'id_status_tinggal' => $id_status_tinggal,
							'id_difabilitas' => $id_difabilitas,
							'id_kontrasepsi' => $id_kontrasepsi,
							'is_sementara' => $this->cekEnum($data['cells'][$i][32]),////cekEnum
							'is_bsm' => $this->cekEnum($data['cells'][$i][33])////cekEnum
							);
							$this->m_penduduk->insertPenduduk($dataPenduduk);
							
							$id_penduduk = $this->m_penduduk->getIdPendudukByNIK($data['cells'][$i][1]);
							//get id keluarga berdasarkan no kk
							$id_keluarga = $this->m_penduduk->getIdKeluargaByNoKK($data['cells'][$i][26]);
							$dataHubKel = Array
							(
								'id_penduduk' => $id_penduduk,
								'nama_ayah' => $data['cells'][$i][28],
								'nama_ibu' => $data['cells'][$i][29],
								'id_keluarga' => $id_keluarga,
								'id_status_keluarga' => $id_status_keluarga
							);
							$this->m_penduduk->insertHubKel($dataHubKel);
						}
					  
					}
				}
			}          
            delete_files($upload_data['file_path']);
            redirect('datapenduduk/c_penduduk', 'refresh');
		}
			
	}

	function cekNull($parameter)
	{
		if($parameter==NULL)
		{return 0;}
		else return $parameter;
	}
	
	function cekEnum($parameter)
	{
		if($parameter=='YA')
		{
			return 'Y';
		}
		else 
		{
			return 'N';
		}
	}
					
    function load_data() {
	
        $this->load->library('flexigrid');
		
		$valid_fields = array('id_penduduk','nik','nama','tempat_lahir','tanggal_lahir','ref_jen_kel.deskripsi',
		'no_telp',
		'ref_dusun.nama_dusun','ref_rw.nomor_rw','ref_rt.nomor_rt');//Ingat Tambahkan pendapatan per bulan
		
		$this->flexigrid->validate_post('id_penduduk','DESC',$valid_fields);
		$records = $this->m_penduduk->get_penduduk_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
		
		$record_items = array();
		
		$counter=0;
		foreach ($records['records']->result() as $row)
		{
			$counter++;
			$record_items[] = array(
                $row->id_penduduk,
				$row->id_penduduk,
				$row->nik,
                $row->nama,				
				$row->tempat_lahir,
                date('j-m-Y ',strtotime($row->tanggal_lahir)),
				$row->nama_jen_kel,
				$row->no_telp,
                $row->nama_dusun,
                $row->nomor_rw,	
				$row->nomor_rt,		
				//$row->pendapatan_per_bulan,			
//				'<input type="button" value="Edit" class="ubah" onclick="edit_penduduk(\''.$row->id_penduduk.'\')"/>
//				<input type="button" value="Detil" id="detil" class="detil" onclick="detil_penduduk(\''.$row->id_penduduk.'\')"/>'
'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_penduduk(\''.$row->id_penduduk.'\')"/><i class="fa fa-pencil"></i></button>
<button type="submit" class="btn btn-info btn-xs" title="Detail Penduduk" onclick="detil_penduduk(\''.$row->id_penduduk.'\')"/><i class="fa fa-eye"></i></button>'				
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
			$s['cek'] = $this->session->userdata('logged_in');
			
			
			$data['jenis_pekerjaan'] = $this->m_penduduk->get_pekerjaan();
			$data['jenis_pendidikan'] = $this->m_penduduk->get_pendidikan();
			$data['nama_dusun'] = $this->m_penduduk->get_dusun();
			$data['noKK'] = $this->m_penduduk->get_noKK();
			
			
			$data['page_title'] = 'Tambah penduduk';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('penduduk/v_tambah', $data, TRUE);		
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }

	function simpan_penduduk() {
		
		$nik = $this->input->post('nik', TRUE);
		$nama = $this->input->post('nama', TRUE);
		$jk = $this->input->post('jenis_kelamin', TRUE);
		$tanggal = $this->input->post('tanggal', TRUE);
		$tempat = $this->input->post('tempat', TRUE);
		$rt = $this->input->post('rt', TRUE);
		$rw = $this->input->post('rw', TRUE);
		$agama = $this->input->post('agama', TRUE);
		$goldar = $this->input->post('goldar', TRUE);
		$pekerjaan = $this->input->post('id_pekerjaan', TRUE);
		$pendapatan = $this->input->post('pendapatan', TRUE);
		$status = $this->input->post('status_kawin', TRUE);
		$kw = $this->input->post('kewarganegaraan', TRUE);
		$pend = $this->input->post('id_pendidikan', TRUE);
		$dusun = $this->input->post('id_dusun', TRUE);
		$kk = $this->input->post('kk', TRUE);
		$iduser = $this->input->post('iduser', TRUE);
		
		
		$this->form_validation->set_rules('nik', 'NIK', 'required');
		$this->form_validation->set_rules('nama', 'Nama Penduduk', 'required');
		$this->form_validation->set_rules('tanggal', 'Tanggal Lahir', 'required');
		$this->form_validation->set_rules('tempat', 'Tempat Lahir', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
				'nik' => $nik,
				'nama_penduduk' => $nama,
				'jenis_kelamin' => $jk,
				'tanggal_lahir' => date('Y-m-d', strtotime($tanggal)),
				'tempat_lahir' => $tempat,
				'rt' => $rt,
				'rw' => $rw,
				'agama' => $agama,
				'golongan_darah' => $goldar,
				'id_pekerjaan' => $pekerjaan,
				'pendapatan' => $pendapatan,
				'status_kawin' => $status,
				'kewarganegaraan' => $kw,
				'id_pendidikan' => $pend,
				'kk' => $kk,
				'id_dusun' => $dusun,
				'iduser' => $iduser,
			);
	
			$this->m_penduduk->insertPenduduk($data);
			
			
			redirect('datapenduduk/c_penduduk','refresh');
        }
		else $this->add();
    }

    function edit($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
		
			$s['cek'] = $this->session->userdata('logged_in');
			$x = $s['cek']->id_pengguna;
				
			$data['temphasil'] = $this->m_user->getUserByIdPengguna($x);
			$data['hasil'] = $this->m_penduduk->getPendudukByNIK($id);
			
			$data['result'] = $this->m_penduduk->getDataPendudukByIdPenduduk($id);
			
			$data['nama_dusun'] = $this->m_keluarga->get_dusun();
			$data['nomor_rw'] = $this->m_keluarga->get_rw();
			$data['nomor_rt'] = $this->m_keluarga->get_rt();
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
			
			
			$data['page_title'] = 'Edit Data Penduduk';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('penduduk/v_ubah', $data, TRUE);
		
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
    }
	
	function update_penduduk() {	
	
		/* POST HANDLING tbl_penduduk */		
		
		$is_sementara =  $this->input->post('is_sementara', TRUE);
		$id_penduduk = $this->input->post('id_penduduk', TRUE);
		$foto = $this->input->post('foto', TRUE);
	
		$nik = $this->input->post('nik', TRUE); 		
		$nama = $this->input->post('nama', TRUE);
		$tempat_lahir = $this->input->post('tempat_lahir', TRUE);
		$tanggal_lahir = $this->input->post('tanggal_lahir', TRUE);		
		$no_telp = $this->input->post('no_telp', TRUE);
		$email = $this->input->post('email', TRUE);
		$no_kitas = $this->input->post('no_kitas', TRUE);
		$no_paspor = $this->input->post('no_paspor', TRUE);
		/* $id_rt = $this->input->post('id_rt', TRUE);
		$id_rw = $this->input->post('id_rw', TRUE);
		$id_dusun = $this->input->post('id_dusun', TRUE); 
		dianjurkan tidak digunakan, agar data di tbl_keluarga
		dan tbl_penduduk tetap sinkron
		*/
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
		
		/* UPDATE HANDLING tbl_penduduk */	
		
			$dataPenduduk = array(
				'is_sementara' => $is_sementara,
				'nik' => $nik,
				'nama' => strtoupper($nama),
				'tempat_lahir' => strtoupper($tempat_lahir),				
				'tanggal_lahir' => date('Y-m-d', strtotime($tanggal_lahir)),
				'no_telp' => $no_telp,
				'email' => $email,			
				'no_kitas' => $no_kitas,
				'no_paspor' => $no_paspor,
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
				
				
				$this->m_penduduk->updatePenduduk(array('id_penduduk' => $id_penduduk), $dataPenduduk);
			/* LOG */
				$json = json_encode($dataPenduduk);			
				$jsonWhere = json_encode(array('id_penduduk' => $id_penduduk));			
				$this->log('update_penduduk','UPDATE : '.$jsonWhere,$json,'tbl_penduduk');
				/* END OF LOG */
		/* END OF UPDATE HANDLING tbl_penduduk */	
		
		/* POST HANDLING tbl_kondisi_kehamilan */
			$status_hamil = $this->input->post('hamil', TRUE);
			$is_resti = $this->input->post('is_resti', TRUE);		
			$keterangan = $this->input->post('keterangan', TRUE);	
			$tgl_hpl = $this->input->post('tgl_hpl', TRUE);
		/* END OF POST HANDLING tbl_kondisi_kehamilan */
		
		/* UPDATE HANDLING tbl_kondisi_kehamilan */
		if($status_hamil=='Y' AND $id_jen_kel=='2'){
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
				$this->log('update_penduduk','INSERT',$json,'tbl_kondisi_kehamilan');
				/* END OF LOG */
		}
		/* END OF UPDATE HANDLING tbl_kondisi_kehamilan */
		
		redirect('datapenduduk/c_penduduk','refresh');	
    }
	
	
	function delete()
    {
        $post = explode(",", $this->input->post('items'));
        array($post); $sucess=-1;
        foreach($post as $id){
            $this->m_penduduk->deletePenduduk($id);
            /* LOG */
			$json = json_encode(array('id_penduduk' => $id));			
			$this->log('delete','DELETE',$json,'tbl_penduduk');
			/* END OF LOG */
            $sucess++;
        }
		if ($sucess > 0 ){
            //echo 'Hapus '.$sucess.' item berhasil.';
        }else{
            //echo 'Tidak ada item yang dihapus.';
        }
        redirect('c_penduduk', 'refresh');
    }
	
	function detil($id){
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
		
			$s['cek'] = $this->session->userdata('logged_in');
			$x = $s['cek']->id_pengguna;
				
			$data['temphasil'] = $this->m_user->getUserByIdPengguna($x);
			$data['hasil'] = $this->m_penduduk->getPendudukByNIK($id);
			
			$data['result'] = $this->m_penduduk->getDataPendudukByIdPenduduk($id);
			$data['keluarga'] = $this->m_penduduk->getDataHubunganKeluargaByIdPenduduk($id);
			
			$data['nama_dusun'] = $this->m_keluarga->get_dusun();
			$data['nomor_rw'] = $this->m_keluarga->get_rw();
			$data['nomor_rt'] = $this->m_keluarga->get_rt();
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
			
			
			$data['page_title'] = 'Detil Data Penduduk';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('penduduk/v_detil', $data, TRUE);
			
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
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
	
}
?>