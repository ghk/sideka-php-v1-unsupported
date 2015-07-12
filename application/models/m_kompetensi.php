<?php
class M_kompetensi extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='ref_kompetensi';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_kompetensi_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->db->where('id_kompetensi !=', 0);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_kompetensi) as record_count")->from($this->_table);
        $this->db->where('id_kompetensi !=', 0);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
  function insertKompetensi($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteKompetensi($id)
  {
    $this->db->where('id_kompetensi', $id);
    $this->db->delete($this->_table);
  }
  
  function getKompetensiByIdKompetensi($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_kompetensi' => $id))->row();
  }
  
  function updateKompetensi($where, $data) //update
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