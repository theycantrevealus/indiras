<?php
include('header.php');

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['submit'])) {
    include('conn.php');
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT account.id, account.username, account.password, authority.code FROM account left join authority on account.authority = authority.id WHERE account.username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $data = base64_decode($row['password']);
        $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

        $decrypted = rtrim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', 'indiras##123!!___', true),
                substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
                MCRYPT_MODE_CBC,
                $iv
            ),
            "\0"
        );
        if($password == $decrypted) {
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['authority'] = $row['code'];
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Email atau password Anda salah. Silakan coba lagi!')</script>";
        }
    } else {
        echo "<script>alert('Email atau password Anda salah. Silakan coba lagi!')</script>";
    }
}

?>
<div class="container">
    <div class="tab-content" style="padding-top: 200px;">
        <form action="" method="post">
            <div class="container">
                <div class="form-group" style="margin-top:10px;">
                    <div class="row">
                        <div class="col-md-3" style="margin-top:7px;">
                            <label class="control-label">Username:</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="username">
                        </div>
                    </div>
                </div>
                <div class="form-group" style="margin-top:10px;">
                    <div class="row">
                        <div class="col-md-3" style="margin-top:7px;">
                            <label class="control-label">Password:</label>
                        </div>
                        <div class="col-md-9">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>
                </div>

                <button class="btn btn-default pull-right" name="submit" type="submit">Login</button>
            </div>
        </form>
    </div>

</div>