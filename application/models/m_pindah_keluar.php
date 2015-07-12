<?php
class M_pindah_keluar extends CI_Model 
{
	  function __construct()
	  {
		parent::__construct();
		$this->_table = 'tbl_pindah_keluar';
		$this->_tableKeluarga = 'tbl_keluarga';
		$this->_tableHubKeluarga = 'tbl_hub_kel';
		$this->_tablePenduduk = 'tbl_penduduk';
		$this->_tableIkutPindahKeluar = 'tbl_ikut_pindah_keluar';
		
		//get instance
		$this->CI = get_instance();
	  }
	  
	  public function get_pindah_keluar_flexigrid()
		{
			//Build contents query
			$this->db->select
			('
				tbl_pindah_keluar.*,
				ref_jenis_pindah.deskripsi as jenis_pindah,
				ref_klasifikasi_pindah.deskripsi as klasifikasi_pindah,
				ref_alasan_pindah.deskripsi as alasan_pindah,
				tbl_penduduk.nama
			')->from($this->_table);
			
			$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_pindah_keluar.id_penduduk');
			$this->db->join('ref_jenis_pindah','ref_jenis_pindah.id_jenis_pindah = tbl_pindah_keluar.id_jenis_pindah');
			$this->db->join('ref_klasifikasi_pindah','ref_klasifikasi_pindah.id_klasifikasi_pindah = tbl_pindah_keluar.id_klasifikasi_pindah');
			$this->db->join('ref_alasan_pindah','ref_alasan_pindah.id_alasan_pindah = tbl_pindah_keluar.id_alasan_pindah');
			$this->db->join('tbl_hub_kel','tbl_hub_kel.id_penduduk = tbl_penduduk.id_penduduk');
			$this->db->where('tbl_hub_kel.id_status_keluarga','1');
			$this->CI->flexigrid->build_query();

			//Get contents
			$return['records'] = $this->db->get();

			//Build count query
			$this->db->select("count(id_pindah_keluar) as record_count")->from($this->_table);
			$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_pindah_keluar.id_penduduk');
			$this->db->join('tbl_hub_kel','tbl_hub_kel.id_penduduk = tbl_penduduk.id_penduduk');
			$this->db->where('tbl_hub_kel.id_status_keluarga','1');
			$record_count = $this->db->get();
			$row = $record_count->row();

			//Get Record Count
			$return['record_count'] = $row->record_count;

			$this->CI->flexigrid->build_query(TRUE);
			//Return all
			return $return;
		}
		
		function get_jenisPindah() 
		{      
			$this->db->where('id_jenis_pindah <>', '0');
			$records = $this->db->get('ref_jenis_pindah');
			$data=array();
			foreach ($records->result() as $row)
			{	
				$data[''] = '--Pilih--';
				$data[$row->id_jenis_pindah] = $row->deskripsi;
			}
			return ($data);
		}
		
		function get_KlasifikasiPindah() 
		{      
			$this->db->where('id_klasifikasi_pindah <>', '0');
			$records = $this->db->get('ref_klasifikasi_pindah');
			$data=array();
			foreach ($records->result() as $row)
			{	
				$data[''] = '--Pilih--';
				$data[$row->id_klasifikasi_pindah] = $row->deskripsi;
			}
			return ($data);
		}
		
		function get_AlasanPindah() 
		{      
			$this->db->where('id_alasan_pindah <>', '0');
			$records = $this->db->get('ref_alasan_pindah');
						$this->db->where('id_alasan_pindah <>', 0);
			$data=array();
			foreach ($records->result() as $row)
			{	
				$data[''] = '--Pilih--';
				$data[$row->id_alasan_pindah] = $row->deskripsi;
			}
			return ($data);
		}
		
		function get_IdKeluargaByNoKk($no_kk)
		{
			$this->db->select('id_keluarga');
			$this->db->where('no_kk', $no_kk);
			$q = $this->db->get('tbl_keluarga');
			//if id is unique we want just one row to be returned
			$data = array_shift($q->result_array());
			return ($data['id_keluarga']);
		}
		
		function get_IdPendudukByNIK($nik)
		{
		$this->db->select('id_penduduk');
		$this->db->where('nik', $nik);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		return $data['id_penduduk'];
		}
		
		function insertPindahKeluar($data)
		{
			$this->db->insert($this->_table, $data);
		}
		
		function insertKeluarga($data)
		{
			$this->db->insert($this->_tableKeluarga, $data);
		}
		
		function insertPenduduk($data)
		{
			$this->db->insert($this->_tablePenduduk, $data);
		}
		
		function insertHubKeluarga($data)
		{
			$this->db->insert($this->_tableHubKeluarga, $data);
		}
		
		function insertIkutPindahKeluar($data)
		{
			$this->db->insert($this->_tableIkutPindahKeluar, $data);
		}
		
		function updatePindahKeluar($where, $data)
		{
			$this->db->where($where);
			$this->db->update($this->_table, $data);
			return $this->db->affected_rows();
		}
		
		function updateKeluarga($where, $data)
		{
			$this->db->where($where);
			$this->db->update($this->_tableKeluarga, $data);
			return $this->db->affected_rows();
		}
		
		function updatePenduduk($where, $data)
		{
			$this->db->where($where);
			$this->db->update($this->_tablePenduduk, $data);
			return $this->db->affected_rows();
		}

		function updateHubKeluarga($where, $data)
		{
			$this->db->where($where);
			$this->db->update($this->_tableHubKeluarga, $data);
			return $this->db->affected_rows();
		}
		
		function deletePindahKeluar($id)
		{
			$this->db->where('id_pindah_keluar', $id);
			$this->db->delete($this->_table);
		}
				
		function getIdPendudukByIdPindahKeluar($id)
		{
			$this->db->select('id_penduduk');
			$this->db->where('id_pindah_keluar', $id);
			$q = $this->db->get('tbl_pindah_keluar');
			$data = array_shift($q->result_array());
			return ($data['id_penduduk']);
		}
		
		function getIdKeluargaByIdPindahKeluar($id)
		{
			$this->db->select('id_keluarga');
			$this->db->where('id_pindah_keluar', $id);
			$q = $this->db->get('tbl_pindah_keluar');
			$data = array_shift($q->result_array());
			return ($data['id_keluarga']);
		}
		
		function getIdHubKelByIdKeluarga($id)
		{
			$this->db->select('id_hub_kel');
			$this->db->where('id_keluarga', $id);
			$q = $this->db->get('tbl_hub_kel');
			$data = array_shift($q->result_array());
			return ($data['id_hub_kel']);
		}
		
		function getPindahKeluarByIdPindahKeluar($id)
		{
			return $this->db->get_where($this->_table,array('id_pindah_keluar' => $id))->row();
		}
		
		function getPendudukByIdPenduduk($id)
		{
			return $this->db->get_where($this->_tablePenduduk,array('id_penduduk' => $id))->row();
		}
		
		function getKeluargaByIdKeluarga($id)
		{
			return $this->db->get_where($this->_tableKeluarga,array('id_keluarga' => $id))->row();
		}
		
		function getHubKelByIdHubKel($id)
		{
			return $this->db->get_where($this->_tableHubKeluarga,array('id_hub_kel' => $id))->row();
		}
		
		function getIdStatusPendudukByDeskripsi($desc)
		{
			$this->db->select('id_status_penduduk');
			$this->db->where('deskripsi', $desc);
			$q = $this->db->get('ref_status_penduduk');
			$data = array_shift($q->result_array());
			return ($data['id_status_penduduk']);
		}
		
		function getIdPendudukByNoKK($no_kk)
		{
			$this->db->select('tbl_penduduk.id_penduduk');
			$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_keluarga.id_kepala_keluarga');
			$this->db->where('tbl_keluarga.no_kk', $no_kk);
			$q = $this->db->get('tbl_keluarga');
			$data = array_shift($q->result_array());
			return ($data['id_penduduk']);
		}
		
	
		function getKepalaKeluargaLikeNama($nama)
		{
			$this->db->select('tbl_penduduk.nama, tbl_keluarga.no_kk');
			$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_keluarga.id_kepala_keluarga','left');
			$this->db->join('ref_status_penduduk','ref_status_penduduk.id_status_penduduk = tbl_penduduk.id_status_penduduk');
			$this->db->like('tbl_penduduk.nama', $nama);
			$this->db->where('ref_status_penduduk.deskripsi <>', 'Meninggal');
			$this->db->where('ref_status_penduduk.deskripsi <>', 'Pindahan Keluar');
			$query = $this->db->get('tbl_keluarga');
			return $query->result();
		}
		
		function getIdPindahKeluarByIdPenduduk($id)
		{
			$this->db->select('*');
			$this->db->where('id_penduduk', $id);
			$q = $this->db->get('tbl_pindah_keluar');
			$data = array_shift($q->result_array());
			return ($data['id_pindah_keluar']);
		}
		
		function cekAnggotaKeluargaByIdKeluarga($id)
		{
			$this->db->select('tbl_hub_kel.id_hub_kel');
			$this->db->join('tbl_keluarga','tbl_keluarga.id_keluarga = tbl_hub_kel.id_keluarga');
			$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk');
			$this->db->join('ref_status_penduduk','ref_status_penduduk.id_status_penduduk = tbl_penduduk.id_status_penduduk');
			$this->db->where('tbl_hub_kel.id_keluarga', $id);
			$q = $this->db->get('tbl_hub_kel');
			if($q->num_rows() >= 1)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		
		function getIdKeluargaByNoKK($no_kk)
		{	
			$this->db->select('tbl_hub_kel.id_keluarga');
			$this->db->join('tbl_keluarga','tbl_keluarga.id_keluarga = tbl_hub_kel.id_keluarga');
			$this->db->where('tbl_keluarga.no_kk', $no_kk);
			$q = $this->db->get('tbl_hub_kel');
			return $q->result();
		}
		
		function getIdPendudukByIdKeluarga($id_keluarga)
		{	
			$this->db->select('id_penduduk');
			$this->db->where('id_keluarga', $id_keluarga);
			$q = $this->db->get('tbl_hub_kel');
			return $q->result();
		}
		
		function get_IdPindahKeluarByIdKeluarga($id_keluarga)
		{
			$this->db->select('id_pindah_keluar');
			$this->db->where('id_keluarga', $id_keluarga);
			$q = $this->db->get('tbl_pindah_keluar');
			return $q->result();
		}
		
		
}
?>