<?php
include('conn.php');

$username=$_POST['username'];
$password=$_POST['password'];

$sql="select * from account where username='$username'";
$query=$conn->query($sql);
if ($query->num_rows > 0) {
    $row = mysqli_fetch_assoc($query);
    $_SESSION['username'] = $row['username'];
    header("Location: index.php");
    exit();
} else {
    echo "<script>alert('Email atau password Anda salah. Silakan coba lagi!')</script>";
}
//$data = base64_decode($encrypted);
//$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
//
//$decrypted = rtrim(
//    mcrypt_decrypt(
//        MCRYPT_RIJNDAEL_128,
//        hash('sha256', $key, true),
//        substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
//        MCRYPT_MODE_CBC,
//        $iv
//    ),
//    "\0"
//);

// header('location:category.php');

?>