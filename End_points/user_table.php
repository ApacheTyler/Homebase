<?php
	function user_table_get(){
		$results = executeQuery("SELECT table_name
  						FROM user_tables
  					  ORDER BY table_name");
  		return $results;
	}

	function user_table_post($tableData){

		$dev = '{
		"name": "table_1",
		"deferrable": "true",
		"cols": [
								{
										"name": "col_1",
										"type": "VARCHAR2",
										"size": 20,
										"notNull": false
								},
								{
										"name": "col_2",
										"type": "NUMBER",
										"size": 20,
										"notNull": true
								},
								{
										"name": "col_1",
										"type": "int",
										"size": null,
										"notNull": false
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
																		"constrainName": "fk_table_1_col_2",
																		"tableCol": "col_2",
																		"refTable": "table_3",
																		"refCol": "ref_col_1"
																},
																{
																		"constrainName": "fk_table_1_col_3",
																		"tableCol": "col_3",
																		"refTable": "table_6",
																		"refCol": "ref_col_99"
																}
									]
    }';

		//print_r(json_decode($dev, true));

		print_r(_create_table($dev['name']) . "(
			" . "
)");

		$results = executeQuery("CREATE TABLE API_TEST_TABLE
			(
				sur_id VARCHAR2(20),
				CONSTRAINT pk_api_test_table PRIMARY KEY (sur_id)
			)
		");
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

		}
		return $columns_statement;
	}

	function _primary_keys($primary_keys){
		$primary_key_statement = "";
		foreach($primary_key as $key){

		}
		return $primary_key_statement;
	}

	function _foreign_keys($foreign_keys){
		$foreign_key_statement = "";
		foreach($foreign_keys as $key){

		}
		return $foreign_keys;
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
