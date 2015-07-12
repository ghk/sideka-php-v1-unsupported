<?php
class M_desa extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='ref_desa';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_desa_flexigrid()
    {
        //Build contents query
        $this->db->select('ref_desa.*,ref_kecamatan.nama_kecamatan')
			->from($this->_table)
			->join('ref_kecamatan','ref_kecamatan.id_kecamatan=ref_desa.id_kecamatan');
			$this->db->where('id_desa <>','0');
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_desa) as record_count")->from($this->_table);
        $this->db->where('id_desa <>','0');
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
  function insertDesa($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteDesa($id)
  {
    $this->db->where('id_desa', $id);
    $this->db->delete($this->_table);
  }
  
  function getDesaByIddesa($id)
  {	
    return $this->db->get_where($this->_table,array('id_desa' => $id))->row();
  }
  
  function updateDesa($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
  function get_kec() 
	{      
	$this->db->where('id_kecamatan <>','0');
      	$records = $this->db->get('ref_kecamatan');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_kecamatan] = $row->nama_kecamatan;
        }
        return ($data);
    }
	
	function cekFIleExistByKodeBPS($kode_desa_bps)
	  {	
		return $this->db->get_where($this->_table,array('kode_desa_bps' => $kode_desa_bps))->row();
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