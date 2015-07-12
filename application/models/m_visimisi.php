<?php
class M_visimisi extends CI_Model {

  function __construct(){
		parent::__construct();
		$this->_table='tbl_visi_misi';
	
		//get instance
		$this->CI = get_instance();
	}
	public function get_visimisi_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_visi_misi) as record_count")->from($this->_table);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
	
	function insertVisimisi($data){
		$this->db->insert($this->_table, $data);
	}
	
	function updateVisimisi($where, $data)
	{
		$this->db->where($where);
		$this->db->update($this->_table, $data);
		return $this->db->affected_rows();
	}
	
	function deleteVisimisi($id){
		$this->db->where('isi_visi_misi', $id);
		$this->db->delete($this->_table);
	}
	
	function getVisimisiByIdvisimisi($id)
	{	
		return $this->db->get_where($this->_table,array('id_visi_misi' => $id))->row();
	}
	
	public function get_visimisi(){
		$this->db->order_by("waktu", "desc");
		return $this->db->get('visi_misi_desa')->result();
	}
}
?>