<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
 
function to_excel($query, $filename='xlsoutput') 
{ 
     $headers = ''; // variable untuk menampung header 
     $data = ''; // variable untuk menampung data 
 
     //$obj =& get_instance(); 
 
     $fields = $query->field_data(); 
     if ($query->num_rows() == 0) { 
          echo 'The table appears to have no data.'; 
     } else { 
          foreach ($fields as $field) { 
             $headers .= $field->name . "\t"; 
          } 
 
          foreach ($query->result() as $row) { 
               $line = ''; 
               foreach($row as $value) { 
                    if ((!isset($value)) OR ($value == "")) { 
                         $value = "\t"; 
                    } else { 
                         $value = str_replace('"', '""', $value); 
                         $value = '"' . $value . '"' . "\t"; 
                    } 
                    $line .= $value; 
               } 
               $data .= trim($line)."\n"; 
          } 
 
          $data = str_replace("\r","",$data); 
 
          header("Content-type: application/x-msdownload"); 
          header("Content-Disposition: attachment; filename=$filename.xls"); 
          echo "$headers\n$data"; 
     } 
} 
 
function array_to_excel($array, $filename='xlsoutput') 
{ 
     $headers = ''; // variable untuk menampung header 
     $data = ''; // variable untuk menampung data 
 
     //$obj =& get_instance(); 
 
     //$fields = $query->field_data(); 
     if (sizeof($array) == 0) { 
          echo 'The table appears to have no data.'; 
     } else { 
          foreach ($array as $row) { 
               $line = ''; 
               foreach($row as $value) { 
                    if ((!isset($value)) OR ($value == "")) { 
                         $value = "\t"; 
                    } else { 
                         $value = str_replace('"', '""', $value); 
                         $value = '"' . $value . '"' . "\t"; 
                    } 
                    $line .= $value; 
               } 
               $data .= trim($line)."\n"; 
          } 
 
          $data = str_replace("\r","",$data); 
 
 
        header('Content-type: application/ms-excel'); 
        header("Content-Disposition: attachment; filename=$filename.xls"); 
        echo $data; 
     } 
}

?>