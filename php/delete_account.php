<?php
include('conn.php');

$id = $_GET['id'];

$sql="update account set status=0 where id='$id'";
$conn->query($sql);

header('location:account.php');
?>