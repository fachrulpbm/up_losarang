<form action="" method="post" name="form_transpemasukan">
    <table align="center">
        <tr align="center">
            <td colspan=3>
                <h4>Transaksi Pemasukan </h4>
            </td>
        </tr>
        <tr>
           <td>No. Transaksi Jual</td>
            <td>:</td>
            <td>
                <input type="text" name="no_trj" size="20" required>
            </td>   
        </tr>
        <tr>
            <td>Tanggal Transaksi Jual</td>
            <td>:</td>
            <td>
                <input type="date" name="tgl_trj" size="30" required>
            </td>  
        </tr>
        <tr>
            <td>Uraian</td>
            <td>:</td>
            <td>
                <input type="text" name="uraian_trj" size="40" required>
            </td>       
        </tr>
        <tr>
            <td>Kode Pemasukan</td>
            <td>:</td>
            <td>
                <select id="kd_pemasukan" name="kd_pemasukan" style="width: 200px">
                    <option value="default">-- Pilih Pemasukan --</option>
                    <?php
                    $tampil_masterpemasukan = "SELECT * FROM pemasukan ORDER BY kd_pemasukan ASC";
                    $hasil = mysqli_query($koneksi, $tampil_masterpemasukan);
                    while ($row = mysqli_fetch_array($hasil)) {
                        echo "
                                <option value=" . $row['kd_pemasukan'] . ">" . $row['nm_produk'] . "</option>
                           ";
                    }
                    ?>
                </select>
            </td>      
        </tr>
        <script>

            $( document ).ready(function() {
                $('#kd_produk').change(function(){
                    var kode = $('#kd_produk').val();
                    $.post("transpemasukan.php", {kodes: kode}, function(data){
                        
                    });
                });
            });
        </script>
         <tr>
            <td>Qty</td>
            <td>:</td>
            <td>
                <input type="number" name="qty" size="15" required>
            </td>               
        </tr>
        <tr>
           <td>Harga</td>
            <td>:</td>
            <td>
                <input type="number" name="hrg_trj_pemasukan" size="15" disabled>
            </td>                
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" value="Simpan Transaksi" name="btnpemasukan">
            </td>
        </tr>
    </table>
</form>

<br>

<?php

    /* SUBMIT */
    if (isset($_POST['btnpemasukan'])) {
        $no_trj = $_POST['no_trj'];
        $tgl_trj = $_POST['tgl_trj'];
        $uraian_trb = $_POST['uraian_trj'];
        $kd_pemasukan = $_POST['kd_pemasukan'];
        $qty = $_POST['qty'];
        $hrg_trj = $_POST['hrg_trj'];
        /* UPDATE */
        if (isset($_GET['aksi'])) {
            $update = "UPDATE tampil_pemasukan SET no_trj='$no_trj', tgl_trj ='$tgl_trj', uraian_trj='$uraian_trj', kd_pemasukan='$kd_pemasukan', qty='$qty',hrg_trj=$hrg_trj,WHERE kd_pemasukan='$kd_pemasukan'";
            mysqli_query($koneksi, $update);
            header("Location: index.php?menu=form_transpemasukan");
        }
        /* INSERT */ else {
            $insert = "INSERT INTO form_pemasukan(no_trj, tgl_trj, uraian_trj,kd_pemasukan, qty, hrg_trj) VALUES('$no_trj', '$tgl_trj', '$uraian_trj', '$kd_pemasukan', '$qty','$hrg_trj')";
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
        $delete = " DELETE FROM form_trj_pemasukan WHERE kd_pemasukan='$kode' ";
        mysqli_query($koneksi, $delete);
        header('Location: index.php?menu=form_transpemasukan');
    }
    /* END OF DELETE */

    /* READ */
    echo "
        <table border='1' class='data' align='center' width='720px'>
            <tr>
                <th class='data-td'>No.Transaksi</th>
                <th class='data-td'>Tanggal</th>
                <th class='data-td'>Uraian</th>
                <th class='data-td'>Kode Pemasukan</th>
                <th class='data-td'>Qty</th>
                <th class='data-td'>Harga </th>
                <th class='data-td' width='13%'>Aksi</th>
            </tr>
        ";
    if (isset($_POST['cari']) && $_POST['btnCari']) {
        $cari = $_POST['cari'];
        $read = "SELECT * FROM pemasukan WHERE kd_pemasukan LIKE '%$cari%' OR nm_produk LIKE '%$cari%'";
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
                        <td class='data-td'>" . $row['no_trj'] . "</td>
                        <td class='data-td'>" . $row['tgl_trj'] . "</td>
                        <td class='data-td'>" . $row['uraian_trj'] . "</td>
                        <td class='data-td'>" . $row['kd_pemasukan'] . "</td>
                        <td class='data-td'>" . $row['qty'] . "</td>
                        <td class='data-td'>" . $row['hrg_trj'] . "</td>
                        <td class='data-td' align='center'>
                            <a href='index.php?menu=form_trb_pemasukan&trb_=" . 
                            $row['kd_pemasukan'] . "&aksi=ubah'>Ubah</a>
                            <a href='index.php?menu=form_trb_pemasukan&kd_pemasukan=" . $row['kd_pemasukan'] . "&aksi=hapus'>Hapus</a>
                        </td>
                    </tr>
                ";
        }
    } else {
        echo "
                <tr style='padding: 20px'>
                    <td colspan='7' align='center'>
                        <i>Data tidak ada!</i>
                    </td>
                </tr>
            ";
    }
    echo "</table>";
    /* END OF READ */

    /* GET DATA */
    if (isset($_GET['kd_pemasukan']) && $_GET['aksi'] == "ubah") {
        $kd_produk = $_GET['kd_pemasukan'];
        $search = "SELECT * FROM pemasukan WHERE kd_pemasukan = '$kd_pemasukan'";
        $hasil_search = mysqli_query($koneksi, $search);
        $row = mysqli_fetch_array($hasil_search);
        $no_trb = $row['no_trj'];
        $tgl_trb = $row['tgl_trj'];
        $uraian_trb = $row['uraian_trj'];
        $qty = $row['qty'];
        $hrg_trb = $row['hrg_trj'];
        ?>
     <script>
         var no_trb = "<?php echo $no_trj ?>";
         var tgl_trb = "<?php echo $tgl_trj ?>";
         var uraian_trb = "<?php echo $uraian_trj ?>";
         var kd_pengeluaran = "<?php echo $kd_pemasukan ?>";
         var qty = "<?php echo $qty ?>";
         var hrg_trb = "<?php echo $hrg_trj?>";
         document.form_trj_pemasukan.kd_pemasukan.value = kd_pemasukan;
         document.form_trj_pemasukan.kd_pemasukan.readOnly = true;
         
         document.form_pemasukan.no_trj.value = no_trj;
         document.form_pemasukan.tgl_trj.value = tgl_trj;
         document.form_pemasukan.uraian_trj.value = uraian_trj;
         document.form_pemasukan.qty.value = qty;
         document.form_pemasukan.hrg_trj.value = hrg_trj;
     </script>
 <?php
    }
    /* END OF GET DATA */
    ?>

