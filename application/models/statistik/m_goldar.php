<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_goldar extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('subquery');
    }
    
	function getDataGoldar(){
        $this->db->select('ref_goldar.deskripsi as jenis,count(tbl_penduduk.id_goldar) as jumlah');
		
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_goldar','ref_goldar.id_goldar = tbl_penduduk.id_goldar','right');
		$this->db->group_by("ref_goldar.deskripsi");
		$query = $this->db->get();
		return $query->result();
    }
	
	function getDataGoldarTable(){
        $this->db->select('ref_goldar.deskripsi as jenis,count(tbl_penduduk.id_goldar) as jumlah');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','1');
		$sub->where('tbl_penduduk.id_goldar = ref_goldar.id_goldar');
		$this->subquery->end_subquery('laki');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','2');
		$sub->where('tbl_penduduk.id_goldar = ref_goldar.id_goldar');
		$this->subquery->end_subquery('perempuan');
		
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_goldar','ref_goldar.id_goldar = tbl_penduduk.id_goldar','right');
		$this->db->group_by("ref_goldar.deskripsi");
		$query = $this->db->get();
		return $query->result();
    }
		
	function getJumlahGoldar(){
		$this->db->select('id_goldar,deskripsi');
		$this->db->from('ref_goldar');
		$query = $this->db->get();		
		return $query->num_rows();		
	}
	function getGoldarPenduduk()
	{
		$this->db->select('ref_goldar.deskripsi as jenis,count(tbl_penduduk.id_goldar) as jumlah');
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_goldar','ref_goldar.id_goldar = tbl_penduduk.id_goldar','right');
		$this->db->group_by("ref_goldar.deskripsi");
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