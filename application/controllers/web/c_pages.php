<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class C_pages extends CI_Controller {
	public function  __construct()
    {
		parent::__construct();
		$this->load->helper('text');
		$this->load->helper('url');
		$this->load->model('m_logo');
		
    }
	
	function search($search_terms = '', $start = 0)
	{
		// If the form has been submitted, rewrite the URL so that the search
		// terms can be passed as a parameter to the action. Note that there
		// are some issues with certain characters here.
		if ($this->input->post('keyword'))
		{
			redirect('web/c_pages/search/' . $this->input->post('keyword'));
		}
		
		if ($search_terms)
		{
			// Determine the number of results to display per page
			$results_per_page = $this->config->item('results_per_page');
			
			// Load the model, perform the search and establish the total
			// number of results
			$this->load->model('page_model');
			$results = $this->page_model->search(urldecode($search_terms), $start, $results_per_page);
			$total_results = $this->page_model->count_search_results(urldecode($search_terms));
			
			// Call a method to setup pagination
			$this->_setup_pagination('web/c_pages/search/' . $search_terms . '/', $total_results, $results_per_page);
		}
		
		// Render the view, passing it the necessary data
		$data['base_url']=$this->config->item('base_url');
		$data['konten_logo'] = $this->m_logo->getLogo();
		$data['logo'] = $this->load->view('v_logo', $data,TRUE);
		$data['menu'] = $this->load->view('v_navbar', $data, TRUE);
		$array['search_terms'] = $search_terms;
		$array['total_results'] = @$total_results;
		$array['results'] = @$results;	
		$data['key'] = $array;
		$data['content']=$this->load->view('search_results',$data,TRUE);
		$temp['footer'] = $this->load->view('v_footer',$data,TRUE);
		$this->load->view('templateHome',$temp);
	}
	
	/**
	 * Setup the pagination library.
	 *
	 * @param string $url The base url to use.
	 * @param string $total_results The total number of results.
	 * @param string $results_per_page The number of results per page.
	 * @return void
	 * @author Joe Freeman
	 */
	function _setup_pagination($url, $total_results, $results_per_page)
	{
		// Ensure the pagination library is loaded
		$this->load->library('pagination');
		
		// This is messy. I'm not sure why the pagination class can't work
		// this out itself...
		//$uri_segment = count(explode('/', $url));
		
		//pagination
		$config['base_url'] =site_url($url);
		$config['enable_query_strings'] = TRUE; 
        $config['total_rows'] = $total_results;
        $config['per_page'] = '3';
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
		// Initialise the pagination class, passing in some minimum parameters
		/*$this->pagination->initialize(array(
			'base_url' => site_url($url),
			'uri_segment' => 4,
			'total_rows' => $total_results,
			'per_page' => $results_per_page
		));*/
	}
}

/* End of file pages.php */
/* Location: ./system/application/controllers/pages.php */