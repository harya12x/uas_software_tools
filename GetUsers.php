<?php
session_start();
include 'Database.php';

$db = new Database();
$con = $db->Connect();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT id_user, nama_user, last_seen FROM users";
$userRows = mysqli_query($con, $query);

if ($userRows) {
    $users = array();

    while ($user = mysqli_fetch_assoc($userRows)) {
        // Lakukan manipulasi waktu di sini jika perlu
        // ...

        $users[] = $user;
    }
    echo json_encode($users);
} else {
    echo json_encode(array('error' => 'Error executing query'));
}

mysqli_close($con);
?>
