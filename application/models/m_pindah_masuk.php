<?php
class M_pindah_masuk extends CI_Model 
{
	  function __construct()
	  {
		parent::__construct();
		$this->_table = 'tbl_pindah_masuk';
		$this->_tableKeluarga = 'tbl_keluarga';
		$this->_tableHubKeluarga = 'tbl_hub_kel';
		$this->_tablePenduduk = 'tbl_penduduk';
		
		//get instance
		$this->CI = get_instance();
	  }
	  
	  public function get_pindah_masuk_flexigrid()
		{
			//Build contents query
			$this->db->select
			('
				tbl_pindah_masuk.*,
				ref_rt.nomor_rt as nomor_rt,
				ref_rw.nomor_rw as nomor_rw,
				ref_dusun.nama_dusun as nama_dusun,
				ref_desa.nama_desa as nama_desa,
				ref_jenis_pindah.deskripsi as jenis_pindah,
				ref_klasifikasi_pindah.deskripsi as klasifikasi_pindah,
				ref_alasan_pindah.deskripsi as alasan_pindah
			')->from($this->_table);
			
			$this->db->join('ref_rt','ref_rt.id_rt = tbl_pindah_masuk.id_rt');
			$this->db->join('ref_rw','ref_rw.id_rw = tbl_pindah_masuk.id_rw');
			$this->db->join('ref_dusun','ref_dusun.id_dusun = tbl_pindah_masuk.id_dusun');
			$this->db->join('ref_desa','ref_desa.id_desa = tbl_pindah_masuk.id_desa');
			$this->db->join('ref_jenis_pindah','ref_jenis_pindah.id_jenis_pindah = tbl_pindah_masuk.id_jenis_pindah');
			$this->db->join('ref_klasifikasi_pindah','ref_klasifikasi_pindah.id_klasifikasi_pindah = tbl_pindah_masuk.id_klasifikasi_pindah');
			$this->db->join('ref_alasan_pindah','ref_alasan_pindah.id_alasan_pindah = tbl_pindah_masuk.id_alasan_pindah');
			
			
			$this->CI->flexigrid->build_query();

			//Get contents
			$return['records'] = $this->db->get();

			//Build count query
			$this->db->select("count(id_pindah_masuk) as record_count")->from($this->_table);
			$record_count = $this->db->get();
			$row = $record_count->row();

			//Get Record Count
			$return['record_count'] = $row->record_count;

			$this->CI->flexigrid->build_query(TRUE);
			//Return all
			return $return;
		}
		
		function get_nomorRT() 
		{      
			$this->db->where('id_rt !=','0');
			$records = $this->db->get('ref_rt');
			$data=array();
			foreach ($records->result() as $row)
			{	
				$data[''] = '--Pilih--';
				$data[$row->id_rt] = $row->nomor_rt;
			}
			return ($data);
		}
		
		function get_nomorRW() 
		{      
			$this->db->where('id_rw !=','0');
			$records = $this->db->get('ref_rw');
			$data=array();
			foreach ($records->result() as $row)
			{	
				$data[''] = '--Pilih--';
				$data[$row->id_rw] = $row->nomor_rw;
			}
			return ($data);
		}
		
		function get_jenisPindah() 
		{      
			$this->db->where('id_jenis_pindah !=','0');
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
			$this->db->where('id_klasifikasi_pindah !=','0');
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
			$this->db->where('id_alasan_pindah !=','0');
			$records = $this->db->get('ref_alasan_pindah');
			$data=array();
			foreach ($records->result() as $row)
			{	
				$data[''] = '--Pilih--';
				$data[$row->id_alasan_pindah] = $row->deskripsi;
			}
			return ($data);
		}
		
		function get_Desa() 
		{      
			$this->db->where('id_desa !=','0');
			$records = $this->db->get('ref_desa');
			$data=array();
			foreach ($records->result() as $row)
			{	
				$data[''] = '--Pilih--';
				$data[$row->id_desa] = $row->nama_desa;
			}
			return ($data);
		}
		
		function get_Dusun() 
		{      
			$this->db->where('id_dusun !=','0');
			$records = $this->db->get('ref_dusun');
			$data=array();
			foreach ($records->result() as $row)
			{	
				$data[''] = '--Pilih--';
				$data[$row->id_dusun] = $row->nama_dusun;
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
		
		function insertPindahMasuk($data)
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
		
		function updatePindahMasuk($where, $data)
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
		
		function deletePindahMasuk($id)
		{
			$this->db->where('id_pindah_masuk', $id);
			$this->db->delete($this->_table);
		}
				
		function getIdPendudukByIdPindahMasuk($id)
		{
			$this->db->select('id_penduduk');
			$this->db->where('id_pindah_masuk', $id);
			$q = $this->db->get('tbl_pindah_masuk');
			$data = array_shift($q->result_array());
			return ($data['id_penduduk']);
		}
		
		function getIdKeluargaByIdPindahMasuk($id)
		{
			$this->db->select('id_keluarga');
			$this->db->where('id_pindah_masuk', $id);
			$q = $this->db->get('tbl_pindah_masuk');
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
		
		function getPindahMasukByIdPindahMasuk($id)
		{
			return $this->db->get_where($this->_table,array('id_pindah_masuk' => $id))->row();
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
		
		function get_rt_dinamic($id_rw) 
		{      
			$this->db->where('id_rt !=','0');	
			$this->db->where('id_rw',$id_rw);		
			$records = $this->db->get('ref_rt');
			$data=array();
			foreach ($records->result() as $row)
			{	
				$data[''] = '--Pilih--';
				$data[$row->id_rt] = $row->nomor_rt;
			}
			return ($data);
		}
		
		function get_rw_dinamic($id_dusun) 
		{      
			$this->db->where('id_rw !=','0');	
			$this->db->where('id_dusun',$id_dusun);		
			$records = $this->db->get('ref_rw');
			$data=array();
			foreach ($records->result() as $row)
			{	
				$data[''] = '--Pilih--';
				$data[$row->id_rw] = $row->nomor_rw;
			}
			return ($data);
		}
}
?>