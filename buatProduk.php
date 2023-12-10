<?php

session_start();

require_once "font.php";
require_once "navbar.php";
require 'koneksi.php';


if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["posisi"] === "pembeli") {
    header("Location: index.php");
    exit;
}

if (isset($_POST["submit"])) {

    if (tambah($_POST) > 0 ) {
        echo"
            <script>
                alert('data berhasil ditambahkan')
                document.location.href = './'
            </script>
        ";
    } else {
       echo mysqli_error($conn);
    }

}

$pengguna = $_SESSION["username"];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Produk</title>
    <link rel="stylesheet" href="buat_produk.css">
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <h2>FURNITURE</h2>
            <ul class="desc">
                <h1>Hai, <?= $pengguna ?>!</h1>
                <p>Silahkan buat produk anda!</p>
            </ul>
            <input type="hidden" name="pembuat" value="<?= $pengguna ?>">
            <ul>
                <label for="nama_produk">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" placeholder="Enter your name product" required/>
            </ul>
            <ul>
                <label for="stok">Stock</label>
                <input type="number" id="stok" name="stok" placeholder="Enter your stock" required/>
            </ul>
            <ul>
                <label for="harga">Harga</label>
                <input type="number" id="harga" name="harga" placeholder="Enter your price" required/>
            </ul>
            <ul>
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" placeholder="Enter your description" required></textarea>
            </ul>
            <ul>
                <label for="spesifikasi">Spesifikasi</label>
                <textarea name="spesifikasi" id="spesifikasi" placeholder="Enter your description" required></textarea>
            </ul>
            <ul>
                <label for="kategori"></label>
                <select name="kategori" id="kategori" required>
                    <option selected hidden disabled>Pilih Kategori</option>
                    <option value="kursi">Kursi</option>
                    <option value="sofa">sofa</option>
                    <option value="minimalist">minimalist</option>
                    <option value="elegant">elegant</option>
                </select>
            </ul>
            <ul>
                <label for="gambar">Gambar</label>
                <input type="file" id="gambar" name="gambar" accept="image/*" required/>
            </ul>
            <ul id="bungkus-warna">
                <label>Warna</label>
                <input type="color" name="warna[]" class="warna-input" required/>
            </ul>
            <ul class="btn-tamkur">
                <button type="button" class="btn-warna" onclick="tambahWarna()">Tambah Warna</button>
                <button type="button" class="btn-warna" onclick="kurangiWarna()">Kurangi Warna</button>
            </ul>
            <button type="submit" name="submit">Buat Produk</button>
        </div>
    </form>

    <?php include_once 'footer.php'; ?>

    <script>
        function tambahWarna () {
            var warnaKonten = document.getElementById('bungkus-warna')
            var inputWarna = document.createElement('input')
            inputWarna.type = 'color'
            inputWarna.name = 'warna[]'
            inputWarna.classList.add('warna-input')
            warnaKonten.appendChild(inputWarna)
        }

        function kurangiWarna() {
            let warnaKonten = document.getElementById('bungkus-warna');
            let inputWarna = warnaKonten.getElementsByClassName('warna-input');

            if (inputWarna.length > 0) {
                warnaKonten.removeChild(inputWarna[inputWarna.length - 1]);
            }
        }

    </script>
</body>
</html>