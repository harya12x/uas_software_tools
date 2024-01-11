<?php
include 'Database.php';

$db = new Database();
$con = $db->Connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Memeriksa apakah semua field yang dibutuhkan ada
    if (isset($_POST['nama_siswa'], $_POST['kelas_siswa'], $_POST['tanggal_transaksi'], $_POST['jumlah_pembayaran'])) {
        $nama_siswa = mysqli_real_escape_string($con, $_POST['nama_siswa']);
        $kelas_siswa = mysqli_real_escape_string($con, $_POST['kelas_siswa']);
        $tanggal_transaksi = mysqli_real_escape_string($con, $_POST['tanggal_transaksi']);
        $jumlah_pembayaran = mysqli_real_escape_string($con, $_POST['jumlah_pembayaran']);

        // Query untuk menambahkan data ke database
        $query = "INSERT INTO transaksi_spp (nama_siswa, kelas_siswa, tanggal_transaksi, jumlah_pembayaran) VALUES (?, ?, ?, ?)";
        
        // Gunakan prepared statement untuk menghindari SQL injection
        $stmt = mysqli_prepare($con, $query);

        if ($stmt) {
            // Bind parameter
            mysqli_stmt_bind_param($stmt, 'sssi', $nama_siswa, $kelas_siswa, $tanggal_transaksi, $jumlah_pembayaran);

            // Eksekusi prepared statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo json_encode(array('status' => 'sukses', 'message' => 'Data berhasil ditambahkan.'));
            } else {
                echo json_encode(array('status' => 'gagal', 'message' => 'Gagal menambahkan data: ' . mysqli_stmt_error($stmt)));
            }

            // Tutup prepared statement
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(array('status' => 'gagal', 'message' => 'Error preparing the query: ' . mysqli_error($con)));
        }
    } else {
        echo json_encode(array('status' => 'gagal', 'message' => 'Invalid data received. Required fields are missing.'));
    }
} else {
    echo json_encode(array('status' => 'gagal', 'message' => 'Invalid request method.'));
}

mysqli_close($con);
?>
