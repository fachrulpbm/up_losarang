<?php
    include_once('koneksi.php');
?>

<form action="" method="post" name="form_satuan">

    <table align="center">

        <tr align="center">
            <td colspan=3>
                <h2>Satuan</h2>
                <a href="index.php">Home</a>
                <a href="satuan_konversi.php">Konversi</a>
            </td>
        </tr>

        <tr>
            <td>Kode Satuan</td>
            <td>:</td>
            <td>
                <input type="text" name="kd_satuan" id="kd_satuan">
            </td>
        </tr>

        <tr>
            <td>Nama Satuan</td>
            <td>:</td>
            <td>
                <input type="text" name="nm_satuan" id="nm_satuan">
            </td>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" name="btnSatuan" value="Simpan Satuan">
            </td>
        </tr>


    </table>

</form>

<?php

    /* SUBMIT */
    if(isset($_POST['btnSatuan'])){
        $kd_satuan = $_POST['kd_satuan'];
        $nm_satuan = $_POST['nm_satuan'];
        /* UPDATE */
        if(isset($_GET['aksi'])){
            $update = "UPDATE satuan SET nm_satuan='$nm_satuan' WHERE kd_satuan='$kd_satuan'";
            mysqli_query($koneksi, $update);
            header("Location: satuan.php");
        }
        /* INSERT */
        else{
            $insert = "INSERT INTO satuan(kd_satuan, nm_satuan) VALUES('$kd_satuan', '$nm_satuan')";
            mysqli_query($koneksi, $insert);
        }
    }
    /* END OF SUBMIT */

    /* DELETE */
    if( isset($_GET['kd_satuan']) && $_GET['aksi'] == 'hapus' ){
        
        $kode = $_GET['kd_satuan'];
        $delete = " DELETE FROM satuan WHERE kd_satuan='$kode' ";
        mysqli_query($koneksi, $delete);
        header('Location: satuan.php');

    }

    /* READ */
    $read = "SELECT * FROM satuan";
    $hasil_read = mysqli_query($koneksi, $read);
    echo "
        <table border=1 align='center'>
                <tr>
                    <th>Kode Satuan</th>
                    <th>Nama Satuan</th>
                    <th>Aksi</th>
                </tr>
    ";
    while($row = mysqli_fetch_array($hasil_read)){
        echo "
                <tr>
                    <td>".$row['kd_satuan']."</td>
                    <td>".$row['nm_satuan']."</td>
                    <td>
                        <a href='satuan.php?kd_satuan=".$row['kd_satuan']."&aksi=ubah'>Ubah</a>
                        <a href='satuan.php?kd_satuan=".$row['kd_satuan']."&aksi=hapus'>Hapus</a>
                    </td>
                </tr>
        ";
    }
    echo "</table>";
    /* END OF READ */

    /* GET DATA */
    if(isset($_GET['kd_satuan']) && $_GET['aksi'] == "ubah"){
        $kd_satuan = $_GET['kd_satuan'];
        $search = "SELECT * FROM satuan WHERE kd_satuan = '$kd_satuan'";
        $hasil_search = mysqli_query($koneksi, $search);
        $row = mysqli_fetch_array($hasil_search);
        $nm_satuan = $row['nm_satuan'];
?>
        <script>
            var kd_satuan = "<?php echo $kd_satuan ?>";
            var nm_satuan = "<?php echo $nm_satuan ?>";
            document.form_satuan.kd_satuan.value = kd_satuan;
            document.getElementById("nm_satuan").value = nm_satuan;
        </script>
<?php
    }
    /* END OF GET DATA */
?>