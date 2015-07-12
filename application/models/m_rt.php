<?php
class M_rt extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='ref_rt';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_rt_flexigrid()
    {
        //Build contents query
        $this->db->select('ref_rt.*,ref_rw.nomor_rw as nomor_rw,ref_dusun.nama_dusun')->from($this->_table);
		$this->db->join('ref_rw','ref_rw.id_rw=ref_rt.id_rw');		
		$this->db->join('ref_dusun','ref_dusun.id_dusun=ref_rw.id_dusun');
		$this->db->order_by('ref_rw.nomor_rw');
        $this->db->where('ref_rt.id_rt <>','0');
		$this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_rt) as record_count")->from($this->_table);
		$this->db->join('ref_rw','ref_rw.id_rw=ref_rt.id_rw');		
		$this->db->join('ref_dusun','ref_dusun.id_dusun=ref_rw.id_dusun');
		$this->db->where('id_rt <>','0');		
		$this->CI->flexigrid->build_query(TRUE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;
		//$this->CI->flexigrid->build_query(TRUE);		
        //Return all
        return $return;
    }
  function insertRt($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function deleteRt($id)
  {
    $this->db->where('id_rt', $id);
    $this->db->delete($this->_table);
  }
  
  function getRtByIdrt($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_rt' => $id))->row();
  }
  
  function updateRt($where, $data) //update
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
  function get_rw() 
	{      
	$this->db->where('id_rw <>','0');
      	$records = $this->db->get('ref_rw');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_rw] = $row->nomor_rw;
        }
        return ($data);
    }
	
	function get_dusun() 
	{      
		$this->db->where('id_dusun <>','0');
      	$records = $this->db->get('ref_dusun');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_dusun] = $row->nama_dusun;
        }
        return ($data);
    }
	function get_dusunByIdRw($id_rw) 
	{      
		
		$this->db->where('id_rw',$id_rw);
		$this->db->join('ref_dusun','ref_dusun.id_dusun=ref_rw.id_dusun');
      	$q = $this->db->get('ref_rw');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['id_dusun']);
    }
	
	function get_rw_dinamic($id_dusun) 
	{      
		$this->db->where('id_rw !=','0');	
		$this->db->where('id_dusun',$id_dusun);		
      	$records = $this->db->get('ref_rw');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_rw] = $row->nomor_rw;
        }
        return ($data);
    }
	
	function get_RT($idrt,$RT)
	{
		$this->db->where('id_rt',$idrt)
		->where('id_RT',$RT);
		
		$quer=$this->db->get('ref_rt');
		
		if($quer->num_rows() > 0)
			return $quer->result_array();
		else
			return array();
	}
	
	function cekFIleExist($nomor_rt)
	{	
		return $this->db->get_where($this->_table,array('nomor_rt' => $nomor_rt))->row();
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