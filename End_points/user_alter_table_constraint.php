<?php

  function user_alter_table_constraint_post($req){

  }

  function user_alter_table_constraint_delete($req){
    $table_name = array_key_exists('table-name', $req) ? $req['table-name'] : '';
    $column_name = array_key_exists('constraint-name', $req) ? $req['constraint-name'] : '';
    $drop_constraint_statement = "ALTER TABLE $table_name
      DROP CONSTRAINT $column_name";
    return executeQuery($drop_constraint_statement);
  }

?>
