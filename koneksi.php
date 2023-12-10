<?php

$conn = mysqli_connect("localhost", "root", "", "ecommerce");

function query($query) {

    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;

    }
    return $rows;
};


function tambah($data) {
    global $conn;
    $nama_produk = htmlspecialchars($data["nama_produk"]);
    $stok = htmlspecialchars($data["stok"]);
    $harga = htmlspecialchars($data["harga"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $spesifikasi = htmlspecialchars($data["spesifikasi"]);
    $nama_kategori = htmlspecialchars($data["kategori"]);
    $nama_warna = $data["warna"];
    $pembuat = $data["pembuat"];

    $gambar = upload();
    if (!$gambar) {
        return false;
    }
    
    $query = "INSERT INTO produk
            (pembuat, nama_produk, stok, harga, deskripsi, spesifikasi, gambar)
            VALUES
            ('$pembuat', '$nama_produk', '$stok', '$harga', '$deskripsi', '$spesifikasi', '$gambar')
            ";
    mysqli_query($conn, $query);

    $id_produk = $conn->insert_id;

    $query = "INSERT INTO kategori
            (id_produk, nama_kategori)
            VALUES
            ('$id_produk', '$nama_kategori')
            ";
    mysqli_query($conn, $query);

    foreach ($nama_warna as $namWar) {
        global $conn;
        $query = "INSERT INTO warna
                (id_produk, nama_warna)
                VALUES
                ('$id_produk', '$namWar')
        ";
        mysqli_query($conn, $query);
    }

    return mysqli_affected_rows($conn);
};

function upload() {

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ( $error === 4 ) {
        echo "
            <script>
                alert('Pilih gambar terlebih dahulu')
            </script>
        ";
        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
            <script>
                alert('Yang anda aplod bukan gambar')
            </script>
        ";
        return false;
    }

    if ($ukuranFile > 10000000) {
        echo "
        <script>
            alert('Ukuran gambar terlalu besar')
        </script>
        ";
        return false;
    }

    $namaFIleBaru = uniqid();
    $namaFIleBaru .= '.';
    $namaFIleBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'gambar/' . $namaFIleBaru);

    return $namaFIleBaru;

}


function hapus($id_produk) {
    global $conn;
    mysqli_query($conn, "DELETE FROM produk WHERE id_produk = $id_produk");

    return mysqli_affected_rows($conn);
}


function edit($data) {
    global $conn;      

    $id_produk = $data["id_produk"];
    $nama_produk = htmlspecialchars($data["nama_produk"]);
    $stok = htmlspecialchars($data["stok"]);
    $harga = htmlspecialchars($data["harga"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $spesifikasi = htmlspecialchars($data["spesifikasi"]);
    $nama_kategori = htmlspecialchars($data["kategori"]);
    $nama_warna = $data["warna"];
    $id_warna = $data["id_warna"];
    $gambarLama = htmlspecialchars($data['gambarLama']);

    if ( $_FILES['gambar']['error'] === 4 ) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }


    $query = "UPDATE produk SET
                nama_produk = '$nama_produk',
                stok = '$stok',
                harga = '$harga',
                deskripsi = '$deskripsi',
                spesifikasi = '$spesifikasi',
                gambar = '$gambar'
             WHERE id_produk = $id_produk
            ";
    mysqli_query($conn, $query);

    $query = "UPDATE kategori SET
                nama_kategori = '$nama_kategori'
             WHERE id_produk = $id_produk
            ";
    mysqli_query($conn, $query);
    
    
    if (isset($data["warna"]) && isset($data["id_warna"])) {
        $warnaBaru = $data["warna"];
        $idWarna = $data["id_warna"];

        foreach ($warnaBaru as $key => $warna) {
            $id_warna = $idWarna[$key];

            $query = "UPDATE warna SET nama_warna = '$warna' WHERE id_warna = $id_warna";
            mysqli_query($conn, $query);

            // if (!$conn->query($query)) {
            //     echo "Error updating record: " . $conn->error;
            //     exit();
            // }

        }
    }

    // if (isset($_POST["warnaDihapus"])) {
    //     $warnaDihapus = $_POST["warnaDihapus"];

    //     foreach ($warnaDihapus as $id_warna) {
    //         $query = "DELETE FROM warna WHERE id_warna = $id_warna";
    //         mysqli_query($conn, $query);

    //         if (!$conn->query($query)) {
    //             echo "Error deleting record: " . $conn->error;
    //             exit();
    //         }
    //     }
    // }


    // if (isset($_POST["warnaBaru"])) {
    //     $tambahWarnaBaru = $_POST["warnaBaru"];

    //     foreach ($tambahWarnaBaru as $tambahWarna) {
    //         $query= "INSERT INTO warna (id_produk, nama_warna) VALUES ($id_produk, '$tambahWarna')";
    //         mysqli_query($conn, $query);

    //         if (!$conn->query($query)) {
    //             // echo "Error inserting new color: " . $conn->error;
    //             exit();
    //         }
    //     }
    // }

    return mysqli_affected_rows($conn);
}



function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $email =  htmlspecialchars($data["email"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $position = strtolower($data["sebagai"]);

    $result = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    if (mysqli_fetch_assoc($result)) {
        echo "
        <script>
        alert('email sudah terdaftar')
        </script>
        ";
        return false;
    }

    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "
        <script>
        alert('username sudah terdaftar')
        </script>
        ";
        return false;
    }
    
    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO users (username, email, password, posisi) VALUES ('$username', '$email', '$password', '$position')");

    return mysqli_affected_rows($conn);

}



function komentar ($data) {
    global $conn;

    $id_produk = $data["id_produk"];
    $pengguna = $data["pengguna"];
    $isi_komen = $data["komen"];

    $query = "INSERT INTO komentar
            (id_produk, pengguna, isi_komen)
            VALUES
            ('$id_produk', '$pengguna', '$isi_komen')
            ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}

function keranjang ($data) {
    global $conn;

    $id_produk = $data["add_keranjang"];

    // var_dump($id_produk);die;

    $result = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_produk = $id_produk");

    if (mysqli_num_rows($result) === 0) {

        $query = "INSERT INTO keranjang (id_produk) VALUES ($id_produk)";
        mysqli_query($conn, $query);
    
        return mysqli_affected_rows($conn);
    } else {
        echo "
            <script>
            alert('Barang sudah di keranjang')
            </script>
        ";
        return false;
    }


}


function hapusKeranjang($id_keranjang) {
    global $conn;
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = $id_keranjang");

    return mysqli_affected_rows($conn);
}



function cari ($keyword) {
    $query = "SELECT * FROM produk
                WHERE
            nama_produk LIKE '%$keyword%' OR
            stok LIKE '%$keyword%' OR
            harga LIKE '%$keyword%' OR
            pembuat LIKE '%$keyword%'
            ";

    return query($query);
}


?>
