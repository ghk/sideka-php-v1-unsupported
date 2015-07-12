<?php
class M_meninggal extends CI_Model 
{
		function __construct()
		{
			parent::__construct();
			$this->_table='tbl_meninggal';
			$this->_tablePenduduk='tbl_penduduk';
			$this->_tablePerangkat='tbl_perangkat';
			$this->_tableKeluarga='tbl_keluarga';
			$this->_tableHubKel='tbl_hub_kel';
			$this->_tableSurat='tbl_surat';
			$this->_refPelapor='ref_pelapor';
			//get instance
			$this->CI = get_instance();
		}
		
		public function get_meninggal_flexigrid()
		{
			//Build contents query
			$this->db->select
			(
				'tbl_meninggal.id_meninggal, 
				tbl_meninggal.nama, 
				tbl_meninggal.tgl_meninggal,
				tbl_meninggal.sebab, 
				tbl_meninggal.id_penduduk, 
				tbl_meninggal.penentu_kematian, 
				tbl_meninggal.tempat_kematian, 
				tbl_meninggal.id_pelapor, 
				tbl_meninggal.nama_pelapor, 
				tbl_meninggal.hubungan_pelapor, 
				tbl_meninggal.id_surat'
			)->from($this->_table);
			//$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_meninggal.id_penduduk');
			//$this->db->join('tbl_surat','tbl_surat.id_surat = tbl_meninggal.id_surat');
			$this->db->join('ref_pelapor','ref_pelapor.id_pelapor = tbl_meninggal.id_pelapor');
			//$this->db->join('ref_kode_surat','ref_kode_surat.kode_surat = tbl_surat.kode_surat') ;
			
			$this->CI->flexigrid->build_query();
			//Get contents
			$return['records'] = $this->db->get();
			//Build count query
			$this->db->select("count(id_meninggal) as record_count")->from($this->_table);
			$record_count = $this->db->get();
			$row = $record_count->row();
			//Get Record Count
			$return['record_count'] = $row->record_count;
			
			$this->CI->flexigrid->build_query(TRUE);
			//Return all
			return $return;
		}

		function get_pelapor() 
		{      
			$records = $this->db->get('ref_pelapor');
			$data=array();
			foreach ($records->result() as $row)
			{	
				$data[''] = '--Pilih--';
				$data[$row->id_pelapor] = $row->deskripsi;
			}
			return ($data);
		}

		function insertMeninggal($data)
		{
			$this->db->insert($this->_table, $data);
		}
		function insertSurat($data)
		  {
			$this->db->insert($this->_tableSurat, $data);
		  }

		function deletePenduduk($id)
		{
			$this->db->where('nik', $id);
			$this->db->delete($this->_tablePenduduk);
		}
		
		function getIdPendudukByNIK($nik)
		{
			$this->db->select('id_penduduk');
			$this->db->where('nik', $nik);
			$q = $this->db->get('tbl_penduduk');
			//if id is unique we want just one row to be returned
			$data = array_shift($q->result_array());
			return $data['id_penduduk'];
		}
		
		function getHubunganPelaporByIdPelapor($id)
		{
			$this->db->select('deskripsi');
			$this->db->where('id_pelapor', $id);
			$q = $this->db->get('ref_pelapor');
			//if id is unique we want just one row to be returned
			$data = array_shift($q->result_array());
			return $data['deskripsi'];
		}

		function updateMeninggal($where, $data)
		 {
		    $this->db->where($where);
			$this->db->update($this->_table, $data);
			return $this->db->affected_rows();
		 }
		 
		 function updateSurat($where, $data)
		 {
		    $this->db->where($where);
			$this->db->update($this->_tableSurat, $data);
			return $this->db->affected_rows();
		 }
		 
		  function updatePenduduk($where, $data)
		 {
		    $this->db->where($where);
			$this->db->update($this->_tablePenduduk, $data);
			return $this->db->affected_rows();
		 }
		 
		  function updateKeluarga($where, $data)
		 {
		    $this->db->where($where);
			$this->db->update($this->_tableKeluarga, $data);
			return $this->db->affected_rows();
		 }
		 
		  function updateHubKel($where, $data)
		 {
		    $this->db->where($where);
			$this->db->update($this->_tableHubKel, $data);
			return $this->db->affected_rows();
		 }

		 function getMeninggalByIdMeninggal($id)
		 {	
		    return $this->db->get_where($this->_table,array('id_meninggal' => $id))->row();
		 }
		 
		 function getPendudukByIdPenduduk($id)
		 {	
		    return $this->db->get_where($this->_tablePenduduk,array('id_penduduk' => $id))->row();
		 }
		 
		function deleteMeninggal($id)
		{
			$this->db->where('id_meninggal', $id);
			$this->db->delete($this->_table);
		}
		
		function get_NikPenduduk($nik)
		{
			$this->db->select('nik,nama');
			$this->db->like('nik', $nik);
			$query = $this->db->get('tbl_penduduk');
			
			return $query->result();
		}
		
