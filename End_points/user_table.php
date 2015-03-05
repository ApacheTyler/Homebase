<?php
	function user_table_get(){
		$results = executeQuery("SELECT table_name
  						FROM user_tables
  					  ORDER BY table_name");
  		return $results;
	}

	function user_table_post($tableData){

		$dev = '{
		"name": "API_TEST_TABLE",
		"deferrable": "true",
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
																					"col1",
																					"col2"
																			]
								},
		"foreignKey":  [
																{
																		"constraintName": "fk_table_1_col_2",
																		"tableCol": "col_2",
																		"refTable": "table_3",
																		"refCol": "ref_col_1"
																},
																{
																		"constraintName": "fk_table_1_col_3",
																		"tableCol": "col_3",
																		"refTable": "table_6",
																		"refCol": "ref_col_99"
																}
									]
    }';

		$table_data = (json_decode($dev, true));

		$table_columns_and_constraints = _create_columns($table_data['cols']) . _primary_keys($table_data['primaryKey']);
		$table_columns_and_constraints = rtrim($table_columns_and_constraints, ',');

		$create_statement = (_create_table($table_data['name']) . "(
			" . $table_columns_and_constraints . "
)");

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
		$primary_key_statement = "CONSTRAINT " . $primary_keys['constraintName'] . " PRIMARY KEY (" . $keys . ")";
		return $primary_key_statement;
	}

	function _foreign_keys($foreign_keys){
		$foreign_key_statement = "";
		foreach($foreign_keys as $key){

		}
		return $foreign_keys;
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
