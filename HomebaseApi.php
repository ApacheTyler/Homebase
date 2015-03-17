<?php
ini_set('display_errors',true);
ini_set('display_startup_errors',true);
ini_set('date.timezone','America/New_York');
error_reporting (E_ALL|E_STRICT);

require 'Homebase_Routes.php';

// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
    $GLOBALS['oracle_connection'] = openDatabaseConnection();
    $API = new HomebaseApi($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
    echo $API->processAPI();
    $conn = $GLOBALS['oracle_connection'];
    oci_close($GLOBALS['oracle_connection']);
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}

?>
