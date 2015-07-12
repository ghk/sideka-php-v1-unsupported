<?php
class M_pages extends CI_Model {

  function __construct(){
		parent::__construct();
		$this->_table='tbl_pages';
	
		//get instance
		$this->CI = get_instance();
	}
	
	
	function insertPages($data){
		$this->db->insert($this->_table, $data);
	}
	
	function deletePages($url){
		$this->db->where('url', $url);	
		$this->db->delete($this->_table);
	}
	  
	function updatePages($where, $data){
		$this->db->where($where);
		$this->db->update($this->_table, $data);
		return $this->db->affected_rows();
	}
  
}
?>