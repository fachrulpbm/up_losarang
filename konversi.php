<form action="" method="post" name="form_konversi">
    <table align="center">
        <tr align="center">
            <td colspan=3>
                <h4>Konversi Satuan</h4>
            </td>
        </tr>
        <tr>
             <td>Kode Satuan</td>
            <td>:</td>
            <td>
                <select name="kd_satuan" id="kd_satuan" style="width: 200px">
                    <option value="default">-- Pilih Satuan --</option>
                    <?php
                    $tampil_satuan = "SELECT * FROM satuan ORDER BY kd_satuan ASC";
                    $hasil = mysqli_query($koneksi, $tampil_satuan);
                    while ($row = mysqli_fetch_array($hasil)) {
                        echo "
                                <option value=" . $row['kd_satuan'] . ">" . $row['kd_satuan'] . "</option>
                           ";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Nilai Konversi</td>
            <td>:</td>
            <td>
                <input type="number" name="nilai_konversi" id="nilai_konversi" size="10" required>
            </td>  
        </tr>
        <tr>
            <td>Kode Konversi</td>
            <td>:</td>
            <td>
                <input type="text" name="kd_konversi" size="20" required>
            </td>
        </tr>
        <tr>
            <td>Nama konversi</td>
            <td>:</td>
            <td>
                <input type="text" name="nm_konversi" id="nm_konversi" size="30" required>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" value="Simpan Konversi" name="btnKonversi">
            </td>
        </tr>
    </table>
</form>

<br>

<form action="" method="post">
     <table align="center" width="720px" style="margin-bottom: 10px">
         <tr align="left">
             <td>
                 Cari Konversi:
                 <input type="text" name="cari" size="20">
                 <input type="submit" name="btnCari" value="Cari">
             </td>
         </tr>
     </table>
 </form>

<?php

    /* SUBMIT */
    if (isset($_POST['btnKonversi'])) {
        $kd_konversi = $_POST['kd_konversi'];
        $kd_satuan = $_POST['kd_satuan'];
        $nilai_konversi = $_POST['nilai_konversi'];
        $nm_konversi = $_POST['nm_konversi'];

        /* UPDATE */
        if (isset($_GET['aksi'])) {
            $update = "UPDATE satuan_konversi SET kd_satuan='$kd_satuan', nilai_konversi='$nilai_konversi', nm_konversi='$nm_konversi' WHERE kd_konversi='$kd_konversi'";
            mysqli_query($koneksi, $update);
            header("Location: index.php?menu=konversi");
        }
        /* INSERT */ else {
            $insert = "INSERT INTO satuan_konversi(kd_konversi, kd_satuan, nilai_konversi, nm_konversi) VALUES('$kd_konversi', '$kd_satuan', '$nilai_konversi', '$nm_konversi')";
            mysqli_query($koneksi, $insert);
            if (!$insert) {
                trigger_error('Invalid query: ' . $koneksi->error);
            }
        }
    }
    /* END OF SUBMIT */


    /* DELETE */
    if (isset($_GET['kd_konversi']) && $_GET['aksi'] == 'hapus') {
        $kode = $_GET['kd_konversi'];
        $delete = " DELETE FROM satuan_konversi WHERE kd_konversi='$kode' ";
        mysqli_query($koneksi, $delete);
        header('Location: index.php?menu=konversi');
    }
    /* END OF DELETE */

    /* READ */
    echo "
        <table border='1' class='data' align='center' width='720px'>
            <tr>
                <th class='data-td'>Kode Satuan</th>
                <th class='data-td' width='8%'>Nilai Konversi</th>
                <th class='data-td'>Kode Konversi</th>
                <th class='data-td'>Nama Konversi</th>
                <th class='data-td' width='13%'>Aksi</th>
            </tr>
        ";
    if (isset($_POST['cari']) && $_POST['btnCari']) {
        $cari = $_POST['cari'];
        $read = "SELECT * FROM satuan_konversi WHERE kd_konversi LIKE '%$cari%' OR nm_konversi LIKE '%$cari%'";
    } else {
        $read = "SELECT * FROM satuan_konversi";
    }
    $data = mysqli_query($koneksi, $read);

    if (!$data) {
        trigger_error('Invalid query: ' . $koneksi->error);
    }
    if ($data->num_rows > 0) {
        while ($row = mysqli_fetch_array($data)) {
            echo "
                    <tr>
                        <td class='data-td'>" . $row['kd_satuan'] . "</td>
                        <td class='data-td'>" . $row['nilai_konversi'] . "</td>
                        <td class='data-td'>" . $row['kd_konversi'] . "</td>
                        <td class='data-td'>" . $row['nm_konversi'] . "</td>
                        <td class='data-td' align='center'>
                            <a href='index.php?menu=konversi&kd_konversi=" . $row['kd_konversi'] . "&aksi=ubah'>Ubah</a>
                            <a href='index.php?menu=konversi&kd_konversi=" . $row['kd_konversi'] . "&aksi=hapus'>Hapus</a>
                        </td>
                    </tr>
                ";
        }
    } else {
        echo "
                <tr style='padding: 20px'>
                    <td colspan='5' align='center'>
                        <i>Data tidak ada!</i>
                    </td>
                </tr>
            ";
    }
    echo "</table>";
    /* END OF READ */

    /* GET DATA */
    if (isset($_GET['kd_konversi']) && $_GET['aksi'] == "ubah") {
        $kd_konversi = $_GET['kd_konversi'];
        $search = "SELECT * FROM satuan_konversi WHERE kd_konversi = '$kd_konversi'";
        $hasil_search = mysqli_query($koneksi, $search);
        $row = mysqli_fetch_array($hasil_search);
        $kd_satuan = $row['kd_satuan'];
        $nilai_konversi = $row['nilai_konversi'];
        $nm_konversi = $row['nm_konversi'];
        ?>
     <script>
         var kd_konversi = "<?php echo $kd_konversi ?>";
         var kd_satuan = "<?php echo $kd_satuan ?>";
         var nilai_konversi = "<?php echo $nilai_konversi ?>";
         var nm_konversi = "<?php echo $nm_konversi ?>";
         document.form_konversi.kd_konversi.value = kd_konversi;
         document.form_konversi.kd_konversi.readOnly = true;
         
         document.form_konversi.kd_satuan.value = kd_satuan;
         document.form_konversi.nilai_konversi.value = nilai_konversi;
         document.form_konversi.nm_konversi.value = nm_konversi;
     </script>
 <?php
    }
    /* END OF GET DATA */
    ?>