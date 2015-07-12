<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
if ( ! class_exists('fpdf')){
    require_once(BASEPATH.'libraries/fpdf'.EXT);
}

$obj =& get_instance();
$obj->fpdf = new fpdf();
$obj->ci_is_loaded[] = 'fpdf';
?>