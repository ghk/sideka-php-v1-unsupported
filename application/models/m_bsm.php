<?php
class M_bsm extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_penduduk';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_bsm_flexigrid()
    {
	
        //Build contents query
        /* $this->db->select('
		tbl_bsm.*,
		tbl_penduduk.nik,
		tbl_keluarga.no_kk,
		tbl_penduduk.nama,
		ref_kelas_sosial.deskripsi as kelas_sosial
		')->from($this->_table);	//kelas sosial	
		
		$this->db->join('tbl_penduduk','tbl_bsm.id_penduduk = tbl_penduduk.id_penduduk');
		$this->db->join('tbl_hub_kel','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk');
		$this->db->join('tbl_keluarga','tbl_hub_kel.id_keluarga = tbl_keluarga.id_keluarga');
		$this->db->join('ref_kelas_sosial','tbl_keluarga.id_kelas_sosial = ref_kelas_sosial.id_kelas_sosial'); */
		
		$this->db->select('
		tbl_penduduk.*,
		tbl_keluarga.no_kk,
		ref_pendidikan.deskripsi as pendidikan,
		ref_kelas_sosial.deskripsi as kelas_sosial
		')->from($this->_table);		
		$this->db->join('ref_pendidikan','tbl_penduduk.id_pendidikan = ref_pendidikan.id_pendidikan');		
		$this->db->join('tbl_hub_kel','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk');
		$this->db->join('tbl_keluarga','tbl_hub_kel.id_keluarga = tbl_keluarga.id_keluarga');		
		$this->db->join('ref_kelas_sosial','tbl_keluarga.id_kelas_sosial = ref_kelas_sosial.id_kelas_sosial');
		
        //$this->db->where('ref_pendidikan.is_bsm','Y');
		$this->db->where('tbl_penduduk.is_bsm','Y');
		$this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_penduduk) as record_count")->from($this->_table);
        $this->db->where('tbl_penduduk.is_bsm','Y');
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        $this->CI->flexigrid->build_query(TRUE);
        //Return all
        return $return;
    }
	
	/* function cekJenisBsm($id_penduduk,$jenis_bsm)
	{
		$this->db->select('jenis_bsm');
		$this->db->where('id_penduduk', $id_penduduk);		
		$this->db->where('jenis_bsm', $jenis_bsm);
		$q = $this->db->get('tbl_bsm');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['is_bsm'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	} */
	
  function insertBsm($data)
  {
    $this->db->insert('tbl_bsm', $data);
  }
  
  function deleteBsm($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
  function getBsmByIdBsm($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_bsm' => $id))->row();
  }
  
  function updateBsm($where, $data) //update
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
   function getIdpendudukByIdBsm($id_bsm)
	{
		$this->db->select('id_penduduk');
		$this->db->where('id_bsm', $id_bsm);
		$q = $this->db->get('tbl_bsm');
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
	
  function getPendudukByIdBsm($id)
  {	
	$id_penduduk=$this->getIdpendudukByIdBsm($id);
    return $this->db->get_where('tbl_penduduk',array('id_penduduk' => $id_penduduk))->row();
  }
  
  	function getIdPendudukByNIK($nik)
	{
		$this->db->select('id_penduduk');
		$this->db->where('nik', $nik);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_penduduk'];	
		if($result == NULL)
		{	
			return 'data tidak ditemukan';
		}
		else return $result; 
	}
	
	function cekFIleExist($id_penduduk)
	{	
		return $this->db->get_where($this->_table,array('id_penduduk' => $id_penduduk))->row();
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