<?php

	function user_schema_get(){
		$table_array = user_table_get();
	}

	function user_schema_get_table_primary_key($table_name){
		$results = executeQuery("SELECT cols.table_name, cols.column_name, cols.position, cons.status, cons.owner
				FROM all_constraints cons, all_cons_columns cols
					WHERE cols.table_name = '$table_name'
						AND cons.constraint_type = 'P'
						AND cons.constraint_name = cols.constraint_name
						AND cons.owner = cols.owner
				ORDER BY cols.table_name, cols.position");
		return $results;
	}

?>
