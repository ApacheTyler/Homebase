<?php

require_once 'Restful_Api_Abstract.php';
require 'OracleConnectionManager.php';
require 'End_points/user_table.php';
require 'End_points/user_table_column.php';
require 'End_points/user_schema.php';
require 'End_points/user_alter_table_column.php';
require 'End_points/user_alter_table_constraint.php';
require 'End_points/user_alter_table_name.php';

class HomebaseApi extends RestfulAPI_Abs
{
  //  protected $User;


    // Abstracted out for example
    ////$APIKey = new Models\APIKey();
    ////$User = new Models\User();

    const REQUEST_NOT_SUPPORTED = "Endpoint does not support request type";

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

     /**
     * End point for creating, reading, updating, and deleting
     * tables in a user schema
     **/
     protected function user_table(){
       if ($this->method == 'GET') {
    		return user_table_get();
  	   }
       if ($this->method == 'POST') {
        return user_table_post($_POST['table_post']);//Create table
       }
  	   else {
      		return array('error' => self::REQUEST_NOT_SUPPORTED);
  	   }
     }
     /**
     * !!Rucs does not support put or delete requests, this method simulates it!!
     * !! GET requests are considered PUT requests !!
     * !! POST requests are considered DELETE requests!!
     **/
     protected function user_table_put_delete(){
       if ($this->method == 'GET') {//Surrogate PUT request
         return array('error' => self::REQUEST_NOT_SUPPORTED);
       }
       if ($this->method == 'POST') {//Surrogate DELETE request
         if(!array_key_exists('table-name',$_POST)){
           return array('error' => "Missing parameter table-name");
         }
         else{
           return user_table_delete($_POST['table-name']);
         }
       }
       else {
          return array('error' => self::REQUEST_NOT_SUPPORTED);
       }
     }

     /**
     * End point for creating, reading, updating, and deleting
     * tables in a user schema
     **/
     protected function user_table_columns(){
       if ($this->method == 'GET' || $this->method == 'POST') {
    		return user_table_column_get($_GET);
  	   }
  	   else {
      		return array('error' => self::REQUEST_NOT_SUPPORTED);
  	   }
     }

     /**
     * End point alerting atable
     **/
     protected function user_alter_table_column(){
       if($this->method == 'POST'){
         return user_alter_table_column_post($_POST);
       }
       else {
         return array('error' => self::REQUEST_NOT_SUPPORTED);
       }
     }

     protected function user_alter_table_column_put_delete(){
       if($this->method == 'GET'){
         return user_alter_table_column_put($_GET);
       }
       if($this->method == 'POST'){
         return user_alter_table_column_delete($_POST);
       }
       else {
         return array('error' => self::REQUEST_NOT_SUPPORTED);
       }
     }

     protected function user_alter_table_constraint(){
       if($this->method == 'POST'){
         return user_alter_table_constraint_post($_POST);
       }
       else {
         return array('error' => self::REQUEST_NOT_SUPPORTED);
       }
     }

     protected function user_alter_table_constraint_put_delete(){
       if($this->method == 'POST'){//DELETE
         return user_alter_table_constraint_delete($_POST);
       }
       else {
         return array('error' => self::REQUEST_NOT_SUPPORTED);
       }
     }

     protected function user_alter_table_name(){
       if($this->method == 'POST'){
         user_alter_table_name_post($_POST);
       }
       else{
         return array('error' => self::REQUEST_NOT_SUPPORTED);
       }
     }

     protected function user_alter_column_name(){
       if($this->method == 'POST'){
         user_alter_column_name_post($_POST);
       }
       else{
         return array('error' => self::REQUEST_NOT_SUPPORTED);
       }
     }

     protected function user_alter_constraint_name(){
       if($this->method == 'POST'){
         user_alter_constraint_name_post($_POST);
       }
       else{
         return array('error' => self::REQUEST_NOT_SUPPORTED);
       }
     }

     /**
     * End point for obtaining structure of user schema
     **/
     protected function user_schema(){
       if(!$GLOBALS['oracle_connection']){
         return array('error' => oci_error());
       }
       if ($this->method == 'POST' || $this->method=='GET') {
       		$res = array();
       		$user_schema = array();
    		$tables = user_table_get();
    		foreach($tables as $table){
          $table_name = $table['TABLE_NAME'];
    			$table['TABLE_COLS'] = user_table_column_get($table['TABLE_NAME']);
          $table['TABLE_PRIMARY_KEY'] = user_schema_get_table_primary_key($table_name);
          $table['TABLE_FOREIGN_KEY'] = user_schema_get_table_foreign_key($table_name);
          $table['TABLE_TRIGGERS'] = user_schema_get_table_triggers($table_name);
          $table['TABLE_CONSTRAINTS'] = user_table_column_get_constraints_by_column_name($table_name);
    			$user_schema[] = $table;
    		}
    		$res['USER_SCHEMA'] = $user_schema;
    		return $res;
  	   }
  	   else {
         return array('error' => self::REQUEST_NOT_SUPPORTED);
  	   }
     }

     protected function test_tables(){
       if ($this->method == 'POST'){
          executeQuery('CREATE TABLE "BOWLERS"
             (	"BNAME" VARCHAR2(40 BYTE),
          	"HANDED" VARCHAR2(5 BYTE),
          	"TEAM" VARCHAR2(40 BYTE),
          	"PHONE" VARCHAR2(13 BYTE),
          	 CONSTRAINT "PK_BOWLERS" PRIMARY KEY ("BNAME"),
          	 CONSTRAINT "UK_PHONE" UNIQUE ("PHONE")
             )
          ');
          executeQuery('  CREATE TABLE "TOURNAMENTS"
             (	"TNAME" VARCHAR2(80 BYTE),
          	"TDATE" DATE,
          	 CONSTRAINT "PK_TOURNAMENTS" PRIMARY KEY ("TNAME")
             )
          ');
          executeQuery('
            CREATE TABLE "PERFORMANCES"
             (	"BNAME" VARCHAR2(80 BYTE),
          	"TNAME" VARCHAR2(40 BYTE),
          	"SCORE" NUMBER,
          	 CONSTRAINT "PK_PERFORMANCES" PRIMARY KEY ("BNAME", "TNAME"),
          	 CONSTRAINT "FK_PERFORMANCESBNAME" FOREIGN KEY ("BNAME")
          	  REFERENCES "BOWLERS" ("BNAME"),
          	 CONSTRAINT "FK_PERFORMANCESTNAME" FOREIGN KEY ("TNAME")
          	  REFERENCES "TOURNAMENTS" ("TNAME")
             )
          ');
       }
     }

 }
?>
