 <?php
    include_once('koneksi.php');
 ?>
 <form action="" method="post" name="form_satuan">
     <table align="center">
         <tr align="center">
             <td colspan=3>
                 <h4>Satuan</h4>
             </td>
         </tr>
         <tr>
             <td>Kode Satuan</td>
             <td>:</td>
             <td>
                 <input type="text" name="kd_satuan" id="kd_satuan" size="5">
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

 <br>

 <form action="index.php?menu=satuan&" method="get">
     <table align="center" width="600px" style="margin-bottom: 10px">
         <tr align="left">
             <td>
                 Cari Satuan:
                 <input type="text" name="cari_satuan" id="txtCari" size="30" placeholder="Masukkan kode atau nama satuan">
                 <input type="submit" value="Cari" name="btnCari">
             </td>
         </tr>
     </table>
 </form>

 <?php

    /* SUBMIT */
    if (isset($_POST['btnSatuan'])) {
        $kd_satuan = $_POST['kd_satuan'];
        $nm_satuan = $_POST['nm_satuan'];
        /* UPDATE */
        if (isset($_GET['aksi'])) {
            $update = "UPDATE satuan SET nm_satuan='$nm_satuan' WHERE kd_satuan='$kd_satuan'";
            mysqli_query($koneksi, $update);
            header("Location: index.php?menu=satuan");
        }
        /* INSERT */ else {
            $insert = "INSERT INTO satuan(kd_satuan, nm_satuan) VALUES('$kd_satuan', '$nm_satuan')";
            mysqli_query($koneksi, $insert);
        }
    }
    /* END OF SUBMIT */


    /* DELETE */
    if (isset($_GET['kd_satuan']) && $_GET['aksi'] == 'hapus') {
        $kode = $_GET['kd_satuan'];
        $delete = " DELETE FROM satuan WHERE kd_satuan='$kode' ";
        mysqli_query($koneksi, $delete);
        header('Location: index.php?menu=satuan');
    }
    /* END OF DELETE */

    /* READ <---------------- Bagian ini yang masih belum fix*/
    echo "
        <table border='1' class='data' align='center' width='600px'>
            <tr>
                <th class='data-td' width='20%'>Kode Satuan</th>
                <th class='data-td'>Nama Satuan</th>
                <th class='data-td' width='17%'>Aksi</th>
            </tr>
        ";
    if (isset($_GET['btnCari']) && $_GET['cari_satuan']) {
        $cari = $_GET['cari_satuan'];
        $search = "SELECT * FROM satuan WHERE kd_satuan LIKE '$cari'";
        $data = mysqli_query($koneksi, $read);
    } else {
        $read = "SELECT * FROM satuan";
        $data = mysqli_query($koneksi, $read);
    }
    if ($data->num_rows > 0) {
        while ($row = mysqli_fetch_array($data)) {
            echo "
                    <tr>
                        <td class='data-td'>" . $row['kd_satuan'] . "</td>
                        <td class='data-td'>" . $row['nm_satuan'] . "</td>
                        <td class='data-td' align='center'>
                            <a href='index.php?menu=satuan&kd_satuan=" . $row['kd_satuan'] . "&aksi=ubah'>Ubah</a>
                            <a href='index.php?menu=satuan&kd_satuan=" . $row['kd_satuan'] . "&aksi=hapus'>Hapus</a>
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
    if (isset($_GET['kd_satuan']) && $_GET['aksi'] == "ubah") {
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
         document.getElementById("kd_satuan").readOnly = true;
         document.getElementById("nm_satuan").value = nm_satuan;
     </script>
 <?php
    }
    /* END OF GET DATA */
 ?>