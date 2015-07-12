<?php
class M_status_tinggal extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='ref_status_tinggal';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_status_tinggal_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->db->where('id_status_tinggal !=', 0);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_status_tinggal) as record_count")->from($this->_table);
        $this->db->where('id_status_tinggal !=', 0);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
  function insertStatusTinggal($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteStatusTinggal($id)
  {
    $this->db->where('id_status_tinggal', $id);
    $this->db->delete($this->_table);
  }
  
  function getStatusTinggalByIdStatusTinggal($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_status_tinggal' => $id))->row();
  }
  
  function updateStatusTinggal($where, $data) //update
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