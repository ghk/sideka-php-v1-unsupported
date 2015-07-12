<?php
class M_ped_sumber_air extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_ped_sumber_air';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_ped_sumber_air_flexigrid()
    {
        //Build contents query
        $this->db->select('tbl_ped_sumber_air.*,ref_dusun.nama_dusun')->from($this->_table);
		$this->db->join('ref_dusun','ref_dusun.id_dusun=tbl_ped_sumber_air.id_dusun');
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_ped_sumber_air) as record_count")->from($this->_table);        
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;
		$this->CI->flexigrid->build_query(TRUE);
        //Return all
        return $return;
    }
  function insertPedSumberAir($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deletePedSumberAir($id)
  {
    $this->db->where('id_ped_sumber_air', $id);
    $this->db->delete($this->_table);
  }
  
  function getPedSumberAirByIdPedSumberAir($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_ped_sumber_air' => $id))->row();
  }
  
  function updatePedSumberAir($where, $data) //update
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
  function get_dusun() 
	{      
      	$records = $this->db->get('ref_dusun');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_dusun] = $row->nama_dusun;
        }
        return ($data);
    }
	
	function cekFIleExist($deskripsi)
	{	
		return $this->db->get_where($this->_table,array('deskripsi' => $deskripsi))->row();
	}
}
?>