<?php

session_start();

require_once "font.php";
require_once "navbar.php";
require "koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$pemilik = $_SESSION["username"];

$keranjang = query("SELECT * FROM keranjang WHERE pemilik = '$pemilik'");

$totalHarga = 0;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <link rel="stylesheet" href="keranjang.css">

    <!-- <script>
        $minus = document.getElementsByClassName('.kurang')
        $plus = document.getElementsByClassName('.tambah')
        $nilai =
        function (param) {

        }

    </script> -->
</head>
<body>
    <div class="bungkusCart">
        <section class="cart">
            <h2>Your Cart</h2>
            
            <div class="katalog">
                <?php if(empty($keranjang)) : ?>
                    <div colspan="6" style="padding: 5rem; font-size: 1.2rem; background-color: rgb(246, 246, 246);">Keranjang Kosong.</div>
                <?php else : ?>
                <?php
                foreach ($keranjang as $keranjang) {
                    $id_produk = $keranjang['id_produk'];
                    $id_keranjang = $keranjang['id_keranjang'];
                    $allProduk = query("SELECT * FROM produk WHERE id_produk = $id_produk");
                ?>
                <?php foreach ($allProduk as $allProduk) :?>
                <?php $totalHarga += $allProduk['harga'] ;?>
                <div class="produk">
                    <img src="./gambar/<?= $allProduk['gambar'] ?>"/>
                    <div>
                        <ul>
                            <li class="judul">
                                <h3><?= $allProduk['nama_produk'] ?></h3>
                                <p>New in Rechoster <?= $keranjang['id_keranjang'] ?></p>
                            </li>
                            <li>
                                <h2>Rp. <?= number_format($allProduk['harga'], 0, ',', '.') ?></h2>
                            </li>
                        </ul>
                        <ul class="hitung">
                            <li>
                                <span class="material-symbols-rounded kurang">remove</span>
                                <span class="banyakBarang">1</span>
                                <span class="material-symbols-rounded tambah">add</span>
                            </li>
                            <li>
                                <a href="hapusKeranjang.php?id_keranjang=<?= $id_keranjang ?>" style="color: black;" onclick="
                                    return confirm('yakin?');">
                                    <span class="material-symbols-rounded">delete</span>
                                </a>
                                <span class="material-symbols-rounded">favorite</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php } ?>
                <?php endif; ?>
            </div>
        </section>
    
        <section class="cekot">
            <h2>Summary</h2>
            <div class="bungkuscek">
                <div class="keterangan">
                    <ul>
                        <li>Total Harga ?</li>
                        <span>Rp. <?= number_format($totalHarga, 2, ',', '.') ?></span>
                    </ul>
                    <ul>
                        <li>Biaya Ongkir</li>
                        <span>Free</span>
                    </ul>
                    <ul>
                        <?php $pajak = $totalHarga*5/100; ?>
                        <li>Biaya Penanganan?</li>
                        <span>Rp. <?= number_format($pajak, 2, ',', '.') ?></span>
                    </ul>
                </div>
                <div class="total">
                    <ul>
                        <?php $allTotal = $totalHarga + $pajak; ?>
                        <li>Total</li>
                        <li class="nilai-total">Rp. <?= number_format($allTotal, 2, ',', '.') ?></li>
                    </ul>
                </div>
                <button>Checkout Now</button>
            </div>
        </section>
    </div>

    <?php include_once "footer.php"; ?>
</body>
</html>