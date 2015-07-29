<?php
class M_anggaran extends CI_Model {

   function __construct()
  {
    parent::__construct();
    $this->_table='tbl_anggaran';
	
    //get instance
    $this->CI = get_instance();
  }
	public function get_flexigrid()
    {
        //Build contents query
        $this->db->select('*')->from($this->_table);
        $this->db->where('id_anggaran !=', 0);
        $this->CI->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id_anggaran) as record_count")->from($this->_table);
        $this->db->where('id_anggaran !=', 0);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;
    }
  function insert($data)
  {
    $this->db->insert($this->_table, $data);
  }
  
  function delete($id)
  {
    $this->db->where('id_anggaran', $id);
    $this->db->delete($this->_table);
  }
  
  function getById($id) //edit
  {	
    return $this->db->get_where($this->_table,array('id_anggaran' => $id))->row();
  }
  
  function update($where, $data) //update
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }

    function get_id_apbdes()
    {
        $this->db->where('id_apbdes !=','0');
        $records = $this->db->get('tbl_apbdes');

        $data=array();
        foreach ($records->result() as $row)
        {
            $data[''] = '--Pilih--';
            $data[$row->id_apbdes] = $row->nama;
        }
        return ($data);
    }

    function get_id_parent()
    {
        $this->db->where('id_parent >=','0');
        $records = $this->db->get('tbl_anggaran');

        $data=array();
        foreach ($records->result() as $row)
        {
            $data[''] = '--Pilih--';
            $data[$row->id_anggaran] = $row->nama;
        }
        return ($data);
    }
}
?>
