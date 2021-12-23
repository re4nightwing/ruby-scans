<?php
include 'db-conn.php';
$merchant_id         = $_POST['merchant_id'];
$order_id             = $_POST['order_id'];
$payhere_amount     = $_POST['payhere_amount'];
$payhere_currency    = $_POST['payhere_currency'];
$status_code         = $_POST['status_code'];
$md5sig                = $_POST['md5sig'];


$order_id_arr = explode('/',$order_id);
$stmt = $dbh->prepare("UPDATE `user_details` SET `ruby_count`=`ruby_count`+?, `toss_time`=now() WHERE `user_mail`=?");
$stmt->execute([$order_id_arr[1],$order_id_arr[0]]);
$dbh = null;

?>