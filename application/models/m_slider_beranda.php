<?php
class M_slider_beranda extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->_table='tbl_slider_beranda';

		//get instance
		$this->CI = get_instance();
	}
	
	public function get_slider_beranda_flexigrid()
    {
        //Build contents query
		
		$this->db->select('*')->from($this->_table);
		
		$this->CI->flexigrid->build_query();
		
        //Get contents
         $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_slider_beranda) as record_count")->from($this->_table);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count; 
		
        //Return all
        return $return;
    }
  
	function insertSliderBeranda($data)
	{
		$this->db->insert($this->_table, $data);
	}
	
	function updateSliderBeranda($where, $data)
	{
		$this->db->where($where);
		$this->db->update('tbl_slider_beranda', $data);
		return $this->db->affected_rows();
	}	
	
	function deleteSliderBeranda($id)
	{
		$this->db->where('id_slider_beranda', $id);
		$this->db->delete($this->_table);
	}
	
	function getSliderBerandaByIdSliderBeranda($id)
	{
		return $this->db->get_where('tbl_slider_beranda',array('id_slider_beranda' => $id))->row();
	}

	public function getSliderBeranda(){
		return $this->db->get('tbl_slider_beranda')->result();
	}
	
	public function getSliderBerandaRow(){

		return $this->db->count_all_results('tbl_slider_beranda');
	}
	
	function getKontenBackgroundByIdSliderBeranda($id_slider_beranda)
	{
		$this->db->select('konten_background');
		$this->db->where('id_slider_beranda', $id_slider_beranda);
		$q = $this->db->get('tbl_slider_beranda');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['konten_background']);
	}
	
	function getKontenLogoByIdSliderBeranda($id_slider_beranda)
	{
		$this->db->select('konten_logo');
		$this->db->where('id_slider_beranda', $id_slider_beranda);
		$q = $this->db->get('tbl_slider_beranda');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['konten_logo']);
	}
}
?>
