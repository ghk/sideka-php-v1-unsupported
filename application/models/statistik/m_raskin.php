<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_raskin extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('subquery');
    }
    
	
	function getMenerimaBantuanByKelasSosial($id_kelas_sosial,$bantuan){
        $this->db->select('*');
		$this->db->where($bantuan,'Y');		
		$this->db->where('id_kelas_sosial',$id_kelas_sosial); // sangat miskin
		$this->db->from('tbl_keluarga');
		$this->db->join('tbl_penduduk','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk');
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		$this->db->where('ref_status_penduduk.deskripsi <>','Meninggal');
		$query = $this->db->get();
        return $query->num_rows();
    }
	
	function getTotalKeluargaByKelasSosial($id_kelas_sosial){
        $this->db->select('*');
		$this->db->where('id_kelas_sosial',$id_kelas_sosial);
		$this->db->from('tbl_keluarga');
		$this->db->join('tbl_penduduk','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk');
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		$this->db->where('ref_status_penduduk.deskripsi <>','Meninggal');
		$query = $this->db->get();
        return $query->num_rows();
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