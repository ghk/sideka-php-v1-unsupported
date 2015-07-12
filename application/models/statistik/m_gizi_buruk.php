<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_gizi_buruk extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('subquery');
    }
    
	
	function getAnakByUmur($min_value,$max_value){		
		$this->db->select('id_penduduk');
		$this->db->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >=', $min_value);
		$this->db->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <=', $max_value);
		$q = $this->db->get('tbl_penduduk');
		return $q->num_rows();		
    }
	
	function getAnakGiziBurukByUmur($min_value,$max_value){		
		$this->db->select('id_gizi_buruk');
		$this->db->join('tbl_penduduk','tbl_gizi_buruk.id_penduduk = tbl_penduduk.id_penduduk');
		$this->db->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >=', $min_value);
		$this->db->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <=', $max_value);
		$q = $this->db->get('tbl_gizi_buruk');
		return $q->num_rows();		
    }
	
	
	function getGiziBurukByKelamin($jen_kel,$min_value,$max_value){		
		$this->db->select('id_gizi_buruk');
		$this->db->join('tbl_penduduk','tbl_gizi_buruk.id_penduduk = tbl_penduduk.id_penduduk');
		$this->db->where('tbl_penduduk.id_jen_kel', $jen_kel);
		$this->db->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >=', $min_value);
		$this->db->where('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <=', $max_value);
		$q = $this->db->get('tbl_gizi_buruk');
		return $q->num_rows();		
    }
	
}