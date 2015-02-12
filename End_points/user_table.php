<?php
	function user_table_get(){
		$results = executeQuery("SELECT table_name
  						FROM user_tables
  					  ORDER BY table_name");
  		return $results;
	}
	
	function parse_table_name_results($result){
		return $result['TABLE_NAME'];
	}
?>