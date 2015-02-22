<?php

require_once 'Restful_Api_Abstract.php';
require 'OracleConnectionManager.php';
require 'End_points/user_table.php';
require 'End_points/user_table_column.php';
class HomebaseApi extends RestfulAPI_Abs
{
  //  protected $User;


    // Abstracted out for example
    ////$APIKey = new Models\APIKey();
    ////$User = new Models\User();

    public function __construct($request, $origin) {
        parent::__construct($request);

        // if (!array_key_exists('apiKey', $this->request)) {
        //     throw new Exception('No API Key provided');
        // } else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
        //     throw new Exception('Invalid API Key');
        // } else if (array_key_exists('token', $this->request) &&
        //      !$User->get('token', $this->request['token'])) {
        //
        //     throw new Exception('Invalid User Token');
        // }
        //
        // $this->User = $User;
    }

    /**
     * Example of an Endpoint
     */
     protected function example() {
        if ($this->method == 'GET') {
        	$res = array();
        	$res['Name'] = 'Tyler';
            return json_encode($res);
        } else {
            return "Only accepts GET requests";
        }
     }

     protected function user_table(){
       if ($this->method == 'GET' || $this->method=="POST") {
    		return user_table_get();
  	   }
       else if ($this->method == 'PUT'){
        return user_table_put();
       }
  	   else {
      		return "Error";
  	   }
     }

     protected function user_table_columns(){
       if ($this->method == 'GET' || $this->method == 'POST') {
    		return user_table_column_get($_GET);
  	   }
  	   else {
      		return "Error";
  	   }
     }

     protected function user_schema(){
       if ($this->method == 'POST' || $this->method=='GET') {
       		$res = array();
       		$user_schema = array();
    		$tables = user_table_get();
    		foreach($tables as $table){
    			$table['TABLE_COLS'] = user_table_column_get($table['TABLE_NAME']);
    			$user_schema[] = $table;
    		}
    		$res['USER_SCHEMA'] = $user_schema;
    		return $res;
  	   }
  	   else {
      		return "Error";
  	   }
     }

 }
?>
