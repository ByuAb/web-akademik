
<?php
    if(!isset($_GET['page'])){
        include "../session_check.php";
    }

    if(isset($_GET['status'])){
        echo '<script>alert("Input Data Gagal")</script>';
    }
?>

<!-- Tabel Data Jadwal -->
<div class="tabel-page">
    <div class="tabel-heading">
        Data Jadwal Mengajar
    </div>
    <div class="search-box">
        <form method="get" action="#">
            <input type="hidden" name="page" value="jadwal_mengajar">
            <label for="fdosen">Dosen: <input list="dosen" name="dosen" type="text">
        </label>
        <datalist id="dosen">  
        <!-- Select Data Dosen -->
        <?php
        include "../config/db_connection.php";

        $sql = "SELECT * FROM dosen";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>
            <option value="<?php echo $row['ID_Dosen']?>">
                <?php echo $row['Nama_Dosen']?>
            </option>
        <?php
            }
        }
        ?>
        </datalist>
        <button class="button-input" id="myBtn" type="submit">
        <i class="fa fa-search" aria-hidden="true"></i>Search
        </button>
        </form>
    </div>
    <div class="data-result">
        <div class="button-container">
            <!-- <a href="admin_home_page.php?page=jadwal_input"> -->
            <button class="button-input" id="myBtn" onclick="show_modal(0)">
            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Data
            </button>
            <!-- </a> -->
        </div>
        <table id="list-data" class="display">
            <thead>
                <tr>
                <th><h5>Dosen</h5></th>
                <th><h5>Mata Kuliah</h5></th>
                <th><h5>Hari</h5></th>
                <th><h5>Waktu</h5></th>
                <th><h5>Ruangan</h5></th>
                <th><h5>Update</h5></th>
                <th><h5>Delete</h5></th>
                </tr>
            </thead>

            <!-- Ambil Data Dosen -->
            <?php
                $id_dosen = "'KO'";
                if(isset($_GET['dosen'])){
                    $id_dosen = "'".$_GET['dosen']."'";
                }

                $sql = "SELECT * FROM jadwal as j
                            INNER JOIN dosen as d ON j.ID_Dosen = d.ID_Dosen
                            INNER JOIN mata_kuliah as mk ON j.ID_Matkul = mk.ID_Matkul
                            INNER JOIN ruangan as r ON j.ID_Ruangan = r.ID_Ruangan
                            
                            ORDER BY FIELD(j.Hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')";

                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);


                if (mysqli_num_rows($result) > 0){
                    $i = 1;
                    while($row = mysqli_fetch_assoc($result)) {
            ?>
                    <!-- Tampil Data Dosen -->
                        <tr>
                            <td><?php echo $row["Nama_Dosen"];?></td>
                            <td><?php echo $row["Nama_Matkul"];?></td>
                            <td><?php echo $row["Hari"];?></td>
                            <td><?php echo $row["Jam_Masuk"]."-".$row["Jam_Keluar"];?></td>
                            <td><?php echo $row["Nama_Ruangan"];?></td>


                            <td>
                                <button class="button-edit" id="buttonEdit" onclick="show_modal(<?php echo $i?>)">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                    Update
                                </button>
                            </td>
                            <td>
                                <a href='javascript:hapusDataJadwal("<?php echo $row['ID_Jadwal']?>", "<?php echo $row['ID_Dosen']?>", 
                                "<?php echo $row['ID_Matkul']?>")'>
                                    <button class="button-delete">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                    </button>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Update -->
                        <div id="myModal<?php echo $i?>" class="modal">
                            <!-- Modal Content -->
                            <div class="modal-content">
                                <div class="modal-header">
                                <span class="close" id="close<?php echo $i?>">&times;</span>
                                <h2>Update Jadwal Mengeajar</h2>
                                <hr>
                                </div>
                                <div class="modal-body">
                                    <form name="input" method="post" action="jadwal/jadwal_mengajar_update.php">
                                        <!--ID JAdwal Sebemlumnya-->
                                        <input type="hidden" name="old_id" value="<?php echo $row['ID_Jadwal']?>">
                                        <input type="hidden" name="old_id_dosen" value="<?php echo $row['ID_Dosen']?>">
                                        <!--Nama Dosen-->
                                        <label for="fid">Nama Dosen</label>
                                        <input type="text" id="fid" value="<?php echo $row['ID_Dosen']?>" maxlength="7" required>
                                        <!--Nama Matkul-->
                                        <label for="fnama">Nama Mata Kuliah</label>
                                        <input type="text" id="fnama" value="<?php echo $row['Nama_Ruangan']?>" required>
                                        <!--Hari-->
                                        <label for="fnama">Hari</label>
                                        <input type="text" id="fnama" list="hari" name="hari" value="<?php echo $row['Hari']?>" required>
                                        <datalist id="hari">
                                            <option value="Senin"></option>
                                            <option value="Selasa"></option>
                                            <option value="Rabu"></option>
                                            <option value="Kamis"></option>
                                            <option value="Jumat"></option>
                                            <option value="Sabtu"></option>
                                        </datalist>
                                        <!--Ruangan-->
                                        <label for="fdosen">Ruangan <input list="ruangan" name="ruangan" type="text" value="
                                        <?php echo $row['ID_Ruangan']?>">
                                        </label>
                                        <datalist id="ruangan">
                                            <!--Select Data Ruangan-->
                                            <?php
                                            $sql_r = "SELECT * FROM ruangan";
                                            $result_r = mysqli_query($conn, $sql_r);
                                            if (mysqli_num_rows($result_r) > 0) {
                                                while($row_r = mysqli_fetch_assoc($result_r)) {
                                            ?>
                                                <option value="<?php echo $row_r['ID_Ruangan']?>">
                                                <?php echo $row_r['Nama_Ruangan']?>
                                            </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </datalist>
                                        <!--Jam-->
                                        <label for="fjam">Jam</label>
                                        <br>
                                        <input type="time" name="j_masuk" step="1" value="<?php echo $row['Jam_Masuk']?>"> -
                                        <input type="time" name="j_keluar" step="1" value="<?php echo $row['Jam_Keluar']?>">
                                        <input type="submit" value="Update">
                                    </form>
                                </div>
                            </div>
                        </div>
            <?php
                    $i++;
                    }
                }
                mysqli_close($conn);
            ?>
       
    </table>
    </div>
    <div style="clear: both;"></div>
</div>

<!-- GET Data Dosen, Matkul Ruangan -->
<?php
    include "../config/db_connection.php";
    //Dosen
    $sql_dosen = "SELECT * FROM dosen";
    $dosen = mysqli_query($conn, $sql_dosen);
    //Matakuliah
    $sql_matkul = "SELECT * FROM mata_kuliah";
    $matkul = mysqli_query($conn, $sql_matkul);
    //Ruangan
    $sql_r = "SELECT * FROM ruangan";
    $ruangan = mysqli_query($conn, $sql_r);
?>

<!-- Modal Input Data  -->
<div id="myModal0" class="modal">
    <!-- Modal Content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" id="close0">&times;</span>
            <h2>Input Jadwal Mengajar</h2>
            <hr>
        </div>
        <div class="modal-body">
            <form name="input" method="post" action="jadwal/jadwal_mengajar_input.php">
                <!-- Data Dosen -->
                <label for="fdosen">Dosen: <input type="text" name="dosen" list="dosen">
                </label>
                <datalist id="dosen">
                    <!-- Select data dosen -->
                    <?php
                    while($l_dosen = mysqli_fetch_assoc($dosen)) {
                    ?>
                    <option value="<?php echo $l_dosen['ID_Dosen']?>">
                        <?php echo $l_dosen['Nama_Dosen']?>
                    </option>
                    <?php
                    }
                    ?>
                </datalist>
                <!-- data matkul -->
                <label for="fmatkul">Mata Kuliah: <input list="matkul" name="matkul" type="text">
                </label>
                <datalist id="matkul">
                    <!-- Select data matkul -->
                    <?php
                    while($l_matkul = mysqli_fetch_assoc($matkul)) {
                    ?>
                    <option value="<?php echo $l_matkul['ID_Matkul']?>">
                        <?php echo $l_matkul['Nama_Matkul']?>
                    </option>
                    <?php
                    }
                    ?>
                </datalist>
                <!-- Data Ruangan -->
                <label for="fruangan">Ruangan: <input list="ruangan" name="ruangan" type="text">
                </label>
                <datalist id="ruangan">
                    <!-- Select data ruangan -->
                    <?php
                    while($l_r = mysqli_fetch_assoc($ruangan)) {
                    ?>
                    <option value="<?php echo $l_r['ID_Ruangan']?>">
                        <?php echo $l_r['Nama_Ruangan']?>
                    </option>
                    <?php
                    }
                    ?>
                </datalist>

                <!-- Data Hari -->
                <label for="hari">Hari: <input list="hari" name="hari" type="text">
                </label>
                <datalist>
                    <option value="Senin"></option>
                    <option value="Selasa"></option>
                    <option value="Rabu"></option>
                    <option value="Kamis"></option>
                    <option value="Jumat"></option>
                    <option value="Sabtu"></option>
                </datalist>
                <!-- Jam -->
                <label for="fjam">Jam</label>
                <br>
                <input type="time" name="j_masuk" step="1"> - <input type="time" name="j_keluar" step="1">
                <input type="submit" value="Input">
            </form>
        </div>
    </div>
</div>