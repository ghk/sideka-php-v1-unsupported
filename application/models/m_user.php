<?php
class M_user extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_pengguna';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_user_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table)->where('id_pengguna >','1');
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_pengguna) as record_count")->from($this->_table)->where('id_pengguna >','1');
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
  function insertUser($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteUser($id)
  {
    $this->db->where('id_pengguna', $id);
    $this->db->delete($this->_table);
  }
  
  function getUserByNamaPengguna($namaPengguna)
  {	
    return $this->db->get_where($this->_table,array('nama_pengguna' => $namaPengguna))->row();
  }
  
  function getUserByIdPengguna($id_pengguna)
  {	
    return $this->db->get_where($this->_table,array('id_pengguna' => $id_pengguna))->row();
  }
  
  function updateUser($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
    
  function idexists($id) {
    $opt = array('id'=>$id);
    $q = $this->db->getwhere('nama_pengguna', $opt);
    $result = false;
    if ($q->num_rows() > 0) {
      	$result = true;
    }
    	$q->free_result();
    return $result;
  } 

  function get_NikPenduduk($nik)
  {
    $this->db->select('nik,nama');
        $this->db->like('nik', $nik);
        $query = $this->db->get('tbl_penduduk');
    
        return $query->result();
  }
  
  function get_NamaPenduduk($nama)
  {
    $this->db->select('nama,nik');
        $this->db->like('nama', $nama);
        $query = $this->db->get('tbl_penduduk');
    
        return $query->result();
  }

    
}
?>