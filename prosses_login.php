<?php
// include_once("functions.php");

// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $username = isset($_POST['username']) ? $_POST['username'] : null;
//     $password = isset($_POST['password']) ? $_POST['password'] : null;
//     $role = isset($_POST['role']) ? $_POST['role'] : null;

//     // Debugging
//     var_dump($username, $password, $role);

//     // Pastikan fungsi getUser di functions.php
//     $user = getUser($username, $password, $role);

//     if ($user) {
//         $_SESSION['user'] = $user;
//         $_SESSION['user']['role'] = $role; // Pastikan role diset dalam session

//         // Debugging Session
//         var_dump($_SESSION);

//         // Redirect berdasarkan peran pengguna
//         if ($role == 'admin') {
//             header("Location: /rapot_sederhana/index.php");
//         } elseif ($role == 'guru') {
//             header("Location: /rapot_sederhana/h_guru/nilai.php");
//         } elseif ($role == 'siswa') {
//             header("Location: /rapot_sederhana/h_siswa/siswa_dashboard.php");
//         }
//         exit();
//     } else {
//         $error = "Username atau password salah";
//         echo $error; // Menampilkan pesan error
//     }
// }




include_once("functions.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $role = isset($_POST['role']) ? $_POST['role'] : null;

    // Debugging
    var_dump($username, $password, $role);

    // Pastikan fungsi getUser di functions.php
    $user = getUser($username, $password, $role);

    if ($user) {
        $_SESSION['user'] = $user;
        $_SESSION['user']['role'] = $role; // Pastikan role diset dalam session

        // Debugging Session
        var_dump($_SESSION);

        // Redirect berdasarkan peran pengguna
        if ($role == 'admin') {
            header("Location: /rapot_sederhana/index.php");
        } elseif ($role == 'guru') {
            header("Location: /rapot_sederhana/h_guru/nilai.php");
        } elseif ($role == 'siswa') {
            header("Location: /rapot_sederhana/h_siswa/siswa_dashboard.php");
        }
        exit();
    } else {
        $error = "Username atau password salah";
        echo $error; // Menampilkan pesan error
    }
}




/// dIBAWAH PROSES LOGIN 

// function getUser($username, $password, $role) {
//     $db = dbConnect();
//     if ($db) {
//         $username = $db->escape_string($username);
//         $password = $db->escape_string($password);

//         if ($role == 'siswa') {
//             // Query untuk siswa
//             $query = "SELECT * FROM siswa WHERE nama='$username' AND nis='$password'";
//         } elseif ($role == 'guru') {
//             // Query untuk guru
//             $query = "SELECT * FROM guru WHERE nama_guru='$username' AND nip='$password'";
//         } elseif ($role == 'admin') {
//             // Query untuk admin
//             $query = "SELECT * FROM user WHERE username='$username' AND password='$password' AND role='admin'";
//         }

//         // Debugging query
//         echo "Executed Query: " . $query . "<br>";

//         $result = $db->query($query);
//         if ($result) {
//             if ($result->num_rows > 0) {
//                 return $result->fetch_assoc();
//             } else {
//                 echo "No rows found.<br>";
//             }
//         } else {
//             echo "Query Error: " . $db->error . "<br>";
//         }
//     }
//     return false;
// }

?>
