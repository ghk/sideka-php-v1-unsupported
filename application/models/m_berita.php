<?php
class M_berita extends CI_Model {

  function __construct(){
		parent::__construct();
		$this->_table='tbl_berita';
	
		//get instance
		$this->CI = get_instance();
	}
	public function get_berita_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_berita) as record_count")->from($this->_table);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
	function insertBerita($data){
		$this->db->insert($this->_table, $data);
	}
	
	function deleteBerita($id){
		$this->db->where('id_berita', $id);	
		$this->db->delete($this->_table);
	}
	  
	function updateBerita($where, $data){
		$this->db->where($where);
		$this->db->update($this->_table, $data);
		return $this->db->affected_rows();
	}
  
    function getBeritaByIdberita($id)
	{	
		 $this->db->select('tbl_berita.*,tbl_pengguna.nama_pengguna as nama_pengguna')->from($this->_table);
		 $this->db->join('tbl_pengguna','tbl_berita.id_pengguna = tbl_pengguna.id_pengguna ');
		 $this->db->where('tbl_berita.id_berita', $id);
		 return  $this->db->get()->row();
		//return $this->db->get_where($this->_table,array('id_berita' => $id))->row();
	}
 
	public function get_recent_berita(){
		$this->db->order_by("waktu", "desc");
		return $this->db->get('tbl_berita',4,0)->result();
	}
	
	public function get_recent_berita_all(){
		 $this->db->select('tbl_berita.*,tbl_pengguna.nama_pengguna as nama_pengguna')->from($this->_table);
		 $this->db->join('tbl_pengguna','tbl_berita.id_pengguna = tbl_pengguna.id_pengguna ');
		$this->db->order_by("waktu", "desc");
		return $this->db->get()->result();
	}
	
	public function berita_all(){
		 $this->db->select('tbl_berita.id_berita, 
		 tbl_berita.gambar, 
		 tbl_berita.judul_berita, 
		 tbl_berita.isi_berita, 
		 tbl_berita.waktu, 
		 tbl_pengguna.nama_pengguna as nama_pengguna')->from($this->_table);
		 $this->db->join('tbl_pengguna','tbl_berita.id_pengguna = tbl_pengguna.id_pengguna ');
		 $this->db->order_by('tbl_berita.waktu','desc');
		
	}
	
	public function berita_all_numrows(){
		 $this->db->select('tbl_berita.id_pengguna, 
		 tbl_berita.gambar, 
		 tbl_berita.judul_berita, 
		 tbl_berita.isi_berita, 
		 tbl_berita.waktu, 
		 tbl_pengguna.nama_pengguna as nama_pengguna')->from($this->_table);
		 $this->db->join('tbl_pengguna','tbl_berita.id_pengguna = tbl_pengguna.id_pengguna ');
		 $this->db->order_by('tbl_berita.waktu','desc');
		return $this->db->get()->num_rows();
	}
}
?>