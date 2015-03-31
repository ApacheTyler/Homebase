<?php
  require 'vendor/autoload.php';
  require 'vendor/nightlinus/oracle-db/autoload.php';
  foreach (glob('*.php') as $file){
      include $file;
  }
?>
