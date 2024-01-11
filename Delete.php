<?php
include 'Database.php';

$db = new Database();
$con = $db->Connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transaksi = mysqli_real_escape_string($con, $_POST['id_transaksi']);

    $query = "DELETE FROM transaksi_spp WHERE id_transaksi = '$id_transaksi'";

    if (mysqli_query($con, $query)) {
        echo json_encode(array('status' => 'sukses', 'message' => 'Data berhasil dihapus.'));
    } else {
        echo json_encode(array('status' => 'gagal', 'message' => 'Gagal menghapus data.'));
    }
} else {
    echo json_encode(array('error' => 'Invalid data received.'));
}

mysqli_close($con);
?>
