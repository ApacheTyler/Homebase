<?php

function user_table_info_post($req){
  $table_name = $req['table-name'];
  $constraint_name = $req['constraint-name'];
  $table =array();
  $table['TABLE_CONSTRAINTS'] = get_table_constraints($table_name, $constraint_name);
  $table['TABLE_CONSTRAINTS'] = array_unique($table['TALBE_CONSTRAINTS']);
  return $table;
}

function get_table_constraints($table_name, $constraint_name){
  return executeQuery("SELECT c.constraint_name, c.constraint_type, a.table_name, a.column_name,
                            r.table_name as reference_table, r.column_name as reference_column, c.deferrable,
                            c.DEFERRED, c.DELETE_RULE, c.search_condition, c.status
                FROM user_cons_columns a
                JOIN user_constraints c ON a.owner = c.owner
                    AND a.constraint_name = c.constraint_name
                LEFT OUTER JOIN (SELECT table_name, column_name, constraint_name FROM user_constraints NATURAL JOIN user_cons_columns) r
                  ON r.constraint_name = c.r_constraint_name
								WHERE a.table_name = '$table_name' AND c.constraint_name = '$constraint_name'");
}

?>
