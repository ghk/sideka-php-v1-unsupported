<?php
class M_logo extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->_table='tbl_logo';

		//get instance
		$this->CI = get_instance();
	}
	
	public function get_logo_flexigrid()
    {
        //Build contents query
		
		$this->db->select('*')->from($this->_table);
		
		$this->CI->flexigrid->build_query();
		
        //Get contents
         $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_logo) as record_count")->from($this->_table);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count; 
		
        //Return all
        return $return;
    }
  
	function insertLogo($data)
	{
		$this->db->insert($this->_table, $data);
	}
	
	function updateLogo($where, $data)
	{
		$this->db->where($where);
		$this->db->update('tbl_logo', $data);
		return $this->db->affected_rows();
	}	
	
	function deleteLogo($id)
	{
		$this->db->where('id_logo', $id);
		$this->db->delete($this->_table);
	}
	
	function getIdLogo($id)
	{
		return $this->db->get_where('tbl_logo',array('id_logo' => $id))->row();
	}
	
	function getLogo() //for view web
	{
		$this->db->select('
		tbl_logo.id_logo,
		tbl_logo.konten_logo_desa,
		tbl_logo.konten_logo_kabupaten,
		tbl_logo.path_css,
		ref_desa.nama_desa,
		ref_desa.alamat_desa');
		$this->db->join('ref_desa','ref_desa.id_desa = tbl_logo.id_logo');
		$query = $this->db->get('tbl_logo');
		return $query->row();
	}
}
?>
