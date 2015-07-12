<?php
class M_alasan_pindah extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='ref_alasan_pindah';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_alasan_pindah_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->db->where('id_alasan_pindah !=', 0);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_alasan_pindah) as record_count")->from($this->_table);
        $this->db->where('id_alasan_pindah !=', 0);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
  function insertAlasanPindah($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteAlasanPindah($id)
  {
    $this->db->where('id_alasan_pindah', $id);
    $this->db->delete($this->_table);
  }
  
  function getAlasanPindahByIdAlasanPindah($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_alasan_pindah' => $id))->row();
  }
  
  function updateAlasanPindah($where, $data) //update
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