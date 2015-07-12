<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_report extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('subquery');
    }
    
	function highchartJson($json)
	{
		$deskripsi = '"deskripsi":';
		$jumlah = '"jumlah":';	
		$petikdua = '"'	;	
		$json = str_replace($deskripsi, "", strval($json));		
		$json = str_replace($jumlah, "", strval($json));				
		$json = str_replace("{", "", strval($json));				
		$json = str_replace("}", "", strval($json));
		$json = str_replace($petikdua, "'", strval($json));
		$json = str_replace(",'",",", strval($json));		
		$json = str_replace("']","]", strval($json));
		return $json;
	}
    function get_dataL(){
        $this->db->select('*');
		$this->db->where('id_jen_kel','1');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
    function get_dataP(){
        $this->db->select('*');
		$this->db->where('id_jen_kel','2');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
	// -------- Hitung total data penduduk -------- //
	function getTotalData(){
		$this->db->select('*');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
	}
	
	// -------- Hitung total data kepala keluarga -------- //
	function getTotalDataKepalaKeluarga(){
		$this->db->select('*');
		$this->db->from('tbl_keluarga');
		$query = $this->db->get();
        return $query->num_rows();
	}
	
	//--------------  Status Kawin --------------- //
	function get_dataBK(){
        $this->db->select('*');
		$this->db->where('id_status_kawin','1');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
	function get_dataBKlaki(){
        $this->db->select('*');
		$this->db->where('id_status_kawin','1');
		$this->db->where('id_jen_kel','1');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
	function get_dataBKperempuan(){
        $this->db->select('*');
		$this->db->where('id_status_kawin','1');
		$this->db->where('id_jen_kel','2');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }	
	// ----- Kawin ---- //
	function get_dataK(){
        $this->db->select('*');
		$this->db->where('id_status_kawin','2');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
	function get_dataKlaki(){
        $this->db->select('*');
		$this->db->where('id_status_kawin','2');
		$this->db->where('id_jen_kel','1');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
	function get_dataKperempuan(){
        $this->db->select('*');
		$this->db->where('id_status_kawin','2');
		$this->db->where('id_jen_kel','2');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }	
	// ---- Cerai Hidup --- //
	function get_dataCH(){
        $this->db->select('*');
		$this->db->where('id_status_kawin','3');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
	function get_dataCHlaki(){
        $this->db->select('*');
		$this->db->where('id_status_kawin','3');
		$this->db->where('id_jen_kel','1');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
	function get_dataCHperempuan(){
        $this->db->select('*');
		$this->db->where('id_status_kawin','3');
		$this->db->where('id_jen_kel','2');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
	// --- Cerai Mati --- //
	function get_dataCM(){
        $this->db->select('*');
		$this->db->where('id_status_kawin','4');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
	function get_dataCMlaki(){
        $this->db->select('*');
		$this->db->where('id_status_kawin','4');
		$this->db->where('id_jen_kel','1');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
	function get_dataCMperempuan(){
        $this->db->select('*');
		$this->db->where('id_status_kawin','4');
		$this->db->where('id_jen_kel','2');
		$this->db->from('tbl_penduduk');
		$query = $this->db->get();
        return $query->num_rows();
    }
	
	// -------------  Golongan Darah   -------------------- //	
	

	function getGolDar()
	{
		$q = $this->db->get('ref_goldar');
		return $q->result();
	}
	function getPendudukByIdGolDar($id_goldar)
	{
		$this->db->select('ref_goldar.deskripsi,count(id_penduduk) as jumlah')->from('tbl_penduduk');
		$this->db->join('ref_goldar','ref_goldar.id_goldar = tbl_penduduk.id_goldar');
		$this->db->where('tbl_penduduk.id_goldar', $id_goldar);
		$q = $this->db->get();
		return $q->result();		
	}
	
	function getJumlahPendudukByIdGolDar($id_goldar)
	{
		$this->db->select('*');
		$this->db->join('ref_goldar','ref_goldar.id_goldar = tbl_penduduk.id_goldar');
		$this->db->where('tbl_penduduk.id_goldar', $id_goldar);
		$q = $this->db->get('tbl_penduduk');		
		return $q->num_rows();			
	}
	
	function getJumlahLakiLakiByIdGolDar($id_goldar)
	{	
		$this->db->select('*');
		$this->db->join('ref_goldar','ref_goldar.id_goldar = tbl_penduduk.id_goldar');
		$this->db->where('tbl_penduduk.id_goldar', $id_goldar);
		$this->db->where('tbl_penduduk.id_jen_kel', '1');		
		$q = $this->db->get('tbl_penduduk');
		return $q->num_rows();	      
	}
	
	function getJumlahPerempuanByIdGolDar($id_goldar)
	{
		$this->db->select('*');
		$this->db->join('ref_goldar','ref_goldar.id_goldar = tbl_penduduk.id_goldar');
		$this->db->where('tbl_penduduk.id_goldar', $id_goldar);
		$this->db->where('tbl_penduduk.id_jen_kel', '2');
		$q = $this->db->get('tbl_penduduk');
		return $q->num_rows();	
	}
	
	// ------------------- Agama ------------- //	
	
	
	function getAgama()
	{
		$q = $this->db->get('ref_agama');
		return $q->result();
	}
	function getPendudukByIdAgama($id_agama)
	{
		$this->db->select('ref_agama.deskripsi,count(id_penduduk) as jumlah')->from('tbl_penduduk');
		$this->db->join('ref_agama','ref_agama.id_agama = tbl_penduduk.id_agama');
		$this->db->where('tbl_penduduk.id_agama', $id_agama);
		$q = $this->db->get();
		return $q->result();		
	}
	
	function getJumlahPendudukByIdAgama($id_agama)
	{
		$this->db->select('*');
		$this->db->join('ref_agama','ref_agama.id_agama = tbl_penduduk.id_agama');
		$this->db->where('tbl_penduduk.id_agama', $id_agama);
		$q = $this->db->get('tbl_penduduk');		
		return $q->num_rows();			
	}
	
	function getJumlahLakiLakiByIdAgama($id_agama)
	{	
		$this->db->select('*');
		$this->db->join('ref_agama','ref_agama.id_agama = tbl_penduduk.id_agama');
		$this->db->where('tbl_penduduk.id_agama', $id_agama);
		$this->db->where('tbl_penduduk.id_jen_kel', '1');		
		$q = $this->db->get('tbl_penduduk');
		return $q->num_rows();	      
	}
	
	function getJumlahPerempuanByIdAgama($id_agama)
	{
		$this->db->select('*');
		$this->db->join('ref_agama','ref_agama.id_agama = tbl_penduduk.id_agama');
		$this->db->where('tbl_penduduk.id_agama', $id_agama);
		$this->db->where('tbl_penduduk.id_jen_kel', '2');
		$q = $this->db->get('tbl_penduduk');
		return $q->num_rows();	
	}

	//------------------- Get All Data ---------------------- //
	// ---- DATA PENDIDIKAN --- //
	
	function getDataPendidikan(){
		$this->db->select(deskripsi);
		$this->db->from('ref_pendidikan');
		$query = $this->db->get();
	}
	
	function get_dataPendidikanJumlah(){
		$this->db->select('deskripsi as jenis,count(tbl_penduduk.id_pendidikan) as jumlah');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','1');
		$sub->where('tbl_penduduk.id_pendidikan = ref_pendidikan.id_pendidikan');
		$this->subquery->end_subquery('laki');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','2');
		$sub->where('tbl_penduduk.id_pendidikan = ref_pendidikan.id_pendidikan');
		$this->subquery->end_subquery('perempuan');
		
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_pendidikan','ref_pendidikan.id_pendidikan = tbl_penduduk.id_pendidikan','right');
		$this->db->group_by("deskripsi");
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_jumlahPendidikan(){
		$this->db->select('id_pendidikan,deskripsi');
		$this->db->from('ref_pendidikan');
		$query = $this->db->get();		
		return $query->num_rows();		
	}
	function get_pendidikanPenduduk()
	{
		$this->db->select('deskripsi as jenis,count(tbl_penduduk.id_pendidikan) as jumlah');
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_pendidikan','ref_pendidikan.id_pendidikan = tbl_penduduk.id_pendidikan','right');
		$this->db->group_by("deskripsi");
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
	
	
	// --- PEKERJAAN ---//

	function get_dataPekerjaanJumlah(){
        $this->db->select('ref_pekerjaan.deskripsi as jenis,count(tbl_penduduk.id_pekerjaan) as jumlah');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','1');
		$sub->where('tbl_penduduk.id_pekerjaan = ref_pekerjaan.id_pekerjaan');
		$this->subquery->end_subquery('laki');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','2');
		$sub->where('tbl_penduduk.id_pekerjaan = ref_pekerjaan.id_pekerjaan');
		$this->subquery->end_subquery('perempuan');
		
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_pekerjaan','ref_pekerjaan.id_pekerjaan = tbl_penduduk.id_pekerjaan','right');
		$this->db->group_by("ref_pekerjaan.deskripsi");
		$query = $this->db->get();
		return $query->result();
    }
		
	function get_jumlahPekerjaan(){
		$this->db->select('id_pekerjaan,deskripsi');
		$this->db->from('ref_pekerjaan');
		$query = $this->db->get();		
		return $query->num_rows();		
	}
	function get_pekerjaanPenduduk()
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
	
	
	//--- Raskin  --- Jamkesmas --- Kelas Sosisal --- //
	function get_raskinYa(){
        $this->db->select('*');
		$this->db->where('is_raskin','Y');
		$this->db->from('tbl_keluarga');
		$query = $this->db->get();
        return $query->num_rows();
    }
	
	function get_raskinTidak(){
        $this->db->select('*');
		$this->db->where('is_raskin','N');
		$this->db->from('tbl_keluarga');
		$query = $this->db->get();
        return $query->num_rows();
    }
	
	// --- JAMKESMAS --- //
	
	function get_jamkesmasYa(){
        $this->db->select('*');
		$this->db->where('is_jamkesmas','Y');
		$this->db->from('tbl_keluarga');
		$query = $this->db->get();
        return $query->num_rows();
    }
	
	function get_jamkesmasTidak(){
        $this->db->select('*');
		$this->db->where('is_jamkesmas','N');
		$this->db->from('tbl_keluarga');
		$query = $this->db->get();
        return $query->num_rows();
    }
	
	// --- JAMKESMAS --- //
	
	function get_pkhYa(){
        $this->db->select('*');
		$this->db->where('is_jamkesmas','Y');
		$this->db->from('tbl_keluarga');
		$query = $this->db->get();
        return $query->num_rows();
    }
	
	function get_pkhTidak(){
        $this->db->select('*');
		$this->db->where('is_jamkesmas','N');
		$this->db->from('tbl_keluarga');
		$query = $this->db->get();
        return $query->num_rows();
    }
	
	// --- KK PEREMPUAN --- //
	
	function getKkPerempuan(){		
		$this->db->select('*');
		$this->db->join('tbl_keluarga','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk');
		$this->db->where('tbl_penduduk.id_jen_kel', '2');
		$q = $this->db->get('tbl_penduduk');
		return $q->num_rows();		
    }
	
	function getKkLaki(){		
		$this->db->select('*');
		$this->db->join('tbl_keluarga','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk');
		$this->db->where('tbl_penduduk.id_jen_kel', '1');
		$q = $this->db->get('tbl_penduduk');
		return $q->num_rows();		
    }
	
	// --- KK GIZI BURUK --- //
	
	function getGiziBuruk($jen_kel){		
		$this->db->select('id_gizi_buruk');
		$this->db->join('tbl_penduduk','tbl_gizi_buruk.id_penduduk = tbl_penduduk.id_penduduk');
		$this->db->where('tbl_penduduk.id_jen_kel', $jen_kel);
		//$this->db->where('umur >=', $minvalue);
		//$this->db->where('umur <=', $maxvalue);
		$q = $this->db->get('tbl_gizi_buruk');
		return $q->num_rows();		
		
		//$age = date_diff(date_create($bdate), date_create('now'))->y;
    }
	
	// --- KEHAMILAN --- //
	
	function getKehamilan(){		
		$this->db->select('id_kondisi_kehamilan');
		$this->db->join('tbl_penduduk','tbl_kondisi_kehamilan.id_penduduk = tbl_penduduk.id_penduduk');
		$q = $this->db->get('tbl_kondisi_kehamilan');
		return $q->num_rows();				
    }
	function pendudukPerempuan(){		
		$this->db->select('id_penduduk');
		$this->db->where('id_jen_kel', 2);
		$q = $this->db->get('tbl_penduduk');
		return $q->num_rows();			
    }
	
	//////MIGRAN//////
	
	function getMigran(){
	
		$this->db->select('id_penduduk	');		
		$this->db->join('ref_pekerjaan','tbl_penduduk.id_pekerjaan = ref_pekerjaan.id_pekerjaan');		
		$this->db->where('ref_pekerjaan.deskripsi','BURUH MIGRAN');
		$q = $this->db->get('tbl_penduduk');		
		return $q->num_rows();	
	}
	
	//////BSM//////
	
	function getBsm(){
	
		$this->db->select('id_bsm');		
		//$this->db->join('ref_pekerjaan','tbl_penduduk.id_pekerjaan = ref_pekerjaan.id_pekerjaan');		
		//$this->db->where('ref_pekerjaan.deskripsi','BURUH MIGRAN');
		$q = $this->db->get('tbl_bsm');		
		return $q->num_rows();	
	}
	
	////////////////
	
	// -------------  KELAS SOSIAL  -------------------- //	
	

	/* function getGolDar()
	{
		$q = $this->db->get('ref_goldar');
		return $q->result();
	}
	function getPendudukByIdGolDar($id_goldar)
	{
		$this->db->select('ref_goldar.deskripsi,count(id_penduduk) as jumlah')->from('tbl_penduduk');
		$this->db->join('ref_goldar','ref_goldar.id_goldar = tbl_penduduk.id_goldar');
		$this->db->where('tbl_penduduk.id_goldar', $id_goldar);
		$q = $this->db->get();
		return $q->result();		
	}
	
	function getJumlahPendudukByIdGolDar($id_goldar)
	{
		$this->db->select('*');
		$this->db->join('ref_goldar','ref_goldar.id_goldar = tbl_penduduk.id_goldar');
		$this->db->where('tbl_penduduk.id_goldar', $id_goldar);
		$q = $this->db->get('tbl_penduduk');		
		return $q->num_rows();			
	}
	 */
	
	// --- Kelas Sosial --- //
	
	function get_sangatmiskin(){
        $this->db->select('*');
		$this->db->where('id_kelas_sosial','4');
		$this->db->from('tbl_keluarga');
		$query = $this->db->get();
        return $query->num_rows();
    }
	
	function get_miskin(){
        $this->db->select('*');
		$this->db->where('id_kelas_sosial','3');
		$this->db->from('tbl_keluarga');
		$query = $this->db->get();
        return $query->num_rows();
    }
	
	function get_sedang(){
        $this->db->select('*');
		$this->db->where('id_kelas_sosial','2');
		$this->db->from('tbl_keluarga');
		$query = $this->db->get();
        return $query->num_rows();
    }
	
	function get_kaya(){
        $this->db->select('*');
		$this->db->where('id_kelas_sosial','1');
		$this->db->from('tbl_keluarga');
		$query = $this->db->get();
        return $query->num_rows();
    }
}