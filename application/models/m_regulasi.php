<?php
class M_regulasi extends CI_Model {

  function __construct(){
		parent::__construct();
		$this->_table='tbl_regulasi';
	
		//get instance
		$this->CI = get_instance();
	}
	public function get_regulasi_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_regulasi) as record_count")->from($this->_table);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
	
	function insertRegulasi($data){
		$this->db->insert($this->_table, $data);
	}
	
	function updateRegulasi($where, $data)
	{
		$this->db->where($where);
		$this->db->update($this->_table, $data);
		return $this->db->affected_rows();
	}
	
	function deleteRegulasi($id){
		$this->db->where('id_regulasi', $id);
		$this->db->delete($this->_table);
	}
	
	function getRegulasiByIdregulasi($id)
	{	
		return $this->db->get_where($this->_table,array('id_regulasi' => $id))->row();
	}
	
	function getFileRegulasiByIdRegulasi($id_regulasi)
	{
		$this->db->select('file_regulasi');
		$this->db->where('id_regulasi', $id_regulasi);
		$q = $this->db->get('tbl_regulasi');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['file_regulasi']);
	}
	
	public function getRegulasi(){
		return $this->db->get('tbl_regulasi')->result();
	}
	

}
?>