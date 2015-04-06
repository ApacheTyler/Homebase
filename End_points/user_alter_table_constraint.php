<?php

/** TURN OFF MAGIC QUOTES **/
if (get_magic_quotes_gpc()) {
	$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
	while (list($key, $val) = each($process)) {
			foreach ($val as $k => $v) {
					unset($process[$key][$k]);
					if (is_array($v)) {
							$process[$key][stripslashes($k)] = $v;
							$process[] = &$process[$key][stripslashes($k)];
					} else {
							$process[$key][stripslashes($k)] = stripslashes($v);
					}
			}
	}
	unset($process);
}

  /**
  * Adds constraint to table
  **/
  function user_alter_table_constraint_post($req){
    $statement_to_execute = "";
    $constraint = _get_constraint_statement($req);
    $statement_to_execute = "ALTER TABLE " . $req['table-name'] . "
    ADD " . $constraint;
    return executeQuery($statement_to_execute);
  }

  /**
  * Drops constraint from table
  **/
  function user_alter_table_constraint_delete($req){
    $table_name = array_key_exists('table-name', $req) ? $req['table-name'] : '';
    $column_name = array_key_exists('constraint-name', $req) ? $req['constraint-name'] : '';
    $drop_constraint_statement = "ALTER TABLE $table_name
      DROP CONSTRAINT $column_name";
    return executeQuery($drop_constraint_statement);
  }


  /** PRIVATE FUNCTIONS **/

  function _get_constraint_statement($req){
    $statement_to_execute = "";
    $constraint = json_decode($req['cons'], true);
    switch (strtolower($req['constraint-type'])){
      case "p":
        $statement_to_execute = _table_constraint_primary_keys($constraint);
        break;
      case "f":
        $statement_to_execute = _table_constraint_foreign_keys($constraint);
        break;
      case "u":
        $statement_to_execute = _table_constraint_unique_keys($constraint);
        break;
      case "c":
        $statement_to_execute = _table_constraint_check_constraint($constraint);
        break;
      case "n":
        $statement_to_execute = _table_constraint_not_null_constraint($constraint);
        break;
    }
    return $statement_to_execute;
  }

  function _table_constraint_foreign_keys($foreign_key){
		$foreign_key_statement = "";
			$deferrable = "";
			if($foreign_key['deferrable']){
				$deferrable = "DEFERRABLE INITIALLY DEFERRED";
			}
			$foreign_key_statement = $foreign_key_statement . " CONSTRAINT " . $foreign_key['constraintName'] . " FOREIGN KEY (" . $foreign_key['tableCol'] . ") REFERENCES " . $foreign_key['refTable'] . "(" . $foreign_key['refCol'] . ") " . $deferrable . "
			";
		return $foreign_key_statement;
	}

  function _table_constraint_primary_keys($primary_keys){
		$primary_key_statement = "";
		$keys = "";
		foreach($primary_keys['cols'] as $col){
			$keys = $keys . $col . ",";
		}
		$keys = rtrim($keys, ",");
		$primary_key_statement = " CONSTRAINT " . $primary_keys['constraintName'] . " PRIMARY KEY (" . $keys . ")
		";
		return $primary_key_statement;
	}

  function _table_constraint_unique_keys($unq_key){
    $unique_key_statement = "";
    $keys = "";
    foreach($unq_key['cols'] as $col){
			$keys = $keys . $col . ",";
		}
    $keys = rtrim($keys, ",");
    $unique_key_statement = " CONSTRAINT " . $unq_key['constraintName'] . " UNIQUE (" . $keys . ")
    ";
    return $unique_key_statement;
  }

  function _table_constraint_check_constraint($chk_cons){
    $check_constraint_statement = "";
    $check_constraint_statement = " CONSTRAINT " . $chk_cons['constraintName'] . " CHECK (" . $chk_cons['checkCondition'] . ")
    ";
    return $check_constraint_statement;
  }

  function _table_constraint_not_null_constraint($nn_cons){
    $not_null_constraint_statement = "";
    $not_null_constraint_statement = " CONSTRAINT " . $nn_cons['constraintName'] . " CHECK (" . $nn_cons['columnName'] . " IS NOT NULL)
    ";
    return $not_null_constraint_statement;
  }

?>
