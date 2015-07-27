<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pendapatan_dan_belanja extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->library('subquery');
	}

	function getDataPiePendapatan(){
		$this->db->select('tbl_anggaran.nama as nama_akun, (tbl_anggaran.jumlah * 100) /(select sum(jumlah) from tbl_anggaran, tbl_apbdes where tbl_anggaran.id_apbdes = tbl_apbdes.id_apbdes and tbl_anggaran.tipe_apbdes = 0 and tbl_anggaran.id_parent is null ) as jumlah');
		$this->db->from('tbl_anggaran');
		$this->db->join('tbl_apbdes','tbl_apbdes.id_apbdes = tbl_anggaran.id_apbdes ','right');
		$this->db->where('tbl_anggaran.tipe_apbdes = 0 and tbl_anggaran.id_parent is null ');
		$query = $this->db->get();
		return $query->result();
	}
	function getDataPieBelanja(){
		$this->db->select('tbl_anggaran.nama as nama_akun, (tbl_anggaran.jumlah * 100) /(select sum(jumlah) from tbl_anggaran, tbl_apbdes where tbl_anggaran.id_apbdes = tbl_apbdes.id_apbdes and tbl_anggaran.tipe_apbdes = 1 and tbl_anggaran.id_parent is null ) as jumlah');
		$this->db->from('tbl_anggaran');
		$this->db->join('tbl_apbdes','tbl_apbdes.id_apbdes = tbl_anggaran.id_apbdes ','right');
		$this->db->where('tbl_anggaran.tipe_apbdes = 1 and tbl_anggaran.id_parent is null ');
		$query = $this->db->get();
		return $query->result();
	}
	function getDataStackPendapatanRealisasi(){
		$this->db->select('tbl_anggaran.nama as nama_akun, tbl_realisasi.jumlah as jumlah');
		$this->db->from('tbl_anggaran');
		$this->db->join('tbl_apbdes','tbl_apbdes.id_apbdes = tbl_anggaran.id_apbdes','right');
		$this->db->join('tbl_realisasi','tbl_realisasi.id_anggaran = tbl_anggaran.id_anggaran','right');
		$this->db->where('tbl_anggaran.tipe_apbdes = 0 and tbl_anggaran.id_parent is null ');
		$query = $this->db->get();
		return $query->result();
	}

	function getDataStackPendapatanBelumRealisasi(){
		$this->db->select('tbl_anggaran.nama as nama_akun, tbl_anggaran.jumlah - tbl_realisasi.jumlah as jumlah');
		$this->db->from('tbl_anggaran');
		$this->db->join('tbl_apbdes','tbl_apbdes.id_apbdes = tbl_anggaran.id_apbdes','right');
		$this->db->join('tbl_realisasi','tbl_realisasi.id_anggaran = tbl_anggaran.id_anggaran','right');
		$this->db->where('tbl_anggaran.tipe_apbdes = 0 and tbl_anggaran.id_parent is null ');
		$query = $this->db->get();
		return $query->result();
	}

	function getDataStackBelanjaRealisasi(){
		$this->db->select('tbl_anggaran.nama as nama_akun, tbl_realisasi.jumlah as jumlah');
		$this->db->from('tbl_anggaran');
		$this->db->join('tbl_apbdes','tbl_apbdes.id_apbdes = tbl_anggaran.id_apbdes','right');
		$this->db->join('tbl_realisasi','tbl_realisasi.id_anggaran = tbl_anggaran.id_anggaran','right');
		$this->db->where('tbl_anggaran.tipe_apbdes = 1 and tbl_anggaran.id_parent is null ');
		$query = $this->db->get();
		return $query->result();
	}

	function getDataStackBelanjaBelumRealisasi(){
		$this->db->select('tbl_anggaran.nama as nama_akun, tbl_anggaran.jumlah - tbl_realisasi.jumlah as jumlah');
		$this->db->from('tbl_anggaran');
		$this->db->join('tbl_apbdes','tbl_apbdes.id_apbdes = tbl_anggaran.id_apbdes','right');
		$this->db->join('tbl_realisasi','tbl_realisasi.id_anggaran = tbl_anggaran.id_anggaran','right');
		$this->db->where('tbl_anggaran.tipe_apbdes = 1 and tbl_anggaran.id_parent is null ');
		$query = $this->db->get();
		return $query->result();
	}


	function getDataAkunTable(){
		$this->db->select('tbl_anggaran.nama as nama_akun, tbl_anggaran.jumlah as jumlah');
		$this->db->from('tbl_anggaran');
		$this->db->join('tbl_apbdes','tbl_apbdes.id_apbdes = tbl_anggaran.id_apbdes','right');
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

	function highchartJson2($json)
	{
		$deskripsi = '"nama_akun2":';
		$jumlah = '"jumlah2":';
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