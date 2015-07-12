<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class C_kontak extends CI_Controller {

    public function  __construct()
    {
		parent::__construct();
		 //Load flexigrid helper and library
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->helper('form');
		$this->load->model('m_kontak');
		$this->load->helper('text');
		$this->load->helper('url');
    }
	
	 function index()    {
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			$this->lists();
		}else
			$this->load->view('v_login',true);
        	
    }
	
	function lists() {
        $colModel['id_kontak'] = array('ID',50,TRUE,'left',0);	
		$colModel['nama'] = array('Nama',150,TRUE,'left',2);
		$colModel['email'] = array('Email',150,TRUE,'left',2);
		$colModel['pesan'] = array('Pesan',150,TRUE,'center',2);
		$colModel['waktu'] = array('Waktu',150,TRUE,'center',2);
        $colModel['aksi'] = array('AKSI',60,FALSE,'center',0);
		
		//Populate flexigrid buttons..
        $buttons[] = array('Select All','check','btn');
		$buttons[] = array('separator');
        $buttons[] = array('DeSelect All','uncheck','btn');
        $buttons[] = array('separator');
        $buttons[] = array('Delete Selected Items','delete','btn');
        $buttons[] = array('separator');
       		
        $gridParams = array(
            'height' => 300,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => '',
            'showTableToggleBtn' => false
	);

        $grid_js = build_grid_js('flex1',site_url('c_kontak/load_data'),$colModel,'id_kontak','desc',$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

        $data['page_title'] = 'DATA KONTAK';		
		$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
        $data['content'] = $this->load->view('kontak/v_list', $data, TRUE);
        $this->load->view('utama', $data);
    }
	

    function load_data() {	
	
		$this->load->library('flexigrid');
        $valid_fields = array('id_kontak','nama','email','pesan');

		$this->flexigrid->validate_post('id_kontak','ASC',$valid_fields);
		$records = $this->m_kontak->get_kontak_flexigrid();
	
		$this->output->set_header($this->config->item('json_header'));
	
		$record_items = array();
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->id_kontak,
				$row->id_kontak,
				$row->nama,
				$row->email,
				$row->pesan,
				 date('d-m-Y G:i',strtotime($row->waktu)),
				'<button type="submit" class="btn btn-info btn-xs" title="Lihat Data Kontak" onclick="tampil_kontak(\''.$row->id_kontak.'\')"/><i class="fa fa-eye"></i></button>'
			);  
		}
		//Print please
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
    
	function tampil_kontak($id)
	{
		$session['hasil'] = $this->session->userdata('logged_in');
		$role = $session['hasil']->role;
		if($this->session->userdata('logged_in') AND $role == 'Administrator')
		{
			//Atribut Kontak
			$data['id_kontak'] = $id;
			$data['page_title'] = 'Tampil Data Kontak';
			$data['kontak'] = $this->m_kontak->getKontakById($id);
			$data['menu'] = $this->load->view('menu/v_admin', $data, TRUE);
			$data['content'] = $this->load->view('kontak/v_detil', $data, TRUE);
        
			$this->load->view('utama', $data);
		}else
			$this->load->view('v_login',true);
	}
	
	function simpan_kontak() {
	
		$nama = $this->input->post('nama', TRUE);
		$email = $this->input->post('email', TRUE);
		$pesan = $this->input->post('pesan', TRUE);		
		
		$realPerson = $this->input->post('aunt', TRUE);		
		$realPersonHash = $this->input->post('auntHash', TRUE);		
		
		$this->form_validation->set_rules('nama', 'Nama', 'required');				
		$this->form_validation->set_rules('pesan', 'Pesan', 'required');
		
		if ($this->form_validation->run() == TRUE)
		{		
			if ($this->rpHash($realPerson) == $realPersonHash) {
				$email2=$this->cekNull($email);
				$data = array(
					'nama' => $nama,
					'email' => $email2,
					'pesan' => $pesan					
				);

				$this->m_kontak->insertKontak($data);	
				echo true;
				//echo "bener";
				}
			else 
			{
				echo false;
					//echo "salah";
			}
        }
		else { redirect('web/c_home','refresh'); return false;}
    }
	
	function cekNull($parameter)
	{
		if($parameter==NULL)
		{return ' ';}
		else return $parameter;
	}
	
	function delete()    {
        $post = explode(",", $this->input->post('items'));
        array_pop($post); $sucess=0;
        foreach($post as $id){
            $this->m_kontak->deleteKontak($id);
            $sucess++;
        }
		if ($sucess > 0 ){
            //echo 'Success delete '.$sucess.' item(s).';
        }
		else{
            //echo 'No delete items';
        }
        redirect('c_kontak', 'refresh');
    }
	
 	function rpHash($value) { 
		$hash = 5381; 
		$value = strtoupper($value); 
		for($i = 0; $i < strlen($value); $i++) { 
			$hash = (($hash << 5) + $hash) + ord(substr($value, $i)); 
		} 
		return $hash; 
	}  
	
	/*******PHP 64 BIT/*******/
	/*
	function rpHash($value) { 
    $hash = 5381; 
    $value = strtoupper($value); 
    for($i = 0; $i < strlen($value); $i++) { 
        $hash = (leftShift32($hash, 5) + $hash) + ord(substr($value, $i)); 
    } 
    return $hash; 
	} 
 
	// Perform a 32bit left shift 
	function leftShift32($number, $steps) { 
		// convert to binary (string) 
		$binary = decbin($number); 
		// left-pad with 0's if necessary 
		$binary = str_pad($binary, 32, "0", STR_PAD_LEFT); 
		// left shift manually 
		$binary = $binary.str_repeat("0", $steps); 
		// get the last 32 bits 
		$binary = substr($binary, strlen($binary) - 32); 
		// if it's a positive number return it 
		// otherwise return the 2's complement 
		return ($binary{0} == "0" ? bindec($binary) : 
			-(pow(2, 31) - bindec(substr($binary, 1)))); 
	} */
	/*******END OF PHP 64 BIT/*******/
}
?>