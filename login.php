<?php

    session_start();
    if( isset($_SESSION["login"]) ) {
        header("Location: login.php");
        exit;
    }


    require("function.php");


    $error = "";
    if(isset($_POST['tombol_login'])){
       
        if(login($_POST) == 1){
            header("Location: index.php");
            exit;
        }else{
            $error = login($_POST);
        }
     
    }


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>


    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
        body {
            background: #5493e4ff;
        }
        .login-card {
            margin-top: 25%;
            padding: 30px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 4px 18px white(0,0,0,0.1);
        }
    </style>
</head>
<body>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">


            <div class="login-card">


                <h3 class="text-center mb-4">Login</h3>


                <?php if($error) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>


                <form action="" method="POST">


                    <!-- Nama Lengkap -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan usernama..." autocomplete="off" required>
                    </div>


                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password..." autocomplete="off" required>
                    </div>


                    <!-- Tombol Register -->
                    <button type="submit" name="tombol_login" class="btn btn-primary w-100">Login</button>
                    <p class="mt-2">Sudah punya akun? <a href="register.php">Register</a></p>
                </form>


            </div>


        </div>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>


