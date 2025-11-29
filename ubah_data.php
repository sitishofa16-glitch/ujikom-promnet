<?php


    require("function.php");


    $id = $_GET['id'];


    $query = query("
    SELECT b.*, k.nama_kategori 
    FROM buku b
    LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
    WHERE b.id_buku = $id
")[0];

    
    $buku = $query;


    // ketika tombol submit nya di klik
    if(isset($_POST['tombol_submit'])){
       
        if(ubah_data($_POST) > 0){
            echo "
                <script>
                    alert('Data berhasil diubah di database!');
                    document.location.href = 'index.php';
                </script>
            ";
        }else{
            echo "
                <script>
                    alert('Data gagal diubah di database!');
                    document.location.href = 'index.php';
                </script>
            ";
        }


    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>


    <!-- NAVBAR SECTION START  -->
    <nav class="navbar navbar-expand-lg navbar-light white bg-danger">
        <div class="container">
            <a class="navbar-brand text-white" href="#">SIMBS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active text-white" aria-current="page" href="#">Data buku</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <!-- NAVBAR SECTION END  -->
   
    <div class="p-4 container">
        <div class="row">
            <h1 class="mb-2">Ubah Data buku</h1>
            <a href="index.php" class="mb-2">Kembali</a>
            <div class="col-md-6">
                <!-- <form action="" method="POST" enctype="multipart/form-data"> -->
               <form action="" method="POST">
    <input type="hidden" name="id_buku" value="<?= $buku['id_buku'] ?>">

    <div class="mb-3">
        <label class="form-label fw-bold">Judul</label>
        <input type="text" class="form-control" name="judul" value="<?= $buku['judul'] ?>" autocomplete="off">
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Penulis</label>
        <input type="text" class="form-control" name="penulis" value="<?= $buku['penulis'] ?>" autocomplete="off">
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Penerbit</label>
        <input type="text" class="form-control" name="penerbit" value="<?= $buku['penerbit'] ?>" autocomplete="off">
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Tahun Terbit</label>
        <input type="text" class="form-control" name="tahun_terbit" value="<?= $buku['tahun_terbit'] ?>" autocomplete="off">
    </div>

        <div class="mb-3">
        <label class="form-label fw-bold">Kategori</label>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="">Fiksi</option>
                        <option value="">Non-Fiksi</option>
                        <option value="">Pendidikan</option>
                        <option value="">Teknologi</option>
                        <option value="">Bisnis</option>
                        <option value="">Kesehatan</option>
                        <option value="">Agama</option>
                        <option value="">Anak-anak</option>
                        <option value="">Komik</option>
                        <option value="">Referensi</option>
                        <?php foreach ($kategori as $row): ?>
                            <option value="<?= $row['id_kategori']; ?>" <?= $row['id_kategori'] == $buku['id_kategori'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($row['nama_kategori']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
    </div>


    <div class="mb-3">
        <button type="submit" name="tombol_submit" class="btn-sm btn-primary">Submit</button>
    </div>
</form>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
