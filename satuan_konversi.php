<?php
include_once('koneksi.php');
?>

<form action="" method="post">
    <table align="center">
        <tr align="center">
            <td colspan=3>
                <h4>Konversi</h4>
            </td>
        </tr>
        <tr>
            <td>Kode Konversi</td>
            <td>:</td>
            <td>
                <input type="text" name="kd_konversi" size="5">
            </td>
        </tr>
        <tr>
            <td>Kode Satuan</td>
            <td>:</td>
            <td>
                <select name="satuan" style="width: 150px">
                    <option value="default">-- pilih satuan --</option>
                    <?php
                    $tampil_satuan = "SELECT * FROM satuan ORDER BY kd_satuan ASC";
                    $hasil = mysqli_query($koneksi, $tampil_satuan);
                    while ($row = mysqli_fetch_array($hasil)) {
                        echo "
                                <option value=" . $row['kd_satuan'] . ">" . $row['nm_satuan'] . "</option>
                           ";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Nilai Konversi</td>
            <td>:</td>
            <td>
                <input type="text" name="nilai_konversi" size="10">
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="submit" value="Submit Konversi" name="btnSubmit">
            </td>
        </tr>
    </table>
</form>



<?php

if (isset($_POST['btnSubmit'])) {
    $satuan = $_POST['satuan'];
    echo "Satuan yang dipilih adalah " . $satuan;
}

?>