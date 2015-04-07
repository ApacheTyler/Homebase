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

	function user_table_column_get_constraints_by_column_name($table_name){
		$query = "SELECT cols.table_name, cols.column_name, cols.position, cons.status, cons.owner, cons.constraint_type, cons.constraint_name
			FROM user_constraints cons, user_cons_columns cols
			WHERE cols.table_name = '$table_name'
			AND cons.constraint_name = cols.constraint_name
			AND cons.owner = cols.owner
			ORDER BY cols.table_name, cols.position";
		return executeQuery($query);
	}

?>
