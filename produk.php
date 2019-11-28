<form action="" method="post" name="form_produk">
    <table align="center">
        <tr align="center">
            <td colspan=3>
                <h4>Produk</h4>
            </td>
        </tr>
        <tr>
           <td>Kode Produk</td>
            <td>:</td>
            <td>
                <input type="text" name="kd_produk" id="kd_produk" size="20" required>
            </td>   
        </tr>
        <tr>
            <td>Nama Produk</td>
            <td>:</td>
            <td>
                <input type="text" name="nm_produk" id="nm_produk" size="30" required>
            </td>  
        </tr>
        <tr>
            <td>Qty Jual</td>
            <td>:</td>
            <td>
                <input type="number" name="qty" id="qty" size="10" required>
            </td>
        </tr>
        <tr>
            <td>Satuan Jual</td>
            <td>:</td>
            <td>
                <select name="kd_konversi" id="kd_konversi" style="width: 200px">
                    <option value="default">-- Pilih Satuan Jual --</option>
                    <?php
                    $tampil_satuan = "SELECT * FROM satuan_konversi ORDER BY kd_konversi ASC";
                    $hasil = mysqli_query($koneksi, $tampil_satuan);
                    while ($row = mysqli_fetch_array($hasil)) {
                        echo "
                                <option value=" . $row['kd_konversi'] . ">" . $row['kd_konversi'] . "</option>
                           ";
                    }
                    ?>
                </select>
            </td> 
        </tr>
         <tr>
            <td>Harga Jual</td>
            <td>:</td>
            <td>
                <input type="text" name="hrg_jual" id="hrg_jual" size="15" required>
            </td>
        </tr>
        <tr>
            <td>Satuan Beli</td>
            <td>:</td>
            <td>
                <input type="text" name="satuan_beli" id="satuan_beli" readonly="true">
            </td>
        </tr>
        <!-- TAMPIL SATUAN BELI BY PILIHAN SATUAN JUAL -->
        <script>
            $( document ).ready(function() {
                $('#kd_konversi').change(function(){
                    var kd_produk = $('#kd_produk').val();
                    var nm_produk = $('#nm_produk').val();
                    var qty = $('#qty').val();
                    var hrg_jual = $('#hrg_jual').val();
                    var hrg_beli = $('#hrg_beli').val();
                    var kode = $(this).children("option:selected").val();

                    window.location.href = "index.php?menu=produk&kd_konversi="+kode+"&kd_produk="+kd_produk+"&nm_produk="+nm_produk+"&qty="+qty+"&hrg_jual="+hrg_jual+"&hrg_beli="+hrg_beli;
                });
            });
        </script>
        <tr>
            <td>Harga Beli</td>
            <td>:</td>
            <td>
                <input type="text" name="hrg_beli" id="hrg_beli" size="15" required>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" value="Simpan Produk" name="btnProduk">
            </td>
        </tr>
    </table>
</form>

<br>

<form action="" method="post">
     <table align="center" width="720px" style="margin-bottom: 10px">
         <tr align="left">
             <td>
                 Cari Produk:
                 <input type="text" name="cari" size="20">
                 <input type="submit" name="btnCari" value="Cari">
             </td>
         </tr>
     </table>
 </form>

