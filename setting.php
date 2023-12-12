<?php

session_start();

require 'koneksi.php';
require_once 'navbar.php';
require_once 'font.php';


if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$pengguna = $_SESSION["username"];

$produk = query("SELECT 
                a.id_produk AS id_produk, a.pembuat, a.nama_produk, a.stok, a.harga, a.gambar,
                c.nama_kategori 
                FROM produk a 
                LEFT JOIN kategori c ON a.id_produk = c.id_produk
                ORDER BY id_produk DESC
                ");


if (isset($_POST["cari"])) {
    $produk = cari($_POST["search"]);
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <link rel="stylesheet" href="setting.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/setting.js"></script>

    <script>
        function checkWindowSize() {
            var windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

            if (windowWidth < 800) {
                alert("Hanya bisa di akses dengan layar diatas 800px");
                
                window.location.href = "index.php";
            }
        }

        window.onload = checkWindowSize;
        window.onresize = checkWindowSize;
    </script>
</head>
<body>
    <section>
        <div>
            <ul>
                <h1>Setting Produk</h1>
            </ul>
            <ul>
                    <input type="search" name="search" placeholder="Cari..." autofocus autocomplete="off" id="search">
                    <button type="submit" name="cari" id="button-cari" >Cari</button>
            </ul>
        </div>
    
        <div id="bungkusTabel" style="display: flex; flex-direction: column; gap: 0;">
            <p style="color: white; font-size: .8rem; background-color: rgba(255, 184, 53, 0.808); padding: .5rem 2rem; width: 100%;">Hanya bisa melakukan aksi pada produk yang dibuat sendiri!</p>
            <table id="konten">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Pembuat</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($produk)) : ?>
                        <tr>
                            <td colspan="6" style="padding: 5rem; font-size: 1.2rem; background-color: rgb(246, 246, 246);">Tidak ada produk, silahkan tambah produk.</td>
                        </tr>
                    <?php else : ?>
                    <?php foreach ($produk as $produk) : ?>
                    <tr>
                        <td><?= $produk['nama_produk'] ?></td>
                        <td><?= $produk['stok'] ?></td>
                        <td>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></td>
                        <td>
                            <img src="./gambar/<?= $produk['gambar'] ?>">
                        </td>
                        <td><?= $produk["pembuat"] ?></td>
                        <td>
                            <?php if ($pengguna == $produk["pembuat"]) : ?>
                            <div>
                                <a href="editProduk.php?id_produk=<?= $produk['id_produk'] ?>">
                                    <button type="submit" name="edit" class="edit">Edit</button>
                                </a>
                                <a href="hapus.php?id_produk=<?= $produk['id_produk'] ?>" onclick="
                                    return confirm('yakin?');">
                                    <button type="submit" name="hapus" class="hapus">Hapus</button>
                                </a>
                            </div>
                            <?php else : ?>
                            <div>-</div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <?php include_once 'footer.php'; ?>
</body>
</html>