<?php

  /**
  * Adds column to an existing table
  **/
  function user_alter_table_column_post($req){
    $table_name = array_key_exists('table-name', $req) ? $req['table-name'] : '';
    $column_name = array_key_exists('column-name', $req) ? $req['column-name'] : '';
    $column_type = array_key_exists('column-type', $req) ? $req['column-type'] : '';
    $column_size = array_key_exists('column-size', $req) ? $req['column-size'] : '';
    $add_column_statement = "ALTER TABLE $table_name
      ADD $column_name $column_type";
    if($column_size){
      $add_column_statement = $add_column_statement . " ($column_size)";
    }
    return executeQuery($add_column_statement);
  }

?>
