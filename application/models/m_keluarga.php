<?php
class M_keluarga extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_keluarga';
    $this->load->library('Excel_generator');
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_keluarga_flexigrid()
    {
        //Build contents query
      
		
		$this->db->select('
		tbl_keluarga.*,
		tbl_penduduk.nama,
		tbl_penduduk.nik,
		ref_rt.nomor_rt,
		ref_rw.nomor_rw,
		ref_dusun.nama_dusun
		')->from($this->_table);
		
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_keluarga.id_kepala_keluarga');	
		$this->db->join('ref_rt','ref_rt.id_rt = tbl_keluarga.id_rt');
		$this->db->join('ref_rw','ref_rw.id_rw = tbl_keluarga.id_rw');
		$this->db->join('ref_dusun','ref_dusun.id_dusun = tbl_keluarga.id_dusun');
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		$this->db->where('ref_status_penduduk.deskripsi <>','Meninggal');
		
		
	   $this->CI->flexigrid->build_query();
		
        //Get contents
         $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_keluarga) as record_count")->from($this->_table);  
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_keluarga.id_kepala_keluarga');	
		$this->db->join('ref_rt','ref_rt.id_rt = tbl_keluarga.id_rt');
		$this->db->join('ref_rw','ref_rw.id_rw = tbl_keluarga.id_rw');
		$this->db->join('ref_dusun','ref_dusun.id_dusun = tbl_keluarga.id_dusun');
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		$this->db->where('ref_status_penduduk.deskripsi <>','Meninggal');		 
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count; 
		
		$this->CI->flexigrid->build_query(TRUE);	

        //Return all
        return $return;
    }
	
	function get_dataForExportExcel()
	{
		$this->db->select('
		tbl_keluarga.*,
		tbl_penduduk.nama,
		ref_rt.nomor_rt,
		ref_rw.nomor_rw,
		ref_dusun.nama_dusun
		')->from($this->_table);
		
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_keluarga.id_kepala_keluarga');	
		$this->db->join('ref_rt','ref_rt.id_rt = tbl_keluarga.id_rt');
		$this->db->join('ref_rw','ref_rw.id_rw = tbl_keluarga.id_rw');
		$this->db->join('ref_dusun','ref_dusun.id_dusun = tbl_keluarga.id_dusun');
		
		$query = $this->db->get();
        $this->excel_generator->set_query($query);
	}
	
  function insertKeluarga($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
   function insertPenduduk($data)
  {
    $this->db->insert('tbl_penduduk', $data);
  }
  function insertHubKel($data)
  {
    $this->db->insert('tbl_hub_kel', $data);
  }
  function getIdPendudukByIdKeluarga($id)
  {
	$count=0;
    $this->db->select('id_penduduk');
	$this->db->where('id_keluarga',$id);
	$records = $this->db->get('tbl_hub_kel');
	$data=array();
	foreach ($records->result() as $row)
	{	
		$data[$count] = $row->id_penduduk;
		$count++;
	}
	return ($data);
  }
  
  function deleteKeluarga($id)
  {
  
	//$count=0;
	
/* 	//langkah 1
	$this->db->select('id_penduduk');
	$this->db->where('id_keluarga',$id);
	$records = $this->db->get('tbl_hub_kel');
	foreach ($records->result() as $row)
	{	
		//hapus semua hub_kel
		$this->db->where('id_penduduk', $row->id_penduduk);
		$this->db->delete('tbl_hub_kel');
		
		//hapus semua penduduk
		//$data = $this->m_keluarga->getIdPendudukByIdKeluarga($id);
		$this->db->where('id_penduduk', $row->id_penduduk);
		$this->db->delete('tbl_penduduk');
		//$count++;
	} */
	
	//langkah 2 (gak usah pake perulangan, pasti terhapus semua)
	$this->db->where('id_keluarga', $id);    
    $this->db->delete($this->_table);
	
	
  }
  
  function getphotoKeluarga($id)
  {
	$nik = $this->getNIKByKK($id);
	$this->db->select('photo');
	$this->db->where('nik',$nik);
	
	$q = $this->db->get('data_penduduk');
	return $q->result();
  }
  
  function getKeluargaById($id)
  {	
    
		$this->db->select('
		tbl_keluarga.*,
		tbl_penduduk.nama,
		ref_rt.nomor_rt,
		ref_rw.nomor_rw,
		ref_dusun.nama_dusun
		')->from($this->_table);
		
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_keluarga.id_kepala_keluarga');	
		$this->db->join('ref_rt','ref_rt.id_rt = tbl_keluarga.id_rt');
		$this->db->join('ref_rw','ref_rw.id_rw = tbl_keluarga.id_rw');
		$this->db->join('ref_dusun','ref_dusun.id_dusun = tbl_keluarga.id_dusun');		
		$this->db->where('tbl_keluarga.id_keluarga', $id);
		$q = $this->db->get();
		return $q->row();
		//return $this->db->get_where($this->_table,array('id_keluarga' => $id))->row();
  }
  function getIdKepalaKeluargaByIdKeluarga($id)
	{
		$this->db->select('id_kepala_keluarga');
		$this->db->where('id_keluarga', $id);
		$q = $this->db->get('tbl_keluarga');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_kepala_keluarga'];
		if ($result == NULL)
		{
			return 'tidak ditemukan';
		}
		else
		{			
			return  $result;
		}
	}
   function getPendudukByIdKepalaKeluarga($id)
  {	
	$id_kepala_keluarga=$this->getIdKepalaKeluargaByIdKeluarga($id);
    return $this->db->get_where('tbl_penduduk',array('id_penduduk' => $id_kepala_keluarga))->row();
  }
  
  function getHubKelById($id)
  {	
    return $this->db->get_where('tbl_hub_kel',array('id_keluarga' => $id))->row();
  }
  
	function getNIKByKK($id)
	{	
		$this->db->select('nik');
		$this->db->where('kk', $id);
		$q = $this->db->get('tbl_keluarga');
		return $q->result();
	}
	
	function getIdKepalaKeluargaByNIK($id)
	{	
		$this->db->select('id_penduduk');
		$this->db->where('NIK', $id);
		$q = $this->db->get('tbl_penduduk');
		return $q->result();
	}
	
	function getIdKeluargaByNoKK($id)
	{	
		$this->db->select('id_keluarga');
		$this->db->where('no_kk', $id);
		$q = $this->db->get('tbl_keluarga');
		return $q->result();
	}
  
  function updateKeluarga($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }	
   function updatePenduduk($where, $data)
  {
    $this->db->where($where);
    $this->db->update('tbl_penduduk', $data);
    return $this->db->affected_rows();
  }	
   function updateHubKel($where, $data)
  {
    $this->db->where($where);
    $this->db->update('tbl_hub_kel', $data);
    return $this->db->affected_rows();
  }	
 	
	function get_kelas_sosial() 
	{    
		$this->db->where('id_kelas_sosial !=','0');	
      	$records = $this->db->get('ref_kelas_sosial');
		
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_kelas_sosial] = $row->deskripsi;
        }
        return ($data);
    }
	
	function get_dusun() 
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
	
	function get_rw() 
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
	function get_rt() 
	{      
		$this->db->where('id_rt !=','0');				
		$this->db->join('ref_rw','ref_rw.id_rw = ref_rt.id_rw');
      	$records = $this->db->get('ref_rt');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_rt] = $row->nomor_rt;
        }
        return ($data);
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
	
	function get_pekerjaan() 
	{      
		$this->db->where('id_pekerjaan !=','0');
      	$records = $this->db->get('ref_pekerjaan');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_pekerjaan] = $row->deskripsi;
        }
        return ($data);
    }
	
	function get_pendidikan() 
	{      
		$this->db->where('id_pendidikan !=','0');
      	$records = $this->db->get('ref_pendidikan');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_pendidikan] = $row->deskripsi;
        }
        return ($data);
    }
	
	function get_status_keluarga() 
	{      
		$this->db->where('id_status_keluarga !=','0');
		$this->db->where('id_status_keluarga !=','1');
      	$records = $this->db->get('ref_status_keluarga');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_status_keluarga] = $row->deskripsi;
        }
        return ($data);
    }
	//Get Referensi
	function get_agama()
	{	
		$this->db->where('id_agama !=','0');
		$records = $this->db->get('ref_agama');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_agama] = $row->deskripsi;
        }
        return ($data);
	}
	
	function get_goldar()
	{
		$this->db->where('id_goldar !=','0');
		$records = $this->db->get('ref_goldar');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_goldar] = $row->deskripsi;
        }
        return ($data);
	}
	
	function get_jen_kel()
	{
		$this->db->where('id_jen_kel !=','0');
		$records = $this->db->get('ref_jen_kel');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_jen_kel] = $row->deskripsi;
        }
        return ($data);
	}
	function get_kewarganegaraan()
	{
		$this->db->where('id_kewarganegaraan !=','0');
		$records = $this->db->get('ref_kewarganegaraan');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_kewarganegaraan] = $row->deskripsi;
        }
        return ($data);
	}
	
	function get_pekerjaan_ped()
	{
		$this->db->where('id_pekerjaan_ped !=','0');
		$records = $this->db->get('ref_pekerjaan_ped');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_pekerjaan_ped] = $row->deskripsi;
        }
        return ($data);
	}
	
	function get_kompetensi()
	{
		$records = $this->db->get('ref_kompetensi');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_kompetensi] = $row->deskripsi;
        }
        return ($data);
	}
	
	function get_status_kawin()
	{
		$this->db->where('id_status_kawin !=','0');
		$records = $this->db->get('ref_status_kawin');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_status_kawin] = $row->deskripsi;
        }
        return ($data);
	}
	function get_status_penduduk()
	{
		$this->db->where('id_status_penduduk !=','0');
		$records = $this->db->get('ref_status_penduduk');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_status_penduduk] = $row->deskripsi;
        }
        return ($data);
	}
	
	function get_status_tinggal()
	{
		$this->db->where('id_status_tinggal !=','0');
		$records = $this->db->get('ref_status_tinggal');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_status_tinggal] = $row->deskripsi;
        }
        return ($data);
	}
	
	function get_difabilitas()
	{
		$this->db->where('Id_difabilitas !=','0');
		$records = $this->db->get('ref_difabilitas');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_difabilitas] = $row->deskripsi;
        }
        return ($data);
	}
	function get_kontrasepsi()
	{
		$this->db->where('id_kontrasepsi !=','0');
		$records = $this->db->get('ref_kontrasepsi');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_kontrasepsi] = $row->deskripsi;
        }
        return ($data);
	}
	
  	function getIdPendudukByNik($nik)
	{
		$this->db->select('id_penduduk');
		$this->db->where('nik', $nik);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_penduduk'];	
		if($result == NULL)
		{	
			return 'data tidak ditemukan';
		}
		else return $result; 
	}
	
	function getAnggotaKeluargaByIdKeluarga($id)
	{
		$this->db->select(
		'tbl_penduduk.nama as nama , 
		tbl_keluarga.alamat_jalan , 
		tbl_penduduk.tempat_lahir, 
		tbl_penduduk.tanggal_lahir,
		ref_status_keluarga.deskripsi'
		)->from('tbl_keluarga');
		$this->db->join('tbl_hub_kel','tbl_hub_kel.id_keluarga = tbl_keluarga.id_keluarga ');
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk');
		$this->db->join('ref_status_keluarga','ref_status_keluarga.id_status_keluarga = tbl_hub_kel.id_status_keluarga');
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		
		$this->db->where('tbl_hub_kel.id_keluarga', $id);		
		$this->db->where('ref_status_penduduk.deskripsi !=', 'Meninggal');	
		$this->db->order_by('tbl_hub_kel.id_status_keluarga');	
		$q = $this->db->get();
		return $q->result();
	}
	
	function getNoKkExist($no_kk)
	{
		$this->db->select('id_keluarga');
		$this->db->where('no_kk', $no_kk);
		$q = $this->db->get('tbl_keluarga');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['id_keluarga'];	
		if($result == NULL)
		{	
			return FALSE;
		}
		else return TRUE;
	}
	
	function getNikExist($nik)
	{
		$this->db->select('nama');
		$this->db->where('nik', $nik);
		$q = $this->db->get('tbl_penduduk');
		//if id is unique we want just one row to be returned
		$data = array_shift($q->result_array());
		$result = $data['nama'];	
		if($result == NULL)
		{	
			return FALSE;
		}
		else return TRUE;
	}

}
?>