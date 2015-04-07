<?php

function user_alter_column_name_post($req){
  $table_name = $req['table-name'];
  $column_to_rename = $req['column-name'];
  $new_column_name = $req['new-column-name'];
  $rename_column_statement = "";
  $rename_column_statement = "ALTER TABLE $table_name
    RENAME $column_to_rename TO $new_column_name";
  executeQuery($rename_column_statement);
}

?>
