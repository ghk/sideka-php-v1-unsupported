<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_kehamilan extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('subquery');
    }
    
	
	function getKehamilan(){		
		$this->db->select('id_kondisi_kehamilan');
		$q = $this->db->get('tbl_kondisi_kehamilan');
		return $q->num_rows();		
    }
	
	function getKehamilanResti($is_resti){		
		$this->db->select('id_kondisi_kehamilan');
		$this->db->where('is_resti', $is_resti);
		$q = $this->db->get('tbl_kondisi_kehamilan');
		return $q->num_rows();		
    }
	
	
}