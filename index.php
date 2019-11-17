<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UP Losarang</title>
    <script src="jquery.js"></script>
    <style>
        .data {
            border-collapse: collapse;
        }

        .data-td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <table border="0" align="center" style="border-collapse: collapse" width="720px">
        <tr>
            <td colspan="8" align="center">
                <h2>Unit Produksi SMKN 1 Losarang</h2>
            </td>
        </tr>
        <tr>
            <td align="center">
                <a href="index.php">Home</a> |
                <a href="index.php?menu=satuan">Satuan</a> |
                <a href="index.php?menu=konversi">Konversi</a> |
                <a href="index.php?menu=produk">Produk</a> |
                <a href="index.php?menu=mpengeluaran">Master Pengeluaran</a> |
                <a href="index.php?menu=mpemasukan">Master Pemasukan</a> |
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
            include_once('satuan_konversi.php');
        }
    }
    ?>

</body>

</html>