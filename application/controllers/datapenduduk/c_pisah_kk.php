<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_pisah_kk extends CI_Controller {

    function  __construct()
    {
		parent::__construct();

        //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
        $this->load->model('m_pisah_kk');
        $this->load->model('m_keluarga');
		$this->load->model('m_log');
		$this->load->model('m_pindah_keluar');
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
 
        $data['page_title'] = 'PISAH KARTU KELUARGA';		
		$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
        $data['content'] = $this->load->view('pisah_kk/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }
	function getRt(){	
			$id_rw = $this->input->post('id_rw');
			$data['nomor_rt'] = $this->m_keluarga->get_rt_dinamic($id_rw);
			$this->load->view('keluarga/rt',$data);
	}
	function cekKepalaKeluarga(){	
			$nik = $this->input->post('niklala');
			$id_penduduk = $this->m_pisah_kk->getIdPendudukByNIK($nik);			
			$cek = $this->m_pisah_kk->cekKepalaKeluargaByIdPenduduk($id_penduduk);
			if($cek == TRUE)
			{	echo true;	}
			else
			{	echo false;	}
	}
	function getNotifKepalaKeluarga(){	
			$data['nama'] = $this->input->post('nama');
			$this->load->view('pisah_kk/v_kepala_keluarga',$data);
	}
	function tambah_kk() { 
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['page_title'] = 'TAMBAH KARTU KELUARGA';				
			
			$data['json_array_nik'] = $this->autocomplete_Nik('tambah_kk');			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk('tambah_kk');
			$data['nama_dusun'] = $this->m_keluarga->get_dusun();
			$data['nomor_rw'] = $this->m_keluarga->get_rw();
			$data['id_kelas_sosial'] = $this->m_keluarga->get_kelas_sosial();
			
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('pisah_kk/v_tambah_kk', $data, TRUE);
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
			       
    }
		
	function simpan_tambah_kk() {
	
		$nik = $this->input->post('nik', TRUE);
		$id_penduduk = $this->m_pisah_kk->getIdPendudukByNIK($nik);
		
		
		/* POST HANDLING tbl_keluarga */
		
		$no_kk = $this->input->post('no_kk', TRUE);
		
		$alamat_jalan = $this->input->post('alamat_jalan', TRUE);
		$id_rt = $this->input->post('id_rt', TRUE);
		$id_rw = $this->input->post('id_rw', TRUE);
		$id_dusun = $this->input->post('id_dusun', TRUE);
		
		$is_raskin = $this->input->post('is_raskin', TRUE);
		$is_jamkesmas = $this->input->post('is_jamkesmas', TRUE);
		$is_pkh = $this->input->post('is_pkh', TRUE);	
		$id_kelas_sosial = $this->input->post('id_kelas_sosial', TRUE);
		
		/* END OF POST HANDLING tbl_keluarga */
		
		/* INSERT HANDLING tbl_keluarga */
		$data = array(
				'no_kk' => $no_kk,
				'alamat_jalan' => strtoupper($alamat_jalan),
				'id_rt' => $id_rt,
				'id_rw' => $id_rw,
				'id_dusun' => $id_dusun,
				'id_kepala_keluarga' => $id_penduduk,
				'is_raskin' => $is_raskin,
				'is_jamkesmas' => $is_jamkesmas,
				'is_pkh' => $is_pkh,
				'id_kelas_sosial' => $id_kelas_sosial
			);
			$this->m_keluarga->insertKeluarga($data);
			/* LOG */
			$json = json_encode($data);			
			$this->log('simpan_tambah_kk','INSERT',$json,'tbl_keluarga');
			/* END OF LOG */
		/* END OF INSERT HANDLING tbl_keluarga */
		
		
		/* POST HANDLING tbl_hub_kel */
		
		$temp_id_keluarga = $this->m_keluarga->getIdKeluargaByNoKK($no_kk);
		foreach($temp_id_keluarga as $a)
		{
			$id_keluarga = $a->id_keluarga;
		}
		$id_status_keluarga = 1; //STATUS KEPALA KELUARGA
		/* END OF POST HANDLING tbl_hub_kel */
		
		/* UPDATE HANDLING tbl_hub_kel */
			$data = array(
				'id_keluarga' => $id_keluarga,
				'id_status_keluarga' => $id_status_keluarga
			);
			$this->m_keluarga->updateHubKel(array('id_penduduk' => $id_penduduk),$data);
			
			/* LOG */
			$json = json_encode($data);						
			$jsonWhere = json_encode(array('id_penduduk' => $id_penduduk));
			$this->log('simpan_tambah_kk','UPDATE : '.$jsonWhere,$json,'tbl_hub_kel');
			/* END OF LOG */
		/* END OF UPDATE HANDLING tbl_hub_kel */
		
		/* POST HANDLING tbl_penduduk *//* END OF POST HANDLING tbl_penduduk */	
		/* UPDATE HANDLING tbl_penduduk */	
			$dataPenduduk = array(
				'id_rt' => $id_rt,
				'id_rw' => $id_rw,
				'id_dusun' => $id_dusun				
				);			
				$this->m_keluarga->updatePenduduk(array('id_penduduk' => $id_penduduk), $dataPenduduk);
			/* LOG */
			$json = json_encode($dataPenduduk);			
			$jsonWhere = json_encode(array('id_penduduk' => $id_penduduk));			
			$this->log('simpan_tambah_kk','UPDATE : '.$jsonWhere,$json,'tbl_penduduk');
			/* END OF LOG */
		/* END OF UPDATE HANDLING tbl_penduduk */	
		
		redirect('datapenduduk/c_pisah_kk','refresh');
    }
	
	function pindah_kk() {
	$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Pengelola Data')
		{
			$data['page_title'] = 'PINDAH KARTU KELUARGA';					
			$data['json_array_nik'] = $this->autocomplete_Nik('pindah_kk');			
			$data['json_array_nama'] = $this->autocomplete_NamaPenduduk('pindah_kk');
			$data['json_array'] = $this->autocomplete_KepalaKeluarga();			
			$data['id_status_keluarga'] = $this->m_keluarga->get_status_keluarga();
			$data['menu'] = $this->load->view('menu/v_pengelolaData', $data, TRUE);
			$data['content'] = $this->load->view('pisah_kk/v_pindah_kk', $data, TRUE);
			$this->load->view('utama', $data);
		}else
			redirect('c_login', 'refresh');
        
    }
	
	function simpan_pindah_kk() {
	
		$nik = $this->input->post('nik', TRUE);
		$id_penduduk = $this->m_pisah_kk->getIdPendudukByNIK($nik);
		
		
		$no_kk		 = $this->input->post('no_kk', TRUE);		
		$id_keluarga = $this->m_pisah_kk->getIdKeluargaByNoKK($no_kk);
		
		$id_status_keluarga = $this->input->post('id_status_keluarga', TRUE);
		
		$id_keluarga_dirinya = $this->m_pisah_kk->getIdKeluargaByIdPenduduk($id_penduduk);
		
		if($id_keluarga != $id_keluarga_dirinya)
		{
			if($this->m_pisah_kk->cekKepalaKeluargaByIdPenduduk($id_penduduk) == TRUE)
			{
				//jika dia sendirian disitu			
				$cekKesendirian = $this->m_pisah_kk->cekKesendirianByIdKeluarga($id_keluarga_dirinya);
				
				if($cekKesendirian == TRUE)
				{				
					//update tbl_hub_kel dia by id_penduduk
					/* UPDATE HANDLING tbl_hub_kel */
						$data = array(
							'id_keluarga' => $id_keluarga,
							'id_status_keluarga' => $id_status_keluarga
						);
						$this->m_keluarga->updateHubKel(array('id_penduduk' => $id_penduduk),$data);
						
						/* LOG */
						$json = json_encode($data);						
						$jsonWhere = json_encode(array('id_penduduk' => $id_penduduk));
						$this->log('simpan_pindah_kk','UPDATE : '.$jsonWhere,$json,'tbl_hub_kel');
						/* END OF LOG */
					/* END OF UPDATE HANDLING tbl_hub_kel */
								
				}
				
				else //jika tidak sendirian atau punya anggota keluarga
				{
					/* UPDATE KEPALA KELUARGANYA */
						/* UPDATE HANDLING tbl_hub_kel */
						$data = array(
							'id_keluarga' => $id_keluarga,
							'id_status_keluarga' => $id_status_keluarga
						);
						$this->m_keluarga->updateHubKel(array('id_penduduk' => $id_penduduk),$data);
						
						/* LOG */
						$json = json_encode($data);						
						$jsonWhere = json_encode(array('id_penduduk' => $id_penduduk));
						$this->log('simpan_pindah_kk','UPDATE : '.$jsonWhere,$json,'tbl_hub_kel');
						/* END OF LOG */
						/* END OF UPDATE HANDLING tbl_hub_kel */
					/* END OF UPDATE KEPALA KELUARGANYA */
					
					/* UPDATE ANGOTANYA */				
						//update tbl_hub_kel dia by id penduduk
						
						/* UPDATE HANDLING tbl_hub_kel */
						$dataAnggota = array(
							'id_keluarga' => $id_keluarga
						);
						$this->m_keluarga->updateHubKel(array('id_keluarga' => $id_keluarga_dirinya),$dataAnggota);
						
						/* LOG */
						$json = json_encode($dataAnggota);						
						$jsonWhere = json_encode(array('id_keluarga' => $id_keluarga_dirinya));
						$this->log('simpan_pindah_kk','UPDATE : '.$jsonWhere,$json,'tbl_hub_kel');
						/* END OF LOG */
					/* END OF UPDATE HANDLING tbl_hub_kel */
							
					/* END OF UPDATE ANGOTANYA */
				}
				//hapus  tbl_keluarga dia 
					/* DELETE HANDLING tbl_keluarga */
						$this->m_pisah_kk->deleteKeluargaByIdKeluarga($id_keluarga_dirinya);
						/* LOG */					
						$json = json_encode(array('id_keluarga' => $id_keluarga_dirinya));
						$this->log('simpan_pindah_kk','DELETE',$json,'tbl_keluarga');
						/* END OF LOG */
					/* END OF DELETE HANDLING tbl_keluarga */
				
			}
			else
			{
				/* UPDATE HANDLING tbl_hub_kel */
				$data = array(
					'id_keluarga' => $id_keluarga,
					'id_status_keluarga' => $id_status_keluarga
				);
				$this->m_keluarga->updateHubKel(array('id_penduduk' => $id_penduduk),$data);
				
				/* LOG */
				$json = json_encode($data);						
				$jsonWhere = json_encode(array('id_penduduk' => $id_penduduk));
				$this->log('simpan_pindah_kk','UPDATE : '.$jsonWhere,$json,'tbl_hub_kel');
				/* END OF LOG */
				/* END OF UPDATE HANDLING tbl_hub_kel */
			}
			
		}		
		redirect('datapenduduk/c_pisah_kk','refresh');
    }
	
	public function autocomplete_Nik($punya)
    {
        $nik = $this->input->post('nik',TRUE);
        $rows = $this->m_pisah_kk->get_NikPenduduk($nik,$punya);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]=$row->nik;
		}
        return json_encode($json_array);
    }
	
	public function autocomplete_NamaPenduduk($punya)
    {
        $nama = $this->input->post('nama',TRUE);
        $rows = $this->m_pisah_kk->get_NamaPenduduk($nama,$punya);
        $json_array = array();
        foreach ($rows as $row)
		{
            $json_array[]= $row->nik.' | '.$row->nama;
		}
        return json_encode($json_array);
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