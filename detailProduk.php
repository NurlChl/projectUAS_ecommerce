<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require_once 'font.php';
require_once 'navbar.php';
require 'koneksi.php';

$current_page = basename($_SERVER['PHP_SELF']);


$id_produk = $_GET['id_produk'];
$posisi = $_SESSION["posisi"];
$pengguna = $_SESSION["username"];

$produk = query("SELECT 
                a.id_produk AS id_produk, a.pembuat, a.nama_produk, a.stok, a.harga, a.deskripsi, a.spesifikasi, a.gambar,
                c.nama_kategori 
                FROM produk a 
                LEFT JOIN kategori c ON a.id_produk = c.id_produk
                WHERE a.id_produk = $id_produk
                ")[0];

$warna_produk = query("SELECT nama_warna FROM warna WHERE id_produk = $id_produk ");

$rekomendasi = query("SELECT 
                a.id_produk AS id_produk, a.nama_produk, a.stok, a.harga, a.deskripsi, a.spesifikasi, a.gambar,
                c.nama_kategori 
                FROM produk a 
                LEFT JOIN kategori c ON a.id_produk = c.id_produk
                ");

if (isset($_POST["btnKomen"])) {
    if ( komentar($_POST) > 0 ) {
        header("Location: detailProduk.php?id_produk=$id_produk");
        echo"
            <script>
                alert('Komentar berhasil dikirim')
            </script>
        ";
    } else {
       echo mysqli_error($conn);
    }
}

$panggilKomen = query("SELECT * FROM komentar WHERE id_produk = $id_produk");


if (isset($_POST["btnKeranjang"])) {
    if (keranjang($_POST) > 0 ) {
        echo"
            <script>
                alert('ditambah ke keranjang')
                document.location.href = 'keranjang.php'
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
    <title>Detail Produk</title>
    <link rel="stylesheet" href="detail_produk.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.spesifikasi').hide();
            $('.review').hide();
            $('.deskripsi').show();
            $('#deskrip').addClass('diklik');
            $('#spesif').removeClass('diklik');
            $('#ripiu').removeClass('diklik');
            
            $('.navig ul #deskrip').click(function() {
                $('.deskripsi').show();
                $('.spesifikasi').hide();
                $('.review').hide();
                $('#deskrip').addClass('diklik');
                $('#spesif').removeClass('diklik');
                $('#ripiu').removeClass('diklik');
            })

            $('.navig ul #spesif').click(function() {
                $('.spesifikasi').show();
                $('.deskripsi').hide();
                $('.review').hide();
                $('#spesif').addClass('diklik');
                $('#deskrip').removeClass('diklik');
                $('#ripiu').removeClass('diklik');
            })

            $('.navig ul #ripiu').click(function() {
                $('.review').show();
                $('.spesifikasi').hide();
                $('.deskripsi').hide();
                $('#ripiu').addClass('diklik');
                $('#spesif').removeClass('diklik');
                $('#deskrip').removeClass('diklik');
            })
        })
    </script>
</head>
<body>
    <section class="detail">
        <div class="bungkus">
            <form action="" method="post">
                <img src="./gambar/<?= $produk['gambar'] ?>"/>
                <?php if ($pengguna !== $produk['pembuat']) : ?>
                    <input type="hidden" name="id_produk" value="<?= $id_produk ?>">
                    <input type="hidden" name="pengguna" value="<?= $pengguna ?>">
                    <textarea name="komen" id="komen" placeholder="Berikan penilaian"></textarea>
                    <button type="submit" name="btnKomen">Kirim Komen</button>
                <?php endif; ?>
            </form>
            <div>
                <ul class="judul">
                    <p><?= $produk['nama_kategori'] ?></p>
                    <h1><?= $produk['nama_produk'] ?></h1>
                    <p>New in Rechester</p>
                </ul>
                <ul class="desc">
                    <div class="navig">
                        <ul>
                            <li id="deskrip">Description</li>
                            <li id="spesif">Specification</li>
                            <li id="ripiu">Reviews</li>
                        </ul>
                    </div>
                    <section class="scroll">
                        <p class="deskripsi"><?= $produk['deskripsi'] ?></p>
                        <p class="spesifikasi"><?= $produk['spesifikasi'] ?></p>
                        <div class="review">
                            <?php if(empty($panggilKomen)) : ?>
                                <ul>
                                    <p style="text-align: center;">Belum ada komentar.</p>
                                </ul>
                            <?php else : ?>
                            <?php foreach ($panggilKomen as $panggilKomen) : ?>
                            <ul>
                                <li><?= $panggilKomen['pengguna'] ?></li>
                                <p><?= $panggilKomen['isi_komen'] ?></p>
                            </ul>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </section>
                </ul>
                <ul class="warna">
                    <li>
                    <?php foreach ($warna_produk as $warna_produk) : ?>
                        <span style="background-color: <?= $warna_produk['nama_warna'] ?>;"></span>
                    <?php endforeach ?>
                    </li>
                    <li>
                        <h2>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></h2>
                    </li>
                </ul>
                <ul class="btn">
                    <form action="" method="post">
                        <input type="hidden" name="add_keranjang" value="<?= $produk['id_produk'] ?>"/>
                        <input type="hidden" name="user_keranjang" value="<?= $pengguna ?>"/>
                        <button type="submit" class="btn-cart" name="btnKeranjang">Keranjang</button>
                    </form>
                        <button class="btn-buy">Kuy Beli</button>
                </ul>
            </div>
        </div>
    </section>

    <section class="rekomendasi">
        <h1>Rekomendasi</h1>
        <div class="katalog">
            <?php foreach ($rekomendasi as $rekomendasi) : ?>
            <div class="produk" onclick="document.location.href='detailProduk.php?id_produk=<?= $rekomendasi['id_produk'] ?>'">
                <img src="./gambar/<?= $rekomendasi['gambar'] ?>"/>
                <ul>
                    <li>
                        <h4><?= $rekomendasi['nama_produk'] ?></h4>
                        <h3><?= number_format($rekomendasi['harga'], 0, ',', '.') ?></h3>
                    </li>
                    <li>
                        <p class="desc">New in Rchester</p>
                        <span>
                        <?php
                        $idProduk = $rekomendasi['id_produk'];
                        $listWarna = query("SELECT nama_warna FROM warna Where id_produk = $idProduk");
                        $arrWarna = count($listWarna);
                        // var_dump($listWarna);

                        for ($i = 0; $i < 3; $i++) {

                        ?>
                            <p style="background-color: <?= $listWarna[$i]['nama_warna'] ?>; border: 2px solid rgb(243, 243, 243);" class="war<?= $i+1 ?>" ></p>
                        <?php } ?>
                        </span>
                    </li>
                </ul>
            </div>
            <?php  endforeach ?>
        </div>
    </section>

    <?php include_once 'footer.php'; ?>
</body>
</html>