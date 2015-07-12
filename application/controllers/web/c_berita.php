<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class C_berita extends CI_Controller {

    public function  __construct()
    {
		parent::__construct();
		$this->load->model('m_berita');
		$this->load->model('m_logo');
		$this->load->helper('text');
		$this->load->library('pagination');
    }
	
	function index()
    {		
    		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['berita'] = $this->m_berita->get_recent_berita_all();
		
		//pagination
		$config['base_url'] =base_url().'/web/c_berita/index';
	        $config['total_rows'] = $this->m_berita->berita_all_numrows(); //$this->db->get('tbl_berita')->num_rows();
	        $config['per_page'] = '6';
	        $config['num_links'] = 3;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = '<ul class="pagination pagination-sm">'; 
		$config['full_tag_close'] = '</ul>'; 
		$config['num_tag_open'] = '<li>'; 
		$config['num_tag_close'] = '</li>'; 
		$config['cur_tag_open'] = '<li class="active"><span>'; 
		$config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>'; 
		$config['prev_tag_open'] = '<li>'; 
		$config['prev_tag_close'] = '</li>'; 
		$config['next_tag_open'] = '<li>'; 
		$config['next_tag_close'] = '</li>'; 
		$config['first_link'] = '&laquo;'; 
		$config['prev_link'] = '&lsaquo;'; 
		$config['last_link'] = '&raquo;'; 
		$config['next_link'] = '&rsaquo;'; 
		$config['first_tag_open'] = '<li>'; 
		$config['first_tag_close'] = '</li>'; 
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
	        $this->pagination->initialize($config);        
	        $pag = $this->db->get($this->m_berita->berita_all(), $config['per_page'], $this->uri->segment(4));  //$this->m_berita->berita_all( $config['per_page']); //      
	        //$pag = $this->m_berita->berita_all( 6,4); //      
	        $data['berita'] = $pag->result();
		
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$data['content'] = $this->load->view('web/berita',$data,TRUE);
		$temp['footer'] = $this->load->view('v_footer',$data,TRUE);
		$this->load->view('templateHome',$temp);
	}
	
	function get_detail_berita($id){
		$data['konten_logo'] = $this->m_logo->getLogo();
		/* $data['berita'] = $this->m_berita->getBeritaByIdberita($id);
		$data['menu'] = $this->load->view('web/menu/berita', $data, TRUE);		
		$temp['content'] = $this->load->view('web/detail_berita',$data,TRUE);
		$this->load->view('templateHome',$temp); */
		$data['berita'] = $this->m_berita->getBeritaByIdberita($id);
		$data['logo'] = $this->load->view('v_logo', $data, TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$data['content'] = $this->load->view('web/detail_berita',$data,TRUE);
		$temp['footer'] = $this->load->view('v_footer',$data,TRUE);
		$this->load->view('templateHome',$temp);
	}
}
?>