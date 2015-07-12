<?php
class M_changePass extends CI_Model {

  function __construct()
  {
    parent::__construct();
   	$this->tabel = 'pengguna';
	
    //get instance
    $this->CI = get_instance();
  }  
  
  function updatePenggunaByName($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->tabel, $data);
    return $this->db->affected_rows();
  }
  
  function getPassPengguna()
  {
  	return $this->db->get_where($this->tabel,array('username' => $id))->row();
  }
  
    
  function idexists($username) 
  {
    $opt = array('username'=>$username);
    $q = $this->db->getwhere('username', $opt);
    $result = false;
    if ($q->num_rows() > 0) {
      	$result = true;
    }
    	$q->free_result();
    return $result;
  }

    
}
?>