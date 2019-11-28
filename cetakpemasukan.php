<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=nama_filenya.xls");

    echo "
        <table border='1' class='data' align='center' width='720px'>
            <tr>
                <th class='data-td'>Kode Pemasukan</th>
                <th class='data-td'>Nama Pemasukan</th>
                <th class='data-td' width='13%'>Aksi</th>
            </tr>
        ";
    if (isset($_POST['cari']) && $_POST['btnCari']) {
        $cari = $_POST['cari'];
        $read = "SELECT * FROM pemasukan WHERE kd_pemasukan LIKE '%$cari%' OR nm_pemasukan LIKE '%$cari%'";
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
                        <td class='data-td'>" . $row['kd_pemasukan'] . "</td>
                        <td class='data-td'>" . $row['nm_pemasukan'] . "</td>
                        <td class='data-td' align='center'>
                            <a href='index.php?menu=masterpemasukan&kd_pemasukan=" . $row['kd_pemasukan'] . "&aksi=ubah'>Ubah</a>
                            <a href='index.php?menu=masterpemasukan&kd_pemasukan=" . $row['kd_pemasukan'] . "&aksi=hapus'>Hapus</a>
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

?>