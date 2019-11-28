<?php
    session_start();
?>

<table align="center">

    <!-- JUDUL -->
    <tr align="center">
        <td colspan=2>
            <h4>Transaksi Penjualan Produk</h4>
        </td>
    </tr>

    <!-- TRANSAKSI PRODUK -->
    <tr>
        <!-- TRANSAKSI -->
        <td style="vertical-align: text-top">
            <fieldset style="width: 360px; height: 130px; margin: auto">
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
                            <textarea name="uraian_trj" cols="40" rows="4" required></textarea>
                        </td>       
                    </tr>
                </table>
            </fieldset>
        </td>
        <!-- PRODUK -->
        <td>
            <form action="" method="post" name="form_trj_produk">
                <fieldset style="width: 360px; height: 130px; margin: auto">
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
                                    window.location.href = "index.php?menu=transjual&kd_produk="+kode;
                                });
                            });
                        </script>
                        <tr>
                            <td>Qty</td>
                            <td>:</td>
                            <td>
                                <input type="number" id="qty" name="qty" size="15" required>
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
                        <td>Satuan</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="satuan_trb" size="20" disabled>
                            </td>                
                        </tr>
                        <tr>
                        <td>Harga</td>
                            <td>:</td>
                            <td>
                                <input type="number" id="hrg_trb" name="hrg_trb" size="15" disabled>
                            </td>                
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="submit" value="Tambah Produk" name="btnproduk">
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


    /* Tampil Satuan & Harga By Pilihan Produk */
    if(isset($_GET['kd_produk'])){
        $kd_produk = $_GET['kd_produk'];
        $rincian = "SELECT * FROM produk WHERE kd_produk='$kd_produk'";
        $hasil = mysqli_query($koneksi, $rincian);
        $row = mysqli_fetch_array($hasil);
        $satuan = $row['kd_konversi'];
        $harga = $row['hrg_jual'];
        
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