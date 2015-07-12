<?php
class M_provinsi extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='ref_provinsi';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_provinsi_flexigrid()
	{
		//Build contents query
		$this->db->select('*')->from($this->_table);
    $this->db->where('id_provinsi <>','0');
		$this->CI->flexigrid->build_query();

		//Get contents
		$return['records'] = $this->db->get();

		//Build count query
		$this->db->select("count(id_provinsi) as record_count")->from($this->_table);
		$this->db->where('id_provinsi <>','0');
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();

		//Get Record Count
		$return['record_count'] = $row->record_count;

		//Return all
		return $return;
	}
  function insertProvinsi($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteProvinsi($id)
  {
    $this->db->where('id_provinsi', $id);
    $this->db->delete($this->_table);
  }
  
  function getProvinsiByIdprov($id)
  {	
    return $this->db->get_where($this->_table,array('id_provinsi' => $id))->row();
  }
  
  function cekFIleExistByKodeBPS($kode_provinsi_bps)
  {	
    return $this->db->get_where($this->_table,array('kode_provinsi_bps' => $kode_provinsi_bps))->row();
  }
  
  function updateProvinsi($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
}
?>