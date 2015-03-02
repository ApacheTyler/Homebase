<?php

/**
* Needs to be converted to OO paradigm.
* Functions starting with user_schema are public methods
* Functions starting with _ are private methods.
**/

	function user_schema_get(){
		$table_array = user_table_get();
	}

	function user_schema_get_table_primary_key($table_name){
		$results = executeQuery("SELECT cols.table_name, cols.column_name, cols.position, cons.status, cons.owner
				FROM all_constraints cons, user_cons_columns cols
					WHERE cols.table_name = '$table_name'
						AND cons.constraint_type = 'P'
						AND cons.constraint_name = cols.constraint_name
						AND cons.owner = cols.owner
				ORDER BY cols.table_name, cols.position");
		return _parse_primary_key_column_names($results);
	}

	function _parse_primary_key_column_names($results){
		$primary_keys = array();
		foreach($results as $result){
			$primary_keys[] = $result['COLUMN_NAME'];
		}
		return $primary_keys;
	}

	function user_schema_get_table_foreign_key($table_name){
		$results = executeQuery("SELECT c.constraint_name, a.table_name, a.column_name, uc.table_name as reference_table, uc.column_name as reference_column, c.deferrable, c.DEFERRED, c.DELETE_RULE
                FROM all_cons_columns a
                JOIN all_constraints c ON a.owner = c.owner
                    AND a.constraint_name = c.constraint_name
                JOIN all_constraints c_pk ON c.r_owner = c_pk.owner
                       AND c.r_constraint_name = c_pk.constraint_name
                JOIN user_cons_columns uc on uc.constraint_name = c.r_constraint_name
								WHERE a.table_name = '$table_name'");
		return $results;
	}

	function user_schema_get_table_triggers($table_name){
		$results = executeQuery("SELECT trigger_name, trigger_type, triggering_event, status, trigger_body
			 															FROM user_triggers
															WHERE table_name = '$table_name'");
	}



?>
