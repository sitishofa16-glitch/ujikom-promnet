<?php
// Koneksi ke Database
$conn = mysqli_connect("localhost", "root", "", "ujikom");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// fungsi untuk menampilkan data dari database
function query($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


// fungsi untuk menambahkan data ke database
function tambah_data($data){
    global $conn;

    $judul        = mysqli_real_escape_string($conn, $data["judul"]);
    $penulis      = mysqli_real_escape_string($conn, $data["penulis"]);
    $penerbit     = mysqli_real_escape_string($conn, $data["penerbit"]);
    $tahun_terbit = mysqli_real_escape_string($conn, $data["tahun_terbit"]);
    $id_kategori = mysqli_real_escape_string($conn, $data["id_kategori"]);
    // pastikan form mengirim name="id_kategori"
    $id_kategori  = isset($data["id_kategori"]) ? (int)$data["id_kategori"] : "NULL";

    $query = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, id_kategori)
              VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', " . ($id_kategori === "NULL" ? "NULL" : $id_kategori) . ")";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


// fungsi untuk menghapus data dari database
function hapus_data($id)
{
    global $conn;

    $id = (int)$id;
    $query = "DELETE FROM buku WHERE id_buku = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// fungsi untuk mengubah data dari database
function ubah_data($data)
{
    global $conn;

    $id_buku = $data['id_buku'];
    $judul = $data['judul'];
    $penulis = $data['penulis'];
    $penerbit = $data['penerbit'];
    $tahun_terbit = $data['tahun_terbit'];
    $id_kategori = $data['id_kategori'];


    $query = "UPDATE buku SET
                judul = '$judul',
                penulis = '$penulis',
                penerbit = '$penerbit',
                tahun_terbit = '$tahun_terbit',
                id_kategori = '$id_kategori'
              WHERE id_buku = $id
             ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


// fungsi untuk mencari data (mencari juga lewat nama_kategori)
function search_data($keyword)
{
    global $conn;
    $kw = mysqli_real_escape_string($conn, $keyword);

    $query = "SELECT buku.*, kategori.nama_kategori
              FROM buku
              LEFT JOIN kategori ON buku.id_kategori = kategori.id_kategori
              WHERE
                buku.judul LIKE '%$kw%' OR
                buku.penulis LIKE '%$kw%' OR
                buku.penerbit LIKE '%$kw%' OR
                buku.tahun_terbit LIKE '%$kw%' OR
                kategori.nama_kategori LIKE '%$kw%'";

    return query($query);
}


// fungsi untuk register
function register($data){
    global $conn;

    $username = strtolower(mysqli_real_escape_string($conn, $data['username']));
    $email = mysqli_real_escape_string($conn, $data['email']);
    $password = mysqli_real_escape_string($conn, $data['password']);
    $konfirmasi_password = mysqli_real_escape_string($conn, $data['confirm_password']);

    // cek username sudah ada atau belum
    $cek = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if(mysqli_fetch_assoc($cek) != NULL){
        return "Username sudah terdaftar!";
    }

    if($password != $konfirmasi_password){
        return "Konfirmasi password tidak sesuai!";
    }

    // enkripsi password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user (username, email, password) VALUES('$username', '$email', '$password_hash')");

    return true;
}

// fungsi untuk login
function login($data){
    global $conn;

    $username = mysqli_real_escape_string($conn, $data['username']);
    $password = $data['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row['password'])){
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            return true;
        } else {
            return "Password salah!";
        }
    } else {
        return "Username tidak terdaftar!";
    }
}
?>
