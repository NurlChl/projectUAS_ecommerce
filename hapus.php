<?php

require 'koneksi.php';

$id_produk = $_GET["id_produk"];

if (hapus($id_produk) > 0 ) {
    echo "
        <script>
            alert('data berhasil dihapus')
            document.location.href = 'index.php'
        </script>
    ";
} else {
    echo mysqli_error($conn);
}



?>