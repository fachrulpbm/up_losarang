<form action="" method="post" name="form_trb_pengeluaran">
    <table align="center">
        <tr align="center">
            <td colspan=3>
                <h4>Transaksi Pengeluaran </h4>
            </td>
        </tr>
        <tr>
           <td>No. Transaksi beli</td>
            <td>:</td>
            <td>
                <input type="text" name="no_trj" size="20" required>
            </td>   
        </tr>
        <tr>
            <td>Tanggal Transaksi beli</td>
            <td>:</td>
            <td>
                <input type="date" name="tgl_trj" size="30" required>
            </td>  
        </tr>
        <tr>
            <td>Uraian</td>
            <td>:</td>
            <td>
                <input type="text" name="uraian_trb" size="40" required>
            </td>       
        </tr>
        <tr>
            <td>Kode Pengeluaran</td>
            <td>:</td>
            <td>
                <select id="kd_pengeluaran" name="kd_pengeluaran" style="width: 200px">
                    <option value="default">-- Pilih Pengeluaran --</option>
                    <?php
                    $tampil_masterpengeluaran = "SELECT * FROM pengeluaran ORDER BY kd_pengeluaran ASC";
                    $hasil = mysqli_query($koneksi, $tampil_masterpengeluaran);
                    while ($row = mysqli_fetch_array($hasil)) {
                        echo "
                                <option value=" . $row['kd_pengeluaran'] . ">" . $row['nm_pengeluaran'] . "</option>
                           ";
                    }
                    ?>
                </select>
            </td>      
        </tr>
        <script>

            $( document ).ready(function() {
                $('#kd_pengeluaran').change(function(){
                    var kode = $('#kd_pengeluaran').val();
                    $.post("pengeluaran.php", {kodes: kode}, function(data){
                        
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
                <input type="number" name="hrg_trb_pengeluaran" size="15" disabled>
            </td>                
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" value="Simpan Transaksi" name="btntrb_pengeluaran">
            </td>
        </tr>
    </table>
</form>

<br>

<?php

    /* SUBMIT */
    if (isset($_POST['btntrb_pengeluaran'])) {
        $no_trb = $_POST['no_trb'];
        $tgl_trb = $_POST['tgl_trb'];
        $uraian_trb = $_POST['uraian_trb'];
        $kd_pengeluaran = $_POST['kd_pengeluaran'];
        $qty = $_POST['qty'];
        $hrg_trb = $_POST['hrg_trb'];
        /* UPDATE */
        if (isset($_GET['aksi'])) {
            $update = "UPDATE tampil_trb_pengeluaran SET no_trb='$no_trb', tgl_trb ='$tgl_trb', uraian_trb='$uraian_trb', kd_pengeluaran='$kd_pengeluaran', qty='$qty',hrg_trb=$hrg_trb,WHERE kd_pengeluaran='$kd_pengeluaran'";
            mysqli_query($koneksi, $update);
            header("Location: index.php?menu=trb_pengeluaran");
        }
        /* INSERT */ else {
            $insert = "INSERT INTO trb_pengeluaran(no_trb, tgl_trb, uraian_trb,kd_pengeluaran, qty, hrg_trb) VALUES('$no_trb', '$tgl_trb', '$uraian_trb', '$kd_pengeluaran', '$qty','$hrg_trb')";
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
        $delete = " DELETE FROM trb_pengeluaran WHERE kd_pengeluaran='$kode' ";
        mysqli_query($koneksi, $delete);
        header('Location: index.php?menu=trb_pengeluaran');
    }
    /* END OF DELETE */

    /* READ */
    echo "
        <table border='1' class='data' align='center' width='720px'>
            <tr>
                <th class='data-td'>No.Transaksi</th>
                <th class='data-td'>Tanggal</th>
                <th class='data-td'>Uraian</th>
                <th class='data-td'>Kode Pengeluaran</th>
                <th class='data-td'>Qty</th>
                <th class='data-td'>Harga </th>
                <th class='data-td' width='13%'>Aksi</th>
            </tr>
        ";
    if (isset($_POST['cari']) && $_POST['btnCari']) {
        $cari = $_POST['cari'];
        $read = "SELECT * FROM trb_pengeluaran WHERE kd_pengeluaran LIKE '%$cari%' OR nm_produk LIKE '%$cari%'";
    } else {
        $read = "SELECT * FROM trb_pengeluaran";
    }
    $data = mysqli_query($koneksi, $read);

    if (!$data) {
        trigger_error('Invalid query: ' . $koneksi->error);
    }
    if ($data->num_rows > 0) {
        while ($row = mysqli_fetch_array($data)) {
            echo "
                    <tr>
                        <td class='data-td'>" . $row['no_trb'] . "</td>
                        <td class='data-td'>" . $row['tgl_trb'] . "</td>
                        <td class='data-td'>" . $row['uraian_trb'] . "</td>
                        <td class='data-td'>" . $row['kd_pengeluaran'] . "</td>
                        <td class='data-td'>" . $row['qty'] . "</td>
                        <td class='data-td'>" . $row['hrg_trb'] . "</td>
                        <td class='data-td' align='center'>
                            <a href='index.php?menu=trb_pengeluaran&trb_=" . 
                            $row['kd_pengeluaran'] . "&aksi=ubah'>Ubah</a>
                            <a href='index.php?menu=trb_pengeluaran&kd_pengeluaran=" . $row['kd_pengeluaran'] . "&aksi=hapus'>Hapus</a>
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
    if (isset($_GET['kd_pengeluaran']) && $_GET['aksi'] == "ubah") {
        $kd_produk = $_GET['kd_pengeluaran'];
        $search = "SELECT * FROM trb_pengeluaran WHERE kd_pengeluaran = '$kd_pengeluaran'";
        $hasil_search = mysqli_query($koneksi, $search);
        $row = mysqli_fetch_array($hasil_search);
        $no_trb = $row['no_trb'];
        $tgl_trb = $row['tgl_trb'];
        $uraian_trb = $row['uraian_trb'];
        $qty = $row['qty'];
        $hrg_trb = $row['hrg_trb'];
        ?>
     <script>
         var no_trb = "<?php echo $no_trb ?>";
         var tgl_trb = "<?php echo $tgl_trb ?>";
         var uraian_trb = "<?php echo $uraian_trb ?>";
         var kd_pengeluaran = "<?php echo $kd_pengeluaran ?>";
         var qty = "<?php echo $qty ?>";
         var hrg_trb = "<?php echo $hrg_trb?>";
         document.form_trb_pengeluaran.kd_pengeluaran.value = kd_pengeluaran;
         document.form_trb_pengeluaran.kd_pengeluaran.readOnly = true;
         
         document.form_trb_pengeluaran.no_trb.value = no_trb;
         document.form_trb_pengeluaran.tgl_trb.value = tgl_trb;
         document.form_trb_pengeluaran.uraian_trb.value = uraian_trb;
         document.form_trb_pengeluaran.qty.value = qty;
         document.form_trb_pengeluaran.hrg_trb.value = hrg_trb;
     </script>
 <?php
    }
    /* END OF GET DATA */
    ?>