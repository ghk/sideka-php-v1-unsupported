<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_pindah_keluar extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->helper('string');
		$this->load->database();
		$this->load->model('m_pindah_keluar');
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
	
	function lists() {
        $colModel['id_pindah_keluar'] = array('ID',30,TRUE,'left',0);
		$colModel['aksi'] = array('Aksi',40,FALSE,'center',0);
        $colModel['tgl_pindah_keluar'] = array('Tanggal Pindah',100,TRUE,'left',2);
        $colModel['no_kk'] = array('No KK',120,TRUE,'left',2);
        $colModel['nama'] = array('Nama Kepala Keluarga',150,TRUE,'left',2);
        $colModel['alamat_jalan'] = array('Alamat',110,TRUE,'left',2);
        $colModel['nama_provinsi'] = array('Provinsi',150,TRUE,'left',2);
        $colModel['nama_kabkota'] = array('KabKota',100,TRUE,'left',2);
        $colModel['nama_kecamatan'] = array('Kecamatan',100,TRUE,'left',2);
        $colModel['nama_desa'] = array('Desa',100,TRUE,'left',2);
		$colModel['nama_dusun'] = array('Dusun',100,TRUE,'left',2);
		$colModel['nomor_rw'] = array('RW',30,TRUE,'left',2);
		$colModel['nomor_rt'] = array('RT',30,TRUE,'left',2);
        $colModel['ref_jenis_pindah.deskripsi'] = array('Jenis Pindah',100,TRUE,'left',2);
        //$colModel['ref_klasifikasi_pindah.deskripsi'] = array('Klasifikasi Pindah',80,TRUE,'left',2);
		$colModel['ref_alasan_pindah.deskripsi'] = array('Alasan Pindah',100,TRUE,'left',2);
		
		
		//Populate flexigrid buttons..
        $buttons[] = array('Select All','check','btn');
		$buttons[] = array('separator');
        $buttons[] = array('DeSelect All','uncheck','btn');
        $buttons[] = array('separator');
		$buttons[] = array('Add','add','btn');
        $buttons[] = array('separator');
       // $buttons[] = array('Delete Selected Items','delete','btn');
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
	
		$grid_js = build_grid_js('flex1',site_url('peristiwa/c_pindah_keluar/load_data'),$colModel,'id_pindah_keluar','desc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;
		
        $data['page_title'] = 'DATA PERPINDAHAN KELUAR PENDUDUK';	
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('pindah_keluar/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }
	
	function load_data() {	
		$this->load->library('flexigrid');
		
       $valid_fields = array(
							'id_pindah_keluar',
							'tgl_pindah_keluar',
							'no_kk',
							'nama',
							'alamat_jalan',
							'nomor_rt',
							'nomor_rw',
							'nama_dusun',
							'nama_desa',
							'nama_kecamatan',
							'nama_kabkota',
							'nama_provinsi',
							'ref_jenis_pindah.deskripsi',
							//'ref_klasifikasi_pindah.deskripsi',
							'ref_alasan_pindah.deskripsi'
							);

		$this->flexigrid->validate_post('id_pindah_keluar','ASC',$valid_fields);
		$records = $this->m_pindah_keluar->get_pindah_keluar_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
                $row->id_pindah_keluar,
				$row->id_pindah_keluar,
				'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_pindah_keluar(\''.$row->id_pindah_keluar.'\')"/><i class="fa fa-pencil"></i></button>',
                date('d-m-Y',strtotime($row->tgl_pindah_keluar)),
                $row->no_kk,
                $row->nama,
				$row->alamat_jalan,
				$row->nama_provinsi,
				$row->nama_kabkota,
				$row->nama_kecamatan,
				$row->nama_desa,
				$row->nama_dusun,
				$row->nomor_rw,
				$row->nomor_rt,
                $row->jenis_pindah,
                //$row->klasifikasi_pindah,
				$row->alasan_pindah
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
			$data['json_array'] = $this->autocomplete_KepalaKeluarga();
			$data['jenis_pindah'] = $this->m_pindah_keluar->get_jenisPindah();
			$data['klasifikasi_pindah'] = $this->m_pindah_keluar->get_KlasifikasiPindah();
			$data['alasan_pindah'] = $this->m_pindah_keluar->get_AlasanPindah();
			
			$data['page_title'] = 'Tambah Data Perpindahan Keluar Penduduk';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('pindah_keluar/v_tambah', $data, TRUE);
			$this->load->view('utama', $data);
			
		}else
			redirect('c_login', 'refresh'); 
    }
	
	function simpan_pindah_keluar() 
	{
		//$id_pindah_keluar  = $this->input->post('id_pindah_keluar', TRUE);
		$tgl_pindah_keluar = $this->input->post('tgl_pindah_keluar', TRUE);
		$no_kk = $this->input->post('no_kk', TRUE);
		$alamat_jalan = $this->input->post('alamat_jalan', TRUE);
		$nama_provinsi = $this->input->post('nama_provinsi', TRUE);
		$nama_kabkota = $this->input->post('nama_kabkota', TRUE);
		$nama_kecamatan = $this->input->post('nama_kecamatan', TRUE);
		$nama_desa = $this->input->post('nama_desa', TRUE);
		$nama_dusun = $this->input->post('nama_dusun', TRUE);
		$nomor_rw = $this->input->post('nomor_rw', TRUE);
		$nomor_rt = $this->input->post('nomor_rt', TRUE);
		$id_penduduk = $this->input->post('id_penduduk', TRUE);
		$id_keluarga = $this->input->post('id_keluarga', TRUE);
		$id_jenis_pindah = $this->input->post('id_jenis_pindah', TRUE);
		$id_klasifikasi_pindah = $this->input->post('id_klasifikasi_pindah', TRUE);
		$id_alasan_pindah = $this->input->post('id_alasan_pindah', TRUE);
		
		$this->form_validation->set_rules('no_kk', 'No Kepala Keluarga', 'required');
		$this->form_validation->set_rules('tgl_pindah_keluar', 'Tanggal Pindah Keluar', 'required');
		$this->form_validation->set_rules('alamat_jalan', 'Alamat Jalan', 'required');
		$this->form_validation->set_rules('nama_provinsi', 'Provinsi', 'required');
		$this->form_validation->set_rules('nama_kabkota', 'Kabupaten / Kota', 'required');
		$this->form_validation->set_rules('nama_kecamatan', 'Kecamatan', 'required');
		$this->form_validation->set_rules('nama_desa', 'Desa / Kelurahan', 'required');
		$this->form_validation->set_rules('nama_dusun', 'Dusun', 'required');
		$this->form_validation->set_rules('nomor_rw', 'Nomor RW', 'required');
		$this->form_validation->set_rules('nomor_rt', 'Nomor RT', 'required');
		
		if ($this->form_validation->run() == TRUE)
		{  
		$id_penduduk = $this->m_pindah_keluar->getIdPendudukByNoKK($no_kk);
		$id_keluarga = $this->m_pindah_keluar->get_IdKeluargaByNoKk($no_kk);
		$temp_id_penduduk = $this->m_pindah_keluar->getIdPendudukByIdKeluarga($id_keluarga);
		foreach($temp_id_penduduk as $b)
		{
			$id_penduduk = $b->id_penduduk;
			
			//--------INSERT KE TABEL PINDAH PENDUDUK KELUAR---------//
			$dataPindahKeluar = array
			(
				//'id_pindah_keluar' => $id_pindah_keluar,
				'tgl_pindah_keluar' => date('Y-m-d', strtotime($tgl_pindah_keluar)),
				'no_kk' => $no_kk,
				'alamat_jalan' => strtoupper($alamat_jalan),
				'nama_provinsi' => strtoupper($nama_provinsi),
				'nama_kabkota' => strtoupper($nama_kabkota),
				'nama_kecamatan' => strtoupper($nama_kecamatan),
				'nama_desa' => strtoupper($nama_desa),
				'nama_dusun' => strtoupper($nama_dusun),
				'nomor_rw' => $nomor_rw,
				'nomor_rt' => $nomor_rt,
				'id_keluarga' => $id_keluarga,
				'id_penduduk' => $id_penduduk,
				'id_jenis_pindah' => $id_jenis_pindah,
				'id_klasifikasi_pindah' => $id_klasifikasi_pindah,
				'id_alasan_pindah' => $id_alasan_pindah
			);
			
			$this->m_pindah_keluar->insertPindahKeluar($dataPindahKeluar);
			
			//--------INSERT KE TABEL IKUT PINDAH KELUAR---------//
			$id_pindah_keluar = $this->m_pindah_keluar->getIdPindahKeluarByIdPenduduk($id_penduduk);
			
			$dataIkutPindah = array
				(
					'id_pindah_keluar' => $id_pindah_keluar,
					'id_penduduk' => $id_penduduk,
					'id_keluarga' => $id_keluarga
				);
				$this->m_pindah_keluar->insertIkutPindahKeluar($dataIkutPindah);
			
			//--------UPDATE KE TABEL PENDUDUK---------//
			//Ke Penduduk
			$status_penduduk = 'Pindahan Keluar';
			$id_status_penduduk = $this->m_pindah_keluar->getIdStatusPendudukByDeskripsi($status_penduduk);
			
				$id_penduduk = $b->id_penduduk;
			
			$dataP = array(
					'id_status_penduduk' => $id_status_penduduk,
				);
			$result = $this->m_pindah_keluar->updatePenduduk(array('id_penduduk' => $id_penduduk), $dataP);
			
		}
		redirect('peristiwa/c_pindah_keluar','refresh');
		}
		else $this->add(); 
	}
	
	function edit($id)
	{
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['id_pindah_keluar'] = $id;
			
			$id_penduduk = $this->m_pindah_keluar->getIdPendudukByIdPindahKeluar($id);
			$id_keluarga = $this->m_pindah_keluar->getIdKeluargaByIdPindahKeluar($id);
			$id_hub_kel = $this->m_pindah_keluar->getIdHubKelByIdKeluarga($id_keluarga);
			
			$data['pindah_keluar'] = $this->m_pindah_keluar->getPindahKeluarByIdPindahKeluar($id);
			$data['penduduk'] = $this->m_pindah_keluar->getPendudukByIdPenduduk($id_penduduk);
			$data['keluarga'] = $this->m_pindah_keluar->getKeluargaByIdKeluarga($id_keluarga);
			$data['hub_kel'] = $this->m_pindah_keluar->getHubKelByIdHubKel($id_hub_kel);
			$data['jenis_pindah'] = $this->m_pindah_keluar->get_jenisPindah();
			$data['klasifikasi_pindah'] = $this->m_pindah_keluar->get_KlasifikasiPindah();
			$data['alasan_pindah'] = $this->m_pindah_keluar->get_AlasanPindah();
			
			$data['page_title'] = 'Edit Data Perpindahan Keluar Penduduk';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('pindah_keluar/v_ubah', $data, TRUE);
			$this->load->view('utama', $data);
		
		}else
			redirect('c_login', 'refresh'); 
	}
	
	function update_pindah_keluar()
	{
		$id_pindah_keluar  = $this->input->post('id_pindah_keluar', TRUE);
		$tgl_pindah_keluar = $this->input->post('tgl_pindah_keluar', TRUE);
		$no_kk = $this->input->post('no_kk', TRUE);
		$alamat_jalan = $this->input->post('alamat_jalan', TRUE);
		$nama_provinsi = $this->input->post('nama_provinsi', TRUE);
		$nama_kabkota = $this->input->post('nama_kabkota', TRUE);
		$nama_kecamatan = $this->input->post('nama_kecamatan', TRUE);
		$nama_desa = $this->input->post('nama_desa', TRUE);
		$nama_dusun = $this->input->post('nama_dusun', TRUE);
		$nomor_rw = $this->input->post('nomor_rw', TRUE);
		$nomor_rt = $this->input->post('nomor_rt', TRUE);
		$id_penduduk = $this->input->post('id_penduduk', TRUE);
		$id_keluarga = $this->input->post('id_keluarga', TRUE);
		$id_jenis_pindah = $this->input->post('id_jenis_pindah', TRUE);
		$id_klasifikasi_pindah = $this->input->post('id_klasifikasi_pindah', TRUE);
		$id_alasan_pindah = $this->input->post('id_alasan_pindah', TRUE);
		
		$id_penduduk = $this->m_pindah_keluar->getIdPendudukByNoKK($no_kk);
		$id_keluarga = $this->m_pindah_keluar->get_IdKeluargaByNoKk($no_kk);
		$temp_id_pindah_keluar = $this->m_pindah_keluar->get_IdPindahKeluarByIdKeluarga($id_keluarga);
		foreach($temp_id_pindah_keluar as $abc)
		{
			$id_pindah_keluar = $abc->id_pindah_keluar;
			//--------UPDATE KE TABEL PINDAH PENDUDUK KELUAR---------//
			$data4 = array
			(
				'id_pindah_keluar' => $id_pindah_keluar,
				'tgl_pindah_keluar' => date('Y-m-d', strtotime($tgl_pindah_keluar)),
				'no_kk' => $no_kk,
				'alamat_jalan' => strtoupper($alamat_jalan),
				'nama_provinsi' => strtoupper($nama_provinsi),
				'nama_kabkota' => strtoupper($nama_kabkota),
				'nama_kecamatan' => strtoupper($nama_kecamatan),
				'nama_desa' => strtoupper($nama_desa),
				'nama_dusun' => strtoupper($nama_dusun),
				'nomor_rw' => $nomor_rw,
				'nomor_rt' => $nomor_rt,
				//'id_penduduk' => $id_penduduk,
				'id_keluarga' => $id_keluarga,
				'id_jenis_pindah' => $id_jenis_pindah,
				'id_klasifikasi_pindah' => $id_klasifikasi_pindah,
				'id_alasan_pindah' => $id_alasan_pindah,
			);
			$result = $this->m_pindah_keluar->updatePindahKeluar(array('id_pindah_keluar' => $id_pindah_keluar), $data4);
			
			//--------UPDATE KE TABEL PENDUDUK---------//
			//Ke Penduduk
			$status_penduduk = 'Pindahan Keluar';
			$id_status_penduduk = $this->m_pindah_keluar->getIdStatusPendudukByDeskripsi($status_penduduk);
			
			$dataP = array(
					'id_status_penduduk' => $id_status_penduduk,
				);
			$result = $this->m_pindah_keluar->updatePenduduk(array('id_penduduk' => $id_penduduk), $dataP);
		}
			
		redirect('peristiwa/c_pindah_keluar','refresh');
		
		
	}
	
	function delete()
    {
        $post = explode(",", $this->input->post('items'));
        array($post); $sucess=-1;
		
        foreach($post as $id){
			
            $this->m_pindah_keluar->deletePindahKeluar($id);
            $sucess++;
        }
        redirect('peristiwa/c_pindah_keluar', 'refresh');
    }
	
	public function autocomplete_KepalaKeluarga()
    {
        $nama = $this->input->post('nama',TRUE);
        $rows = $this->m_pindah_keluar->getKepalaKeluargaLikeNama($nama);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->no_kk.' | '.$row->nama;
		}
        return json_encode($json_array);
    }
	
	function a()
	{
		$temp_id_penduduk = $this->m_pindah_keluar->getIdPendudukByIdKeluarga('11');
			foreach($temp_id_penduduk as $b)
			{
				$id_penduduk = $b->id_penduduk;
				echo $id_penduduk.' ';
			}
			
		
	}
}
?>