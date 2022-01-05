<?php

// Connect to the database
//$usr = getenv('CLOUDSQL_USER');
//$pass = getenv('CLOUDSQL_PASSWORD');
//$inst = getenv('CLOUDSQL_DSN');
//$db = getenv('CLOUDSQL_DB');

try {
  //$dbh = new PDO("mysql:unix_socket=$inst;dbname=$db", $usr, $pass);
  $dbh = new PDO("mysql:host=ruby-scans.mysql.database.azure.com;dbname=ruby_cons_db", 'dulan@ruby-scans', 'azure@123');
} catch (PDOException $e) {
  echo "error:  " . $e;
}
