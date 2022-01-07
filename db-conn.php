<?php

// Connect to the database
//$usr = getenv('CLOUDSQL_USER');
//$pass = getenv('CLOUDSQL_PASSWORD');
//$inst = getenv('CLOUDSQL_DSN');
//$db = getenv('CLOUDSQL_DB');

try {
  //$dbh = new PDO("mysql:unix_socket=$inst;dbname=$db", $usr, $pass);
  $dbh = new PDO("mysql:host=34.72.85.245;dbname=ruby_cons_db", 'root', '2jBDEgC50DkjjqAj');
} catch (PDOException $e) {
  echo "error:  " . $e;
}
