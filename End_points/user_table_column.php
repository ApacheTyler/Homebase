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
		$query = "SELECT c.constraint_name, c.constraint_type, a.table_name, a.column_name,
	                            r.table_name as reference_table, a.column_name as reference_column, c.deferrable,
	                            c.DEFERRED, c.DELETE_RULE, c.search_condition, c.status
	                FROM user_cons_columns a
	                JOIN user_constraints c ON a.owner = c.owner
	                    AND a.constraint_name = c.constraint_name
	                LEFT OUTER JOIN (SELECT table_name, constraint_name FROM user_constraints) r
	                  ON r.constraint_name = c.r_constraint_name
									WHERE a.table_name = '$table_name'";
		return executeQuery($query);
	}

?>
