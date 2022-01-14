<?php

// Connect to the database
$usr = getenv('CLOUDSQL_USER');
$pass = getenv('CLOUDSQL_PASSWORD');
$inst = getenv('CLOUDSQL_DSN');
$db = getenv('CLOUDSQL_DB');

try {
  $dbh = new PDO("mysql:unix_socket=$inst;dbname=$db", $usr, $pass);
  //$dbh = new PDO("mysql:host=35.226.198.122;dbname=ruby_cons_db", 'root', 'FJKHBfNKbB9ieOs3');
  //$dbh = new PDO("mysql:host=localhost;dbname=slayerscans", 'dulan', 'good');
} catch (PDOException $e) {
  echo "error:  " . $e;
}
