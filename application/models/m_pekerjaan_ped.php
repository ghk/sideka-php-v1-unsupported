<?php
class M_pekerjaan_ped extends CI_Model {

   function __construct()
  {
    parent::__construct();
    $this->_table='ref_pekerjaan_ped';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_pekerjaan_ped_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->db->where('id_pekerjaan_ped !=', 0);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_pekerjaan_ped) as record_count")->from($this->_table);
        $this->db->where('id_pekerjaan_ped !=', 0);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
  function insertPekerjaan_ped($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deletePekerjaan_ped($id)
  {
    $this->db->where('id_pekerjaan_ped', $id);
    $this->db->delete($this->_table);
  }
  
  function getPekerjaan_pedByIdPekerjaan_ped($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_pekerjaan_ped' => $id))->row();
  }
  
  function updatePekerjaan_ped($where, $data) //update
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