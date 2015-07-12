<?php
class M_berita extends CI_Model {

  function __construct(){
		parent::__construct();
		$this->_table='berita';
	
		//get instance
		$this->CI = get_instance();
	}
	public function get_berita_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(judul_berita) as record_count")->from($this->_table);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
	function insertBerita($data){
		$this->db->insert($this->_table, $data);
	}
	
	function deleteBerita($id){
		$this->db->where('judul_berita', $id);	
		$this->db->delete($this->_table);
	}
	  
	function updateBerita($where, $data){
		$this->db->where($where);
		$this->db->update($this->_table, $data);
		return $this->db->affected_rows();
	}
  
    function getBeritaByIdberita($id)
	{	
		return $this->db->get_where($this->_table,array('id_berita' => $id))->row();
	}
 
	public function get_recent_berita(){
		$this->db->order_by("waktu", "desc");
		return $this->db->get('berita',3,0)->result();
	}
	
	public function get_recent_berita_all(){
		$this->db->order_by("waktu", "desc");
		return $this->db->get('berita')->result();
	}
}
?>