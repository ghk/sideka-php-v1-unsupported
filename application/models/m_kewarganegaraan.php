<?php
class M_kewarganegaraan extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='ref_kewarganegaraan';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_kewarganegaraan_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->db->where('id_kewarganegaraan !=', 0);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_kewarganegaraan) as record_count")->from($this->_table);
        $this->db->where('id_kewarganegaraan !=', 0);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
  function insertKewarganegaraan($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteKewarganegaraan($id)
  {
    $this->db->where('id_kewarganegaraan', $id);
    $this->db->delete($this->_table);
  }
  
  function getKewarganegaraanByIdKewarganegaraan($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_kewarganegaraan' => $id))->row();
  }
  
  function updateKewarganegaraan($where, $data) //update
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