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

    $judul  = $data["judul"];
    $penulis  = $data["penulis"];
    $penerbit  = $data["penerbit"];
    $tahun_terbit  = $data["tahun_terbit"];
    $kategori = $data["kategori"];

    $query = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, kategori)
              VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', '$kategori')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


// fungsi untuk menghapus data dari database
function hapus_data($id)
{
    global $conn;


    $query = "DELETE FROM buku WHERE id_buku= $id";


    $result = mysqli_query($conn, $query);


    return mysqli_affected_rows($conn);
}

// fungsi untuk mengubah data dari database
function ubah_data($data)
{
    global $conn;

    $id_buku = $data["id_buku"];
    $judul  = $data["judul"];
    $penulis  = $data["penulis"];
    $penerbit  = $data["penerbit"];
    $tahun_terbit  = $data["tahun_terbit"];
    $kategori = $data["kategori"];

    $query = "UPDATE buku SET
                judul = '$judul',
                penulis = '$penulis',
                penerbit = '$penerbit',
                tahun_terbit = '$tahun_terbit',
                kategori = '$kategori'
              WHERE id_buku = $id_buku
             ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}



// fungsi untuk mencari data
function search_data($keyword)
{
    $query = "SELECT * FROM buku
              WHERE
                judul LIKE '%$keyword%' OR
                penulis LIKE '%$keyword%' OR
                penerbit LIKE '%$keyword%' OR
                tahun_terbit LIKE '%$keyword%' OR
                kategori LIKE '%$keyword%'";
    return query($query);
}


// fungsi untuk register
function register($data){
    global $conn;


    $username = strtolower($data['username']);
    $email = $data['email'];
    $password = mysqli_real_escape_string($conn, $data['password']);
    $konfirmasi_password = mysqli_real_escape_string($conn, $data['confirm_password']);


// query untuk ngecek username yang diinputkan oleh user di database
    $query = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    $result = mysqli_fetch_assoc($query);


    if($result != NULL){
        return "Username sudah terdaftar!";
    }


    if($password != $konfirmasi_password){
        return "Konfirmasi password tidak sesuai!";
    }


// enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);


// tambahkan userbaru ke database
    mysqli_query($conn, "INSERT INTO user (username, email, password) VALUES('$username', '$email', '$password')");


    return true;
}

// fungsi untuk login
function login($data){
    global $conn;


    $username = $data['username'];
    $password = $data['password'];


    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);


    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);


        if(password_verify($password, $row['password'])){
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            return true;
        } else {
           
            return "Password salah!";
        }


    }else{
        return "Username tidak terdaftar!";
    }
}
?>