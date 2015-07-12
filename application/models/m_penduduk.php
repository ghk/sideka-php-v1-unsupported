<?php
class M_penduduk extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_penduduk';
    $this->load->library('Excel_generator');
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_penduduk_flexigrid()
    {
        //Build contents query
        $this->db->select(
		'tbl_penduduk.*,
		ref_rt.nomor_rt,
		ref_rw.nomor_rw,
		ref_dusun.nama_dusun,		
		ref_jen_kel.deskripsi as nama_jen_kel
		
		')->from($this->_table);
		
		$this->db->join('ref_rt','tbl_penduduk.id_rt=ref_rt.id_rt'); 													// ke tbl RT
		$this->db->join('ref_rw','tbl_penduduk.id_rw=ref_rw.id_rw'); 													// ke tbl RW
		$this->db->join('ref_dusun','tbl_penduduk.id_dusun=ref_dusun.id_dusun'); 										// ke tbl DUSUN
		$this->db->join('ref_jen_kel','tbl_penduduk.id_jen_kel=ref_jen_kel.id_jen_kel'); 								// ke tbl JENIS KELAMIN
		
		//$this->db->join('tbl_penduduk','tbl_penduduk.iduser=data_penduduk.iduser');
		/* $this->db->join('ref_pekerjaan','ref_pekerjaan.id_pekerjaan=data_penduduk.id_pekerjaan');
		$this->db->join('ref_pendidikan','ref_pendidikan.id_pendidikan=data_penduduk.id_pendidikan');
		$this->db->join('ref_dusun','ref_dusun.id_dusun=data_penduduk.id_dusun'); */
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_penduduk) as record_count")->from($this->_table);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        $this->CI->flexigrid->build_query(TRUE);
        //Return all
        return $return;
    }
    
    function get_dataForExportExcel()
	{
		$this->db->select('
				tbl_penduduk.nik as nik,
				tbl_penduduk.nama as nama,
				tbl_penduduk.tempat_lahir as tempat_lahir,
				tbl_penduduk.tanggal_lahir as tanggal_lahir,
				tbl_penduduk.no_telp as no_telp,
				tbl_penduduk.email as email,
				tbl_penduduk.no_kitas as no_kitas,
				tbl_penduduk.no_paspor as no_paspor,
				
				ref_rt.nomor_rt as nomor_rt,
				ref_rw.nomor_rw as nomor_rw,
				ref_dusun.nama_dusun as nama_dusun,
				pd1.deskripsi as nama_pendidikan,
				pd2.deskripsi as nama_pendidikan_terakhir,
				ref_agama.deskripsi as nama_agama,
				ref_goldar.deskripsi as nama_goldar,
				ref_jen_kel.deskripsi as nama_jen_kel,
				ref_kewarganegaraan.deskripsi as nama_kewarganegaraan,
				ref_pekerjaan.deskripsi as nama_pekerjaan,
				ref_pekerjaan_ped.deskripsi as nama_pekerjaan_ped,
				ref_kompetensi.deskripsi as nama_kompetensi,
				ref_status_kawin.deskripsi as nama_status_kawin,
				ref_status_penduduk.deskripsi as nama_status_penduduk,
				ref_status_tinggal.deskripsi as nama_status_tinggal,
				ref_difabilitas.deskripsi as nama_difabilitas,
				ref_kontrasepsi.deskripsi as nama_kontrasepsi,
				tbl_keluarga.no_kk as no_kk,
				if(tbl_hub_kel.id_status_keluarga = 1, "YA", "TIDAK") as is_kepala_keluarga,
				tbl_keluarga.alamat_jalan as alamat_jalan,
				tbl_hub_kel.nama_ayah as nama_ayah,
				tbl_hub_kel.nama_ibu as nama_ibu,
				ref_status_keluarga.deskripsi as nama_status_keluarga,
				tbl_keluarga.id_kepala_keluarga as_id_keluarga,
				if(tbl_keluarga.is_sementara  = "N", "TIDAK", "YA") as is_keluarga_sementara,
				if(tbl_keluarga.is_raskin  = "N", "TIDAK", "YA") as is_raskin,
				if(tbl_keluarga.is_jamkesmas  = "N", "TIDAK", "YA") as is_jamkesmas,
				if(tbl_keluarga.is_pkh  = "N", "TIDAK", "YA") as is_pkh,
				ref_kelas_sosial.deskripsi as nama_kelas_sosial,
				
				if(tbl_penduduk.is_sementara  = "N", "TIDAK", "YA")  as is_penduduk_sementara,
				if(tbl_penduduk.is_bsm  = "N", "TIDAK", "YA") as is_bsm,
				
		')->from($this->_table);
		$this->db->select("DATE_FORMAT(tbl_penduduk.tanggal_lahir, '%d/%m/%Y') AS tanggal_lahir", FALSE);

		$this->db->join('ref_rt','tbl_penduduk.id_rt = ref_rt.id_rt','left'); 				
		$this->db->join('ref_rw','tbl_penduduk.id_rw = ref_rw.id_rw','left'); 												
		$this->db->join('ref_dusun','tbl_penduduk.id_dusun = ref_dusun.id_dusun','left'); 								
		$this->db->join('ref_jen_kel','tbl_penduduk.id_jen_kel = ref_jen_kel.id_jen_kel','left'); 	
		$this->db->join('ref_goldar','tbl_penduduk.id_goldar = ref_goldar.id_goldar','left'); 	
		$this->db->join('ref_pendidikan as pd1','tbl_penduduk.id_pendidikan = pd1.id_pendidikan','left'); 			
		$this->db->join('ref_pendidikan as pd2','tbl_penduduk.id_pendidikan_terakhir = pd2.id_pendidikan','left'); 			
		$this->db->join('ref_agama','tbl_penduduk.id_agama = ref_agama.id_agama','left'); 		
		$this->db->join('ref_status_kawin','tbl_penduduk.id_status_kawin = ref_status_kawin.id_status_kawin','left'); 	
		$this->db->join('ref_pekerjaan','tbl_penduduk.id_pekerjaan = ref_pekerjaan.id_pekerjaan','left'); 	
		$this->db->join('ref_pekerjaan_ped','tbl_penduduk.id_pekerjaan_ped = ref_pekerjaan_ped.id_pekerjaan_ped','left'); 	
		$this->db->join('ref_kewarganegaraan','tbl_penduduk.id_kewarganegaraan = ref_kewarganegaraan.id_kewarganegaraan','left'); 	
		$this->db->join('ref_kompetensi','tbl_penduduk.id_kompetensi = ref_kompetensi.id_kompetensi','left'); 					
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk','left'); 			
		$this->db->join('ref_status_tinggal','tbl_penduduk.id_status_tinggal = ref_status_tinggal.id_status_tinggal','left'); 			
		$this->db->join('ref_difabilitas','tbl_penduduk.id_difabilitas = ref_difabilitas.id_difabilitas','left'); 				
		$this->db->join('ref_kontrasepsi','tbl_penduduk.id_kontrasepsi = ref_kontrasepsi.id_kontrasepsi','left'); 
		
		$this->db->join('tbl_hub_kel','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk','left'); 
		$this->db->join('tbl_keluarga','tbl_hub_kel.id_keluarga = tbl_keluarga.id_keluarga','left'); 
		
		$this->db->join('ref_status_keluarga','tbl_hub_kel.id_status_keluarga = ref_status_keluarga.id_status_keluarga','left'); 
		$this->db->join('ref_kelas_sosial','tbl_keluarga.id_kelas_sosial = ref_kelas_sosial.id_kelas_sosial','left'); 
		$this->db->group_by('tbl_penduduk.nik');
		$query = $this->db->get();
        $this->excel_generator->set_query($query);
	}

	function insertKeluarga($data)
	{
      $this->db->insert('tbl_keluarga', $data);
	}
	
	function insertHubKel($data)
   {
      $this->db->insert('tbl_hub_kel', $data);
   }
  
	function cekNIKExist($nik)
	{	
		return $this->db->get_where('tbl_penduduk',array('NIK' => $nik))->row();
	}
	function cekNoKKExist($no_kk)
	{	
		return $this->db->get_where('tbl_keluarga',array('no_kk' => $no_kk))->row();
	}
	
	//Id Pendidikan
	function getIdPendidikan($deskripsi)
	{
		$this->db->select('id_pendidikan');
		$this->db->where('deskripsi', $deskripsi);
		$q = $this->db->get('ref_pendidikan');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_pendidikan'];	
		return  $result;	
	}
	
	//pekerjaan PED
	function getIdPekerjaanPED($deskripsi)
	{
		$this->db->select('id_pekerjaan_ped');
		$this->db->like('deskripsi', $deskripsi);
		$q = $this->db->get('ref_pekerjaan_ped');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_pekerjaan_ped'];	
		return  $result;	
	}
	
	//kompetensi
	function getIdKompetensi($deskripsi)
	{
		$this->db->select('id_kompetensi');
		$this->db->like('deskripsi', $deskripsi);
		$q = $this->db->get('ref_kompetensi');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_kompetensi'];	
		return  $result;	
	}
	
	//kompetensi
	function getIdStatusPenduduk($deskripsi)
	{
		$this->db->select('id_status_penduduk');
		$this->db->like('deskripsi', $deskripsi);
		$q = $this->db->get('ref_status_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_status_penduduk'];	
		return  $result;	
	}
	
	//status tinggal
	function getIdStatusTinggal($deskripsi)
	{
		$this->db->select('id_status_tinggal');
		$this->db->like('deskripsi', $deskripsi);
		$q = $this->db->get('ref_status_tinggal');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_status_tinggal'];	
		return  $result;	
	}
	
	//difabilitas
	function getIdDifabilitas($deskripsi)
	{
		$this->db->select('id_difabilitas');
		$this->db->like('deskripsi', $deskripsi);
		$q = $this->db->get('ref_difabilitas');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_difabilitas'];	
		return  $result;	
	}
	
	//kontrasepsi
	function getIdKontrasepsi($deskripsi)
	{
		$this->db->select('id_kontrasepsi');
		$this->db->like('deskripsi', $deskripsi);
		$q = $this->db->get('ref_kontrasepsi');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_kontrasepsi'];	
		return  $result;	
	}
	
	//kelas sosial
	function getIdKelasSosial($deskripsi)
	{
		$this->db->select('id_kelas_sosial');
		$this->db->like('deskripsi', $deskripsi);
		$q = $this->db->get('ref_kelas_sosial');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_kelas_sosial'];	
		return  $result;	
	}
	
	//Id Keluarga By NoKK
	function getIdKeluargaByNoKK($no_kk)
	{
		$this->db->select('id_keluarga');
		$this->db->where('no_kk', $no_kk);
		$q = $this->db->get('tbl_keluarga');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_keluarga'];	
		return  $result;	
	}
	
	 //Id Keluarga By IdKK
	function getIdStatusKeluarga($deskripsi)
	{
		$this->db->select('id_status_keluarga');
		$this->db->where('deskripsi', $deskripsi);
		$q = $this->db->get('ref_status_keluarga');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_status_keluarga'];	
		return  $result;	
	}
	
	 //Id Keluarga By IdKK
	function getIdKeluargaByIdKK($id)
	{
		$this->db->select('id_keluarga');
		$this->db->where('id_kepala_keluarga', $id);
		$q = $this->db->get('tbl_keluarga');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_keluarga'];	
		return  $result;	
	}
	
	 //Id Penduduk By NIK
	function getIdPendudukByNIK($nik)
	{
		$this->db->select('id_penduduk');
		$this->db->where('nik', $nik);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_penduduk'];	
		return  $result;	
	}
	
   //jenis kelamin
	function getIdJenKel($deskripsi)
	{
		$this->db->select('id_jen_kel');
		$this->db->like('deskripsi', $deskripsi);
		$q = $this->db->get('ref_jen_kel');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_jen_kel'];	
		return  $result;	
	}
  //gol darah
	function getIdGolDar($deskripsi)
	{
		$this->db->select('id_goldar');
		$this->db->where('deskripsi', $deskripsi);
		$q = $this->db->get('ref_goldar');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_goldar'];	
		return  $result;	
	}
  //rt
		function getIdRt($nomor_rt, $id_rw)
	{
		$this->db->select('id_rt');
		$this->db->where('id_rw', $id_rw);
		$this->db->where('nomor_rt', $nomor_rt);
		$q = $this->db->get('ref_rt');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_rt'];	
		return  $result;	
	}
  //rw
	function getIdRw($nomor_rw)
	{
		$this->db->select('id_rw');
		$this->db->where('nomor_rw', $nomor_rw);
		$q = $this->db->get('ref_rw');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_rw'];	
		return  $result;	
	}
  //dusun
	function getIdDusun($nama_dusun)
	{
		$this->db->select('id_dusun');
		$this->db->like('nama_dusun', $nama_dusun);
		$q = $this->db->get('ref_dusun');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_dusun'];	
		return  $result;	
	}
  //agama
	function getIdAgama($deskripsi)
	{
		$this->db->select('id_agama');
		$this->db->like('deskripsi', $deskripsi);
		$q = $this->db->get('ref_agama');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_agama'];	
		return  $result;	
	}
  //status perkawinan
	function getIdStatusKawin($deskripsi)
	{
		$this->db->select('id_status_kawin');
		$this->db->where('deskripsi', $deskripsi);
		$q = $this->db->get('ref_status_kawin');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_status_kawin'];	
		return  $result;	
	}
  //pekerjaan
	function getIdPekerjaan($deskripsi)
	{
		$this->db->select('id_pekerjaan');
		$this->db->like('deskripsi', $deskripsi);
		$q = $this->db->get('ref_pekerjaan');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_pekerjaan'];	
		return  $result;	
	}
  //kewarganegaraan
	function getIdKewarganegaraan($deskripsi)
	{
		$this->db->select('id_kewarganegaraan');
		$this->db->like('deskripsi', $deskripsi);
		$q = $this->db->get('ref_kewarganegaraan');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_kewarganegaraan'];	
		return  $result;	
	}
	
  function insertPenduduk($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deletePenduduk($id)
  {
    $this->db->where('id_penduduk', $id);
    $this->db->delete('tbl_hub_kel');
	
	$this->db->where('id_penduduk', $id);
    $this->db->delete($this->_table);
  }
  
  function getPendudukByNIK($id)
  {	
    return $this->db->get_where($this->_table,array('NIK' => $id))->row();
  }
  
  function updatePenduduk($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
    function get_pekerjaan() 
	{      
      	$records = $this->db->get('ref_pekerjaan');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_pekerjaan] = $row->jenis_pekerjaan;
        }
        return ($data);
    }
	
	function get_pendidikan() 
	{      
      	$records = $this->db->get('ref_pendidikan');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_pendidikan] = $row->jenis_pendidikan;
        }
        return ($data);
    }
	
	function get_dusun() 
	{      
      	$records = $this->db->get('ref_dusun');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_dusun] = $row->nama_dusun;
        }
        return ($data);
    }
	
	function get_noKK() 
	{      
      	$records = $this->db->get('data_keluarga');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->KK] = $row->nama;
        }
        return ($data);
    }	
	
	function getDataPendudukByIdPenduduk($id_penduduk)
	{
		 $this->db->select(
		'tbl_penduduk.*,
		ref_rt.nomor_rt as nomor_rt,
		ref_rw.nomor_rw as nomor_rw,
		ref_dusun.nama_dusun as nama_dusun,
		pd1.deskripsi as nama_pendidikan,
		pd2.deskripsi as nama_pendidikan_terakhir,
		ref_agama.deskripsi as nama_agama,
		ref_goldar.deskripsi as nama_goldar,
		ref_jen_kel.deskripsi as nama_jen_kel,
		ref_kewarganegaraan.deskripsi as nama_kewarganegaraan,
		ref_pekerjaan.deskripsi as nama_pekerjaan,
		ref_pekerjaan_ped.deskripsi as nama_pekerjaan_ped,
		ref_kompetensi.deskripsi as nama_kompetensi,
		ref_status_kawin.deskripsi as nama_status_kawin,
		ref_status_penduduk.deskripsi as nama_status_penduduk,
		ref_status_tinggal.deskripsi as nama_status_tinggal,
		ref_difabilitas.deskripsi as nama_difabilitas,
		ref_kontrasepsi.deskripsi as nama_kontrasepsi
		')->from($this->_table);
		
		$this->db->join('ref_rt','tbl_penduduk.id_rt=ref_rt.id_rt','left'); 													// ke tbl RT
		$this->db->join('ref_rw','tbl_penduduk.id_rw=ref_rw.id_rw','left'); 													// ke tbl RW
		$this->db->join('ref_dusun','tbl_penduduk.id_dusun=ref_dusun.id_dusun','left'); 										// ke tbl DUSUN
		$this->db->join('ref_pendidikan as pd1','tbl_penduduk.id_pendidikan = pd1.id_pendidikan','left'); 					// ke tbl PENDIDIKAN
		$this->db->join('ref_pendidikan as pd2','tbl_penduduk.id_pendidikan_terakhir = pd2.id_pendidikan','left'); 			// ke tbl PENDIDIKAN
		$this->db->join('ref_agama','tbl_penduduk.id_agama=ref_agama.id_agama','left'); 										// ke tbl AGAMA
		$this->db->join('ref_goldar','tbl_penduduk.id_goldar = ref_goldar.id_goldar','left'); 									// ke tbl GOLONGAN DARAH
		$this->db->join('ref_jen_kel','tbl_penduduk.id_jen_kel=ref_jen_kel.id_jen_kel','left'); 								// ke tbl JENIS KELAMIN
		$this->db->join('ref_kewarganegaraan','tbl_penduduk.id_kewarganegaraan=ref_kewarganegaraan.id_kewarganegaraan','left'); 			// ke tbl KEWARGANEGARAAN
		$this->db->join('ref_pekerjaan','tbl_penduduk.id_pekerjaan=ref_pekerjaan.id_pekerjaan','left'); 						// ke tbl PEKERJAAN
		$this->db->join('ref_pekerjaan_ped','tbl_penduduk.id_pekerjaan_ped=ref_pekerjaan_ped.id_pekerjaan_ped','left'); 		// ke tbl PEKERJAAN PED
		$this->db->join('ref_kompetensi','tbl_penduduk.id_kompetensi=ref_kompetensi.id_kompetensi','left'); 					// ke tbl KOMPETENSI
		$this->db->join('ref_status_kawin','tbl_penduduk.id_status_kawin=ref_status_kawin.id_status_kawin','left'); 			// ke tbl STATUS KAWIN
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk=ref_status_penduduk.id_status_penduduk','left'); 			// ke tbl STATUS PENDUDUK
		$this->db->join('ref_status_tinggal','tbl_penduduk.id_status_tinggal=ref_status_tinggal.id_status_tinggal','left'); 				// ke tbl STATUS TINGGAL
		$this->db->join('ref_difabilitas','tbl_penduduk.id_difabilitas=ref_difabilitas.id_difabilitas','left'); 				// ke tbl DIFABILITAS
		$this->db->join('ref_kontrasepsi','tbl_penduduk.id_kontrasepsi=ref_kontrasepsi.id_kontrasepsi','left'); 				// ke tbl KONTRASEPSI 
		$this->db->where('tbl_penduduk.id_penduduk',$id_penduduk);
		
		$q = $this->db->get();
		return $q->row();	
		
	}
	
	function getDataHubunganKeluargaByIdPenduduk($id_penduduk)
	{
		 $this->db->select('*')->from('tbl_hub_kel');	
		$this->db->join('tbl_keluarga','tbl_hub_kel.id_keluarga=tbl_keluarga.id_keluarga'); 				// ke tbl KONTRASEPSI 
		$this->db->where('tbl_hub_kel.id_penduduk',$id_penduduk);		
		$q = $this->db->get();
		return $q->row();	
		
	}


	
}

?>