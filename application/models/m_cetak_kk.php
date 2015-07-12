<?php
class M_cetak_kk extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_keluarga';
	
    //get instance
    $this->CI = get_instance();
  }
	
	function GetIdPendudukByNIK($nik)
	{
		$this->db->select('id_penduduk')->from('tbl_penduduk');
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		$this->db->where('ref_status_penduduk.deskripsi <>','Meninggal');
		$this->db->where('nik', $nik);
		$q = $this->db->get();
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_penduduk'];
		return  $result;
	}
	function GetIdKeluargaByIdKK($id)
	{
		$this->db->select('id_keluarga')->from('tbl_keluarga');
		$this->db->where('id_kepala_keluarga', $id);
		$q = $this->db->get();
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_keluarga'];
		return  $result;
	}
	
	function GetPendudukByIdPenduduk($id)
	{
		$this->db->select('tbl_keluarga.no_kk,
		tbl_penduduk.nama,
		tbl_keluarga.alamat_jalan,
		ref_rt.nomor_rt,
		ref_rw.nomor_rw,
		ref_desa.nama_desa,
		ref_desa.kode_pos,
		ref_kecamatan.nama_kecamatan,
		ref_kab_kota.nama_kab_kota,
		ref_provinsi.nama_provinsi');
		$this->db->join('tbl_keluarga ','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk','left');	
		$this->db->join('ref_rt','ref_rt.id_rt = tbl_penduduk.id_rt','left');
		$this->db->join('ref_rw','ref_rw.id_rw = tbl_penduduk.id_rw','left');
		$this->db->join('ref_dusun','ref_dusun.id_dusun = tbl_keluarga.id_dusun','left');
		$this->db->join('ref_desa','ref_desa.id_desa = ref_dusun.id_desa','left');
		$this->db->join('ref_kecamatan','ref_kecamatan.id_kecamatan = ref_desa.id_kecamatan','left');
		$this->db->join('ref_kab_kota','ref_kab_kota.id_kab_kota = ref_kecamatan.id_kab_kota','left');
		$this->db->join('ref_provinsi ','ref_provinsi.id_provinsi = ref_kab_kota.id_provinsi','left');
		$this->db->join('ref_status_penduduk','ref_status_penduduk.id_status_penduduk= tbl_penduduk.id_status_penduduk','left');
		$this->db->where('tbl_penduduk.id_penduduk', $id);
		$this->db->where('ref_status_penduduk.deskripsi <>', 'Meninggal');
		//$this->db->where('ref_status_penduduk.deskripsi <>', 'Pindahan Keluar');
		$this->db->where('tbl_penduduk.is_sementara', 'N');
		$data=array();
		$query=$this->db->get('tbl_penduduk');
		if($query->num_rows()>0)
		{
			$data = $query->result();
		}
		$query->free_result();
		return $data;
	}
	
	function GetPendudukByIdKeluarga($id)
	{	$this->db->select('tbl_penduduk.nama,
		tbl_penduduk.nik,
		ref_jen_kel.deskripsi as jen_kel,
		tbl_penduduk.tempat_lahir,
		tbl_penduduk.tanggal_lahir,
		ref_agama.deskripsi as agama,
		ref_agama.is_diakui,
		ref_pendidikan.deskripsi as pendidikan,
		ref_pekerjaan.deskripsi as pekerjaan,
		ref_status_kawin.deskripsi as status_kawin,
		ref_status_keluarga.deskripsi as status_keluarga,
		ref_kewarganegaraan.deskripsi as kewarganegaraan,
		tbl_penduduk.no_paspor,
		tbl_penduduk.no_kitas,
		tbl_hub_kel.nama_ayah,
		tbl_hub_kel.nama_ibu');
		$this->db->join('tbl_keluarga','tbl_keluarga.id_keluarga = tbl_hub_kel.id_keluarga','left');	
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk','left');
		$this->db->join('ref_jen_kel','ref_jen_kel.id_jen_kel = tbl_penduduk.id_jen_kel','left');
		$this->db->join('ref_agama','ref_agama.id_agama = tbl_penduduk.id_agama','left');
		$this->db->join('ref_pendidikan ','ref_pendidikan.id_pendidikan = tbl_penduduk.id_pendidikan','left');
		$this->db->join('ref_pekerjaan','ref_pekerjaan.id_pekerjaan = tbl_penduduk.id_pekerjaan','left');
		$this->db->join('ref_status_kawin','ref_status_kawin.id_status_kawin = tbl_penduduk.id_status_kawin','left');
		$this->db->join('ref_status_keluarga  ','ref_status_keluarga.id_status_keluarga = tbl_hub_kel.id_status_keluarga','left');
		$this->db->join('ref_kewarganegaraan ','ref_kewarganegaraan.id_kewarganegaraan = tbl_penduduk.id_kewarganegaraan','left');
		$this->db->join('ref_status_penduduk','ref_status_penduduk.id_status_penduduk= tbl_penduduk.id_status_penduduk','left');
		$this->db->where('tbl_hub_kel.id_keluarga', $id);
		$this->db->where('ref_status_penduduk.deskripsi <>', 'Meninggal');
		//$this->db->where('ref_status_penduduk.deskripsi <>', 'Pindahan Keluar');
		$this->db->where('tbl_penduduk.is_sementara', 'N');
		$this->db->order_by('tbl_hub_kel.id_status_keluarga');		
		$data=array();
		$query=$this->db->get('tbl_hub_kel');
		if($query->num_rows()>0)
		{
			$data = $query->result();
		}
		$query->free_result();
		return $data;
	}
	
	function get_NikPenduduk($nik)
	{
		$this->db->select('tbl_keluarga.id_kepala_keluarga,
		tbl_penduduk.nama,tbl_penduduk.nik');
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk =tbl_keluarga.id_kepala_keluarga');			
		$this->db->where('tbl_penduduk.nik', $nik);
		$query = $this->db->get('tbl_keluarga');
		
		return $query->result();
	}
	function get_NamaPenduduk($nama)
	{
		$this->db->select('tbl_keluarga.id_kepala_keluarga,
		tbl_penduduk.nama,tbl_penduduk.nik');
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk =tbl_keluarga.id_kepala_keluarga');	
		$this->db->like('tbl_penduduk.nama', $nama);
		$query = $this->db->get('tbl_keluarga');
		
        return $query->result();
	}
	
 	function getPendudukByNIK($id)
   	{	
    	 	return $this->db->get_where('tbl_penduduk',array('NIK' => $id))->row();
   	} 
	
	function getKepalaKeluargaLikeNama($nama)
	{
		$this->db->select('tbl_penduduk.nama, tbl_keluarga.no_kk, tbl_penduduk.nik');
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_keluarga.id_kepala_keluarga','left');
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		$this->db->where('ref_status_penduduk.deskripsi <>','Meninggal');
		$this->db->like('tbl_penduduk.nama', $nama);
		$query = $this->db->get('tbl_keluarga');
		return $query->result();
	}
   	
   
}
?>