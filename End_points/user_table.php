<?php
magic_quotes_gpc = Off;

	function user_table_get(){
		$results = executeQuery("SELECT table_name
  						FROM user_tables
  					  ORDER BY table_name");
  		return $results;
	}

	function user_table_post($tableData){

		$dev = '{
		"name": "API_TEST_TABLE",
		"cols": [
								{
										"name": "col_1",
										"type": "VARCHAR2",
										"size": 20,
										"notNull": false,
										"unique" : true
								},
								{
										"name": "col_2",
										"type": "NUMBER",
										"size": 20,
										"notNull": true,
										"unique": false
								},
								{
										"name": "col_3",
										"type": "int",
										"size": null,
										"notNull": false,
										"unique": true
								}
					],
		"primaryKey": {
																"constraintName": "pk_table_1",
																"cols": [
																					"col_1",
																					"col_2"
																			]
								},
		"foreignKey":  [
																{
																		"constraintName": "fk_table_1_col_2",
																		"tableCol": "col_2",
																		"refTable": "test_table_3",
																		"refCol": "col_1",
																		"deferrable": false
																},
																{
																		"constraintName": "fk_table_1_col_3",
																		"tableCol": "col_3",
																		"refTable": "test_table_6",
																		"refCol": "col_1",
																		"deferrable": true
																}
									]
    }';

		$table_data = (json_decode($tableData, true));

		$table_columns_and_constraints = _create_columns($table_data['cols']) . _primary_keys($table_data['primaryKey']) . _foreign_keys($table_data['foreignKey']);
		$table_columns_and_constraints = rtrim($table_columns_and_constraints, ',');

		$create_statement = (_create_table($table_data['name']) . "(
			" . $table_columns_and_constraints . "
)");

		print_r($tableData);
		print_r($create_statement);

		$results = executeQuery($create_statement);
		return $results;
	}

	/**
	* Generates create table statement
	**/
	function _create_table($table_name){
		return "CREATE TABLE $table_name ";
	}

	/**
	* Generates columns
	**/
	function _create_columns($columns_array){
		$columns_statement = "";
		foreach($columns_array as $column){
			$columns_statement = $columns_statement . $column['name'] . " " . $column['type'];
			if($column['size']){
				$columns_statement = $columns_statement . "(" . $column['size'] .")";
			}
			$columns_statement = $columns_statement . " " . _not_null_constraint($column) . " " . _unique_constraint($column) . ",
			";
		}
		return $columns_statement;
	}

	function _primary_keys($primary_keys){
		$primary_key_statement = "";
		$keys = "";
		foreach($primary_keys['cols'] as $col){
			$keys = $keys . $col . ",";
		}
		$keys = rtrim($keys, ",");
		$primary_key_statement = "CONSTRAINT " . $primary_keys['constraintName'] . " PRIMARY KEY (" . $keys . "),
		";
		return $primary_key_statement;
	}

	function _foreign_keys($foreign_keys){
		$foreign_key_statement = "";
		foreach($foreign_keys as $key){
			$deferrable = "";
			if($key['deferrable']){
				$deferrable = "DEFERRABLE INITIALLY DEFERRED";
			}
			$foreign_key_statement = $foreign_key_statement . "CONSTRAINT " . $key['constraintName'] . " FOREIGN KEY (" . $key['tableCol'] . ") REFERENCES " . $key['refTable'] . "(" . $key['refCol'] . ") " . $deferrable . ",
			";
		}
		$foreign_key_statement = rtrim($foreign_key_statement, ",
		");
		return $foreign_key_statement;
	}

	function _not_null_constraint($column){
		if($column['notNull']){
			return "NOT NULL";
		}
		else{
			return "";
		}
	}

	function _unique_constraint($column){
		if($column['unique']){
			return "UNIQUE";
		}
		else{
			return "";
		}
	}

	function user_table_delete($tableData){
		$results = executeQuery("DROP TABLE $tableData");
		return $results;
	}

	function user_table_put($tableData){
		//TODO: Implement
	}

	function parse_table_name_results($result){
		return $result['TABLE_NAME'];
	}
?>
