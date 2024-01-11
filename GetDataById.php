<?php

include 'Database.php';

$db = new Database();
$con = $db->Connect();

// Check if the ID parameter is set in the request
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);

    // Fetch data from the database based on the ID
    $query = "SELECT * FROM transaksi_spp WHERE id_transaksi = '$id'";
    $result = mysqli_query($con, $query);

    // Check if the query was successful
    if ($result) {
        $row = mysqli_fetch_assoc($result);

        // Check if data is found
        if ($row) {
            // Return data as JSON
            echo json_encode(array('status' => 'sukses', 'data' => $row));
        } else {
            echo json_encode(array('status' => 'gagal', 'message' => 'Data not found for ID: ' . $id));
        }
    } else {
        echo json_encode(array('status' => 'gagal', 'message' => 'Error executing query: ' . mysqli_error($con)));
    }
} else {
    echo json_encode(array('status' => 'gagal', 'message' => 'ID parameter is missing'));
}

mysqli_close($con);
?>
