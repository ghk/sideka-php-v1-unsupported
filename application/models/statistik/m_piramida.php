<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_piramida extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('subquery');
    }
    
	function highchartJsonLaki($json)
	{
			
		$petikdua = '"'	;	
		
		$json = str_replace("{", "", strval($json));				
		$json = str_replace("}", "", strval($json));
		$json = str_replace($petikdua, "'", strval($json));
		$json = str_replace("'","", strval($json));	
		$json = str_replace(",",",-", strval($json));			
		$json = str_replace("[","[-", strval($json));	
		
		return $json;
	}
	
	function highchartJsonPerempuan($json)
	{
			
		$petikdua = '"'	;	
		
		$json = str_replace("{", "", strval($json));				
		$json = str_replace("}", "", strval($json));
		$json = str_replace($petikdua, "'", strval($json));
		$json = str_replace("'","", strval($json));		
		
		return $json;
	}
	
	function getJumlahPenduduk($jen_kel,$min_value,$max_value){		
		$this->db->select('id_penduduk')
		->where('id_jen_kel', $jen_kel)
		->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >=', $min_value)
		->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <=', $max_value)
		->from('tbl_penduduk');
		$q = $this->db->get();
		return $q->num_rows();				
	}
	
	function getDataLaki(){
        $this->db->select('*');
		$this->db->where('id_jen_kel','1');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
    function getDataPerempuan(){
        $this->db->select('*');
		$this->db->where('id_jen_kel','2');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
	
	// -------- Hitung total data penduduk -------- //
	function getDataTotal(){
		$this->db->select('*');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
	}
}