<?php

require 'koneksi.php';

$id_keranjang = $_GET["id_keranjang"];

if (hapusKeranjang($id_keranjang) > 0 ) {
    echo "
        <script>
            alert('dihapus dari keranjang')
            document.location.href = 'keranjang.php'
        </script>
    ";
} else {
    echo mysqli_error($conn);
}



?>