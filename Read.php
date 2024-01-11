<?php
include 'Database.php';

$db = new Database();
$con = $db->Connect();

$query = "SELECT * FROM transaksi_spp";
$result = mysqli_query($con, $query);

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);

mysqli_close($con);
?>
