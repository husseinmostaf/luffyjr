<?php

// Anti-SQL Injection 
function check_inject() 
  { 
    $badchars = array(";","*","/","INSERT","DROP", "SELECT", "UPDATE", "DELETE", "WHERE", "TRUNCATE", "insert", "drop", "select", "update", "delete", "where", "truncate", "-1", "-2", "-3","-4", "-5", "-6", "-7", "-8", "-9",); 
   
    foreach($_POST as $value) 
    { 
      $value = clean_variable($value);

      if(in_array($value, $badchars)) 
      { 
        //die("SQL Injection Detected - Make sure only to use letters and numbers!\n<br />\nIP: ".$_SERVER['REMOTE_ADDR']); 
      } 
      else 
      { 
        $check = preg_split("//", $value, -1, PREG_SPLIT_OFFSET_CAPTURE); 
        foreach($check as $char) 
        { 
          if(in_array($char, $badchars)) 
          { 
            //die("SQL Injection Detected - Make sure only to use letters and numbers!\n<br />\nIP: ".$_SERVER['REMOTE_ADDR']); 
          } 
        } 
      } 
    } 
  } 
function clean_variable($var) 
{ 
$newvar = preg_replace('/[^a-zA-Z0-9\_\-]/', '', $var); 
return $newvar; 
}

?>