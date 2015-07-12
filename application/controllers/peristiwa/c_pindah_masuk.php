<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_pindah_masuk extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->helper('string');
		$this->load->database();
		$this->load->model('m_pindah_masuk');
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
        $colModel['id_pindah_masuk'] = array('ID',30,TRUE,'left',0);
        $colModel['tgl_pindah_masuk'] = array('Tanggal Pindah Masuk',120,TRUE,'left',2);
        $colModel['no_kk'] = array('No Kepala Keluarga',100,TRUE,'left',2);
        $colModel['alamat_jalan'] = array('Alamat',100,TRUE,'left',2);
        $colModel['ref_desa.nama_desa'] = array('Desa Tujuan',80,TRUE,'left',2);
		$colModel['ref_dusun.nama_dusun'] = array('Dusun Tujuan',80,TRUE,'left',2);
		$colModel['ref_rw.nomor_rw'] = array('RW Tujuan',70,TRUE,'left',2);
		$colModel['ref_rt.nomor_rt'] = array('RT Tujuan',70,TRUE,'left',2);
        $colModel['ref_jenis_pindah.deskripsi'] = array('Jenis Pindah',100,TRUE,'left',2);
        $colModel['ref_klasifikasi_pindah.deskripsi'] = array('Klasifikasi Pindah',120,TRUE,'left',2);
		$colModel['ref_alasan_pindah.deskripsi'] = array('Alasan Pindah',100,TRUE,'left',2);
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
	
		$grid_js = build_grid_js('flex1',site_url('peristiwa/c_pindah_masuk/load_data'),$colModel,'id_pindah_masuk','desc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;
		
        $data['page_title'] = 'DATA PERPINDAHAN PENDUDUK MASUK';	
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('pindah_masuk/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }
	
	function load_data() {	
		$this->load->library('flexigrid');
		
       $valid_fields = array(
							'id_pindah_masuk',
							'tgl_pindah_masuk',
							'no_kk',
							'alamat_jalan',
							'ref_rt.nomor_rt',
							'ref_rw.nomor_rw',
							'ref_dusun.nama_dusun',
							'ref_desa.nama_desa',
							'ref_jenis_pindah.deskripsi',
							'ref_klasifikasi_pindah.deskripsi',
							'ref_alasan_pindah.deskripsi'
							);

		$this->flexigrid->validate_post('id_pindah_masuk','ASC',$valid_fields);
		$records = $this->m_pindah_masuk->get_pindah_masuk_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		$counter=0;
		foreach ($records['records']->result() as $row)
		{
			$counter++;
			$record_items[] = array(
                $row->id_pindah_masuk,
				$counter,
                date('d-m-Y',strtotime($row->tgl_pindah_masuk)),
                $row->no_kk,
				$row->alamat_jalan,
				$row->nomor_rt,
                $row->nomor_rw,
				$row->nama_dusun,
				$row->nama_desa,
                $row->jenis_pindah,
                $row->klasifikasi_pindah,
				$row->alasan_pindah,
				'<button type="submit" class="btn btn-default btn-xs" title="Edit" onclick="edit_pindah_masuk(\''.$row->id_pindah_masuk.'\')"/><i class="fa fa-pencil"></i></button>'
			);  
		}
		//Print please
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
	
	 function getRt(){	
			$id_rw = $this->input->post('id_rw');
			$data['nomor_rt'] = $this->m_pindah_masuk->get_rt_dinamic($id_rw);
			$this->load->view('keluarga/rt',$data);
	}
	function getRtEdit(){	
			$id_rw = $this->input->post('id_rw');
			$data['nomor_rt_edit'] = $this->m_pindah_masuk->get_rt_dinamic($id_rw);
			$this->load->view('keluarga/rt_edit',$data);
	}
	
	function getRw(){	
			$id_dusun = $this->input->post('id_dusun');
			$data['nomor_rw'] = $this->m_pindah_masuk->get_rw_dinamic($id_dusun);
			$this->load->view('keluarga/rw',$data);
	}
	
	function getRwEdit(){	
			$id_dusun = $this->input->post('id_dusun');
			$data['nomor_rw_edit'] = $this->m_pindah_masuk->get_rw_dinamic($id_dusun);
			$this->load->view('keluarga/rw_edit',$data);
	}
	
	function add(){		
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{												
			//$data['nomor_rt'] = $this->m_pindah_masuk->get_nomorRT();
			//$data['nomor_rw'] = $this->m_pindah_masuk->get_nomorRW();
			$data['nama_desa'] = $this->m_pindah_masuk->get_Desa();
			$data['nama_dusun'] = $this->m_pindah_masuk->get_Dusun();
			$data['jenis_pindah'] = $this->m_pindah_masuk->get_jenisPindah();
			$data['klasifikasi_pindah'] = $this->m_pindah_masuk->get_KlasifikasiPindah();
			$data['alasan_pindah'] = $this->m_pindah_masuk->get_AlasanPindah();
			
			$data['page_title'] = 'Tambah Data Perpindahan Masuk Penduduk';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('pindah_masuk/v_tambah', $data, TRUE);
			$this->load->view('utama', $data);
			
		}else
			redirect('c_login', 'refresh'); 
    }
	
	function simpan_pindah_masuk() 
	{
		$id_pindah_masuk  = $this->input->post('id_pindah_masuk', TRUE);
		$tgl_pindah_masuk = $this->input->post('tgl_pindah_masuk', TRUE);
		$no_kk = $this->input->post('no_kk', TRUE);
		$alamat_jalan = $this->input->post('alamat_jalan', TRUE);
		$id_desa = $this->input->post('id_desa', TRUE);
		$id_dusun = $this->input->post('id_dusun', TRUE);
		$id_rw = $this->input->post('id_rw', TRUE);
		$id_rt = $this->input->post('id_rt', TRUE);
		$id_penduduk = $this->input->post('id_penduduk', TRUE);
		$id_keluarga = $this->input->post('id_keluarga', TRUE);
		$id_jenis_pindah = $this->input->post('id_jenis_pindah', TRUE);
		$id_klasifikasi_pindah = $this->input->post('id_klasifikasi_pindah', TRUE);
		$id_alasan_pindah = $this->input->post('id_alasan_pindah', TRUE);
		
		$this->form_validation->set_rules('tgl_pindah_masuk', 'Tanggal Pindah Masuk', 'required');
		$this->form_validation->set_rules('no_kk', 'Nomer Kepala Keluarga', 'required');
		$this->form_validation->set_rules('nama', 'Nama Kepala Keluarga', 'required');
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
		$this->form_validation->set_rules('alamat_jalan', 'Alamat', 'required');
		$this->form_validation->set_rules('id_desa', 'Desa', 'required');
		$this->form_validation->set_rules('id_dusun', 'Dusun', 'required');
		$this->form_validation->set_rules('id_rw', 'RW', 'required');
		$this->form_validation->set_rules('id_rt', 'RT', 'required');
		
		if ($this->form_validation->run() == TRUE)
		{ 
		$generate = substr(sha1(uniqid(rand(), true)), 0, 10);
		
		//------1---INSERT KE TABEL PENDUDUK---------//
		//Ke Penduduk
		$nama = $this->input->post('nama', TRUE);
		$id_jen_kel = $this->input->post('id_jen_kel', TRUE);
		$tempat_lahir = $this->input->post('tempat_lahir', TRUE);
		$tanggal_lahir = $this->input->post('tanggal_lahir', TRUE);
		
		$status_penduduk = 'Pindahan Masuk';
		$id_status_penduduk = $this->m_pindah_masuk->getIdStatusPendudukByDeskripsi($status_penduduk);
		$data1 = array
		(	
			'nik' => $generate,
			'nama' => strtoupper($nama),
			'id_jen_kel' => $id_jen_kel,
			'tempat_lahir' => strtoupper($tempat_lahir),
			'tanggal_lahir' => date('Y-m-d', strtotime($tanggal_lahir)),
			'id_dusun' => $id_dusun,
			'id_rw' => $id_rw,
			'id_rt' => $id_rt,
			'id_status_penduduk' => $id_status_penduduk,
			
		);
		$this->m_pindah_masuk->insertPenduduk($data1);
		$id_penduduk = $this->m_pindah_masuk->get_IdPendudukByNIK($generate);
		
		//------2---INSERT KE TABEL KELUARGA---------//
		$data2 = array
		(
			'no_kk' => $no_kk,
			'alamat_jalan' => strtoupper($alamat_jalan),
			'id_dusun' => $id_dusun,
			'id_rw' => $id_rw,
			'id_rt' => $id_rt,
			'id_kepala_keluarga' => $id_penduduk
		);
		$this->m_pindah_masuk->insertKeluarga($data2);
		$id_keluarga = $this->m_pindah_masuk->get_IdKeluargaByNoKk($no_kk);
		//------3---INSERT KE TABEL HUB KELUARGA---------//
		
		$data3 = array
		(
			'id_penduduk' => $id_penduduk,
			'id_keluarga' => $id_keluarga,
			'id_status_keluarga' => 1
		); 
		$this->m_pindah_masuk->insertHubKeluarga($data3);

		
		
		//------4---INSERT KE TABEL PINDAH PENDUDUK MASUK---------//
		$data4 = array
		(
			'id_pindah_masuk' => $id_pindah_masuk,
			'tgl_pindah_masuk' => date('Y-m-d', strtotime($tgl_pindah_masuk)),
			'no_kk' => $no_kk,
			'alamat_jalan' => strtoupper($alamat_jalan),
			'id_desa' => $id_desa,
			'id_dusun' => $id_dusun,
			'id_rw' => $id_rw,
			'id_rt' => $id_rt,
			'id_penduduk' => $id_penduduk,
			'id_keluarga' => $id_keluarga,
			'id_jenis_pindah' => $id_jenis_pindah,
			'id_klasifikasi_pindah' => $id_klasifikasi_pindah,
			'id_alasan_pindah' => $id_alasan_pindah
		);
		
		$this->m_pindah_masuk->insertPindahMasuk($data4);
		redirect('peristiwa/c_pindah_masuk','refresh');
		}
		else $this->add(); 
	}
	
	function edit($id)
	{
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['id_pindah_masuk'] = $id;
			
			$id_penduduk = $this->m_pindah_masuk->getIdPendudukByIdPindahMasuk($id);
			$id_keluarga = $this->m_pindah_masuk->getIdKeluargaByIdPindahMasuk($id);
			$id_hub_kel = $this->m_pindah_masuk->getIdHubKelByIdKeluarga($id_keluarga);
			
			$data['pindah_masuk'] = $this->m_pindah_masuk->getPindahMasukByIdPindahMasuk($id);
			$data['penduduk'] = $this->m_pindah_masuk->getPendudukByIdPenduduk($id_penduduk);
			$data['keluarga'] = $this->m_pindah_masuk->getKeluargaByIdKeluarga($id_keluarga);
			$data['hub_kel'] = $this->m_pindah_masuk->getHubKelByIdHubKel($id_hub_kel);
			
			//$data['nomor_rt'] = $this->m_pindah_masuk->get_nomorRT();
			//$data['nomor_rw'] = $this->m_pindah_masuk->get_nomorRW();
			$data['nama_desa'] = $this->m_pindah_masuk->get_Desa();
			$data['nama_dusun'] = $this->m_pindah_masuk->get_Dusun();
			$data['jenis_pindah'] = $this->m_pindah_masuk->get_jenisPindah();
			$data['klasifikasi_pindah'] = $this->m_pindah_masuk->get_KlasifikasiPindah();
			$data['alasan_pindah'] = $this->m_pindah_masuk->get_AlasanPindah();
			
			$id_rw = $data['pindah_masuk']->id_rw;
			$data['nomor_rt'] = $this->m_pindah_masuk->get_rt_dinamic($id_rw);
			
			$id_dusun = $data['pindah_masuk']->id_dusun;
			$data['nomor_rw'] = $this->m_pindah_masuk->get_rw_dinamic($id_dusun);
			
			$data['page_title'] = 'Edit Data Perpindahan Masuk Penduduk';
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('pindah_masuk/v_ubah', $data, TRUE);
			$this->load->view('utama', $data);

		
		}else
			redirect('c_login', 'refresh'); 
	}
	
	function update_pindah_masuk()
	{
		$id_pindah_masuk  = $this->input->post('id_pindah_masuk', TRUE);
		$tgl_pindah_masuk = $this->input->post('tgl_pindah_masuk', TRUE);
		$no_kk = $this->input->post('no_kk', TRUE);
		$alamat_jalan = $this->input->post('alamat_jalan', TRUE);
		$id_desa = $this->input->post('id_desa', TRUE);
		$id_dusun = $this->input->post('id_dusun', TRUE);
		$id_rw = $this->input->post('id_rw', TRUE);
		$id_rt = $this->input->post('id_rt', TRUE);
		$id_penduduk = $this->input->post('id_penduduk', TRUE);
		$id_keluarga = $this->input->post('id_keluarga', TRUE);
		$id_jenis_pindah = $this->input->post('id_jenis_pindah', TRUE);
		$id_klasifikasi_pindah = $this->input->post('id_klasifikasi_pindah', TRUE);
		$id_alasan_pindah = $this->input->post('id_alasan_pindah', TRUE);
		
		$this->form_validation->set_rules('tgl_pindah_masuk', 'Tanggal Pindah Masuk', 'required');
		$this->form_validation->set_rules('no_kk', 'Nomer Kepala Keluarga', 'required');
		$this->form_validation->set_rules('nama', 'Nama Kepala Keluarga', 'required');
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
		$this->form_validation->set_rules('alamat_jalan', 'Alamat', 'required');
		$this->form_validation->set_rules('id_desa', 'Desa', 'required');
		$this->form_validation->set_rules('id_dusun', 'Dusun', 'required');
		$this->form_validation->set_rules('id_rw', 'RW', 'required');
		$this->form_validation->set_rules('id_rt', 'RT', 'required');
		
		if ($this->form_validation->run() == TRUE)
		{ 
		//------1---UPDATE KE TABEL PENDUDUK---------//
		//Ke Penduduk
		$nama = $this->input->post('nama', TRUE);
		$id_jen_kel = $this->input->post('id_jen_kel', TRUE);
		$tempat_lahir = $this->input->post('tempat_lahir', TRUE);
		$tanggal_lahir = $this->input->post('tanggal_lahir', TRUE);
		
		$id_penduduk = $this->m_pindah_masuk->getIdPendudukByIdPindahMasuk($id_pindah_masuk);
		
		$data1 = array
		(	
			'nama' => strtoupper($nama),
			'id_jen_kel' => $id_jen_kel,
			'tempat_lahir' => strtoupper($tempat_lahir),
			'tanggal_lahir' => date('Y-m-d', strtotime($tanggal_lahir)),
			'id_dusun' => $id_dusun,
			'id_rw' => $id_rw,
			'id_rt' => $id_rt
		);
		$result = $this->m_pindah_masuk->updatePenduduk(array('id_penduduk' => $id_penduduk), $data1);
		
		//------2---UPDATE KE TABEL KELUARGA---------//
		$id_keluarga = $this->m_pindah_masuk->getIdKeluargaByIdPindahMasuk($id_pindah_masuk);
		$data2 = array
		(
			'no_kk' => $no_kk,
			'alamat_jalan' => strtoupper($alamat_jalan),
			'id_dusun' => $id_dusun,
			'id_rw' => $id_rw,
			'id_rt' => $id_rt,
			'id_kepala_keluarga' => $id_penduduk
		);
		$result = $this->m_pindah_masuk->updateKeluarga(array('id_keluarga' => $id_keluarga), $data2);
		
		//------3---UPDATE KE TABEL HUB KELUARGA---------//
		$id_hub_kel = $this->m_pindah_masuk->getIdHubKelByIdKeluarga($id_keluarga);
		
		$data3 = array
		(
			'id_penduduk' => $id_penduduk,
			'id_keluarga' => $id_keluarga
		);
		$result = $this->m_pindah_masuk->updateHubKeluarga(array('id_hub_kel' => $id_hub_kel), $data3);

		
		//------4---UPDATE KE TABEL PINDAH PENDUDUK MASUK---------//
		$data4 = array
		(
			'id_pindah_masuk' => $id_pindah_masuk,
			'tgl_pindah_masuk' => date('Y-m-d', strtotime($tgl_pindah_masuk)),
			'no_kk' => $no_kk,
			'alamat_jalan' => strtoupper($alamat_jalan),
			'id_desa' => $id_desa,
			'id_dusun' => $id_dusun,
			'id_rw' => $id_rw,
			'id_rt' => $id_rt,
			'id_penduduk' => $id_penduduk,
			'id_keluarga' => $id_keluarga,
			'id_jenis_pindah' => $id_jenis_pindah,
			'id_klasifikasi_pindah' => $id_klasifikasi_pindah,
			'id_alasan_pindah' => $id_alasan_pindah
		);
		$result = $this->m_pindah_masuk->updatePindahMasuk(array('id_pindah_masuk' => $id_pindah_masuk), $data4);
		
		redirect('peristiwa/c_pindah_masuk','refresh');
		}
		else $this->edit($id_pindah_masuk);
	}
	
	function delete()
    {
        $post = explode(",", $this->input->post('items'));
        array($post); $sucess=-1;
		
        foreach($post as $id){
			
            $this->m_pindah_masuk->deletePindahMasuk($id);
            $sucess++;
        }
        redirect('peristiwa/c_pindah_masuk', 'refresh');
    }
}
?>