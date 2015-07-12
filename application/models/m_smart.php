<?php
class M_smart extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->_table='tbl_penduduk';
	$this->load->database();
    //get instance
    $this->CI = get_instance();
  }
	public function get_smart_flexigrid($arrayUtuh, $countUtuh)
    {
		
		$count0 = 0; //nama kolom
		$count1 = 1; //operand
		$count2 = 2; //operator
		$countArr = 0;
		$sqlstr = "select tbl_penduduk.*,tbl_keluarga.no_kk,tbl_keluarga.is_raskin,
		tbl_keluarga.is_jamkesmas,tbl_keluarga.is_pkh ,ref_dusun.nama_dusun as nama_dusun, ref_rw.nomor_rw as nomor_rw, ref_rt.nomor_rt as nomor_rt from tbl_penduduk 
		JOIN tbl_hub_kel ON tbl_penduduk.id_penduduk = tbl_hub_kel.id_penduduk 
		JOIN tbl_keluarga ON tbl_hub_kel.id_keluarga = tbl_keluarga.id_keluarga 
		JOIN ref_dusun ON tbl_penduduk.id_dusun = ref_dusun.id_dusun
		JOIN ref_rw ON tbl_penduduk.id_rw = ref_rw.id_rw 
		JOIN ref_rt ON tbl_penduduk.id_rt = ref_rt.id_rt WHERE ";		
		foreach($arrayUtuh as $row)
		{
			if($countUtuh == 0)
			{
				$sqlstr = $sqlstr . "$row[$count0] = '$row[$count1]'";				
				break;
			}
			else
			{
				if($row[$count2]== 'OR')
				{
					if($countArr == $countUtuh)
					{
						$sqlstr = $sqlstr . "$row[$count0] = '$row[$count1]'";
					}
					else
					{
						$sqlstr = $sqlstr . " $row[$count0] = '$row[$count1]' OR ";
					}				
				}
				else if ($row[$count2]== 'AND')
				{
					if($countArr == $countUtuh)
					{
						$sqlstr = $sqlstr . "$row[$count0] = '$row[$count1]'";
					}
					else
					{
						$sqlstr = $sqlstr . "$row[$count0] = '$row[$count1]' AND ";
					}
				}
				$countArr++;
			}
		}   
		
		
		$query = $this->db->query($sqlstr);
		
		return $query->result();
    }
 
	
	//Get Referensi
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
		$this->db->where('id_difabilitas !=','0');
		$records = $this->db->get('ref_difabilitas');
   		$data=array();
        foreach ($records->result() as $row)
        {	
			$data[''] = '--Pilih--';
        	$data[$row->id_difabilitas] = $row->deskripsi;
        }
        return ($data);
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
}
?>