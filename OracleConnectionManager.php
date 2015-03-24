<?php
	/**
	 * Use this page to confirm a successful connection to the database
	 */
	//  ini_set('display_errors',true);
	//  ini_set('display_startup_errors',true);
	//  ini_set('date.timezone','America/New_York');
	//  error_reporting (E_ALL|E_STRICT);

	/**
	*  Accept GET and POST requests
	**/
	function getRequestType(){
		$emptyArray = array();
		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			return $_GET;
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST'){
			return $_POST;
		}
		else if($_SERVER['REQUEST_METHOD'] == 'PUT'){
			parse_str(file_get_contents("php://input"),$put_vars);
			return $put_vars;
		}
		else{
			return $emptyArray;
		}
	}

	/**
	* Create a oracle connection and return it
	**/
	function openDatabaseConnection(){
		$request = getRequestType('user-name');

		$user_name = (array_key_exists('user-name', $request)) ? $request['user-name'] : "";
		$password =  (array_key_exists('password', $request)) ? $request['password'] : "";
		$connectionString = (array_key_exists('connection-string', $request)) ? $request['connection-string'] : "";

		$conn = oci_connect($user_name, $password, $connectionString);
		if(!$conn){
			return array('error' => oci_error($conn));
		}
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

		$conn = $GLOBALS['oracle_connection'];
		if(array_key_exists('error', $conn)){
			return $conn;
		}

		$preparedStatement = oci_parse($conn, $SQLstatement);//Prepare statement

		$success = oci_execute($preparedStatement);//execute preparedStatement

		if(!$success){
			return array('error' => oci_error($preparedStatement));
		}

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

		return $arrayOfDataReturned;

	}



?>
