<?php
session_start();
include 'Database.php';

$db = new Database();
$con = $db->Connect();


if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}


$rows = mysqli_query($con, "SELECT * FROM chat ORDER BY tgl_chat DESC");
$data = array();

while ($row = mysqli_fetch_assoc($rows)) {
    $data[] = $row;
}

$dataGet = json_encode($data);

$mhs = json_decode($dataGet);

foreach ($mhs as $item) {
    echo "<div class='alert alert-primary' role='alert' style='width: 60%;'>";

    echo "<label style='top: 8px; position: absolute; font-size: 11px;'>" . ($item->nama_chat ?? "") . "</label>";

    $date = date_create($item->tgl_chat ?? "");
    echo "<label style='top: 8px; right: 8px; position: absolute; font-size: 11px;'>" . date_format($date, "M d") . "</label>";

    echo "<br>";
    echo $item->text_chat ?? "";

    echo "<br>";

    echo "</div>";
}

mysqli_close($con);
?>
