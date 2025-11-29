<?php
    require("function.php");


    $id = $_GET['id'];


    if(hapus_data($id) > 0){
        echo "
            <script>
                alert('Data berhasil dihapus dari database!');
                document.location.href = 'index.php';
            </script>
        ";
    }else{
        echo "
            <script>
                alert('Data gagal dihapus dari database!');
                document.location.href = 'index.php';
            </script>
        ";
    }
   
?>

