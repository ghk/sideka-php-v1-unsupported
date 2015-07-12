<?php
class M_demografi extends CI_Model {

  function __construct(){
		parent::__construct();
		$this->_table='tbl_demografi';
		$this->load->library('subquery');
	
		//get instance
		$this->CI = get_instance();
	}
	public function get_demografi_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_demografi) as record_count")->from($this->_table);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
	
	function insertDemografi($data){
		$this->db->insert($this->_table, $data);
	}
	
	function updateDemografi($where, $data)
	{
		$this->db->where($where);
		$this->db->update($this->_table, $data);
		return $this->db->affected_rows();
	}
	
	function deleteDemografi($id){
		$this->db->where('waktu', $id);
		$this->db->delete($this->_table);
	}
	
	function getDemografiByIddemografi($id)
	{	
		return $this->db->get_where($this->_table,array('id_demografi' => $id))->row();
	}
	
	public function get_demografi(){
		$this->db->order_by("waktu", "desc");
		return $this->db->get('tbl_demografi')->result();
	}
	
	function getKependudukan()
	{
		$this->db->select('ref_dusun.nama_dusun as jenis,count(tbl_penduduk.id_dusun) as jumlah');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','1');
		$sub->where('tbl_penduduk.id_dusun = ref_dusun.id_dusun');
		$this->subquery->end_subquery('laki');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_penduduk');
		$sub->where('id_jen_kel','2');
		$sub->where('tbl_penduduk.id_dusun = ref_dusun.id_dusun');
		$this->subquery->end_subquery('perempuan');
		
		$this->db->from('tbl_penduduk');
		$this->db->join('ref_dusun','ref_dusun.id_dusun = tbl_penduduk.id_dusun','right');
		$this->db->where('ref_dusun.id_dusun !=','0');
		$this->db->group_by("ref_dusun.nama_dusun");
		$query = $this->db->get();
		return $query->result();
	}	
	
	function getKeluarga()
	{
		$this->db->select('ref_dusun.nama_dusun as jenis,count(tbl_keluarga.id_dusun) as jumlah');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_keluarga');		
		$sub->where('tbl_penduduk.id_jen_kel','1');
		$sub->where('tbl_keluarga.id_dusun = ref_dusun.id_dusun');
		$sub->join('tbl_penduduk','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk');
		$sub->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		$sub->where('ref_status_penduduk.deskripsi <>','Meninggal');
		$this->subquery->end_subquery('laki');
		
		$sub = $this->subquery->start_subquery('select');
		$sub->select ('count(*)')->from('tbl_keluarga');
		$sub->where('tbl_penduduk.id_jen_kel','2');
		$sub->where('tbl_keluarga.id_dusun = ref_dusun.id_dusun');
		$sub->join('tbl_penduduk','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk');
		$sub->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		$sub->where('ref_status_penduduk.deskripsi <>','Meninggal');
		$this->subquery->end_subquery('perempuan');
		
		$this->db->from('tbl_keluarga');		
		$this->db->join('tbl_penduduk','tbl_keluarga.id_kepala_keluarga = tbl_penduduk.id_penduduk');
		$this->db->join('ref_dusun','ref_dusun.id_dusun = tbl_keluarga.id_dusun','right');
		$this->db->where('ref_dusun.id_dusun !=','0');
		$this->db->group_by("ref_dusun.nama_dusun");
		$this->db->join('ref_status_penduduk','tbl_penduduk.id_status_penduduk = ref_status_penduduk.id_status_penduduk');
		$this->db->where('ref_status_penduduk.deskripsi <>','Meninggal');
		$query = $this->db->get();
		return $query->result();
	}
	
}
?>