<?php
class M_perangkat extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_perangkat';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_perangkat_flexigrid()
	{
		//Build contents query
		$this->db->select('tbl_perangkat.*,
		tbl_penduduk.nama,
		ref_jabatan.deskripsi as jabatan,
		ref_pangkat_gol.deskripsi as pangkat_gol')->from($this->_table);
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_perangkat.id_penduduk');
		$this->db->join('ref_jabatan','ref_jabatan.id_jabatan = tbl_perangkat.id_jabatan');
		$this->db->join('ref_pangkat_gol','ref_pangkat_gol.id_pangkat_gol = tbl_perangkat.id_pangkat_gol');
		//$this->db->where('tbl_perangkat.is_aktif','Y');
		$this->CI->flexigrid->build_query();

		//Get contents
		$return['records'] = $this->db->get();

		//Build count query
		$this->db->select("count(id_perangkat) as record_count")->from($this->_table);
		//$this->db->where('is_aktif','Y');
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		
		$row = $record_count->row();

		//Get Record Count
		$return['record_count'] = $row->record_count;

		//Return all
		return $return;
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
	
	function cekJabatanExist($id_jabatan)
	{
		return $this->db->get_where('tbl_perangkat',array('id_jabatan' => $id_jabatan))->row();	
	}
	function insertPerangkat($data)
	{
		$this->db->insert($this->_table, $data);
	}
  
	function deletePerangkat($id)
	{
		$this->db->where('id_perangkat', $id);
		$this->db->delete($this->_table);
	}

	function updatePerangkat($where, $data)
	{
		$this->db->where($where);
		$this->db->update($this->_table, $data);
		return $this->db->affected_rows();
	}
  
	function get_jabatan() 
	{      
		$records = $this->db->get('ref_jabatan');
		$data=array();
		foreach ($records->result() as $row)
		{	
			$data[''] = '--Pilih--';
			$data[$row->id_jabatan] = $row->deskripsi;
		}
		return ($data);
	}
	
	function get_pangkat_gol() 
	{      
		$records = $this->db->get('ref_pangkat_gol');
		$data=array();
		foreach ($records->result() as $row)
		{	
			$data[''] = '--Pilih--';
			$data[$row->id_pangkat_gol] = $row->deskripsi;
		}
		return ($data);
	}
	
	function getIdPendudukByNIK($id)
	{
		$this->db->select('id_penduduk');
		$this->db->where('nik', $id);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_penduduk'];
		return  $result;
	}
	
	function getNIKByIdPerangkat($id)
	{
		$this->db->select('tbl_penduduk.nik as nik')->from('tbl_penduduk');
		$this->db->join('tbl_perangkat','tbl_perangkat.id_penduduk = tbl_penduduk.id_penduduk');
		$this->db->where('tbl_perangkat.id_perangkat', $id);
		$q = $this->db->get();
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['nik'];
		return  $result;
	}
	
	function getNamaByIdPerangkat($id)
	{
		$this->db->select('tbl_penduduk.nama as nama')->from('tbl_penduduk');
		$this->db->join('tbl_perangkat','tbl_perangkat.id_penduduk = tbl_penduduk.id_penduduk');
		$this->db->where('tbl_perangkat.id_perangkat', $id);
		$q = $this->db->get();
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['nama'];
		return  $result;
	}
	
	function getPerangkatByIdPerangkat($id)
	{	
		return $this->db->get_where($this->_table,array('id_perangkat' => $id))->row();
	}

	function cekNIKExist($nik)
	{	
		return $this->db->get_where('tbl_penduduk',array('nik' => $nik))->row();
	}
	
	function cekIdPendudukExist($id)
	{	
		return $this->db->get_where('tbl_perangkat',array('id_penduduk' => $id))->row();
	}
}
?>