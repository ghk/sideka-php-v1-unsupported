<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_buruh_migran extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('subquery');
    }
    
	function getTotalBuruhMigran(){
	
		$this->db->select('id_penduduk	');		
		$this->db->join('ref_pekerjaan','tbl_penduduk.id_pekerjaan = ref_pekerjaan.id_pekerjaan');		
		$this->db->where('ref_pekerjaan.deskripsi','BURUH MIGRAN');
		$q = $this->db->get('tbl_penduduk');		
		return $q->num_rows();	
	}
	
	function getTotalBuruhMigranByJenisKelamin($id_jen_kel){
	
		$this->db->select('id_penduduk	');		
		$this->db->join('ref_pekerjaan','tbl_penduduk.id_pekerjaan = ref_pekerjaan.id_pekerjaan');		
		$this->db->where('ref_pekerjaan.deskripsi','BURUH MIGRAN');
		$this->db->where('tbl_penduduk.id_jen_kel',$id_jen_kel);
		$q = $this->db->get('tbl_penduduk');		
		return $q->num_rows();	
	}
	
}