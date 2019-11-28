<form action="" method="post" name="form_pengeluaran">
    <table align="center">
        <tr align="center">
            <td colspan=3>
                <h4>Master Pengeluaran</h4>
            </td>
        </tr>
        <tr>
           <td>Kode Pengeluaran</td>
            <td>:</td>
            <td>
                <input type="text" name="kd_pengeluaran" size="20" required>
            </td>   
        </tr>
        <tr>
            <td>Nama Pengeluaran</td>
            <td>:</td>
            <td>
                <input type="text" name="nm_pengeluaran" size="30" required>
            </td>  
           
       </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" value="Simpan Pengeluaran" name="btnpengeluaran">
            </td>
        </tr>
    </table>
</form>

<br>

<form action="" method="post">
     <table align="center" width="720px" style="margin-bottom: 10px">
         <tr align="left">
             <td>
                 Cari Pengeluaran:
                 <input type="text" name="cari" size="20">
                 <input type="submit" name="btnCari" value="Cari">
             </td>
             <td align='right'>
                 <a href='index.php?menu=cetakpengeluaran'>Export ke Excel</a>
             </td>
         </tr>
     </table>
 </form>

<?php

    /* SUBMIT */
    if (isset($_POST['btnpengeluaran'])) {
        $kd_pengeluaran = $_POST['kd_pengeluaran'];
        $nm_pengeluaran = $_POST['nm_pengeluaran'];

        /* UPDATE */
        if (isset($_GET['aksi'])) {
            $update = "UPDATE pengeluaran SET nm_pengeluaran='$nm_pengeluaran' WHERE kd_pengeluaran='$kd_pengeluaran'";
            mysqli_query($koneksi, $update);
            header("Location: index.php?menu=masterpengeluaran");
        }
        /* INSERT */
        else {
            $insert = "INSERT INTO pengeluaran(kd_pengeluaran, nm_pengeluaran) VALUES('$kd_pengeluaran','$nm_pengeluaran')";
            mysqli_query($koneksi, $insert);
            if (!$insert) {
                trigger_error('Invalid query: ' . $koneksi->error);
            }
        }
    }
    /* END OF SUBMIT */

    /* DELETE */
    if (isset($_GET['kd_pengeluaran']) && $_GET['aksi'] == 'hapus') {
        $kode = $_GET['kd_pengeluaran'];
        $delete = " DELETE FROM pengeluaran WHERE kd_pengeluaran='$kode' ";
        mysqli_query($koneksi, $delete);
        header('Location: index.php?menu=masterpengeluaran');
    }
    /* END OF DELETE */

    /* READ */
    echo "
        <table border='1' class='data' align='center' width='720px'>
            <tr>
                <th class='data-td'>Kode Pengeluaran</th>
                <th class='data-td'>Nama Pengeluaran</th>
                <th class='data-td' width='13%'>Aksi</th>
            </tr>
        ";
    if (isset($_POST['cari']) && $_POST['btnCari']) {
        $cari = $_POST['cari'];
        $read = "SELECT * FROM pengeluaran WHERE kd_pengeluaran LIKE '%$cari%' OR nm_pengeluaran LIKE '%$cari%'";
    } else {
        $read = "SELECT * FROM pengeluaran";
    }
    $data = mysqli_query($koneksi, $read);

    if (!$data) {
        trigger_error('Invalid query: ' . $koneksi->error);
    }
    if ($data->num_rows > 0) {
        while ($row = mysqli_fetch_array($data)) {
            echo "
                    <tr>
                        <td class='data-td'>" . $row['kd_pengeluaran'] . "</td>
                        <td class='data-td'>" . $row['nm_pengeluaran'] . "</td>
                        <td class='data-td' align='center'>
                            <a href='index.php?menu=masterpengeluaran&kd_pengeluaran=" . $row['kd_pengeluaran'] . "&aksi=ubah'>Ubah</a>
                            <a href='index.php?menu=masterpengeluaran&kd_pengeluaran=" . $row['kd_pengeluaran'] . "&aksi=hapus'>Hapus</a>
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

    if (isset($_GET['kd_pengeluaran']) && $_GET['aksi'] == "ubah") {

        $kd_pengeluaran = $_GET['kd_pengeluaran'];
        
        $search = "SELECT * FROM pengeluaran WHERE kd_pengeluaran = '$kd_pengeluaran'";
        $hasil_search = mysqli_query($koneksi, $search);
        $row = mysqli_fetch_array($hasil_search);
        $nm_pengeluaran = $row['nm_pengeluaran'];
        ?>
     <script>
         var kd_pengeluaran = "<?php echo $kd_pengeluaran ?>";
         var nm_pengeluaran = "<?php echo $nm_pengeluaran ?>";
         document.form_pengeluaran.kd_pengeluaran.value = kd_pengeluaran;
         document.form_pengeluaran.kd_pengeluaran.readOnly = true;
         document.form_pengeluaran.nm_pengeluaran.value = nm_pengeluaran;
    </script>
 <?php
    }
    /* END OF GET DATA */
    ?>