<?php

    /* SUBMIT */
    if (isset($_POST['btnProduk'])) {
        $kd_produk = $_POST['kd_produk'];
        $nm_produk = $_POST['nm_produk'];
        $qty = $_POST['qty'];
        $kd_konversi = $_POST['kd_konversi'];
        $hrg_beli = $_POST['hrg_beli'];
        $hrg_jual = $_POST['hrg_jual'];
        $kd_satuan = $_POST['satuan_beli'];

        /* UPDATE */
        if (isset($_GET['aksi'])) {
            $update = "UPDATE produk SET nm_produk='$nm_produk', qty='$qty', kd_konversi='$kd_konversi', hrg_beli='$hrg_beli', hrg_jual='$hrg_jual', kd_satuan='$kd_satuan' WHERE kd_produk='$kd_produk'";
            mysqli_query($koneksi, $update);
            header("Location: index.php?menu=produk");
        }
        /* INSERT */ else {
            $insert = "INSERT INTO produk(kd_produk, nm_produk, qty, kd_konversi, hrg_beli, hrg_jual, kd_satuan) VALUES('$kd_produk', '$nm_produk', '$qty', '$kd_konversi', '$hrg_beli', '$hrg_jual', '$kd_satuan')";
            mysqli_query($koneksi, $insert);
            if (!$insert) {
                trigger_error('Invalid query: ' . $koneksi->error);
            }
        }
        header('Location: index.php?menu=produk');
    }
    /* END OF SUBMIT */

    /* DELETE */
    if (isset($_GET['kd_produk']) && $_GET['aksi'] == 'hapus') {
        $kode = $_GET['kd_produk'];
        $delete = " DELETE FROM produk WHERE kd_produk='$kode' ";
        mysqli_query($koneksi, $delete);
        header('Location: index.php?menu=produk');
    }
    /* END OF DELETE */

    /* READ */
    echo "
        <table border='1' class='data' align='center' width='720px'>
            <tr>
                <th class='data-td'>Kode Produk</th>
                <th class='data-td'>Nama Produk</th>
                <th class='data-td'>Qty</th>
                <th class='data-td'>Kode Konversi</th>
                <th class='data-td'>Harga Beli</th>
                <th class='data-td'>Harga Jual</th>
                <th class='data-td' width='13%'>Aksi</th>
            </tr>
        ";
    if (isset($_POST['cari']) && $_POST['btnCari']) {
        $cari = $_POST['cari'];
        $read = "SELECT * FROM produk WHERE kd_produk LIKE '%$cari%' OR nm_produk LIKE '%$cari%'";
    } else {
        $read = "SELECT * FROM produk";
    }
    $data = mysqli_query($koneksi, $read);

    if (!$data) {
        trigger_error('Invalid query: ' . $koneksi->error);
    }
    if ($data->num_rows > 0) {
        while ($row = mysqli_fetch_array($data)) {
            echo "
                    <tr>
                        <td class='data-td'>" . $row['kd_produk'] . "</td>
                        <td class='data-td'>" . $row['nm_produk'] . "</td>
                        <td class='data-td'>" . $row['qty'] . "</td>
                        <td class='data-td'>" . $row['kd_konversi'] . "</td>
                        <td class='data-td'>" . $row['hrg_beli'] . "</td>
                        <td class='data-td'>" . $row['hrg_jual'] . "</td>
                        <td class='data-td' align='center'>
                            <a href='index.php?menu=produk&kd_produk=" . $row['kd_produk'] . "&aksi=ubah'>Ubah</a>
                            <a href='index.php?menu=produk&kd_produk=" . $row['kd_produk'] . "&aksi=hapus'>Hapus</a>
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
    if (isset($_GET['kd_produk']) && $_GET['aksi'] == "ubah") {
        $kd_produk = $_GET['kd_produk'];
        $search = "SELECT * FROM produk WHERE kd_produk = '$kd_produk'";
        $hasil_search = mysqli_query($koneksi, $search);
        $row = mysqli_fetch_array($hasil_search);
        $nm_produk = $row['nm_produk'];
        $qty = $row['qty'];
        $kd_konversi = $row['kd_konversi'];
        $hrg_beli = $row['hrg_beli'];
        $hrg_jual = $row['hrg_jual'];
        $kd_satuan = $row['kd_satuan'];
        ?>
     <script>
         var kd_produk = "<?php echo $kd_produk ?>";
         var nm_produk = "<?php echo $nm_produk ?>";
         var qty = "<?php echo $qty ?>";
         var kd_konversi = "<?php echo $kd_konversi ?>";
         var hrg_beli = "<?php echo $hrg_beli ?>";
         var hrg_jual = "<?php echo $hrg_jual?>";
         var kd_satuan = "<?php echo $kd_satuan ?>";
         document.form_produk.kd_produk.value = kd_produk;
         document.form_produk.kd_produk.readOnly = true;
         
         document.form_produk.nm_produk.value = nm_produk;
         document.form_produk.qty.value = qty;
         document.form_produk.kd_konversi.value = kd_konversi;
         document.form_produk.hrg_beli.value = hrg_beli;
         document.form_produk.hrg_jual.value = hrg_jual;
         $('#satuan_beli').val(kd_satuan);
     </script>
 <?php
    }
    /* END OF GET DATA */


    /* Tampil Satuan Beli Produk */
    if(isset($_GET['kd_konversi'])){
        $kd_produk = $_GET['kd_produk'];
        $nm_produk = $_GET['nm_produk'];
        $qty = $_GET['qty'];
        $hrg_jual = $_GET['hrg_jual'];
        $hrg_beli = $_GET['hrg_beli'];
        $kd_konversi = $_GET['kd_konversi'];
        $rincian = "SELECT * FROM satuan_konversi WHERE kd_konversi='$kd_konversi'";
        $hasil = mysqli_query($koneksi, $rincian);
        $row = mysqli_fetch_array($hasil);
        $satuan = $row['kd_satuan'];
        ?>

        <script>
            var kd_produk = "<?php echo $kd_produk ?>";
            var nm_produk = "<?php echo $nm_produk ?>";
            var qty = "<?php echo $qty ?>";
            var hrg_jual = "<?php echo $hrg_jual ?>";
            var hrg_beli = "<?php echo $hrg_beli ?>";
            var satuan = "<?php echo $satuan ?>";
            var kd_konversi = "<?php echo $kd_konversi ?>";
            $('#kd_produk').val(kd_produk);
            $('#nm_produk').val(nm_produk);
            $('#qty').val(qty);
            $('#satuan_beli').val(satuan);
            $('#kd_konversi').val(kd_konversi);
            $('#hrg_beli').val(hrg_beli);
            $('#hrg_jual').val(hrg_jual);
        </script>

        <?php

    }
?>