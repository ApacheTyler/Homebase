<?php
  /**Insert function logic**/
  
  $res = array();//Response Global Variable
  
  function tyler_get(){
  	$res = array();
    $res['Name'] = 'Tyler';
    return json_encode($res);
  }
?>
