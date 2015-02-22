<?php
	/**
	 * Use this page to confirm a successful connection to the database
	 */
	 ini_set('display_errors',true);
	 ini_set('display_startup_errors',true);
	 ini_set('date.timezone','America/New_York');
	 error_reporting (E_ALL|E_STRICT);

	function getRequestType($array_key){
		if(array_key_exists($_GET, $array_key)){
			return $_GET
		}
		else if(array_key_exists($_POST, $array_key)){
			return $_POST
		}
		else{
			return new array();
		}
	}

	function openDatabaseConnection(){
		$request = getRequestType('user-name');
		if(array_key_exists($_GET['user-name'])){
			$user_name = $_GET['user-name'];
			$password = $_GET['password'];
			$connectionString = $_GET['connection-string'];
		}

		$conn = oci_connect($user_name, $password, $connectionString);
		return $conn;
	}

	/**
	* Default function to be passed into $parserFunction if no function or lambda
	* is specified. Function simply returns argument which was passed into it
	**/
	function defaultFunction($defaultParam){
		return $defaultParam;
	}

	/**
	 * Function takes in an sql statement and returns data as an array. When calling, always alias
	 * resuts returned from stored function as 'dataArray'
	 */
	function executeQuery($SQLstatement, $parserFunction = "defaultFunction"){

		$conn = openDatabaseConnection();

		$preparedStatement = oci_parse($conn, $SQLstatement);//Prepare statement

		oci_execute($preparedStatement);//execute preparedStatement

		$arrayOfDataReturned = array();//Array containing all data returned from result set
		$currentRecord;//temp user for each result set

		while($functionResults = oci_fetch_array($preparedStatement, OCI_ASSOC))
		{//Get first class in result set
		/**Calls variable function; SEE: http://www.php.net/manual/en/functions.variable-functions.php**/
		$currentRecord = $parserFunction($functionResults);//Convert information array to class
		array_push($arrayOfDataReturned,$currentRecord);//push created object into all classes array
		//echo($allStudentClasses[0]->term + "<br />");
		}

		oci_free_statement($preparedStatement);

		oci_close($conn);
		return $arrayOfDataReturned;

	}



?>