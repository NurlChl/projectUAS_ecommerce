<?php

require 'koneksi.php';

$id_produk = $_GET["id_produk"];


if (keranjang($id_produk) > 0 ) {
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