		function get_IdSuratByIdMeninggal($id_meninggal)
		{
			$this->db->select('id_surat');
			$this->db->where('id_meninggal', $id_meninggal);
			$q = $this->db->get('tbl_meninggal');
			//if id is unique we want just one row to be returned
			$data = array_shift($q->result_array());
			return ($data['id_surat']);
		}
		
		function get_NamaPenduduk($nama)
		{
			$this->db->select('tbl_penduduk.id_penduduk, 
				tbl_penduduk.nik, 
				tbl_penduduk.nama,
				tbl_hub_kel.id_keluarga,
				ref_status_keluarga.deskripsi');
			$this->db->join('ref_status_penduduk','ref_status_penduduk.id_status_penduduk = tbl_penduduk.id_status_penduduk');
			$this->db->join('tbl_hub_kel','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk','left'); 
			$this->db->join('tbl_keluarga','tbl_hub_kel.id_keluarga = tbl_keluarga.id_keluarga','left'); 
			$this->db->join('ref_status_keluarga','ref_status_keluarga.id_status_keluarga = tbl_hub_kel.id_status_keluarga','left'); 
			$this->db->like('nama', $nama);
			$this->db->where('ref_status_penduduk.deskripsi <>', 'Meninggal');
			$query = $this->db->get('tbl_penduduk');
			
			return $query->result();
		}
	
		
		function cekKepalaKeluargaByIdPenduduk($id)
		{
			$this->db->select('*');
			$this->db->where('id_kepala_keluarga', $id);
			$q = $this->db->get('tbl_keluarga',1);
			return $q->row();
		}
		
		function cekStatusPendudukMeninggakByIdPenduduk($id)
		{
			$this->db->select('tbl_penduduk.id_penduduk, ref_status_penduduk.deskripsi');
			$this->db->join('ref_status_penduduk','ref_status_penduduk.id_status_penduduk = tbl_penduduk.id_status_penduduk');
			$this->db->where('tbl_penduduk.id_penduduk', $id);
			$this->db->where('ref_status_penduduk.deskripsi', 'Meninggal');
			$q = $this->db->get('tbl_penduduk');
			return $q->row();
		}
		
		function cekKesendirianByIdKeluarga($id)
		{
			$this->db->select('tbl_hub_kel.id_hub_kel');
			$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk');
			$this->db->join('ref_status_penduduk','ref_status_penduduk.id_status_penduduk = tbl_penduduk.id_status_penduduk');
			$this->db->where('tbl_hub_kel.id_keluarga', $id);
			$this->db->where('ref_status_penduduk.deskripsi <>', 'Meninggal');
			$q = $this->db->get('tbl_hub_kel');
			if($q->num_rows() == 1)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		
	
		
		
		function getIdKeluargaByIdPenduduk($id)
		{
			$this->db->select('id_keluarga');
			$this->db->where('id_kepala_keluarga', $id);
			$q = $this->db->get('tbl_keluarga');
			$data = array_shift($q->result_array());
			return ($data['id_keluarga']);
		}
		
		function getAnggotaKeluargaById($id_keluarga, $id_penduduk) 
		{      
			$this->db->select('
				tbl_penduduk.id_penduduk, 
				tbl_penduduk.nik, 
				tbl_penduduk.nama,
				tbl_hub_kel.id_keluarga,
				ref_status_keluarga.deskripsi
			')->from('tbl_penduduk');
			$this->db->join('tbl_hub_kel','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk','left'); 
			$this->db->join('tbl_keluarga','tbl_hub_kel.id_keluarga = tbl_keluarga.id_keluarga','left'); 
			$this->db->join('ref_status_keluarga','ref_status_keluarga.id_status_keluarga = tbl_hub_kel.id_status_keluarga','left'); 
			$this->db->join('ref_status_penduduk','ref_status_penduduk.id_status_penduduk = tbl_penduduk.id_status_penduduk');
			$this->db->where('tbl_hub_kel.id_keluarga', $id_keluarga);
			$this->db->where('tbl_hub_kel.id_penduduk <>', $id_penduduk);
			$this->db->where('ref_status_penduduk.deskripsi <>', 'Meninggal');
			$records = $this->db->get();
			$data = array();
			foreach ($records->result() as $row)
			{	
				$data[''] = '-- NIK | Nama | Status Keluarga --';
				$data[$row->id_penduduk] = $row->nik.' | '.$row->nama. ' | '.$row->deskripsi;
			}
			return ($data);
		}
		
		function getIdHubKelByIdPenduduk($id)
		{
			$this->db->select('id_hub_kel');
			$this->db->where('id_penduduk', $id);
			$q = $this->db->get('tbl_hub_kel');
			$data = array_shift($q->result_array());
			return ($data['id_hub_kel']);
		}
		
		function getIdStatusKeluargaByDeskripsi($desc)
		{
			$this->db->select('id_status_keluarga');
			$this->db->where('deskripsi', $desc);
			$q = $this->db->get('ref_status_keluarga');
			$data = array_shift($q->result_array());
			return ($data['id_status_keluarga']);
		}
		
		function getIdStatusPendudukByDeskripsi($desc)
		{
			$this->db->select('id_status_penduduk');
			$this->db->where('deskripsi', $desc);
			$q = $this->db->get('ref_status_penduduk');
			$data = array_shift($q->result_array());
			return ($data['id_status_penduduk']);
		}

		function getIdPendudukByIdMeninggal($id)
		{
			$this->db->select('id_penduduk');
			$this->db->where('id_meninggal', $id);
			$q = $this->db->get('tbl_meninggal');
			$data = array_shift($q->result_array());
			return ($data['id_penduduk']);
		}
		
		function get_NomorSuratByIdSurat($id_surat)
		{
			$this->db->select('nomor_surat');
			$this->db->where('id_surat', $id_surat);
			$q = $this->db->get('tbl_surat');
			//if id is unique we want just one row to be returned
			$data = array_shift($q->result_array());
			return ($data['nomor_surat']);
		}
		
		function get_KodeSuratByDeskripsi($deskripsi)
		{
			$this->db->select('kode_surat');
			$this->db->where('deskripsi', $deskripsi);
			$q = $this->db->get('ref_kode_surat');
			//if id is unique we want just one row to be returned
			$data = array_shift($q->result_array());
			return ($data['kode_surat']);
		}
		
		function get_SupraKodeByKodeSurat($kode_surat)
		{
			$this->db->select('supra_kode');
			$this->db->where('kode_surat', $kode_surat);
			$q = $this->db->get('ref_kode_surat');
			//if id is unique we want just one row to be returned
			$data = array_shift($q->result_array());
			return ($data['supra_kode']);
		}
		
		function get_IdSuratByNomorSurat($nomor_surat)
		{
			$this->db->select('id_surat');
			$this->db->where('nomor_surat', $nomor_surat);
			$q = $this->db->get('tbl_surat');
			//if id is unique we want just one row to be returned
			$data = array_shift($q->result_array());
			return ($data['id_surat']);
		}
		
		function getNoSuratMax()
		{	
			$this->db->select_max('nomor_registrasi');
			$this->db->where('YEAR(tgl_surat)', date('Y'));
			$q = $this->db->get('tbl_surat');
			$data = array_shift($q->result_array());
			$result = $data['nomor_registrasi'];
			if ($result == NULL)
			{
				return '1';
			}
			else
			{	$temp = intval($result);		
				return  $temp;
			}
		}
		function getNoSuratMaxIncrement()
		{	
			$this->db->select_max('nomor_registrasi');
			$this->db->where('YEAR(tgl_surat)', date('Y'));
			$q = $this->db->get('tbl_surat');
			$data = array_shift($q->result_array());
			$result = $data['nomor_registrasi'];
			if ($result == NULL)
			{
				return '1';
			}
			else
			{	$temp = intval($result)+1;		
				return  $temp;
			}
		}
		
		function getSuratLengkap($id_meninggal)
		{
		$this->db->select('tbl_penduduk.nik,
		tbl_meninggal.tgl_meninggal,
		tbl_meninggal.nama,
		tbl_meninggal.sebab,
		tbl_meninggal.penentu_kematian,
		tbl_meninggal.tempat_kematian,
		tbl_surat.id_perangkat,
		tbl_surat.keterangan,
		tbl_surat.tgl_surat,
		tbl_surat.tgl_awal,
		tbl_surat.kode_surat,
		tbl_surat.nomor_surat,
		tbl_surat.judul_surat
		');
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_meninggal.id_penduduk','left');	
		$this->db->join('tbl_surat','tbl_meninggal.id_surat = tbl_surat.id_surat','left');	
		$this->db->where('tbl_meninggal.id_meninggal', $id_meninggal);
		$data=array();
		$query=$this->db->get('tbl_meninggal');
		if($query->num_rows()>0)
		{
			$data = $query->result();
		}
		$query->free_result();
		return $data;
		}
	
	
		function get_pamong() 
	{      
		$this->db->select('tbl_perangkat.id_perangkat, tbl_perangkat.nip,tbl_penduduk.nama,ref_jabatan.deskripsi as jabatan')->from('tbl_penduduk');
		$this->db->join('tbl_perangkat','tbl_perangkat.id_penduduk = tbl_penduduk.id_penduduk');
		$this->db->join('ref_jabatan','ref_jabatan.id_jabatan = tbl_perangkat.id_jabatan');
		$this->db->where('tbl_perangkat.is_aktif','Y');
		$records = $this->db->get();
		$data=array();
		foreach ($records->result() as $row)
		{	
			$data[''] = '--Pilih--';
			$data[$row->id_perangkat] = $row->nama.' - '.$row->jabatan;
		}
		return ($data);
	}

	
	function get_IdPerangkatByIdSurat($id)
	{
		$this->db->select('id_perangkat');
		$this->db->where('id_surat', $id);
		$q = $this->db->get('tbl_surat');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return ($data['id_perangkat']);
	}
	
	function getPerangkatByIdPerangkat($id)
	{
		return $this->db->get_where($this->_tablePerangkat,array('id_perangkat' => $id))->row();
	}
	
	function get_IdPendudukByNIK($nik)
	{
		$this->db->select('id_penduduk');
		$this->db->where('NIK', $nik);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return $data['id_penduduk'];
	}
	
}
?>