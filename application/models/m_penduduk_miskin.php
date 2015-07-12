<?php
class M_penduduk_miskin extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_keluarga';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_penduduk_miskin_flexigrid()
    {
	
		/*select tbl_keluarga.*,tbl_penduduk.nik,tbl_penduduk.nama from tbl_keluarga
		join tbl_penduduk on tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk
		join ref_kelas_sosial on tbl_keluarga.id_kelas_sosial = ref_kelas_sosial.id_kelas_sosial */

        //Build contents query
        $this->db->select('tbl_keluarga.id_keluarga,
        tbl_keluarga.id_kepala_keluarga as id_kepala_keluarga,
        tbl_keluarga.id_kelas_sosial as id_kelas_sosial,
        tbl_keluarga.no_kk as no_kk,
        tbl_keluarga.is_pkh as is_pkh,
        tbl_keluarga.is_jamkesmas as is_jamkesmas,
        tbl_keluarga.is_raskin,
        tbl_penduduk.nik,tbl_penduduk.nama,ref_kelas_sosial.deskripsi as kelas_sosial')->from($this->_table);	//kelas sosial	
		$this->db->join('tbl_penduduk','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk');
		$this->db->join('ref_kelas_sosial','tbl_keluarga.id_kelas_sosial = ref_kelas_sosial.id_kelas_sosial');
        //$this->db->where('tbl_keluarga.id_kelas_sosial',$id_kelas_sosial);
		$this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_keluarga) as record_count")->from($this->_table);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        $this->CI->flexigrid->build_query(TRUE);
        //Return all
        return $return;
    }
  function insertGiziBuruk($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteGiziBuruk($id)
  {
    $this->db->where('id_penduduk_miskin', $id);
    $this->db->delete($this->_table);
  }
  
  function getGiziBurukByIdGiziBuruk($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_penduduk_miskin' => $id))->row();
  }
  
  function updateGiziBuruk($where, $data) //update
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
   function getIdpendudukByIdGiziBuruk($id_penduduk_miskin)
	{
		$this->db->select('id_penduduk');
		$this->db->where('id_penduduk_miskin', $id_penduduk_miskin);
		$q = $this->db->get('tbl_keluarga');
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
	
  function getPendudukByIdGiziBuruk($id)
  {	
	$id_penduduk=$this->getIdpendudukByIdGiziBuruk($id);
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
	
	function cekFIleExist($id_penduduk)
	{	
		return $this->db->get_where($this->_table,array('id_penduduk' => $id_penduduk))->row();
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
	
}
?>