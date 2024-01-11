<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data SPP</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Data SPP</h2>

    <!-- Button trigger modal for create -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
        Tambah Data
    </button>

    <table id="dataTable">
        <!-- Table Content -->
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Nama Siswa</th>
                <th>Kelas Siswa</th>
                <th>Tanggal Transaksi</th>
                <th>Jumlah Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <!-- Modal for create -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Data SPP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for create -->
                    <form onsubmit="createData(); return false;">
                        <div class="form-group">
                            <label for="nama_siswa">Nama Siswa</label>
                            <input type="text" class="form-control" id="nama_siswa" placeholder="Nama Siswa">
                        </div>
                        <div class="form-group">
                            <label for="kelas_siswa">Kelas Siswa</label>
                            <input type="text" class="form-control" id="kelas_siswa" placeholder="Kelas Siswa">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_transaksi">Tanggal Transaksi</label>
                            <input type="date" class="form-control" id="tanggal_transaksi" placeholder="Tanggal Transaksi">
                        </div>
                        <div class="form-group">
                            <label for="jumlah_pembayaran">Jumlah Pembayaran</label>
                            <input type="text" class="form-control" id="jumlah_pembayaran" placeholder="Jumlah Pembayaran">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- Modal for update -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Data SPP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for update -->
                <form onsubmit="updateData(); return false;">
                    <!-- Hidden input for storing ID Transaksi -->
                    <input type="hidden" id="update_id_transaksi">

                    <div class="form-group">
                        <label for="update_nama_siswa">Nama Siswa</label>
                        <input type="text" class="form-control" id="update_nama_siswa" placeholder="Nama Siswa">
                    </div>
                    <div class="form-group">
                        <label for="update_kelas_siswa">Kelas Siswa</label>
                        <input type="text" class="form-control" id="update_kelas_siswa" placeholder="Kelas Siswa">
                    </div>
                    <div class="form-group">
                        <label for="update_tanggal_transaksi">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="update_tanggal_transaksi" placeholder="Tanggal Transaksi">
                    </div>
                    <div class="form-group">
                        <label for="update_jumlah_pembayaran">Jumlah Pembayaran</label>
                        <input type="text" class="form-control" id="update_jumlah_pembayaran" placeholder="Jumlah Pembayaran">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
 
    var table = $('#dataTable').DataTable();

    function displayData(data) {
    table.clear();

    data.forEach(function (row) {
        table.row.add([
            row.id_transaksi,
            row.nama_siswa,
            row.kelas_siswa,
            row.tanggal_transaksi,
            row.jumlah_pembayaran,
            `<div class="btn-group" role="group">
                <button class="btn btn-warning btn-sm" onclick="openUpdateModal(${row.id_transaksi})">Update</button>
                <button class="btn btn-danger btn-sm" onclick="deleteData(${row.id_transaksi})">Delete</button>
            </div>`
        ]).node().id = `row_${row.id_transaksi}`; // Set a unique ID for each row
    });

    table.draw();
}


    function readData() {
        $.ajax({
            url: 'read.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    displayData(data);
                } else {
                  
                }
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }



function deleteData(id) {
    console.log("Delete data with ID: " + id);

    $.ajax({
        url: 'Delete.php',
        type: 'POST',
        dataType: 'json',
        data: { id_transaksi: id },
        success: function (data) {
            if (data.status === 'sukses') {
                alert(data.message);
                // Remove the deleted row from DataTable
                var row = table.row(`#row_${id}`);
                if (row) {
                    row.remove().draw();
                }
            } else {
                alert(data.message);
            }
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}


function updateData() {
    var id_transaksi = $('#update_id_transaksi').val();
    var nama_siswa = $('#update_nama_siswa').val();
    var kelas_siswa = $('#update_kelas_siswa').val();
    var tanggal_transaksi = $('#update_tanggal_transaksi').val();
    var jumlah_pembayaran = $('#update_jumlah_pembayaran').val();

    // Ensure id_transaksi is not an empty string
    if (id_transaksi !== '') {
        $.ajax({
            url: 'Update.php',
            type: 'POST',
            dataType: 'json',
            data: {
                id_transaksi: id_transaksi,
                nama_siswa: nama_siswa,
                kelas_siswa: kelas_siswa,
                tanggal_transaksi: tanggal_transaksi,
                jumlah_pembayaran: jumlah_pembayaran
            },
            success: function (data) {
                console.log("Data to be sent:", {
                id_transaksi: id_transaksi,
                nama_siswa: nama_siswa,
                kelas_siswa: kelas_siswa,
                tanggal_transaksi: tanggal_transaksi,
                jumlah_pembayaran: jumlah_pembayaran
            });

                if (data.status === 'sukses') {
              
                    closeModal('updateModal');
                    readData(); // Update data on success
                } else {
                    alert(data.message);
                }
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    } else {
       
    }
}


    function closeModal(modalId) {
        $(`#${modalId}`).modal('hide');
    }

    function fillUpdateForm(data) {
        $('#update_nama_siswa').val(data.nama_siswa);
        $('#update_kelas_siswa').val(data.kelas_siswa);
        $('#update_tanggal_transaksi').val(data.tanggal_transaksi);
        $('#update_jumlah_pembayaran').val(data.jumlah_pembayaran);
    }

    function openUpdateModal(id) {
        console.log("Open update modal for ID: " + id);

        $.ajax({
            url: 'GetDataById.php',
            type: 'GET',
            dataType: 'json',
            data: { id: id },
            success: function (data) {
                if (data.status === 'sukses') {
                    fillUpdateForm(data.data);
                    $('#updateModal').modal('show');
                    $('#update_id_transaksi').val(id);
                } else {
                    alert(data.message);
                }
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }

    function createData() {
        var nama_siswa = $('#nama_siswa').val();
        var kelas_siswa = $('#kelas_siswa').val();
        var tanggal_transaksi = $('#tanggal_transaksi').val();
        var jumlah_pembayaran = $('#jumlah_pembayaran').val();

        $.ajax({
            url: 'Create.php',
            type: 'POST',
            dataType: 'json',
            data: {
                nama_siswa: nama_siswa,
                kelas_siswa: kelas_siswa,
                tanggal_transaksi: tanggal_transaksi,
                jumlah_pembayaran: jumlah_pembayaran
            },
            success: function (data) {
                if (data.status !== 'gagal') {
                    
                    readData();
                } else {
             
                }
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });

        // Clear form and close modal
        $('#nama_siswa').val("");
        $('#kelas_siswa').val("");
        $('#tanggal_transaksi').val("");
        $('#jumlah_pembayaran').val("");
        closeModal('createModal');
    }

    setInterval(function () {
        readData();
    }, 1000); // 5000 milliseconds = 5 seconds


    </script>
</body>
</html>
