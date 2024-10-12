<?php
include('conn.php');

$id=$_GET['id'];

$name=$_POST['name'];

$sql="update authority set name='$name' where id='$id'";
$conn->query($sql);

header('location:authority.php');
?>