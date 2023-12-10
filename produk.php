<?php

session_start();

require_once "navbar.php";
require_once "font.php";
require 'koneksi.php';

$kategori = 'minimalist';

$produk = query("SELECT 
                a.id_produk AS id_produk, a.pembuat, a.nama_produk, a.stok, a.harga, a.deskripsi, a.spesifikasi, a.gambar,
                c.nama_kategori 
                FROM produk a 
                LEFT JOIN kategori c ON a.id_produk = c.id_produk
                ");

$kategoriKlik = query("SELECT 
                a.id_produk AS id_produk, a.pembuat, a.nama_produk, a.stok, a.harga, a.deskripsi, a.spesifikasi, a.gambar,
                c.nama_kategori 
                FROM produk a 
                LEFT JOIN kategori c ON a.id_produk = c.id_produk
                WHERE nama_kategori = '$kategori'
                ");

// $kategoriKursi = query("SELECT
//                 c.nama
//                 ");



// foreach ($produk as $produk) {
//     $id_produk = $produk['id_produk'];
//     $warna_produk = query("SELECT nama_warna FROM warna WHERE id_produk = $id_produk ");
// }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.favorit').click(function(){
                $('.material-symbols-rounded').toggleClass("like")
            })
        })
    </script>
</head>
<body>
    <header>
        <h1>Accent Furniture Collections</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo reprehenderit non veritatis, quam fugiat dolor ex eligendi praesentium natus minus?</p>
    </header>

    <section>
        <div class="pilihan">
            <ul class="kateg">
                <li>All</li>
                <li>Kursi</li>
                <li>Sofa</li>
                <li>Minimalist</li>
                <li>Elegant</li>
            </ul>
            <ul>
                <li class="material-symbols-rounded filter">page_info</li>
            </ul>
        </div>
        
        <div class="katalog">
        <?php foreach ($produk as $produk) : ?>
            <div class="produk" onclick="document.location.href='detailProduk.php?id_produk=<?= $produk['id_produk']; ?>'">
                <img src="./gambar/<?= $produk['gambar'] ?>"/>
                <ul>
                    <li>
                        <h4><?= $produk['nama_produk'] ?></h4>
                        <h3><?= number_format($produk['harga'], 0, ',', '.') ?></h3>
                    </li>
                    <li>
                        <p class="desc">New in Rechoster</p>
                        <p class="material-symbols-rounded favorit">favorite</p>
                    </li>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>

    </section>

    <?php include_once "footer.php"; ?>
</body>
</html>