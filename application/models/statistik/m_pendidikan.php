<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pendidikan extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('subquery');
    }
    
	function getDataPendidikan(){
        $this->db->select('ref_pendidikan.deskripsi as jenis,count(tbl_penduduk.id_pendidikan) as jumlah');
		
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_pendidikan','ref_pendidikan.id_pendidikan = tbl_penduduk.id_pendidikan','left');
		$this->db->group_by("ref_pendidikan.deskripsi");
		$query = $this->db->get();
		return $query->result();
    }
	
	function getDataPendidikanTable(){
        $this->db->select('ref_pendidikan.deskripsi as jenis,count(tbl_penduduk.id_pendidikan) as jumlah');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','1');
		$sub->where('tbl_penduduk.id_pendidikan = ref_pendidikan.id_pendidikan');
		$this->subquery->end_subquery('laki');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','2');
		$sub->where('tbl_penduduk.id_pendidikan = ref_pendidikan.id_pendidikan');
		$this->subquery->end_subquery('perempuan');
		
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_pendidikan','ref_pendidikan.id_pendidikan = tbl_penduduk.id_pendidikan','right');
		$this->db->group_by("ref_pendidikan.deskripsi");
		$query = $this->db->get();
		return $query->result();
    }
		
	function getJumlahPendidikan(){
		$this->db->select('id_pendidikan,deskripsi');
		$this->db->from('ref_pendidikan');
		$query = $this->db->get();		
		return $query->num_rows();		
	}
	function getPendidikanPenduduk()
	{
		$this->db->select('ref_pendidikan.deskripsi as jenis,count(tbl_penduduk.id_pendidikan) as jumlah');
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_pendidikan','ref_pendidikan.id_pendidikan = tbl_penduduk.id_pendidikan','right');
		$this->db->group_by("ref_pendidikan.deskripsi");
		$query = $this->db->get();
		
		$counter=0;
		foreach ($query->result() as $row)
		{
		   $array[$counter] = $row->jenis;
		   $counter++;		   		  
		} 
		foreach ($query->result() as $row)
		{
			$array[$counter] = $row->jumlah;
		    $counter++;
		}
		return $array;
	}
	
	function highchartJson($json)
	{
		$deskripsi = '"jenis":';
		$jumlah = '"jumlah":';	
		$petikdua = '"'	;	
		$json = str_replace($deskripsi, "", strval($json));		
		$json = str_replace($jumlah, "", strval($json));				
		$json = str_replace("{", "[", strval($json));				
		$json = str_replace("}", "]", strval($json));					
		$json = str_replace("[[", "[", strval($json));				
		$json = str_replace("]]", "]", strval($json));					
		$json = str_replace($petikdua, "'", strval($json));					
		$json = str_replace(",'", ",", strval($json));						
		$json = str_replace("']", "]", strval($json));
		
		return $json;
	}
}