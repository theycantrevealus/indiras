<?php
include('conn.php');

$id=$_GET['id'];

$name=$_POST['aname'];
$auth=$_POST['aauth'];

$sql="update account set name='$name', authority=$auth where id='$id'";
$conn->query($sql);

header('location:account.php');
?>