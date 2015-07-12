<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pekerjaan extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('subquery');
    }
    
	function getDataPekerjaan(){
        $this->db->select('ref_pekerjaan.deskripsi as jenis,count(tbl_penduduk.id_pekerjaan) as jumlah');
		
		/* $sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','1');
		$sub->where('tbl_penduduk.id_pekerjaan = ref_pekerjaan.id_pekerjaan');
		$this->subquery->end_subquery('laki');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','2');
		$sub->where('tbl_penduduk.id_pekerjaan = ref_pekerjaan.id_pekerjaan');
		$this->subquery->end_subquery('perempuan'); */
		
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_pekerjaan','ref_pekerjaan.id_pekerjaan = tbl_penduduk.id_pekerjaan','left');
		$this->db->group_by("ref_pekerjaan.deskripsi");
		$query = $this->db->get();
		return $query->result();
    }
	
	function getDataPekerjaanTable(){
        $this->db->select('ref_pekerjaan.deskripsi as jenis,count(tbl_penduduk.id_pekerjaan) as jumlah');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','1');
		$sub->where('tbl_penduduk.id_pekerjaan = ref_pekerjaan.id_pekerjaan');
		$this->subquery->end_subquery('laki');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','2');
		$sub->where('tbl_penduduk.id_pekerjaan = ref_pekerjaan.id_pekerjaan');
		$this->subquery->end_subquery('perempuan');
		
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_pekerjaan','ref_pekerjaan.id_pekerjaan = tbl_penduduk.id_pekerjaan','right');
		$this->db->group_by("ref_pekerjaan.deskripsi");
		$query = $this->db->get();
		return $query->result();
    }
		
	function getJumlahPekerjaan(){
		$this->db->select('id_pekerjaan,deskripsi');
		$this->db->from('ref_pekerjaan');
		$query = $this->db->get();		
		return $query->num_rows();		
	}
	function getPekerjaanPenduduk()
	{
		$this->db->select('ref_pekerjaan.deskripsi as jenis,count(tbl_penduduk.id_pekerjaan) as jumlah');
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_pekerjaan','ref_pekerjaan.id_pekerjaan = tbl_penduduk.id_pekerjaan','right');
		$this->db->group_by("ref_pekerjaan.deskripsi");
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