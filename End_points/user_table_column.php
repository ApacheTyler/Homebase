<?php
	function user_table_column_get($req){
		$table_name = (is_array($req)) ? $req['table-name'] : $req;
		$results = executeQuery("SELECT column_name, data_type, data_length, data_precision, data_scale
  						FROM user_tab_cols
  					  WHERE table_name = '$table_name'");
  	return $results;
	}

	function user_table_column_put($req){

	}

	function User_table_column_delete($req){

	}

?>
