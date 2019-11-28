<form action="" method="post" name="form_pemasukan">
    <table align="center">
        <tr align="center">
            <td colspan=3>
                <h4>Master Pemasukan</h4>
            </td>
        </tr>
        <tr>
           <td>Kode Pemasukan</td>
            <td>:</td>
            <td>
                <input type="text" name="kd_pemasukan" size="20" required>
            </td>   
        </tr>
        <tr>
            <td>Nama Pemasukan</td>
            <td>:</td>
            <td>
                <input type="text" name="nm_pemasukan" size="30" required>
            </td>  
           
       </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" value="Simpan Pemasukan" name="btnpemasukan">
            </td>
        </tr>
    </table>
</form>

<br>


<form action="" method="post">
     <table align="center" width="720px" style="margin-bottom: 10px">
         <tr align="left">
             <td>
                 Cari Pemasukan:
                 <input type="text" name="cari" size="20">
                 <input type="submit" name="btnCari" value="Cari">
             </td>
             <td align="right">
                <a href="index.php?menu=cetakpemasukan">Export ke Excel</a>
             </td>
         </tr>
     </table>
 </form>

<?php

    /* SUBMIT */
    if (isset($_POST['btnpemasukan'])) {
        $kd_pemasukan = $_POST['kd_pemasukan'];
        $nm_pemasukan = $_POST['nm_pemasukan'];
       

        /* UPDATE */
        if (isset($_GET['aksi'])) {
            $update = "UPDATE pemasukan SET nm_pemasukan='$nm_pemasukan' WHERE kd_pemasukan='$kd_pemasukan'";
            mysqli_query($koneksi, $update);
            header("Location: index.php?menu=masterpemasukan");
        }
        /* INSERT */ else {
            $insert = "INSERT INTO pemasukan(kd_pemasukan, nm_pemasukan) VALUES('$kd_pemasukan','$nm_pemasukan')";
            mysqli_query($koneksi, $insert);
            if (!$insert) {
                trigger_error('Invalid query: ' . $koneksi->error);
            }
        }
    }
    /* END OF SUBMIT */

    /* DELETE */
    if (isset($_GET['kd_pemasukan']) && $_GET['aksi'] == 'hapus') {
        $kode = $_GET['kd_pemasukan'];
        $delete = " DELETE FROM pemasukan WHERE kd_pemasukan='$kode' ";
        mysqli_query($koneksi, $delete);
        header('Location: index.php?menu=masterpemasukan');
    }
    /* END OF DELETE */

    /* READ */
    echo "
        <table border='1' class='data' align='center' width='720px'>
            <tr>
                <th class='data-td'>Kode Pemasukan</th>
                <th class='data-td'>Nama Pemasukan</th>
                <th class='data-td' width='13%'>Aksi</th>
            </tr>
        ";
    if (isset($_POST['cari']) && $_POST['btnCari']) {
        $cari = $_POST['cari'];
        $read = "SELECT * FROM pemasukan WHERE kd_pemasukan LIKE '%$cari%' OR nm_pemasukan LIKE '%$cari%'";
    } else {
        $read = "SELECT * FROM pemasukan";
    }
    $data = mysqli_query($koneksi, $read);

    if (!$data) {
        trigger_error('Invalid query: ' . $koneksi->error);
    }
    if ($data->num_rows > 0) {
        while ($row = mysqli_fetch_array($data)) {
            echo "
                    <tr>
                        <td class='data-td'>" . $row['kd_pemasukan'] . "</td>
                        <td class='data-td'>" . $row['nm_pemasukan'] . "</td>
                        <td class='data-td' align='center'>
                            <a href='index.php?menu=masterpemasukan&kd_pemasukan=" . $row['kd_pemasukan'] . "&aksi=ubah'>Ubah</a>
                            <a href='index.php?menu=masterpemasukan&kd_pemasukan=" . $row['kd_pemasukan'] . "&aksi=hapus'>Hapus</a>
                        </td>
                    </tr>
                ";
        }
    } else {
        echo "
                <tr style='padding: 20px'>
                    <td colspan='3' align='center'>
                        <i>Data tidak ada!</i>
                    </td>
                </tr>
            ";
    }
    echo "</table>";
    /* END OF READ */

    /* GET DATA */

    if (isset($_GET['kd_pemasukan']) && $_GET['aksi'] == "ubah") {

        $kd_pemasukan = $_GET['kd_pemasukan'];
        
        $search = "SELECT * FROM pemasukan WHERE kd_pemasukan = '$kd_pemasukan'";
        $hasil_search = mysqli_query($koneksi, $search);
        $row = mysqli_fetch_array($hasil_search);
        $nm_pemasukan = $row['nm_pemasukan'];
        ?>
     <script>
         var kd_pemasukan = "<?php echo $kd_pemasukan ?>";
         var nm_pemasukan = "<?php echo $nm_pemasukan ?>";
         document.form_pemasukan.kd_pemasukan.value = kd_pemasukan;
         document.form_pemasukan.kd_pemasukan.readOnly = true;
         document.form_pemasukan.nm_pemasukan.value = nm_pemasukan;
    </script>
 <?php
    }
    /* END OF GET DATA */
    ?>