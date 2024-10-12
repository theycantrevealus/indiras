<?php
include('conn.php');
$supcode=$_POST['supcode'];
$supname=$_POST['supname'];
$supcontact=$_POST['supcontact'];
$supaddress=$_POST['supaddress'];

$sql="insert into supplier (code, name, contact, address, status) values ('$supcode', '$supname', '$supcontact', '$supaddress', 1)";
$conn->query($sql);

header('location:supplier.php');

?>