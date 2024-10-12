<?php
include('conn.php');

$id=$_GET['id'];

$supname=$_POST['supname'];
$supcode=$_POST['supcode'];
$supcontact=$_POST['supcontact'];
$supaddress=$_POST['supaddress'];

$sql="update supplier set name='$supname', code='$supcode', contact='$supcontact', address='$supaddress' where id='$id'";
$conn->query($sql);

header('location:supplier.php');
?>