<?php

session_start();

require '../koneksi.php';



if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$pengguna = $_SESSION["username"];

$keyword = $_GET['keyword'];

$query = "SELECT * FROM produk
            WHERE
        nama_produk LIKE '%$keyword%' OR
        stok LIKE '%$keyword%' OR
        harga LIKE '%$keyword%' OR
        pembuat LIKE '%$keyword%'
        ";


$produk = query($query);

?>

<table id="konten">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Pembuat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produk as $produk) : ?>
                <tr>
                    <td><?= $produk['nama_produk'] ?></td>
                    <td><?= $produk['stok'] ?></td>
                    <td>Rp. <?= $produk['harga'] ?></td>
                    <td>
                        <img src="./gambar/<?= $produk['gambar'] ?>">
                    </td>
                    <td><?= $produk["pembuat"] ?></td>
                    <td>
                        <?php if ($pengguna == $produk["pembuat"]) : ?>
                        <div>
                            <a href="editProduk.php?id_produk=<?= $produk['id_produk'] ?>">
                                <button type="submit" name="edit" class="edit">Edit</button>
                            </a>
                            <a href="hapus.php?id_produk=<?= $produk['id_produk'] ?>" onclick="
                                return confirm('yakin?');">
                                <button type="submit" name="hapus" class="hapus">Hapus</button>
                            </a>
                        </div>
                        <?php else : ?>
                        <div>-</div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>