<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pendapatan_dan_belanja extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->library('subquery');
	}

	function getDataPiePendapatan(){
		$this->db->select('tbl_akun.nama_akun as nama_akun, tbl_akun.jumlah * 100 /(select sum(jumlah) from tbl_akun, tbl_apbdes where tbl_akun.id_apbdes = tbl_apbdes.id_apbdes and tbl_apbdes.nama = "Pendapatan") as jumlah');
		$this->db->from('tbl_akun');
		$this->db->join('tbl_apbdes','tbl_apbdes.id_apbdes = tbl_akun.id_apbdes','right');
		$this->db->where('tbl_apbdes.nama = "Pendapatan"');
		$query = $this->db->get();
		return $query->result();
	}

	function getDataPieBelanja(){
		$this->db->select('tbl_akun.nama_akun as nama_akun, tbl_akun.jumlah * 100 /(select sum(jumlah) from tbl_akun, tbl_apbdes where tbl_akun.id_apbdes = tbl_apbdes.id_apbdes and tbl_apbdes.nama = "Belanja") as jumlah');
		$this->db->from('tbl_akun');
		$this->db->join('tbl_apbdes','tbl_apbdes.id_apbdes = tbl_akun.id_apbdes','right');
		$this->db->where('tbl_apbdes.nama = "Belanja"');
		$query = $this->db->get();
		return $query->result();
	}

	function getDataAkunTable(){
		$this->db->select('tbl_akun.nama_akun as nama_akun, tbl_akun.jumlah as jumlah');
		$this->db->from('tbl_akun');
		$this->db->join('tbl_apbdes','tbl_apbdes.id_apbdes = tbl_akun.id_apbdes','right');
		$this->db->where('tbl_apbdes.nama = "Pendapatan"');
		$query = $this->db->get();
		return $query->result();
	}
/**
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
**/
	function highchartJson($json)
	{
		$deskripsi = '"nama_akun":';
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