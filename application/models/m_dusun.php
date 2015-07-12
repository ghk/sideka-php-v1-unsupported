<?php
class M_dusun extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='ref_dusun';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_dusun_flexigrid()
    {
        //Build contents query
        $this->db->select('ref_dusun.*,ref_desa.nama_desa')->from($this->_table);
		$this->db->join('ref_desa','ref_desa.id_desa=ref_dusun.id_desa');
		$this->db->where('id_dusun <>','0');
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_dusun) as record_count")->from($this->_table);
        $this->db->where('id_dusun <>','0');
        $this->CI->flexigrid->build_query(TRUE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
  function insertDusun($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteDusun($id)
  {
    $this->db->where('id_dusun', $id);
    $this->db->delete($this->_table);
  }
  
  function getDusunByIddusun($id)
  {	
    return $this->db->get_where($this->_table,array('id_dusun' => $id))->row();
  }
  
  function updateDusun($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
  function get_desa() 
	{      
	$this->db->where('id_desa <>','0');
      	$records = $this->db->get('ref_desa');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_desa] = $row->nama_desa;
        }
        return ($data);
    }
	
	function get_RW($iddusun)
	{
		$this->db->where('id_dusun',$iddusun);
		$quer=$this->db->get('ref_rw');
		if($quer->num_rows() > 0)
			return $quer->result_array();
		else
			return array();
	}
	
	function get_RT($iddusun,$RW)
	{
		$this->db->where('id_dusun',$iddusun)
		->where('id_RW',$RW);
		
		$quer=$this->db->get('ref_rt');
		
		if($quer->num_rows() > 0)
			return $quer->result_array();
		else
			return array();
	}
	
	function cekFIleExistByKodeBPS($kode_dusun_bps)
	{	
		return $this->db->get_where($this->_table,array('kode_dusun_bps' => $kode_dusun_bps))->row();
	}
	
	function getIdPendudukByNIK($nik)
	{
		$this->db->select('id_penduduk');
		$this->db->where('nik', $nik);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_penduduk'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
	function getNIKByIdPenduduk($id_penduduk)
	{
		$this->db->select('nik');
		$this->db->where('id_penduduk', $id_penduduk);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['nik']);
	}	


  function getNamaByIdPenduduk($id_penduduk)
  {
    $this->db->select('nama');
    $this->db->where('id_penduduk', $id_penduduk);
    $q = $this->db->get('tbl_penduduk');
    //if id is unique we want just one row to be returned
    $data = array_shift($q->result_array());
    return ($data['nama']);
  }


  function get_NikPenduduk($nik)
  {
    $this->db->select('nik,nama');
        $this->db->like('nik', $nik);
        $query = $this->db->get('tbl_penduduk');
    
        return $query->result();
  }
  
  function get_NamaPenduduk($nama)
  {
    $this->db->select('nama,nik');
        $this->db->like('nama', $nama);
        $query = $this->db->get('tbl_penduduk');
    
        return $query->result();
  }
}
?>