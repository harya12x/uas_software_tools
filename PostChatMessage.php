<?php
include 'Database.php';

$db = new Database();
$con = $db->Connect();

// Check if the required keys are set in the $_POST array
if (isset($_POST['senderID'], $_POST['receiverID'], $_POST['message'])) {
    // Sanitize the input to prevent SQL injection
    $senderID = mysqli_real_escape_string($con, $_POST['senderID']);
    $receiverID = mysqli_real_escape_string($con, $_POST['receiverID']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // Insert the message into the database
    $query = "INSERT INTO chat (sender_id, receiver_id, message) VALUES ('$senderID', '$receiverID', '$message')";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "Message sent successfully";
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "Invalid data received";
}

// Close the database connection
mysqli_close($con);
?>
