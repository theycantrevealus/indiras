<?php
include('conn.php');

$id = $_GET['id'];

$sql="update supplier set status=0 where id='$id'";
$conn->query($sql);

header('location:supplier.php');
?>