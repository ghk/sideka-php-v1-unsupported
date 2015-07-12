<?php

/**
 * Highlight the specified search terms in the text.
 * 
 * Terms are highlighted by surrounding them with <span class="hl">...</span>
 * 
 * Note that only complete words are highlighted.
 *
 * @param string $text The text.
 * @param string $search_terms The search terms to be highlighted.
 * @param string $hl_class The CSS class to use for highlighting. Default is 'hl'.
 * @return string The text with terms highlighted.
 * @author Joe Freeman
 */
function search_highlight($text, $search_terms, $hl_class = 'hl')
{
	if ( ! is_array($search_terms))
	{
		$search_terms = explode(' ', $search_terms);
	}
	
	// Highlight each of the terms
	foreach ($search_terms as $term)
	{
		$text = preg_replace('/\b(' . preg_quote($term) . ')\b/i', '<span style="background-color:#ff0;font-size:100%" class="' . $hl_class . '">\1</span>', $text);
	}
	
	return $text;
}

/**
 * Generate an extract based on the content being searched and the search
 * terms. An extract is based on a number of snippets, joined together by
 * ellipses. By default, we will attempt to generate three snippets, each with
 * length sixty characters.
 * 
 * The returned extract will have the terms highlighted.
 * 
 * Note that this code is very inefficient, and just serves as a quick demo of
 * the possibilities.
 *
 * @param string $content The content that has been searched.
 * @param string $search_terms The search terms.
 * @param integer $number_of_snippets The number of snippets to make up the extract.
 * @param integer $snippet_length The length of each snippet.
 * @return string The extract.
 * @author Joe Freeman
 */
function search_extract($content, $search_terms, $number_of_snippets = 3, $snippet_length = 60)
{
	if ( ! is_array($search_terms))
	{
		$search_terms = explode(' ', $search_terms);
	}
	
	// This is going to be our collection of snippets
	$snippets = array();
	
	// Start at the beginning of the string
	$next_start = 0;
	
	// Do this for each snippet
	foreach (range(0, $number_of_snippets) as $count)
	{
		// If we run out of content, then just give up
		if ($next_start > strlen($content))
		{
			break;
		}
		
		// Find the first occurance of any of the search terms
		$start = strlen($content);
		foreach ($search_terms as $term)
		{
			$start = min($start, stripos($content, $term, $next_start));
		}
		
		// Try and include the word before this one
		$start = strrpos(substr($content, 0, $start-1), ' ');
		
		// Next time round, we'll start looking at the end of this snippet
		$next_start = $start + $snippet_length;
		
		// At the snippet to the extract and highlight the terms
		$extract[$count] = search_highlight(trim(substr($content, $start, $snippet_length)), $search_terms);
	}
	
	// Stick all of the snippets together to make up the extract
	return implode(' &hellip; ', $extract) . '&hellip;';
}

/* End of file search_helper.php */
/* Location: ./system/application/helpers/search_helper.php */