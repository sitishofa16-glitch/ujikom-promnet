<?php
//setiap data yang berada di dalam function akan terintegrasi dengan index.php  
require("function.php");
session_start();
//tambahkan session disetiap awal bagian file yang tidak bisa ditembak
if(!isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

// Koneksi ke database sudah di function.php

// Pagination & Search Logic
$jumlahDataPerHalaman = 4;
$halamanAktif = (isset($_GET["halaman"])) ? (int)$_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';

if($keyword != '') {
    // Search mode
    $data_buku = search_data($keyword);
    $jumlahData = count($data_buku);
} else {
    // Normal pagination mode dengan JOIN kategori
    $data_buku = query("
    SELECT b.*, k.nama_kategori
    FROM buku b
    LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
    LIMIT $awalData, $jumlahDataPerHalaman
");

    $jumlahData = count(query("SELECT b.*, k.nama_kategori 
                              FROM buku b 
                              LEFT JOIN kategori k ON b.id_kategori = k.id_kategori"));
}
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

// Buat URL pagination dengan keyword jika search aktif
$param_url = $keyword ? "&keyword=" . urlencode($keyword) : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi PHP MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- NAVBAR SECTION START  -->
    <nav class="navbar navbar-expand-lg navbar-light bg-danger">
        <div class="container">
            <a class="navbar-brand text-white" href="#"> SIMBS </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="#">Data Buku</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- NAVBAR SECTION END  -->

    <!-- CONTENT SECTION START -->
    <section class="p-3">
        <div class="container">
            <h1>Halo, Selamat Datang <?= $_SESSION['username'] ?></h1>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>

            <h1>Data Buku</h1>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="tambah_data.php">
                    <button class="btn btn-primary btn-sm">Tambah Data</button>
                </a>

                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <!-- Tombol Previous -->
                        <?php if ($halamanAktif > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?halaman=<?= $halamanAktif - 1 ?><?= $param_url ?>">«</a>
                            </li>
                        <?php endif; ?>

                        <!-- Daftar halaman -->
                        <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                            <?php if ($i == $halamanAktif) : ?>
                                <li class="page-item active">
                                    <a class="page-link" href="?halaman=<?= $i ?><?= $param_url ?>"><?= $i ?></a>
                                </li>
                            <?php else : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?halaman=<?= $i ?><?= $param_url ?>"><?= $i ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <!-- Tombol Next -->
                        <?php if ($halamanAktif < $jumlahHalaman) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?halaman=<?= $halamanAktif + 1 ?><?= $param_url ?>">»</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

                <!-- Search Form -->
                <form class="mb-2" action="" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" value="<?= htmlspecialchars($keyword) ?>" 
                               placeholder="Cari buku..." autocomplete="off">
                        <button class="btn btn-primary" type="submit" name="tombol_search">
                            Cari
                        </button>
                        <?php if($keyword): ?>
                            <a href="?" class="btn btn-secondary">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Info hasil pencarian -->
            <?php if($keyword): ?>
                <div class="alert alert-info">
                    Menampilkan <?= count($data_buku) ?> hasil untuk "<strong><?= htmlspecialchars($keyword) ?></strong>"
                </div>
            <?php endif; ?>

            <!-- Tabel Data Buku -->
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID Buku</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($data_buku)): ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data ditemukan</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = ($halamanAktif - 1) * $jumlahDataPerHalaman + 1; ?>
                        <?php foreach ($data_buku as $data): ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= htmlspecialchars($data['id_buku']) ?></td>
                                <td><?= htmlspecialchars($data['judul']) ?></td>
                                <td><?= htmlspecialchars($data['penulis']) ?></td>
                                <td><?= htmlspecialchars($data['penerbit']) ?></td>
                                <td><?= htmlspecialchars($data['tahun_terbit']) ?></td>
                                <td><?= htmlspecialchars($data['nama_kategori'] ?? 'Tidak ada kategori') ?></td>
                                <td>
                                    <a href="ubah_data.php?id=<?= $data['id_buku'] ?>" class="btn btn-success btn-sm">Edit</a>
                                    <a href="hapus_data.php?id=<?= $data['id_buku'] ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Yakin hapus data?')">Hapus</a>
                                </td>
                            </tr>
                            <?php $no++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- CONTENT SECTION END -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
