<?php
	function user_table_get(){
		$results = executeQuery("SELECT table_name
  						FROM user_tables
  					  ORDER BY table_name");
  		return $results;
	}

	function user_table_put(){
		$results = executeQuery("CREATE TABLE API_TEST_TABLE
			(
				sur_id VARCHAR2(20),
				CONSTRAINT pk_api_test_table PRIMARY KEY (sur_id);
			);
		");
		return $results;
	}

	function parse_table_name_results($result){
		return $result['TABLE_NAME'];
	}
?>
