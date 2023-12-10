<?php

require_once "font.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
    <nav>
        <ul>
            <!-- <img/> -->
            <h2>FURNITURE</h2>
        </ul>
        <ul class="navig">
            <a  href="index.php">
                <li <?php if (strpos($_SERVER['PHP_SELF'], 'index.php')) echo 'class=active'; ?> >Home</li>
            </a>
            <li>About</li>
            <a href="produk.php">
                <li <?php if (strpos($_SERVER['PHP_SELF'], 'produk.php')) echo 'class=active'; ?>>Product</li>
            </a>
            <a href="buatProduk.php">
                <li <?php if (strpos($_SERVER['PHP_SELF'], 'buatProduk.php')) echo 'class=active'; ?>>Create Product</li>
            </a>
            <a href="setting.php">
                <li <?php if (strpos($_SERVER['PHP_SELF'], 'setting.php')) echo 'class=active'; ?>>Setting</li>
            </a>
        </ul>
        <ul>
            <!-- <li class="material-symbols-rounded">search</li> -->
            <a href="keranjang.php">
                <li <?php if (strpos($_SERVER['PHP_SELF'], 'keranjang.php')) echo 'style="color: black"'; ?> class="material-symbols-rounded">shopping_cart</li>
            </a>
            <li class="material-symbols-rounded">person</li>
            <?php
            if (!isset($_SESSION["login"])) :?>
            <a href="login.php">
                <li class="btn-login">Login</li>
            </a>
            <?php else : ?>
                <a href="logout.php">
                    <li class="btn-login">Logout</li>
                </a>
            <?php endif; ?>
        </ul>
    </nav>
</body>
</html>