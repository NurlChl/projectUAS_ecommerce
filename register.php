<?php

session_start();

require_once "font.php";
require 'koneksi.php';

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}


if (isset($_POST["register"])) {

    if (registrasi($_POST) > 0 ) {
        echo"
            <script>
                alert('data berhasil ditambahkan')
                document.location.href = 'login.php'
            </script>
        ";
    } else {
       echo mysqli_error($conn);
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <form action="" method="post">
        <div>
            <h2>FURNITURE</h2>
            <ul class="desc">
                <h1>Hello!</h1>
                <p>Silahkan buat akun anda!</p>
            </ul>
            <ul>
                <label for="name">Name</label>
                <input type="text" id="name" name="username" placeholder="Enter your name"/>
            </ul>
            <ul>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email"/>
            </ul>
            <ul>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password"/>
            </ul>
            <ul class="sebagai">
                <label>Position</label>
                <span>
                    <li>
                        <input type="radio" name="sebagai" id="penjual" value="penjual">
                        <label for="penjual">Penjual</label>
                    </li>
                    <li>
                        <input type="radio" name="sebagai" id="pembeli" value="pembeli">
                        <label for="pembeli">Pembeli</label>
                    </li>
                </span>
            </ul>
            <button type="submit" name="register">Register</button>
            <p>You have an account? <a href="login.php"><span>Sign In</span></a></p>
        </div>
    </form>

</body>
</html>