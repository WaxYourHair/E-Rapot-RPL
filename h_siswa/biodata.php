<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'siswa') {
    header("Location: login.php");
    exit();
}
$title = 'biodata'; // Set title untuk menandai menu aktif

// Ambil data biodata siswa dari database
include_once '../functions.php'; // Pastikan jalur ini benar
$nis = $_SESSION['user']['nis'];
$biodata = getBiodataSiswa($nis); // Fungsi ini harus diimplementasikan di functions.php

// Proses unggah gambar jika ada
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $errors = [];
    $path = '../uploads/';
    $extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));
    $file = $path . $nis . '.' . $file_ext;

    if (!in_array($file_ext, $extensions)) {
        $errors[] = 'Ekstensi file tidak diperbolehkan: ' . $file_name;
    }

    if (empty($errors)) {
        if (move_uploaded_file($file_tmp, $file)) {
            $db = dbConnect();
            $file_path = $db->escape_string($file);
            $query = "UPDATE siswa SET foto='$file_path' WHERE nis='$nis'";
            if ($db->query($query)) {
                $_SESSION['user']['photo'] = $file;
                header("Location: biodata.php");
                exit();
            } else {
                $errors[] = 'Gagal menyimpan path foto di database: ' . $db->error;
            }
        } else {
            $errors[] = 'Gagal mengunggah file.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Siswa</title>
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include 'layout/sidebar_index.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include 'layout/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Biodata Siswa</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <!-- Card Biodata -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Biodata Siswa</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <?php
                                            $photo_path = isset($biodata['foto']) && !empty($biodata['foto']) ? $biodata['foto'] : '../uploads/default.png';
                                            ?>
                                            <img src="<?php echo $photo_path; ?>" alt="Foto Siswa" class="img-fluid img-thumbnail">
                                        </div>
                                        <div class="col-md-8">
                                            <p><strong>Nama:</strong> <?php echo $biodata['nama']; ?></p>
                                            <p><strong>NIS:</strong> <?php echo $biodata['nis']; ?></p>
                                            <p><strong>Alamat:</strong> <?php echo $biodata['alamat']; ?></p>
                                            <p><strong>Tanggal Lahir:</strong> <?php echo $biodata['tanggal_lahir']; ?></p>
                                            <p><strong>Jenis Kelamin:</strong> <?php echo $biodata['jenis_kelamin']; ?></p>
                                            <p><strong>Agama:</strong> <?php echo $biodata['agama']; ?></p>
                                            <p><strong>Orang Tua:</strong> <?php echo $biodata['orang_tua']; ?></p>
                                            <p><strong>Asal Sekolah:</strong> <?php echo $biodata['asal_sekolah']; ?></p>
                                            <p><strong>Kelas:</strong> <?php echo $biodata['id_kelas']; ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Form Upload -->
                                            <h6 class="m-0 font-weight-bold text-primary">Upload Foto</h6>
                                            <?php if (!empty($errors)): ?>
                                                <div class="alert alert-danger">
                                                    <?php foreach ($errors as $error): ?>
                                                        <p><?php echo $error; ?></p>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                            <form action="biodata.php" method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label for="image">Pilih Foto:</label>
                                                    <input type="file" name="image" id="image" class="form-control">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </form>
                                            <!-- Akhir Form Upload -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Akhir Card Biodata -->
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'layout/footer.php'; ?>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/js/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>
</body>
</html>
