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

    <table border="0" align="center" width="600px">
        <tr>
            <td colspan="3" align="center">
                <h2>Unit Produksi SMKN 1 Losarang</h2>
            </td>
        </tr>
        <tr>
            <td width="70%">
                <a href="index.php">
                    <h3>
                        Home
                    </h3>
                </a>
            </td>
            <td align="center">
                <a href="index.php?menu=satuan">Satuan</a>
            </td>
            <td align="center">
                <a href="index.php?menu=konversi">Konversi</a>
            </td>
        </tr>
    </table>

    <?php
        if (isset($_GET['menu'])) {
            if ($_GET['menu'] == 'satuan') {
                include_once('satuan.php');
            }elseif ($_GET['menu'] == 'konversi') {
                include_once('satuan_konversi.php');
            }
        }
    ?>


</body>

</html>