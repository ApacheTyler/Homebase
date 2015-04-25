<?php

function user_table_info_post($req){
  $table_name = $req['TABLE_NAME'];
  $table =array();
  $table['TABLE_COLS'] = user_table_column_get($table_name);
  $table['TABLE_PRIMARY_KEY'] = user_schema_get_table_primary_key($table_name);
  $table['TABLE_FOREIGN_KEY'] = user_schema_get_table_foreign_key($table_name);
  $table['TABLE_TRIGGERS'] = user_schema_get_table_triggers($table_name);
  $table['TABLE_CONSTRAINTS'] = user_table_column_get_constraints_by_column_name($table_name);
  return $table;
}

?>
