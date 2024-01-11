<?php
session_start();
include 'Database.php';

$db = new Database();
$con = $db->Connect();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id_user = mysqli_real_escape_string($con, $_GET['id_user']);

    $query = "SELECT * FROM users WHERE id_user='$id_user'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);
        echo json_encode($user);
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
