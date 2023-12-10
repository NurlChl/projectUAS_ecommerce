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

$pengguna = $_SESSION["username"];

$id_produk = $_GET['id_produk'];

$produk = query("SELECT 
                a.id_produk AS id_produk, a.nama_produk, a.stok, a.harga, a.deskripsi, a.spesifikasi, a.gambar,
                c.nama_kategori 
                FROM produk a 
                LEFT JOIN kategori c ON a.id_produk = c.id_produk
                WHERE a.id_produk = $id_produk
                ")[0];

$warna_produk = query("SELECT id_warna, nama_warna FROM warna WHERE id_produk = $id_produk ");

$selected = $produk['nama_kategori'];


if (isset($_POST["submit"])) {
    
    if (edit($_POST) > 0 ) {
        echo "
            <script>
                alert('data berhasil diubah')
                document.location.href = './'
            </script>
        ";
    } else {
       echo mysqli_error($conn);
    }
};

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="edit_produk.css">
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <h2>FURNITURE</h2>
            <ul class="desc">
                <h1>Hai, <?= $pengguna ?>!</h1>
                <p>Silahkan Edit produk anda!</p>
            </ul>
            <input type="hidden" name="pembuat" value="<?= $pengguna ?>">
            <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>"/>
            <input type="hidden" name="gambarLama" value="<?= $produk['gambar'] ?>"/>
            <ul>
                <label for="nama_produk">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" placeholder="Enter your name product" required value="<?= $produk['nama_produk'] ?>"/>
            </ul>
            <ul>
                <label for="stok">Stock</label>
                <input type="number" id="stok" name="stok" placeholder="Enter your stock" required  value="<?= $produk['stok'] ?>"/>
            </ul>
            <ul>
                <label for="harga">Harga</label>
                <input type="number" id="harga" name="harga" placeholder="Enter your price" required value="<?= $produk['harga'] ?>"/>
            </ul>
            <ul>
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" placeholder="Enter your description" required ><?= $produk['deskripsi'] ?></textarea>
            </ul>
            <ul>
                <label for="spesifikasi">Spesifikasi</label>
                <textarea name="spesifikasi" id="spesifikasi" placeholder="Enter your description" required ><?= $produk['spesifikasi'] ?></textarea>
            </ul>
            <ul>
                <label for="kategori"></label>
                <select name="kategori" id="kategori" >
                    <option hidden disabled>Pilih Kategori</option>
                    <option value="kursi" <?php if ($selected == 'kursi'){echo('$selected');} ?> >Kursi</option>
                    <option value="sofa" <?php if ($selected == 'sofa'){echo('$selected');} ?> >sofa</option>
                    <option value="minimalist" <?php if ($selected == 'minimalist'){echo('$selected');} ?> >minimalist</option>
                    <option value="elegant" <?php if ($selected == 'elegant'){echo('$selected');} ?>>elegant</option>
                </select>
            </ul>
            <ul>
                <label for="gambar">Gambar</label>
                <img src="./gambar/<?= $produk['gambar'] ?>" />
                <input type="file" id="gambar" name="gambar" accept="image/*"/>
            </ul>
            <ul id="bungkus-warna">
                <label>Warna</label>
                <?php foreach ($warna_produk as $warna_produk) : ?>
                <input type="color" name="warna[]" class="warna-input" required value="<?= $warna_produk['nama_warna'] ?>"/>
                <input type="hidden" name="id_warna[]" class="warna-id" required value="<?= $warna_produk['id_warna'] ?>"/>
                <?php endforeach ?>
                <!-- <input type="color" name="warnaBaru[]" class="warna-input"/>
                <input type="hidden" name="warnaDihapus[]" value=""> -->
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
            let warnaKonten = document.getElementById('bungkus-warna')
            let inputWarna = document.createElement('input')
            inputWarna.type = 'color'
            inputWarna.name = 'warna[]'
            inputWarna.classList.add('warna-input')
            warnaKonten.appendChild(inputWarna)
        }

        function kurangiWarna() {
            let warnaKonten = document.getElementById('bungkus-warna');
            let inputWarna = warnaKonten.getElementsByClassName('warna-input');
            // let inputIdWarna = warnaKonten.querySelectorAll('[name^="id_warna"]');
            // let inputWarnaId = warnaKonten.getElementsByClassName('warna-id');

            if (inputWarna.length > 0) {
                warnaKonten.removeChild(inputWarna[inputWarna.length - 1]);
                // warnaKonten.removeChild(inputWarnaId[inputWarnaId.length - 1]);
            }
        }

    </script>
</body>
</html>