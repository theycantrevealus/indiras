<?php
include('conn.php');

$auname=$_POST['auname'];
$aname=$_POST['aname'];
$acontact=$_POST['acontact'];
$aauth=$_POST['aauth'];
$apass=$_POST['apass'];

$iv = mcrypt_create_iv(
    mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
    MCRYPT_DEV_URANDOM
);
$encrypted = base64_encode(
    $iv .
    mcrypt_encrypt(
        MCRYPT_RIJNDAEL_128,
        hash('sha256', 'indiras##123!!___', true),
        $apass,
        MCRYPT_MODE_CBC,
        $iv
    )
);

$sql="insert into account (username, name, contact, authority, password, status) values ('$auname', '$aname', '$acontact', $aauth, '$encrypted', 1)";
$conn->query($sql);

header('location:account.php');

?>