<?php
class M_pisah_kk extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_pisah_kk';
	
    //get instance
    $this->CI = get_instance();
  }
	
   
  function insertPisahKk($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deletePisahKk($id)
  {
    $this->db->where('id_pisah_kk', $id);
    $this->db->delete($this->_table);
  }
  
  function getPisahKkByIdPisahKk($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_pisah_kk' => $id))->row();
  }
  
  function updatePisahKk($where, $data) //update
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
   function getIdpendudukByIdPisahKk($id_pisah_kk)
	{
		$this->db->select('id_penduduk');
		$this->db->where('id_pisah_kk', $id_pisah_kk);
		$q = $this->db->get('tbl_pisah_kk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_penduduk'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
	
  function getPendudukByIdPisahKk($id)
  {	
	$id_penduduk=$this->getIdpendudukByIdPisahKk($id);
    return $this->db->get_where('tbl_penduduk',array('id_penduduk' => $id_penduduk))->row();
  }
  
  	function getIdPendudukByNIK($nik)
	{
		$this->db->select('id_penduduk');
		$this->db->where('nik', $nik);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_penduduk'];	
		if($result == NULL)
		{	
			return 'data tidak ditemukan';
		}
		else return $result; 
	}
	function getIdPisahKkByIdPenduduk($id_penduduk)
	{
		$this->db->select('id_pisah_kk');
		$this->db->where('id_penduduk', $id_penduduk);
		$q = $this->db->get('tbl_pisah_kk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_pisah_kk'];	
		if($result == NULL)
		{	
			return 'data tidak ditemukan';
		}
		else return $result; 
	}
	
	function cekFIleExist($id_penduduk)
	{	
		return $this->db->get_where($this->_table,array('id_penduduk' => $id_penduduk))->row();
	}
	
	function get_NikPenduduk($nik,$punya)
	{
		$this->db->select('nik,nama');
		$this->db->join('tbl_hub_kel','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk');
        if($punya != 'pindah_kk')
		{
			$this->db->where('id_status_keluarga !=',1);
		}
        $this->db->like('nik', $nik);
        $query = $this->db->get('tbl_penduduk');
		
        return $query->result();
	}
	
	function get_NamaPenduduk($nama,$punya)
	{
		$this->db->select('nama,nik');
		$this->db->join('tbl_hub_kel','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk');
        if($punya != 'pindah_kk')
		{
			$this->db->where('id_status_keluarga !=',1);
		}
        $this->db->like('nama', $nama);
        $query = $this->db->get('tbl_penduduk');
		
        return $query->result();
	}
	
	function cekKepalaKeluargaByIdPenduduk($id)
	{
		$this->db->select('id_keluarga');
		$this->db->where('id_kepala_keluarga',$id);
		$q	= $this->db->get('tbl_keluarga',1);
		return $q->row();
	}
	
	function cekKesendirianByIdKeluarga($id_keluarga)
	{
		$this->db->select('tbl_hub_kel.id_hub_kel');		
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk');
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		$this->db->where('tbl_hub_kel.id_keluarga',$id_keluarga);
		$this->db->where('ref_status_penduduk.deskripsi <>','Meninggal');
		$q	= $this->db->get('tbl_hub_kel');
		if($q->num_rows() == 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function getIdKeluargaByNoKK($no_kk)
	{	
		$this->db->select('id_keluarga');
		$this->db->where('no_kk', $no_kk);
		$q = $this->db->get('tbl_keluarga',1);
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_keluarga'];	
		if($result == NULL)
		{	
			return 'data tidak ditemukan';
		}
		else return $result; 
	}
	
	function getIdKeluargaByIdPenduduk($id_penduduk)
	{	
		$this->db->select('id_keluarga');
		$this->db->where('id_kepala_keluarga', $id_penduduk);
		$q = $this->db->get('tbl_keluarga',1);
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_keluarga'];	
		if($result == NULL)
		{	
			return 'data tidak ditemukan';
		}
		else return $result; 
	}
	
	function deleteKeluargaByIdKeluarga($id_keluarga)
	{
		$this->db->where('id_keluarga', $id_keluarga);
		$this->db->delete('tbl_keluarga');
	}
	
}
?>