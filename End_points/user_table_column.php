<?php	
	function user_table_column_get($req){
		$table_name = (is_array($req)) ? $req['table-name'] : $req;
		$results = executeQuery("SELECT column_name
  						FROM user_tab_cols
  					  WHERE table_name = '$table_name'");
  		return $results;
	}
	
	function parse_column_name_results($result){
		return $result['COLUMN_NAME'];
	}
?>