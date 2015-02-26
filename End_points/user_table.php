<?php
	function user_table_get(){
		$results = executeQuery("SELECT table_name
  						FROM user_tables
  					  ORDER BY table_name");
  		return $results;
	}

	function user_table_post($tableData){
		$results = executeQuery("CREATE TABLE API_TEST_TABLE
			(
				sur_id VARCHAR2(20),
				CONSTRAINT pk_api_test_table PRIMARY KEY (sur_id)
			)
		");
		return $results;
	}

	function user_table_delete($tableData){
		$results = executeQuery("DROP TABLE API_TEST_TABLE");
		return $results
	}

	function user_table_put($tableData){
		//TODO: Implement
	}

	function parse_table_name_results($result){
		return $result['TABLE_NAME'];
	}
?>
