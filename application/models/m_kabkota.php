<?php
class M_kabkota extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='ref_kab_kota';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_kabkota_flexigrid()
    {
        //Build contents query
        $this->db->select('ref_kab_kota.*,ref_provinsi.nama_provinsi')->from($this->_table);
		$this->db->join('ref_provinsi','ref_provinsi.id_provinsi=ref_kab_kota.id_provinsi');
		  $this->db->where('id_kab_kota <>','0');
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_kab_kota) as record_count")->from($this->_table);
        $this->db->where('id_kab_kota <>','0');
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
  function insertKabkota($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteKabkota($id)
  {
    $this->db->where('id_kab_kota', $id);
    $this->db->delete($this->_table);
  }
  
  function getKabkotaByIdkabkota($id)
  {	
    return $this->db->get_where($this->_table,array('id_kab_kota' => $id))->row();
  }
  
  function cekFIleExistByKodeBPS($kode_kab_kota_bps)
  {	
    return $this->db->get_where($this->_table,array('kode_kab_kota_bps' => $kode_kab_kota_bps))->row();
  }
  
  function updateKabkota($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
  function get_provinsi() 
	{      
	$this->db->where('id_provinsi <>','0');
      	$records = $this->db->get('ref_provinsi');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_provinsi] = $row->nama_provinsi;
        }
        return ($data);
    }
}
?>