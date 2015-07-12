<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_bsm extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('subquery');
    }
    
	function getTotalBsm(){	
		$this->db->select('
		tbl_penduduk.*,
		tbl_keluarga.no_kk,
		ref_pendidikan.deskripsi as pendidikan,
		ref_kelas_sosial.deskripsi as kelas_sosial
		')->from('tbl_penduduk');		
		$this->db->join('ref_pendidikan','tbl_penduduk.id_pendidikan = ref_pendidikan.id_pendidikan');		
		$this->db->join('tbl_hub_kel','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk');
		$this->db->join('tbl_keluarga','tbl_hub_kel.id_keluarga = tbl_keluarga.id_keluarga');		
		$this->db->join('ref_kelas_sosial','tbl_keluarga.id_kelas_sosial = ref_kelas_sosial.id_kelas_sosial');		
        $this->db->where('ref_pendidikan.is_bsm','Y');
			
		$q = $this->db->get();		
		return $q->num_rows();	
	}
	
	function getTotalBsmByJenisKelamin($id_jen_kel){	
		$this->db->select('
		tbl_penduduk.*,
		tbl_keluarga.no_kk,
		ref_pendidikan.deskripsi as pendidikan,
		ref_kelas_sosial.deskripsi as kelas_sosial
		')->from('tbl_penduduk');		
		$this->db->join('ref_pendidikan','tbl_penduduk.id_pendidikan = ref_pendidikan.id_pendidikan');		
		$this->db->join('tbl_hub_kel','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk');
		$this->db->join('tbl_keluarga','tbl_hub_kel.id_keluarga = tbl_keluarga.id_keluarga');		
		$this->db->join('ref_kelas_sosial','tbl_keluarga.id_kelas_sosial = ref_kelas_sosial.id_kelas_sosial');		
        $this->db->where('ref_pendidikan.is_bsm','Y');
		$this->db->where('tbl_penduduk.id_jen_kel',$id_jen_kel);
		$q = $this->db->get();		
		return $q->num_rows();	
	}
	
}