<?php
include_once('koneksi.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UP Losarang</title>
    <script src="jquery.js"></script>
    <style>
    	body{
    		background-image: url("gambar/.png") ;
    	}
        .data {
            border-collapse: collapse;
        }

        .data-td {
            padding: 5px;
        }
        h1,h2,h3,h4{
            margin: 0px;
        }
    </style>
</head>

<body>
    <header>
        <p><img src="gambar/12.png" width="127" height="123" style="float:right"/></p>
    <p><img src="gambar/11.png" width="131" height="126" style="float:left"/></p>
    
    
        <h1 align="center">UNIT PRODUKSI </h1>
        <h2 align="center">TEKNIK ELEKTRONIKA INDUSTRI </h2>
        <h2 align="center">SMK NEGERI 1 LOSARANG </h2>
        <h4 align="center">Alamat : Jl. Raya Pantura Santing - Losarang   Telp, (0234) 507237, Indramayu 45253</h4>
    </header>
	
    <table border="0" align="center" style="border-collapse: collapse" width="720px">
        <tr>
            <td colspan="8" align="center">
                
            </td>
        </tr>
        <tr>
            <td align="center">
                <a href="index.php?menu=home">Home</a> |
                <a href="index.php?menu=satuan">Satuan</a> |
                <a href="index.php?menu=konversi">Konversi</a> |
                <a href="index.php?menu=produk">Produk</a> |
                <a href="index.php?menu=masterpengeluaran">Master Pengeluaran</a> |
                <a href="index.php?menu=masterpemasukan">Master Pemasukan</a> |
                <br>
                <a href="index.php?menu=transbeli">Transaksi Pembelian</a> |
                <a href="index.php?menu=transpengeluaran">Transaksi Pengeluaran</a> |
                <a href="index.php?menu=transjual">Transaksi Penjualan</a> |
                <a href="index.php?menu=transpemasukan">Transaksi Pemasukan</a>
            </td>
        </tr>
    </table>

    <?php
    if (isset($_GET['menu'])) {
        if ($_GET['menu'] == 'satuan') {
            include_once('satuan.php');
        } elseif ($_GET['menu'] == 'konversi') {
            include_once('konversi.php');
        } elseif ($_GET['menu'] == 'produk') {
            include_once('produk.php');
        } elseif ($_GET['menu'] == 'masterpengeluaran') {
            include_once('masterpengeluaran.php');
        } elseif ($_GET['menu'] == 'masterpemasukan') {
            include_once('masterpemasukan.php');
        } elseif ($_GET['menu'] == 'transbeli') {
            include_once('transbeli.php');
        } elseif ($_GET['menu'] == 'transpengeluaran') {
            include_once('transpengeluaran.php');
        } elseif ($_GET['menu'] == 'transjual') {
            include_once('transjual.php');
        } elseif ($_GET['menu'] == 'transpemasukan') {
            include_once('transpemasukan.php');
        } elseif ($_GET['menu'] == 'home') {
            include_once('home.php');
        
    } elseif ($_GET['menu'] == 'cetakpemasukan') {
            include_once('cetakpemasukan.php');
        }
    }
    ?>

</body>

</html>