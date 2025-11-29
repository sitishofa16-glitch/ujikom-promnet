<?php
  //setiap data yang berada di dalam function akan terintegrasi dengan index.php  
 require("function.php");
    session_start();
    //tambahkan session disetiap awal bagian file yang tidak bisa ditembak
    if(!isset($_SESSION["login"]) ) {
        header("Location: login.php");
        exit;
    }




// koneksi ke database
// var conn = fungsi koneksi("nama_host", "username", "password", "nama_db");
// cara cek username di db mysql dengan CMD --> select user();

// pagination
    // konfigurasi
    $jumlahDataPerHalaman = 4;
    $jumlahData = count(query("SELECT * FROM buku"));
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    $halamanAktif = ( isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;
    $awalData = ( $jumlahDataPerHalaman * $halamanAktif ) - $jumlahDataPerHalaman;

    $buku = query("
    SELECT * FROM buku
    JOIN kategori ON buku.id_kategori = kategori.id_kategori
");

    if(isset($_POST['tombol_search'])){
       
    $buku = search_data($_POST['keyword']);}




    $data_buku = query("SELECT * FROM buku LIMIT $awalData, $jumlahDataPerHalaman");



$query = query("SELECT * FROM buku");
$data_buku = $query;


if (isset($_POST['tombol_search'])) {

    $judul = search_data($_POST['keyword']);
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi PHP MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>


    <!-- NAVBAR SECTION START  -->
    <nav class="navbar navbar-expand-lg navbar-light white bg-danger">
        <div class="container">
            <a class="navbar-brand text-white" href="#"> SIMBS </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="#">Data Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Link</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- NAVBAR SECTION END  -->

    <!-- CONTENT SECTION START -->
    <section class="p-3">
        <div class="container">

            <h1>Halo, Selamat Datang <?=$_SESSION['username']?></h1>

            <a href="logout.php">logout</a>

            <h1> Data Buku</h1>

            <div class="d-flex justify-content-between align-items-center">
                <a href="tambah_data.php">
                    <button class="mb-2 btn-sm btn-primary">Tambah Data</button>
                </a>

                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                            <!-- Tombol Previous -->
                        <?php if ($halamanAktif > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>">&laquo;</a>
                            </li>
                        <?php endif; ?>


                        <!-- Daftar halaman -->
                        <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                            <?php if ($i == $halamanAktif) : ?>
                                <li class="page-item active">
                                    <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                                </li>
                            <?php else : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>


                        <!-- Tombol Next -->
                        <?php if ($halamanAktif < $jumlahHalaman) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>



                <form class="mb-2" action="" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" placeholder="Cari buku..." autocomplete="off">
                        <button class="btn btn-primary" type="submit" name="tombol_search">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>

            <table class="table table-striped table-hover">
                <tr>
                    <th>No.</th>
                    <th>Id Buku</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
                <?php $no = 1 ?>
                <?php foreach ($data_buku as $data): ?>
                    <tr>
                        <td> <?= $no ?> </td>
                        <td> <?= $data['id_buku'] ?> </td>
                        <td> <?= $data['judul'] ?> </td>
                        <td> <?= $data['penulis'] ?> </td>
                        <td> <?= $data['penerbit'] ?> </td>
                        <td> <?= $data['tahun_terbit'] ?> </td>
                        <td> <?= $data['nama_kategori'] ?> </td>
                        <td>
                            <a href="ubah_data.php?id=<?= $data['id_buku'] ?>">
                                <button class="btn-sm btn-success">Edit</button>
                            </a>


                            <a href="hapus_data.php?id=<?= $data['id_buku'] ?>">
                                <button class="btn-sm btn-danger">Hapus</button>
                            </a>
                        </td>


                    </tr>
                    <?php $no++; ?>
                <?php endforeach; ?>
            </table>




        </div>
    </section>
    <!-- CONTENT SECTION END -->




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>