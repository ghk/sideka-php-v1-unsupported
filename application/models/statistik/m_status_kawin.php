<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_status_kawin extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('subquery');
    }
    
	function getDataStatusKawin(){
        $this->db->select('ref_status_kawin.deskripsi as jenis,count(tbl_penduduk.id_status_kawin) as jumlah');
		
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_status_kawin','ref_status_kawin.id_status_kawin = tbl_penduduk.id_status_kawin','right');
		$this->db->group_by("ref_status_kawin.deskripsi");
		$query = $this->db->get();
		return $query->result();
    }
	
	function getDataStatusKawinTable(){
        $this->db->select('ref_status_kawin.deskripsi as jenis,count(tbl_penduduk.id_status_kawin) as jumlah');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','1');
		$sub->where('tbl_penduduk.id_status_kawin = ref_status_kawin.id_status_kawin');
		$this->subquery->end_subquery('laki');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','2');
		$sub->where('tbl_penduduk.id_status_kawin = ref_status_kawin.id_status_kawin');
		$this->subquery->end_subquery('perempuan');
		
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_status_kawin','ref_status_kawin.id_status_kawin = tbl_penduduk.id_status_kawin','right');
		$this->db->group_by("ref_status_kawin.deskripsi");
		$query = $this->db->get();
		return $query->result();
    }
		
	function getJumlahStatusKawin(){
		$this->db->select('id_status_kawin,deskripsi');
		$this->db->from('ref_status_kawin');
		$query = $this->db->get();		
		return $query->num_rows();		
	}
	function getStatusKawinPenduduk()
	{
		$this->db->select('ref_status_kawin.deskripsi as jenis,count(tbl_penduduk.id_status_kawin) as jumlah');
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_status_kawin','ref_status_kawin.id_status_kawin = tbl_penduduk.id_status_kawin','right');
		$this->db->group_by("ref_status_kawin.deskripsi");
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