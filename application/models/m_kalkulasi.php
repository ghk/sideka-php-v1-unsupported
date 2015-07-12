<?php
class M_kalkulasi extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_penduduk';
	
    //get instance
    $this->CI = get_instance();
  }
	public function getTotalPenduduk()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
      
        $record_count = $this->db->get();
        return $record_count->num_rows();	
    }
	
	public function getTotalPendudukByKelamin($id_jen_kel)
    {
        //Build contents query
        $this->db->select('*')->from($this->_table)->where('id_jen_kel',$id_jen_kel);
      
        $record_count = $this->db->get();
		return $record_count->num_rows();	
    }

    
}
?>