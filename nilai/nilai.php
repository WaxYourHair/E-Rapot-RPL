<?php
include_once("../functions.php");
$db = dbConnect();

if ($db->connect_errno == 0) {
    $query = "
        SELECT 
            mp.nama_mp AS nama_mapel, 
            k.nama_kelas, 
            g.nama_guru, 
            mp.kd_mp AS id_mapel, 
            k.id_kelas 
        FROM 
            kelas_guru kg
        JOIN 
            guru g ON kg.nip = g.nip
        JOIN 
            kelas k ON kg.id_kelas = k.id_kelas
        JOIN 
            mata_pelajaran mp ON kg.kd_mp = mp.kd_mp";
    
    $result = $db->query($query);

    if (!$result) {
        die("Query Error: " . $db->error);
    }
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Siswa</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include_once("../layout/sidebar.php") ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include_once("../layout/topbar.php") ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">KELAS DAN MATA PELAJARAN</h1>
                    <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#tambahModal">Tambah</button>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pilih Kelas dan Mata Pelajaran</h6>
                        </div>
                        <div class="card-body">
                            <div class="row" id="kelasMpContainer">
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <div class="col-lg-4 mb-4">
                                            <div class="card bg-primary text-white shadow">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $row['nama_mapel']; ?></h5>
                                                    <p class="card-text"><?= $row['nama_kelas']; ?></p>
                                                    <p class="card-text"><?= $row['nama_guru']; ?></p>
                                                    <a href="tampil-nilai.php?id_kelas=<?= $row['id_kelas']; ?>&id_mp=<?= $row['id_mapel']; ?>" class="btn btn-light">Lihat Siswa</a>
                                                    <button class="btn btn-danger btn-delete" data-id="<?= $row['id_kelas']; ?>-<?= $row['id_mapel']; ?>" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php else: ?>
                                    <p>Tidak ada data yang ditemukan.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once("../layout/footer.php") ?>
        </div>
    </div>

    <!-- Form Modal -->
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Kelas dan Guru</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="tambahForm">
                        <div class="form-group">
                            <label>Tahun Akademik</label>
                            <select name="id" class="form-control" required>
                                <?php
                                $tahun_akademik = $db->query("SELECT * FROM tahun_akademik");
                                while ($row = $tahun_akademik->fetch_assoc()) {
                                    echo "<option value='".$row['id']."'>".$row['tahun_akademik']." - ".$row['semester']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama Kelas</label>
                            <select name="id_kelas" class="form-control" required>
                                <?php
                                $kelas = $db->query("SELECT * FROM kelas");
                                while ($row = $kelas->fetch_assoc()) {
                                    echo "<option value='".$row['id_kelas']."'>".$row['nama_kelas']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama Guru</label>
                            <select name="nip" class="form-control" required>
                                <?php
                                $guru = $db->query("SELECT * FROM guru");
                                while ($row = $guru->fetch_assoc()) {
                                    echo "<option value='".$row['nip']."'>".$row['nama_guru']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan Data</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../assets/js/sb-admin-2.min.js"></script>
    <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/js/demo/datatables-demo.js"></script>
    <script src="../assets/js/script.js"></script>
    <script>
    $(document).ready(function() {
        $('#tambahForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'proses_tambah.php',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response); // Debugging: tampilkan respon di console
                    var result = JSON.parse(response);
                    if(result.status === 'success') {
                        location.reload(); // Reload halaman setelah berhasil menambahkan data
                    } else {
                        alert(result.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Debugging: tampilkan pesan kesalahan di console
                }
            });
        });

        // Event listener for delete buttons
        $(document).on('click', '.btn-delete', function() {
            var ids = $(this).data('id').split('-');
            var id_kelas = ids[0];
            var id_mapel = ids[1];
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: 'POST',
                    url: 'proses_hapus.php',
                    data: { id_kelas: id_kelas, id_mapel: id_mapel },
                    success: function(response) {
                        console.log(response); // Debugging: tampilkan respon di console
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            alert('Data berhasil dihapus');
                            location.reload(); // Reload halaman setelah berhasil menghapus data
                        } else {
                            alert(result.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Debugging: tampilkan pesan kesalahan di console
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
