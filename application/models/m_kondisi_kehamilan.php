<?php
class M_kondisi_kehamilan extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_kondisi_kehamilan';
    $this->load->library('Excel_generator');
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_kondisi_kehamilan_flexigrid()
    {
        //Build contents query
        $this->db->select('tbl_kondisi_kehamilan.*,tbl_penduduk.nik,tbl_penduduk.nama')->from($this->_table);		
		$this->db->join('tbl_penduduk','tbl_kondisi_kehamilan.id_penduduk = tbl_penduduk.id_penduduk');
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_kondisi_kehamilan) as record_count")->from($this->_table);
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
		$this->db->select('tbl_kondisi_kehamilan.*,tbl_penduduk.nik,tbl_penduduk.nama')->from($this->_table);		
		$this->db->join('tbl_penduduk','tbl_kondisi_kehamilan.id_penduduk = tbl_penduduk.id_penduduk');
		
		$query = $this->db->get();
        $this->excel_generator->set_query($query);
	}
    
  function insertKondisiKehamilan($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteKondisiKehamilan($id)
  {
    $this->db->where('id_kondisi_kehamilan', $id);
    $this->db->delete($this->_table);
  }
  
  function getKondisiKehamilanByIdKondisiKehamilan($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_kondisi_kehamilan' => $id))->row();
  }
  
  function updateKondisiKehamilan($where, $data) //update
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
   function getIdpendudukByIdKondisiKehamilan($id_kondisi_kehamilan)
	{
		$this->db->select('id_penduduk');
		$this->db->where('id_kondisi_kehamilan', $id_kondisi_kehamilan);
		$q = $this->db->get('tbl_kondisi_kehamilan');
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
	
  function getPendudukByIdKondisiKehamilan($id)
  {	
	$id_penduduk=$this->getIdpendudukByIdKondisiKehamilan($id);
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
	function getIdKondisiKehamilanByIdPenduduk($id_penduduk)
	{
		$this->db->select('id_kondisi_kehamilan');
		$this->db->where('id_penduduk', $id_penduduk);
		$q = $this->db->get('tbl_kondisi_kehamilan');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_kondisi_kehamilan'];	
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
        $this->db->where('id_jen_kel',2);
        $this->db->like('nik', $nik);
        $query = $this->db->get('tbl_penduduk');
		
        return $query->result();
	}
	
	function get_NamaPenduduk($nama)
	{
		$this->db->select('nama,nik');
        $this->db->where('id_jen_kel',2);
        $this->db->like('nama', $nama);
        $query = $this->db->get('tbl_penduduk');
		
        return $query->result();
	}
	
}
?>