<?php

function user_table_info_post($req){
  $table_name = $req['table-name'];
  $constraint_type = $req['constraint-name'];
  $table =array();
  $table['TABLE_COLS'] = user_table_column_get($table_name);
  $table['TABLE_PRIMARY_KEY'] = user_schema_get_table_primary_key($table_name);
  $table['TABLE_FOREIGN_KEY'] = user_schema_get_table_foreign_key($table_name);
  $table['TABLE_TRIGGERS'] = user_schema_get_table_triggers($table_name);
  $table['TABLE_CONSTRAINTS'] = get_table_constraints($table_name);
  return $table;
}

function get_table_constraints($table_name, $constraint_type){
  return executeQuery("SELECT c.constraint_name, c.constraint_type, a.table_name, a.column_name,
                            r.table_name as reference_table, a.column_name as reference_column, c.deferrable,
                            c.DEFERRED, c.DELETE_RULE, c.search_condition, c.status
                FROM user_cons_columns a
                JOIN user_constraints c ON a.owner = c.owner
                    AND a.constraint_name = c.constraint_name
                LEFT OUTER JOIN (SELECT table_name, constraint_name FROM user_constraints) r
                  ON r.constraint_name = c.r_constraint_name
								WHERE a.table_name = '$table_name' AND c.constraint_name = '$constraint_type'");
}

?>
