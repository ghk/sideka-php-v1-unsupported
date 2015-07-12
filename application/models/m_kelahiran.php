<?php
class M_kelahiran extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_kelahiran';
	$this->_tablePenduduk='tbl_penduduk';
	$this->_tableKeluarga='tbl_keluarga';
	$this->_tableHubKeluarga='tbl_hub_kel';
	$this->_tableSurat='tbl_surat';
	$this->_tablePerangkat='tbl_perangkat';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_kelahiran_flexigrid()
    {
        //Build contents query
        $this->db->select
		('
		tbl_kelahiran.id_kelahiran, 
		tbl_kelahiran.tgl_kelahiran, 
		tbl_kelahiran.nama_bayi, 
		ref_jen_kel.deskripsi AS jenis_kelamin,  
		tbl_kelahiran.berat_bayi, 
		tbl_kelahiran.panjang_bayi, 
		tbl_kelahiran.nama_ayah, 
		tbl_kelahiran.nama_ibu, 
		tbl_kelahiran.is_kembar, 
		tbl_kelahiran.lokasi_lahir, 
		tbl_kelahiran.tempat_lahir, 
		tbl_kelahiran.penolong, 
		tbl_kelahiran.id_keluarga, 
		tbl_kelahiran.nama_pelapor,
		tbl_kelahiran.id_surat,
		ref_pelapor.deskripsi AS pelapor
		')->from($this->_table);
		//$this->db->join('tbl_pengguna','tbl_pengguna.id_pengguna=tbl_kelahiran.id_pengguna');
		//$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk=tbl_kelahiran.id_penduduk');
		$this->db->join('tbl_surat','tbl_surat.id_surat=tbl_kelahiran.id_surat');
		$this->db->join('ref_pelapor','ref_pelapor.id_pelapor=tbl_kelahiran.id_pelapor');
		$this->db->join('ref_jen_kel','ref_jen_kel.id_jen_kel = tbl_kelahiran.id_jen_kel');
		//$this->db->join('ref_kode_surat','ref_kode_surat.kode_surat = tbl_surat.kode_surat');
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_kelahiran) as record_count")->from($this->_table);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        $this->CI->flexigrid->build_query(TRUE);
        //Return all
        return $return;
    }
	
	public function get_penduduk_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_tablePenduduk);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_penduduk) as record_count")->from($this->_table);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
	
	function getPendudukByNik()
	{
		$this->db->select('NIK');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
	} 
	
  function insertKelahiran($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function insertPenduduk($data)
  {
    $this->db->insert($this->_tablePenduduk, $data);
  }
  
  function insertHubKeluarga($data)
  {
    $this->db->insert($this->_tableHubKeluarga, $data);
  }
  
  function insertSurat($data)
  {
    $this->db->insert($this->_tableSurat, $data);
  }
  
  function deleteKelahiran($id)
  {
	$idPenduduk = $this->getIdPendudukByIdKelahiran($id);
    $this->db->where('id_kelahiran', $id);
    $this->db->delete($this->_table);
	
	
	$this->db->where('id_penduduk', $idPenduduk);
    $this->db->delete($this->_tablePenduduk);
  }
  
  function deletePenduduk($id)
  {
    $this->db->where('id_penduduk', $id);
    $this->db->delete($this->_tablePenduduk);
  }
  function deleteSurat($id)
  {
	$this->db->where('id_surat', $id);
    $this->db->delete($this->_tableSurat);
  }
  
  function getIdPendudukByIdKelahiran($id)
  {
		$this->db->select('id_penduduk');
		$this->db->where('id_kelahiran', $id);
		$q = $this->db->get('tbl_kelahiran');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['id_penduduk']);
  }
  
  function getKelahiranByIdKelahiran($id)
  {	
    return $this->db->get_where($this->_table,array('id_kelahiran' => $id))->row();
  }
  
  function getPendudukByIdPenduduk($id)
  {	
    return $this->db->get_where($this->_tablePenduduk,array('id_penduduk' => $id))->row();
  }
  
  function getSuratByIdSurat($id)
  {	
    return $this->db->get_where($this->_table,array('id_surat' => $id))->row();
  }
  
  function updateKelahiran($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
  function updatePenduduk($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_tablePenduduk, $data);
    return $this->db->affected_rows();
  }
  
  function updateHubKeluarga($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_tableHubKeluarga, $data);
    return $this->db->affected_rows();
  }
  
  function updateSurat($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_tableSurat, $data);
    return $this->db->affected_rows();
  }
		
	function get_KepalaKeluarga($nama)
	{
		$this->db->select('tbl_penduduk.nama,tbl_keluarga.no_kk');
		$this->db->join('tbl_keluarga','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk');
        $this->db->like('nama', $nama);
        $query = $this->db->get('tbl_penduduk');
        return $query->result();
	}

	
	function get_IdPendudukByNIK($nik)
	{
		$this->db->select('id_penduduk');
		$this->db->where('NIK', $nik);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return $data['id_penduduk'];
	}
	
	function get_IdKeluargaByIdPenduduk($id)
	{
		$this->db->select('id_keluarga');
		$this->db->where('id_penduduk', $id);
		$q = $this->db->get('tbl_hub_kel');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return $data['id_keluarga'];
	}
	
	function get_IdKeluargaByNikAyahIbu($nikAyah, $nikIbu)
	{
		$ayah = $this->get_IdPendudukByNIK($nikAyah);
		$ibu = $this->get_IdPendudukByNIK($nikIbu);
		
		$this->db->select('id_keluarga');
		$this->db->like('id_kepala_keluarga', $ayah);
		$this->db->or_like('id_kepala_keluarga', $ibu);
		$q = $this->db->get('tbl_keluarga');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return $data['id_keluarga'];
	}
	
	function get_IdKepalaKeluargaByIdKeluarga($id)
	{
		$this->db->select('id_kepala_keluarga');
		$this->db->where('id_keluarga', $id);
		$q = $this->db->get('tbl_keluarga');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return $data['id_kepala_keluarga'];
	}
		
	function get_NamaByNik($nik)
	{
		$this->db->select('nama');
		$this->db->where('nik', $nik);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['nama']);
	}
	
	function get_IdPendudukByIdKelahiran($id)
	{
		$this->db->select('id_penduduk');
		$this->db->where('id_kelahiran', $id);
		$q = $this->db->get('tbl_kelahiran');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['id_penduduk']);
	}
		
	function get_IdStatusKeluargaByDeskripsi($deskripsi)
	{
		$this->db->select('id_status_keluarga');
		$this->db->where('deskripsi', $deskripsi);
		$q = $this->db->get('ref_status_keluarga');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['id_status_keluarga']);
	}
	
	function get_NomorSuratByIdSurat($id_surat)
	{
		$this->db->select('nomor_surat');
		$this->db->where('id_surat', $id_surat);
		$q = $this->db->get('tbl_surat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['nomor_surat']);
	}
	
	function get_KodeSuratByDeskripsi($deskripsi)
	{
		$this->db->select('kode_surat');
		$this->db->where('deskripsi', $deskripsi);
		$q = $this->db->get('ref_kode_surat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['kode_surat']);
	}
	
	function get_SupraKodeByKodeSurat($kode_surat)
	{
		$this->db->select('supra_kode');
		$this->db->where('kode_surat', $kode_surat);
		$q = $this->db->get('ref_kode_surat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['supra_kode']);
	}
	
	function get_IdSuratByNomorSurat($nomor_surat)
	{
		$this->db->select('id_surat');
		$this->db->where('nomor_surat', $nomor_surat);
		$q = $this->db->get('tbl_surat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['id_surat']);
	}
	
	function get_IdSuratByIdKelahiran($id_kelahiran)
	{
		$this->db->select('id_surat');
		$this->db->where('id_kelahiran', $id_kelahiran);
		$q = $this->db->get('tbl_kelahiran');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['id_surat']);
	}
	
	function get_IdPerangkatByNomorRegistrasi($nomor_registrasi)
	{
		$this->db->select('id_perangkat');
		$this->db->where('nomor_registrasi', $nomor_registrasi);
		$q = $this->db->get('tbl_surat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['id_perangkat']);
	}
	
	function getNoSuratMax()
	{	
		$this->db->select_max('nomor_registrasi');
		$this->db->where('YEAR(tgl_surat)', date('Y'));
		$q = $this->db->get('tbl_surat');
		$data = array_shift($q->result_array());
		$result = $data['nomor_registrasi'];
		if ($result == NULL)
		{
			return '1';
		}
		else
		{	$temp = intval($result);		
			return  $temp;
		}
	}
	function getNoSuratMaxIncrement()
	{	
		$this->db->select_max('nomor_registrasi');
		$this->db->where('YEAR(tgl_surat)', date('Y'));
		$q = $this->db->get('tbl_surat');
		$data = array_shift($q->result_array());
		$result = $data['nomor_registrasi'];
		if ($result == NULL)
		{
			return '1';
		}
		else
		{	$temp = intval($result)+1;		
			return  $temp;
		}
	}
	
	function getSuratLengkap($id_kelahiran)
	{
		$this->db->select('tbl_penduduk.nik,
		tbl_kelahiran.tgl_kelahiran,
		tbl_kelahiran.nama_bayi,
		tbl_kelahiran.id_jen_kel,
		tbl_kelahiran.berat_bayi,
		tbl_kelahiran.panjang_bayi,
		tbl_kelahiran.nama_ayah,
		tbl_kelahiran.nama_ibu,
		tbl_kelahiran.lokasi_lahir,
		tbl_kelahiran.tempat_lahir,
		tbl_kelahiran.penolong,
		tbl_surat.id_perangkat,
		tbl_surat.keterangan,
		tbl_surat.tgl_surat,
		tbl_surat.tgl_awal,
		tbl_surat.kode_surat,
		tbl_surat.nomor_surat,
		tbl_surat.judul_surat
		');
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_kelahiran.id_penduduk','left');	
		$this->db->join('tbl_surat','tbl_kelahiran.id_surat = tbl_surat.id_surat','left');	
		$this->db->where('tbl_kelahiran.id_kelahiran', $id_kelahiran);
		$data=array();
		$query=$this->db->get('tbl_kelahiran');
		if($query->num_rows()>0)
		{
			$data = $query->result();
		}
		$query->free_result();
		return $data;
	}
	
	
	function cekFIleExist($id_penduduk)
	{	
		return $this->db->get_where($this->_table,array('id_penduduk' => $id_penduduk))->row();
	}
	
		function get_pelapor() 
	{      
      	$records = $this->db->get('ref_pelapor');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_pelapor] = $row->deskripsi;
        }
        return ($data);
    }
	
	function get_jenisKelamin() 
	{      
      	$records = $this->db->get('ref_jen_kel');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_jen_kel] = $row->deskripsi;
        }
        return ($data);
    }
	
	function get_pamong() 
	{      
		$this->db->select('tbl_perangkat.id_perangkat, tbl_perangkat.nip,tbl_penduduk.nama,ref_jabatan.deskripsi as jabatan')->from('tbl_penduduk');
		$this->db->join('tbl_perangkat','tbl_perangkat.id_penduduk = tbl_penduduk.id_penduduk');
		$this->db->join('ref_jabatan','ref_jabatan.id_jabatan = tbl_perangkat.id_jabatan');
		$this->db->where('tbl_perangkat.is_aktif','Y');
		$records = $this->db->get();
		$data=array();
		foreach ($records->result() as $row)
		{	
			$data[''] = '--Pilih--';
			$data[$row->id_perangkat] = $row->nama.' - '.$row->jabatan;
		}
		return ($data);
	}

	
	function get_IdPerangkatByIdSurat($id)
	{
		$this->db->select('id_perangkat');
		$this->db->where('id_surat', $id);
		$q = $this->db->get('tbl_surat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['id_perangkat']);
	}
	
	function getPerangkatByIdPerangkat($id)
	{
		return $this->db->get_where($this->_tablePerangkat,array('id_perangkat' => $id))->row();
	}
	
	function getKepalaKeluargaByIdKeluarga($id)
	{
		$this->db->select('tbl_penduduk.nama,tbl_keluarga.no_kk');
		$this->db->join('tbl_keluarga','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk');
        $this->db->where('id_keluarga', $id);
        $query = $this->db->get('tbl_penduduk');
        return $query->row();
	}
	
	//NEW
		
	function getDusunByIdPenduduk($id)
	{
		$this->db->select('id_dusun');
		$this->db->where('id_penduduk', $id);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return $data['id_dusun'];
	}
	
	function getRwByIdPenduduk($id)
	{
		$this->db->select('id_rw');
		$this->db->where('id_penduduk', $id);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return $data['id_rw'];
	}
	
	function getRtByIdPenduduk($id)
	{
		$this->db->select('id_rt');
		$this->db->where('id_penduduk', $id);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return $data['id_rt'];
	}
	
	function getIdKeluargaByNoKK($no_kk)
	{
		$this->db->select('id_keluarga');
		$this->db->where('no_kk', $no_kk);
		$q = $this->db->get('tbl_keluarga');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return $data['id_keluarga'];
	}
	
	function getIdPendudukByIdKeluarga($id)
	{
		$this->db->select('id_kepala_keluarga');
		$this->db->where('id_keluarga', $id);
		$q = $this->db->get('tbl_keluarga');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return $data['id_kepala_keluarga'];
	}
	
	function get_IdKeluargaByIdKelahiran($id_kelahiran)
	{
		$this->db->select('id_keluarga');
		$this->db->where('id_kelahiran', $id_kelahiran);
		$q = $this->db->get('tbl_kelahiran');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['id_keluarga']);
	}

}
?>