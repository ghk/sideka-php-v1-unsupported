<?php
class M_pekerjaan extends CI_Model {

   function __construct()
  {
    parent::__construct();
    $this->_table='ref_pekerjaan';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_pekerjaan_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->db->where('id_pekerjaan !=', 0);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_pekerjaan) as record_count")->from($this->_table);
        $this->db->where('id_pekerjaan !=', 0);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
  function insertPekerjaan($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deletePekerjaan($id)
  {
    $this->db->where('id_pekerjaan', $id);
    $this->db->delete($this->_table);
  }
  
  function getPekerjaanByIdPekerjaan($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_pekerjaan' => $id))->row();
  }
  
  function updatePekerjaan($where, $data) //update
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