<?php

class Page_model extends CI_Model
{
	function Page_model()
	{
		parent::__construct();
 
		// Make the database available to all the methods
		$this->load->database();
	}
	
	/**
	 * Perform a FULLTEXT search on the page content for the specified search
	 * terms.
	 * 
	 * This method supports pagination. To enable pagination,
	 * $results_per_page must be set.
	 *
	 * @param string $terms The search terms.
	 * @param integer $start The record to start at (default is 0). Only applicable if $results_per_page is also set.
	 * @param integer $results_per_page The maximum number of results to return at once.
	 * @return array The search results.
	 * @author Joe Freeman
	 */
	function search($terms, $start = 0, $results_per_page = 0)
	{
		// Determine whether we need to limit the results
		if ($results_per_page > 0)
		{
			$limit = "LIMIT $start, $results_per_page";
		}
		else
		{
			$limit = '';
		}
		
		// Execute our SQL statement and return the result
		$this->db->select('*');
		$this->db->from('tbl_pages');
		$this->db->like('content',$terms);
		$this->db->or_like('title',$terms);
		$query=$this->db->get(); 
		return $query->result();
	}
	
	/**
	 * Determine the total number of results that will be returned by a seach
	 * on the specified search terms.
	 *
	 * @param string $terms The search terms.
	 * @return integer Total number of search results.
	 * @author Joe Freeman
	 */
	function count_search_results($terms)
	{
		// Run SQL to count the total number of search results
		$this->db->select('*');
		$this->db->from('tbl_pages');
		$this->db->like('content',$terms);
		$this->db->or_like('title',$terms);
		return $this->db->count_all_results();
	}
}

/* End of file page_model.php */
/* Location: ./system/application/models/page_model.php */