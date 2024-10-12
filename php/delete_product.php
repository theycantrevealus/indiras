<?php
	include('conn.php');

	$id = $_GET['product'];

//	$sql="delete from product where productid='$id'";
    $sql="update product set status=0 where productid='$id'";
	$conn->query($sql);

	header('location:product.php');
?>