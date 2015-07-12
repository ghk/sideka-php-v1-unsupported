<?php
class M_kode_surat extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='ref_kode_surat';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_kode_surat_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(kode_surat) as record_count")->from($this->_table);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
  function insertKodeSurat($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteKodeSurat($id)
  {
    $this->db->where('kode_surat', $id);
    $this->db->delete($this->_table);
  }
  
  function getKodeSuratByIdKodeSurat($id) //edit
  {	
    return $this->db->get_where($this->_table,array('kode_surat' => $id))->row();
  }
  
  function updateKodeSurat($where, $data) //update
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
	function cekFIleExist($deskripsi)
	{	
		return $this->db->get_where($this->_table,array('deskripsi' => $deskripsi))->row();
	}
}
?>