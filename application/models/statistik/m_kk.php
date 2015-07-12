<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_kk extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('subquery');
    }
    
	
	// --- KK PEREMPUAN --- //
	
	function getKkPerempuan(){		
		$this->db->select('*');
		$this->db->join('tbl_keluarga','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk');
		$this->db->where('tbl_penduduk.id_jen_kel', '2');
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		$this->db->where('ref_status_penduduk.deskripsi <>','Meninggal');
		$q = $this->db->get('tbl_penduduk');
		return $q->num_rows();		
    }
	
	function getKkLaki(){		
		$this->db->select('*');
		$this->db->join('tbl_keluarga','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk');
		$this->db->where('tbl_penduduk.id_jen_kel', '1');
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		$this->db->where('ref_status_penduduk.deskripsi <>','Meninggal');
		$q = $this->db->get('tbl_penduduk');
		return $q->num_rows();		
    }
	
	function getDataTotal(){
		$this->db->select('*');
		$this->db->from('tbl_keluarga');
		$this->db->join('tbl_penduduk','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk');
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		$this->db->where('ref_status_penduduk.deskripsi <>','Meninggal');
		$query = $this->db->get();
        return $query->num_rows();
	}
}