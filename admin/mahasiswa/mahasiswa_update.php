<?php
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $tingkat = $_POST['tingkat'];
    $alamat = $_POST['alamat'];

    include "../../config/db_connection.php";

    $query = "UPDATE mahasiswa SET Nama_Mhs='$nama', Tingkat='$tingkat', Alamat='$alamat' WHERE NIM='$nim'";

    $res = $conn->query($query);

    if($conn->affected_rows > 0){
        header("location:../admin_home_page.php?page=mahasiswa");
    }
    else{
        header("location:../admin_home_page.php?page=mahasiswa&status=error");
    }
?>