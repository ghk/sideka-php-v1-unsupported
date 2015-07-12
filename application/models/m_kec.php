<?php
class M_kec extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='ref_kecamatan';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_kec_flexigrid()
    {
        //Build contents query
        $this->db->select('ref_kecamatan.*,ref_kab_kota.nama_kab_kota')->from($this->_table);
		$this->db->join('ref_kab_kota','ref_kab_kota.id_kab_kota=ref_kecamatan.id_kab_kota');
		$this->db->where('id_kecamatan <>','0');
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_kecamatan) as record_count")->from($this->_table);
        $this->db->where('id_kecamatan <>','0');
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
  function insertKec($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteKec($id)
  {
    $this->db->where('id_kecamatan', $id);
    $this->db->delete($this->_table);
  }
  
  function getKecByIdkec($id)
  {	
    return $this->db->get_where($this->_table,array('id_kecamatan' => $id))->row();
  }
  
  function updateKec($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
  function get_kab_kota() 
	{      
	$this->db->where('id_kab_kota <>','0');
      	$records = $this->db->get('ref_kab_kota');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_kab_kota] = $row->nama_kab_kota;
        }
        return ($data);
    }
	
  function cekFIleExistByKodeBPS($kode_kecamatan_bps)
  {	
    return $this->db->get_where($this->_table,array('kode_kecamatan_bps' => $kode_kecamatan_bps))->row();
  }
}
?>