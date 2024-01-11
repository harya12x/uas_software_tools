<?php

session_start();

include 'Database.php';

$db = new Database();

$con = $db->Connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $count = mysqli_num_rows($result);
    
        if ($count == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['id_user'] = $row['id_user']; 
            $_SESSION['nama_user'] = $row['nama_user']; 
            $_SESSION['username'] = $username;
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "Error: " . mysqli_error($con);
    }
    

    mysqli_close($con);
}
?>
