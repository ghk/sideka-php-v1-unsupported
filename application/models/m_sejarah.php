<?php
class M_sejarah extends CI_Model {

  function __construct(){
		parent::__construct();
		$this->_table='tbl_sejarah';
	
		//get instance
		$this->CI = get_instance();
	}
	public function get_sejarah_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_sejarah) as record_count")->from($this->_table);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
	
	function insertSejarah($data){
		$this->db->insert($this->_table, $data);
	}
	
	function updateSejarah($where, $data)
	{
		$this->db->where($where);
		$this->db->update($this->_table, $data);
		return $this->db->affected_rows();
	}
	
	function deleteSejarah($id){
		$this->db->where('isi_sejarah', $id);
		$this->db->delete($this->_table);
	}
	
	function getSejarahByIdsejarah($id)
	{	
		return $this->db->get_where($this->_table,array('id_sejarah' => $id))->row();
	}
	
	public function get_sejarah(){
		$this->db->order_by("waktu", "desc");
		return $this->db->get('tbl_sejarah')->result();
	}
}
?>