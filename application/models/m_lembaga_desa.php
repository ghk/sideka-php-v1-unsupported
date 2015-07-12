<?php
class M_lembaga_desa extends CI_Model {

  function __construct(){
		parent::__construct();
		$this->_table='tbl_lembaga_desa';
	
		//get instance
		$this->CI = get_instance();
	}
	public function get_lembaga_desa_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_lembaga_desa) as record_count")->from($this->_table);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
	
	function insertLembaga_desa($data){
		$this->db->insert($this->_table, $data);
	}
	
	function updateLembaga_desa($where, $data)
	{
		$this->db->where($where);
		$this->db->update($this->_table, $data);
		return $this->db->affected_rows();
	}
	
	function deleteLembaga_desa($id){
		$this->db->where('tbl_lembaga_desa', $id);
		$this->db->delete($this->_table);
	}
	
	function getLembaga_desaByIdlembaga($id)
	{	
		return $this->db->get_where($this->_table,array('id_lembaga_desa' => $id))->row();
	}
	
	public function get_lembaga_desa(){
		$this->db->order_by("waktu", "desc");
		return $this->db->get('tbl_lembaga_desa')->result();
	}
	
	
	/* function getKepalaDesa()
	{
		$this->db->select('tbl_perangkat.nip,tbl_penduduk.nama,tbl_penduduk.foto, ref_jabatan.deskripsi');
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_perangkat.id_penduduk');
		$this->db->join('ref_jabatan','ref_jabatan.id_jabatan = tbl_perangkat.id_jabatan');
		$this->db->where('ref_jabatan.deskripsi', 'Kepala Desa');
		$q = $this->db->get('tbl_perangkat');
		return $q->row();
		
	} */
	
	function getPerangkatDesa()
	{
		$this->db->select('tbl_perangkat.nip,tbl_penduduk.nama,tbl_penduduk.foto, ref_jabatan.deskripsi');
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = tbl_perangkat.id_penduduk');
		$this->db->join('ref_jabatan','ref_jabatan.id_jabatan = tbl_perangkat.id_jabatan');
		$this->db->where('tbl_perangkat.is_aktif', 'Y');
		$this->db->order_by('tbl_perangkat.id_perangkat');
		$q = $this->db->get('tbl_perangkat');
		return $q->result();
	}
	
		function getKepalaDusun()
	{
		$this->db->select('tbl_penduduk.nik,tbl_penduduk.nama,tbl_penduduk.foto,ref_dusun.nama_dusun');
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = ref_dusun.id_penduduk');
		$q = $this->db->get('ref_dusun');
		return $q->result();
	}
	
	function getKetuaRW()
	{
		$this->db->select('tbl_penduduk.nik,tbl_penduduk.nama,tbl_penduduk.foto,ref_rw.nomor_rw,ref_dusun.nama_dusun');
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = ref_rw.id_penduduk');
		$this->db->join('ref_dusun','ref_dusun.id_dusun = ref_rw.id_dusun');
		$this->db->order_by("ref_rw.nomor_rw", "asc");
		$q = $this->db->get('ref_rw');
		return $q->result();
	}
	
		function getKetuaRT()
	{
		$this->db->select('tbl_penduduk.nik,tbl_penduduk.nama,tbl_penduduk.foto,ref_rt.nomor_rt,ref_dusun.nama_dusun');
		$this->db->join('tbl_penduduk','tbl_penduduk.id_penduduk = ref_rt.id_penduduk');
		$this->db->join('ref_rw','ref_rw.id_rw = ref_rt.id_rw');
		$this->db->join('ref_dusun','ref_dusun.id_dusun = ref_rw.id_dusun');
		$this->db->order_by("ref_rt.nomor_rt", "asc");
		$q = $this->db->get('ref_rt');
		return $q->result();
	}
}
?>