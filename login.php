<?php

session_start();

require_once "font.php";
require 'koneksi.php';


if ( isset($_COOKIE['apasi']) && isset($_COOKIE['key'])) {
    $apasi = $_COOKIE['apasi'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($conn, "SELECT username FROM users WHERE id = $apasi");
    $row = mysqli_fetch_assoc($result);


    if ( $key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
        $_SESSION["username"] = $row["username"];
        $_SESSION["posisi"] = $row["posisi"];

    }
}


if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['login'])) {

    $email = $_POST["email"];
    $passwrod = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);
        if (password_verify($passwrod, $row["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["username"] = $row["username"];
            $_SESSION["posisi"] = $row["posisi"];

            if (isset($_POST['ingat'])) {
                setcookie('apasi', $row['id'], time()+86400);
                setcookie('key',hash('sha256',  $row['username']), time()+86400);
            }

            header("Location: index.php");
            exit;
        }
    }
    
    $error = true;

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <form action="" method="post">
        <div>
            <h2>FURNITURE</h2>
            <ul class="desc">
                <h1>Welcome Back</h1>
                <p>Level up the way you create account</p>
            </ul>
            <ul>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email"/>
            </ul>
            <ul>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password"/>
            </ul>
            <ul>
                <?php if(isset($error)) : ?>
                    <p style="color: red; font-size: .9rem;">Email / Password salah</p>
                <?php endif; ?>
            </ul>
            <ul>
                <li>
                    <input type="checkbox" id="ingat" name="ingat"/>
                    <label for="ingat">Remember me</label>
                </li>
            </ul>
            <button type="submit" name="login">Login</button>
            <p>Don't have account? <a href="register.php"><span>Sign Up</span></a></p>
        </div>
    </form>

    <script>
        function kirim () {
            document.location.href = './'
        }
    </script>
</body>
</html>