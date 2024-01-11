<?php
include 'Database.php';

$db = new Database();
$con = $db->Connect();

if (isset($_GET['id_user'])) {
    $userID = mysqli_real_escape_string($con, $_GET['id_user']);

    // Ambil last_seen dari tabel user
    $query = "SELECT last_seen FROM users WHERE id_user = '$userID'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $lastSeen = $row['last_seen'];

        echo json_encode(array("lastSeen" => $lastSeen));
    } else {
        echo json_encode(array("error" => "Error executing query"));
    }
} else {
    echo json_encode(array("error" => "Invalid data received"));
}

mysqli_close($con);
?>
