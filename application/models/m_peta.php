<?php
class M_peta extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_peta';
	
    //get instance
    $this->CI = get_instance();
  }
  
  
	public function getPeta()
    {
        //Build contents query
       	$this->db->select('embed');
		$this->db->where('id_peta', 1);
		$q = $this->db->get($this->_table);
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['embed'];	
		if($result == NULL)
		{	
			return 'data tidak ditemukan';
		}
		else return $result;
    }
	
	function updatePeta($where, $data){
		$this->db->where($where);
		$this->db->update($this->_table, $data);
		return $this->db->affected_rows();
	}

    
}
?>