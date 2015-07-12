<?php
class M_log extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_log';
	
    //get instance
    $this->CI = get_instance();
  }
	
  function insertLog($data)
  {
    $this->db->insert($this->_table, $data);
  }
}
?>