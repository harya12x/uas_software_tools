<?php
include 'Database.php';

$db = new Database();
$con = $db->Connect();

if (isset($_GET['id_user'])) {
    $userID = mysqli_real_escape_string($con, $_GET['id_user']);
    $query = "SELECT chat.*, user_sender.nama_user as sender_name, user_receiver.nama_user as receiver_name 
              FROM chat 
              LEFT JOIN users as user_sender ON chat.sender_id = user_sender.id_user
              LEFT JOIN users as user_receiver ON chat.receiver_id = user_receiver.id_user
              WHERE (chat.sender_id = '$userID' OR chat.receiver_id = '$userID') 
              ORDER BY chat.timestamp ASC";

    $result = mysqli_query($con, $query);

    $chatHistory = array();

    while ($row = mysqli_fetch_assoc($result)) {

        $senderName = $row['sender_name'];
        $receiverName = $row['receiver_name'];

        $chatHistory[] = array(
            'senderID' => $row['sender_id'],
            'receiverID' => $row['receiver_id'],
            'senderName' => $senderName,
            'receiverName' => $receiverName,
            'message' => $row['message'],
            'timestamp' => $row['timestamp']
        );
    }

    echo json_encode($chatHistory);
} else {
    echo json_encode(array("error" => "Invalid data received"));
}

mysqli_close($con);
?>
