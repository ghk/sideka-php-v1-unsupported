<?php
class M_surat extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_surat';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_surat_flexigrid()
	{
		//Build contents query
		$this->db->select('tbl_surat.*,ref_kode_surat.deskripsi,tbl_penduduk.nama')->from($this->_table);
		$this->db->join('ref_kode_surat','ref_kode_surat.kode_surat=tbl_surat.kode_surat');
		$this->db->join('tbl_perangkat','tbl_perangkat.id_perangkat= tbl_surat.id_perangkat');
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk= tbl_perangkat.id_penduduk');
		$this->CI->flexigrid->build_query();

		//Get contents
		$return['records'] = $this->db->get();

		//Build count query
		$this->db->select("count(id_surat) as record_count")->from($this->_table);
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();

		//Get Record Count
		$return['record_count'] = $row->record_count;

		//Return all
		return $return;
	}
	
	function getSuratLengkap($id_surat)
	{
		$this->db->select('tbl_penduduk.nik,
		tbl_surat.keterangan,
		tbl_surat.tgl_surat,
		tbl_surat.nomor_surat,
		tbl_surat.kata_penutup,
		tbl_surat.id_perangkat,
		tbl_surat.tgl_awal,
		tbl_surat.tgl_akhir,
		tbl_surat.judul_surat
		');
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_surat.id_penduduk','left');	
		$this->db->where('tbl_surat.id_surat', $id_surat);
		$data=array();
		$query=$this->db->get('tbl_surat');
		if($query->num_rows()>0)
		{
			$data = $query->result();
		}
		$query->free_result();
		return $data;
	}
	
	function getSuratKelahiran($id_penduduk)
	{
		$this->db->select('tbl_kelahiran.nama_bayi,
		tbl_kelahiran.tempat_lahir,
		tbl_kelahiran.tgl_kelahiran,
		tbl_kelahiran.berat_bayi,
		tbl_kelahiran.panjang_bayi,
		ref_jen_kel.deskripsi,
		tbl_kelahiran.nama_ayah,
		tbl_kelahiran.nama_ibu,
		tbl_kelahiran.lokasi_lahir,
		tbl_kelahiran.penolong
		');
		$this->db->join('ref_jen_kel','ref_jen_kel.id_jen_kel = tbl_kelahiran.id_jen_kel');	
		$this->db->where('tbl_kelahiran.id_penduduk', $id_penduduk);
		$query=$this->db->get('tbl_kelahiran');
		
		return $query->row();
	}
	
	function getSuratKematian($id_penduduk)
	{
		$this->db->select('tbl_meninggal.tgl_meninggal,
		tbl_meninggal.sebab,
		tbl_meninggal.penentu_kematian,
		tbl_meninggal.tempat_kematian
		');
		$this->db->where('tbl_meninggal.id_penduduk', $id_penduduk);
		$query=$this->db->get('tbl_meninggal');
		
		return $query->row();
	}
	
	//Id Surat
	function getIdSuratByNomor($no)
	{
		$this->db->select('id_surat');
		$this->db->where('nomor_surat', $no);
		$q = $this->db->get('tbl_surat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_surat'];	
		return  $result;	
	}
	
	//Id Penduduk
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
	
	//Id Penduduk By surat
	function getIdPendudukByIdSurat($id)
	{
		$this->db->select('id_penduduk');
		$this->db->where('id_surat', $id);
		$q = $this->db->get('tbl_surat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_penduduk'];	
		return  $result;	
	}
	//Id Penduduk
	function getPendudukByIdPenduduk($id)
	{
		return $this->db->get_where('tbl_penduduk',array('id_penduduk' => $id))->row();
	}
	
	function get_NikPenduduk($nik)
	{
		$this->db->select('nik,nama');
		$this->db->like('nik', $nik);
		$query = $this->db->get('tbl_penduduk');
		
		return $query->result();
	}
	function get_NamaPenduduk($nama)
	{
		$this->db->select('nama,nik');
        $this->db->like('nama', $nama);
        $query = $this->db->get('tbl_penduduk');
		
        return $query->result();
	}
	
 	function getPendudukByNIK($id)
   	{	
    	 	return $this->db->get_where('tbl_penduduk',array('NIK' => $id))->row();
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
	
	function getNamaByIdPerangkat($id) 
	{      
		$this->db->select('tbl_penduduk.nama')->from('tbl_penduduk');
		$this->db->join('tbl_perangkat','tbl_perangkat.id_penduduk = tbl_penduduk.id_penduduk');
		$this->db->where('tbl_perangkat.id_perangkat', $id);
		$q = $this->db->get();
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['nama'];
		return  $result;
	}
	
	function getJabatanByIdPerangkat($id) 
	{      
		$this->db->select('ref_jabatan.deskripsi as jabatan')->from('ref_jabatan');
		$this->db->join('tbl_perangkat','tbl_perangkat.id_jabatan = ref_jabatan.id_jabatan');
		$this->db->where('tbl_perangkat.id_perangkat', $id);
		$q = $this->db->get();
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['jabatan'];
		return  $result;
	}
   
    	function getIdKeluargaByIdPenduduk($id)
	{
		$this->db->select('tbl_hub_kel.id_keluarga as id_keluarga');
		$this->db->where('id_penduduk', $id);
		$q = $this->db->get('tbl_hub_kel');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_keluarga'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	} 
	function getAlamatById($id)
  {
	//pake id penduduk dapatkan id keluarga di hub_kel lalu get alamat di tbl_keluarga
	//berdasarkan id keluarga
		$id_keluarga=$this->getIdKeluargaByIdPenduduk($id);
		
		$this->db->select('alamat_jalan');
		$this->db->where('id_keluarga', $id_keluarga);
		$q = $this->db->get('tbl_keluarga');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['alamat_jalan'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
  }
	function getDeskripsiKodeSuratById($id)
	{
		$this->db->select('deskripsi');
		$this->db->where('kode_surat', $id);
		$q = $this->db->get('ref_kode_surat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['deskripsi'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
	function getSupraKodeSuratById($id)
	{
		$this->db->select('supra_kode');
		$this->db->where('kode_surat', $id);
		$q = $this->db->get('ref_kode_surat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['supra_kode'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
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
		{	$temp = $result+1;		
			return  $temp;
		}
	}
	
	
	  function cekFIleExistByNoSurat($noMax)
	  {	
		$this->db->select_max('nomor_registrasi')->from('tbl_surat');
		$this->db->where('YEAR(tgl_surat)', date('Y'));
		$q = $this->db->get();
		$data = array_shift($q->result_array());
		$result = $data['nomor_registrasi'];
		
		if($noMax==$result)
		{
			return '1';
		}
		else
		{
			return NULL;
		}
	  }
	  
	  function cekNIKExist($nik)
	  {	
		return $this->db->get_where('tbl_penduduk',array('NIK' => $nik))->row();
	  }

      
	
	function getAlamatDesa()
	{
		$this->db->select('alamat_desa')->from('ref_desa');
		$this->db->where('id_desa','1');
		$q = $this->db->get();
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['alamat_desa'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
	
	function getNIP($id)
	{
		$this->db->select('nip')->from('tbl_perangkat');
		$this->db->where('id_perangkat',$id);
		$q = $this->db->get();
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['nip'];
		return  $result;
		
	}
	
	function getProvinsi()
	{
		$this->db->select('nama_provinsi')->from('ref_provinsi');
		$this->db->where('id_provinsi','1');
		$q = $this->db->get();
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['nama_provinsi'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
	
	  function getKabupaten()
	{
		$this->db->select('nama_kab_kota')->from('ref_kab_kota');
		$this->db->where('id_kab_kota','1');
		$q = $this->db->get();
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['nama_kab_kota'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
	  function getKecamatan()
	{
		$this->db->select('nama_kecamatan')->from('ref_kecamatan');
		$this->db->where('id_kecamatan','1');
		$q = $this->db->get();
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['nama_kecamatan'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
	function getDesa()
	{
		$this->db->select('nama_desa')->from('ref_desa');
		$this->db->where('id_desa','1');
		$q = $this->db->get();
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['nama_desa'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
   function getJenKelById($id)
	{
		$this->db->select('deskripsi');
		$this->db->where('id_jen_kel', $id);
		$q = $this->db->get('ref_jen_kel');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['deskripsi'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
  function getAgamaById($id)
	{
		$this->db->select('deskripsi');
		$this->db->where('id_agama', $id);
		$q = $this->db->get('ref_agama');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['deskripsi'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
	function getStatusById($id)
	{
		$this->db->select('deskripsi');
		$this->db->where('id_status_kawin', $id);
		$q = $this->db->get('ref_status_kawin');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['deskripsi'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
	function getPendidikanById($id)
	{
		$this->db->select('deskripsi');
		$this->db->where('id_pendidikan', $id);
		$q = $this->db->get('ref_pendidikan');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['deskripsi'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
	function getPekerjaanById($id)
	{
		$this->db->select('deskripsi');
		$this->db->where('id_pekerjaan', $id);
		$q = $this->db->get('ref_pekerjaan');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['deskripsi'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
	function getKWById($id)
	{
		$this->db->select('deskripsi');
		$this->db->where('id_kewarganegaraan', $id);
		$q = $this->db->get('ref_kewarganegaraan');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['deskripsi'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}

  function insertSurat($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteSurat($id)
  {
    $this->db->where('id_surat', $id);
    $this->db->delete($this->_table);
  }
  
  function getSuratByIdSurat($id)
  {	
    return $this->db->get_where($this->_table,array('id_surat' => $id))->row();
  }
  
  function updateSurat($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
  function get_kode_surat() 
  {      
	$records = $this->db->get('ref_kode_surat');
	$data=array();
	foreach ($records->result() as $row)
	{	
		$data[''] = '--Pilih--';
		$data[$row->kode_surat] = $row->deskripsi;
	}
	return ($data);
  }
}
?>