<?php
include_once("../functions.php");
$title = 'tampil-nilai';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "raport";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_kelas = isset($_GET['id_kelas']) ? $_GET['id_kelas'] : '';
$kd_mp = isset($_GET['id_mp']) ? $_GET['id_mp'] : '';

// Membuat query SQL
$sql_kelas_mp = "SELECT k.nama_kelas, mp.nama_mp 
                 FROM kelas k, mata_pelajaran mp
                 WHERE k.id_kelas = '$id_kelas' AND mp.kd_mp = '$kd_mp'";

// Menjalankan query dan memeriksa apakah berhasil
$result_kelas_mp = $conn->query($sql_kelas_mp);
if ($result_kelas_mp === false) {
    die("Error: " . $conn->error);
}

// Memeriksa apakah ada hasil yang dikembalikan
if ($result_kelas_mp->num_rows > 0) {
    $kelas_mp = $result_kelas_mp->fetch_assoc();
} else {
    die("No data found for the specified kelas and mata pelajaran.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include_once("../layout/sidebar.php") ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include_once("../layout/topbar.php") ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Input Nilai: <?= $kelas_mp['nama_kelas'] ?> - <?= $kelas_mp['nama_mp'] ?></h1>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Masukkan Nilai</h6>
                        </div>
                        <div class="card-body">
                            <form method="post" action="">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>NIS</th>
                                                <th>NAMA LENGKAP</th>
                                                <th>ID KELAS</th>
                                                <th colspan="7">NILAI TUGAS</th>
                                                <th>Rata-rata Tugas</th>
                                                <th colspan="7">NILAI ULANGAN</th>
                                                <th>Rata-rata Ulangan</th>
                                                <th>PTS</th>
                                                <th>UAS</th>
                                                <th>Nilai Akhir</th>
                                                <th>Grade</th>
                                                <th>Deskripsi</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Tugas 1</th>
                                                <th>Tugas 2</th>
                                                <th>Tugas 3</th>
                                                <th>Tugas 4</th>
                                                <th>Tugas 5</th>
                                                <th>Tugas 6</th>
                                                <th>Tugas 7</th>
                                                <th></th>
                                                <th>Ulangan 1</th>
                                                <th>Ulangan 2</th>
                                                <th>Ulangan 3</th>
                                                <th>Ulangan 4</th>
                                                <th>Ulangan 5</th>
                                                <th>Ulangan 6</th>
                                                <th>Ulangan 7</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT nis, nama, id_kelas FROM siswa WHERE id_kelas = '$id_kelas'";
                                            $result = $conn->query($sql);

                                            if ($result === false) {
                                                die("Error: " . $conn->error);
                                            }

                                            if ($result->num_rows > 0) {
                                                $no = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>{$no}</td>";
                                                    echo "<td><input type='hidden' name='nis[]' value='{$row['nis']}'>{$row['nis']}</td>";
                                                    echo "<td>{$row['nama']}</td>";
                                                    echo "<td><input type='hidden' name='id_kelas[]' value='{$row['id_kelas']}'>{$row['id_kelas']}</td>";
                                                    for ($i = 1; $i <= 7; $i++) {
                                                        echo "<td><input type='number' name='nilai_tp{$i}[]' value='0' class='form-control' placeholder='Tugas {$i}'></td>";
                                                    }
                                                    echo "<td><input type='number' name='rata_tp[]' value='0' class='form-control' readonly></td>";
                                                    for ($i = 1; $i <= 7; $i++) {
                                                        echo "<td><input type='number' name='nilai_uh{$i}[]' value='0' class='form-control' placeholder='Ulangan {$i}'></td>";
                                                    }
                                                    echo "<td><input type='number' name='rata_uh[]' value='0' class='form-control' readonly></td>";
                                                    echo "<td><input type='number' name='nilai_pts[]' value='0' class='form-control' placeholder='PTS'></td>";
                                                    echo "<td><input type='number' name='nilai_uas[]' value='0' class='form-control' placeholder='UAS'></td>";
                                                    echo "<td><input type='number' name='nilai_akhir[]' value='0' class='form-control' readonly></td>";
                                                    echo "<td><input type='text' name='nilai_huruf[]' value='D' class='form-control' readonly></td>";
                                                    echo "<td><input type='text' name='deskripsi[]' value='Kurang Baik' class='form-control' placeholder='Deskripsi'></td>";
                                                    echo "</tr>";
                                                    $no++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='24'>Tidak ada data siswa</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="submit" class="btn btn-success mt-3">Simpan Nilai</button>
                            </form>

                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['nis'])) {
                                    $nis = $_POST['nis'];
                                    $id_kelas = $_POST['id_kelas'];
                                    $nilai_tp1 = $_POST['nilai_tp1'];
                                    $nilai_tp2 = $_POST['nilai_tp2'];
                                    $nilai_tp3 = $_POST['nilai_tp3'];
                                    $nilai_tp4 = $_POST['nilai_tp4'];
                                    $nilai_tp5 = $_POST['nilai_tp5'];
                                    $nilai_tp6 = $_POST['nilai_tp6'];
                                    $nilai_tp7 = $_POST['nilai_tp7'];
                                    $nilai_uh1 = $_POST['nilai_uh1'];
                                    $nilai_uh2 = $_POST['nilai_uh2'];
                                    $nilai_uh3 = $_POST['nilai_uh3'];
                                    $nilai_uh4 = $_POST['nilai_uh4'];
                                    $nilai_uh5 = $_POST['nilai_uh5'];
                                    $nilai_uh6 = $_POST['nilai_uh6'];
                                    $nilai_uh7 = $_POST['nilai_uh7'];
                                    $nilai_pts = $_POST['nilai_pts'];
                                    $nilai_uas = $_POST['nilai_uas'];

                                    for ($i = 0; $i < count($nis); $i++) {
                                        // Menghitung rata-rata tugas
                                        $total_tugas = $nilai_tp1[$i] + $nilai_tp2[$i] + $nilai_tp3[$i] + $nilai_tp4[$i] + $nilai_tp5[$i] + $nilai_tp6[$i] + $nilai_tp7[$i];
                                        $rata_tp = $total_tugas / 7;

                                        // Menghitung rata-rata ulangan
                                        $total_uh = $nilai_uh1[$i] + $nilai_uh2[$i] + $nilai_uh3[$i] + $nilai_uh4[$i] + $nilai_uh5[$i] + $nilai_uh6[$i] + $nilai_uh7[$i];
                                        $rata_uh = $total_uh / 7;

                                        // Menghitung nilai akhir
                                        $nilai_akhir = ($rata_tp + $rata_uh + $nilai_pts[$i] + $nilai_uas[$i]) / 4;

                                        // Menentukan grade berdasarkan nilai akhir
                                        if ($nilai_akhir >= 90) {
                                            $nilai_huruf = 'A';
                                        } elseif ($nilai_akhir >= 80) {
                                            $nilai_huruf = 'B';
                                        } elseif ($nilai_akhir >= 70) {
                                            $nilai_huruf = 'C';
                                        } elseif ($nilai_akhir >= 60) {
                                            $nilai_huruf = 'D';
                                        } else {
                                            $nilai_huruf = 'E';
                                        }

                                        // Menentukan deskripsi berdasarkan grade
                                        switch ($nilai_huruf) {
                                            case 'A':
                                                $deskripsi = 'Sangat Baik';
                                                break;
                                            case 'B':
                                                $deskripsi = 'Baik';
                                                break;
                                            case 'C':
                                                $deskripsi = 'Cukup';
                                                break;
                                            case 'D':
                                                $deskripsi = 'Kurang';
                                                break;
                                            default:
                                                $deskripsi = 'Sangat Kurang';
                                                break;
                                        }

                                        $sql = "INSERT INTO nilai (nis, id_kelas, kd_mp, nilai_tp1, nilai_tp2, nilai_tp3, nilai_tp4, nilai_tp5, nilai_tp6, nilai_tp7, rata_tp, nilai_uh1, nilai_uh2, nilai_uh3, nilai_uh4, nilai_uh5, nilai_uh6, nilai_uh7, rata_uh, nilai_pts, nilai_uas, nilai_akhir, nilai_huruf, deskripsi)
                                                VALUES ('$nis[$i]', '$id_kelas[$i]', '$kd_mp', '$nilai_tp1[$i]', '$nilai_tp2[$i]', '$nilai_tp3[$i]', '$nilai_tp4[$i]', '$nilai_tp5[$i]', '$nilai_tp6[$i]', '$nilai_tp7[$i]', '$rata_tp', '$nilai_uh1[$i]', '$nilai_uh2[$i]', '$nilai_uh3[$i]', '$nilai_uh4[$i]', '$nilai_uh5[$i]', '$nilai_uh6[$i]', '$nilai_uh7[$i]', '$rata_uh', '$nilai_pts[$i]', '$nilai_uas[$i]', '$nilai_akhir', '$nilai_huruf', '$deskripsi')
                                                ON DUPLICATE KEY UPDATE
                                                nilai_tp1=VALUES(nilai_tp1), nilai_tp2=VALUES(nilai_tp2), nilai_tp3=VALUES(nilai_tp3), nilai_tp4=VALUES(nilai_tp4), nilai_tp5=VALUES(nilai_tp5), nilai_tp6=VALUES(nilai_tp6), nilai_tp7=VALUES(nilai_tp7), rata_tp=VALUES(rata_tp), nilai_uh1=VALUES(nilai_uh1), nilai_uh2=VALUES(nilai_uh2), nilai_uh3=VALUES(nilai_uh3), nilai_uh4=VALUES(nilai_uh4), nilai_uh5=VALUES(nilai_uh5), nilai_uh6=VALUES(nilai_uh6), nilai_uh7=VALUES(nilai_uh7), rata_uh=VALUES(rata_uh), nilai_pts=VALUES(nilai_pts), nilai_uas=VALUES(nilai_uas), nilai_akhir=VALUES(nilai_akhir), nilai_huruf=VALUES(nilai_huruf), deskripsi=VALUES(deskripsi)";

                                        if ($conn->query($sql) === TRUE) {
                                            echo "Record created/updated successfully for NIS: $nis[$i]<br>";
                                        } else {
                                            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                                        }
                                    }
                                } else {
                                    echo "No data to save.<br>";
                                }

                                $conn->close();
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once("../layout/footer.php") ?>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
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
</body>
</html>
