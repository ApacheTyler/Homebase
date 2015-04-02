<?php

  /**
  * Adds column to an existing table
  **/
  function user_alter_table_column_post($req){
    $table_name = array_key_exists('table-name', $req) ? $req['table-name'] : '';
    $column_name = array_key_exists('column-name', $req) ? $req['column-name'] : '';
    $column_type = array_key_exists('column-type', $req) ? $req['column-type'] : '';
    $column_size = array_key_exists('column-size', $req) ? $req['column-size'] : '';
    $not_null = array_key_exists('not-null', $req) ? $req['not-null'] : '';
    $unique = array_key_exists('unique', $req) ? $req['unique'] : '';
    $add_column_statement = "ALTER TABLE $table_name
      ADD $column_name $column_type";
    if($column_size){
      $add_column_statement = $add_column_statement . " ($column_size)";
    }
    if($not_null){
      $add_column_statement = $add_column_statement . " NOT NULL";
    }
    if($unique){
      $add_column_statement = $add_column_statement . " UNIQUE";
    }
    return executeQuery($add_column_statement);
  }

  /**
  * Edit an existing column
  **/
  function user_alter_table_column_put($req){
    $table_name = array_key_exists('table-name', $req) ? $req['table-name'] : '';
    $column_name = array_key_exists('column-name', $req) ? $req['column-name'] : '';
    $new_column_type = array_key_exists('new-column-type', $req) ? $req['new-column-type'] : '';
    $new_column_size = array_key_exists('new-column-size', $req) ? $req['new-column-size'] : '';
    $not_null = array_key_exists('not-null', $req) ? $req['not-null'] : '';
    $unique = array_key_exists('unique', $req) ? $req['unique'] : '';

    $edit_column_statement = "ALTER TABLE $table_name
      MODIFY $column_name $new_column_type";

    if($new_column_size){
      $edit_column_statement = $edit_column_statement . " ($new_column_size)";
    }
    if($not_null){
      $edit_column_statement = $edit_column_statement . " NOT NULL";
    }
    if($unique){
      $edit_column_statement = $edit_column_statement . " UNIQUE";
    }
    return executeQuery($edit_column_statement);
  }

  /**
  * Drop eisting column
  **/
  function user_alter_table_column_delete($req){
    $table_name = array_key_exists('table-name', $req) ? $req['table-name'] : '';
    $column_name = array_key_exists('column-name', $req) ? $req['column-name'] : '';
    $drop_column_statement = "ALTER TABLE $table_name
      DROP COLUMN $column_name";
    return executeQuery($drop_column_statement);
  }

?>
