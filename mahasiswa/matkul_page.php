






<!-- rabel data matkul -->
<div class="tabel-page">
    <div class="tabel-heading">
        Daftar Matakuliah Yang Diambil
    </div>
    <table id="list-data" class="display">
        <thead>
            <tr>
                <th><h5>Kode Matkul</h5></th>
                <th><h5>Nama Matkul</h5></th>
                <th><h5>SKS</h5></th>
                <th><h5>Semester</h5></th>
            </tr>
        </thead>
        <!-- Ambil data matkul -->
        <?php
            include "../config/db_connection.php";

            $sql = "SELECT * FROM nilai as n
                    INNER JOIN mata_kuliah as mk ON n.ID_Matkul = mk.ID_Matkul AND n.NIM = ".$_SESSION['nim'];


            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
        ?>  
                <!-- Tampil data matkul -->
                <tr>
                    <td><?php echo $row["ID_Matkul"];?></td>
                    <td><?php echo $row["Nama_Matkul"];?></td>
                    <td><?php echo $row["SKS_Matkul"];?></td>
                    <td><?php echo $row["Semester"];?></td>
                </tr>
        <?php
                }
            }
            else {
                echo "0 results";
            }
            mysqli_close($conn);
        ?>
    </table>
</div>