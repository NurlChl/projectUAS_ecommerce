<?php

require 'koneksi.php';

$id_produk = $_GET["id_produk"];
$pemilik = $_GET["username"];



if (keranjang($id_produk, $pemilik) > 0 ) {
    echo "
        <script>
            alert('ditambah ke keranjang')
            document.location.href = 'keranjang.php'
        </script>
    ";
} else {
    echo mysqli_error($conn);
}


?>