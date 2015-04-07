<?php

  function user_alter_table_name_post($req){
    $table_name = $req['table-name'];
    $new_table_name = $req['new-table-name'];
    $rename_table_statement = "";
    $rename_table_statement = "RENAME TABLE $table_name TO $new_table_name";
    executeQuery($rename_table_statement);
  }

?>
