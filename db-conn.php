<?php

// Connect to the database
//$usr = getenv('CLOUDSQL_USER');
//$pass = getenv('CLOUDSQL_PASSWORD');
//$inst = getenv('CLOUDSQL_DSN');
//$db = getenv('CLOUDSQL_DB');

try {
  //$dbh = new PDO("mysql:unix_socket=$inst;dbname=$db", $usr, $pass);
  $dbh = new PDO("mysql:host=35.223.198.221;dbname=ruby_cons_db", 'root', 'A0FCaA9I1Fcp5iuf');
} catch (PDOException $e) {
  echo "error:  " . $e;
}
