<?php
	function user_table_get(){
		$results = executeQuery("SELECT table_name
  						FROM user_tables
  					  ORDER BY table_name");
  		return $results;
	}

	function user_table_post($tableData){
		print_r(_create_table("API_TEST_TABLE") . "(
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
