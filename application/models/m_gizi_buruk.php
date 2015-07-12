<?php
class M_gizi_buruk extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_gizi_buruk';
    $this->load->library('Excel_generator');
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_gizi_buruk_flexigrid()
    {
        //Build contents query
        $this->db->select('tbl_gizi_buruk.*,tbl_keluarga.no_kk,tbl_penduduk.nik,tbl_penduduk.nama')->from($this->_table);		
		$this->db->join('tbl_penduduk','tbl_gizi_buruk.id_penduduk = tbl_penduduk.id_penduduk');
		$this->db->join('tbl_hub_kel','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk');
		$this->db->join('tbl_keluarga','tbl_hub_kel.id_keluarga = tbl_keluarga.id_keluarga');	
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_gizi_buruk) as record_count")->from($this->_table);
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
		$this->db->select('tbl_gizi_buruk.*,tbl_penduduk.nik,tbl_penduduk.nama')->from($this->_table);		
		$this->db->join('tbl_penduduk','tbl_gizi_buruk.id_penduduk = tbl_penduduk.id_penduduk');
		
		$query = $this->db->get();
        $this->excel_generator->set_query($query);
	}
  function insertGiziBuruk($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteGiziBuruk($id)
  {
    $this->db->where('id_gizi_buruk', $id);
    $this->db->delete($this->_table);
  }
  
  function getGiziBurukByIdGiziBuruk($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_gizi_buruk' => $id))->row();
  }
  
  function updateGiziBuruk($where, $data) //update
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
   function getIdpendudukByIdGiziBuruk($id_gizi_buruk)
	{
		$this->db->select('id_penduduk');
		$this->db->where('id_gizi_buruk', $id_gizi_buruk);
		$q = $this->db->get('tbl_gizi_buruk');
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