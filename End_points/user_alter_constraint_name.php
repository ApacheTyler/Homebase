<?php

function user_alter_constraint_name_post($req){
  $table_name = $req['table-name'];
  $constraint_to_rename = $req['constraint-name'];
  $new_constraint_name = $req['new-constraint-name'];
  $rename_column_statement = "";
  $rename_column_statement = "ALTER TABLE $table_name
    RENAME CONSTRAINT $constraint_to_rename TO $new_constraint_name";
  return executeQuery($rename_column_statement);
}

?>
