<?php
    session_start();

    // periksa apakah file transbeli.json tidak ada
    if(!file_exists('transbeli.json')){
        // Jika YA, maka eksekusi file export-json.php
        include_once('json-transbeli.php');
    }
       
    // baca isi file json
    $transbeli = file_get_contents('transbeli.json');
    // decode variable json
    $trb = json_decode($transbeli, true);
?>

<table align="center">

    <!-- JUDUL -->
    <tr align="center">
        <td colspan=2>
            <h4>Transaksi Pembelian Produk</h4>
        </td>
    </tr>

    <!-- TRANSAKSI PRODUK -->
    <tr>
        <!-- TRANSAKSI -->
        <td style="vertical-align: text-top">
            <fieldset style="width: 330px; height: 130px; margin: auto">
                <legend>Transaksi</legend>
                <table align="left">
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="no_trb" size="20" required>
                        </td>   
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>
                            <input type="date" name="tgl_trb" size="30" required>
                        </td>  
                    </tr>
                    <tr>
                        <td style="vertical-align: text-top">Uraian</td>
                        <td style="vertical-align: text-top">:</td>
                        <td>
                            <textarea name="uraian_trb" cols="40" rows="4" required></textarea>
                        </td>       
                    </tr>
                </table>
            </fieldset>
        </td>
        <!-- PRODUK -->
        <td>
            <form action="" method="post" name="form_trb_produk">
                <fieldset style="width: 330px; height: 130px; margin: auto">
                    <legend>Produk</legend>
                    <table align="left">
                        <tr>
                            <td>Produk</td>
                            <td>:</td>
                            <td>
                                <!-- TAMPIL PILIHAN PRODUK -->
                                <select id="kd_produk" name="kd_produk" style="width: 200px">
                                    <option value="default">-- Pilih Produk --</option>
                                    <?php
                                    $tampil_produk = "SELECT * FROM produk ORDER BY kd_produk ASC";
                                    $hasil = mysqli_query($koneksi, $tampil_produk);
                                    while ($row = mysqli_fetch_array($hasil)) {
                                        echo "
                                                <option value=" . $row['kd_produk'] . ">" . $row['nm_produk'] . "</option>
                                        ";
                                    }
                                    ?>
                                </select>
                            </td>      
                        </tr>
                        <!-- TAMPIL RINCIAN BY PILIHAN PRODUK -->
                        <script>
                            $( document ).ready(function() {
                                $('#kd_produk').change(function(){
                                    var kode = $(this).children("option:selected").val();
                                    window.location.href = "index.php?menu=transbeli&kd_produk="+kode;
                                });
                            });
                        </script>
                        <tr>
                            <td>Qty</td>
                            <td>:</td>
                            <td>
                                <input type="number" id="qty" name="qty" style="width: 40px" required>
                            </td>    
                        </tr>
                        <!-- HITUNG HARGA OTOMATIS  -->
                        <script>
                            $('#qty').on('input',function(e){
                                if( $('#qty').val() != "" ){
                                    var hrg = "<?php echo $_SESSION['harga']; ?>";
                                    var qty = $('#qty').val();
                                    var subtotal = qty * hrg;
                                    $('#hrg_trb').val(subtotal);
                                }
                            });
                        </script>
                        <tr>
                        <td>Satuan Beli</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="satuan_trb" size="20" required readonly="true">
                            </td>                
                        </tr>
                        <tr>
                        <td>Harga</td>
                            <td>:</td>
                            <td>
                                <input type="number" id="hrg_trb" name="hrg_trb" style="width: 60px">
                            </td>                
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="submit" value="Tambah Produk" name="addproduk">
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </form>
        </td>
    </tr>
</table>


<?php

    /* Tambah data produk */


    /* READ */
    echo "
        <br>
        <table border='1' class='data' align='center' width='720px'>
            <tr>
                <th class='data-td'>Produk</th>
                <th class='data-td' width='8%'>Qty</th>
                <th class='data-td' width='12%'>Satuan</th>
                <th class='data-td' width='20%'>Subtotal</th>
                <th class='data-td' width='13%'>Aksi</th>
            </tr>
        ";
    if(isset($_POST['addproduk'])){
        $s = sizeof($trb);

        $trb[$s]['kd_produk'] = $_POST['kd_produk'];
        $trb[$s]['qty'] = $_POST['qty'];
        $trb[$s]['satuan_trb'] = $_POST['satuan_trb'];
        $trb[$s]['harga_trb'] = $_POST['harga_trb'];
        $trb[$s]['harga_trb'] = $_POST['harga_trb'];


        // encode ke JSON
        $json = json_encode($trb, JSON_PRETTY_PRINT);

        // simpan ke file JSON
        file_put_contents('transbeli.json',$json);

        if ($s > 0) {
            for($i=0; $i < $s; $i++){

                echo "
                    <tr>
                        <td class='data-td'>" . $trb[$i]['kd_produk'] . "</td>
                        <td class='data-td'>" . $trb[$i]['qty'] . "</td>
                        <td class='data-td'>" . $trb[$i]['satuan_trb'] . "</td>
                        <td class='data-td'>" . $trb[$i]['harga_trb'] . "</td>
                        <td class='data-td' align='center'>
                            <a href='index.php?menu=transbeli&kd_produk=" . $trb[$i]['kd_produk'] . "&aksi=ubah'>Ubah</a>
                            <a href='index.php?menu=transbeli&kd_produk=" . $trb[$i]['kd_produk'] . "&aksi=hapus'>Hapus</a>
                        </td>
                    </tr>
                ";

            }
            
        }

    }
    
    echo "</table>";
    /* END OF READ */


    /* Tampil Satuan & Harga By Pilihan Produk */
    if(isset($_GET['kd_produk'])){
        $kd_produk = $_GET['kd_produk'];
        $rincian = "SELECT * FROM produk WHERE kd_produk='$kd_produk'";
        $hasil = mysqli_query($koneksi, $rincian);
        $row = mysqli_fetch_array($hasil);
        $satuan = $row['kd_satuan'];
        $harga = $row['hrg_beli'];
        $_SESSION['harga'] = $harga;
        ?>

        <script>
            var kd_produk = "<?php echo $kd_produk ?>";
            var satuan = "<?php echo $satuan ?>";
            var harga = "<?php echo $harga ?>";
            document.form_trb_produk.satuan_trb.value = satuan;
            document.form_trb_produk.hrg_trb.value = harga;
            document.form_trb_produk.kd_produk.value = kd_produk;
        </script>

        <?php

    }

?>