<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = $_SESSION['user_id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $pekerjaan = $_POST['pekerjaan'];
    $gender = $_POST['gender'];
    $tgl_lahir = $_POST['tgl_lahir'];

    $stmt = $pdo->prepare("INSERT INTO customer (id_user, nama, alamat, pekerjaan, gender, tgl_lahir) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id_user, $nama, $alamat, $pekerjaan, $gender, $tgl_lahir]);
    header("Location: user_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat Profile customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #2196f3, #e91e63);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #e3d396;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile {
            color: #fff;
            background-color: #000000;
            border-radius: 5px;
            padding: 10px;
            text-decoration: none;
            display: inline-block;
            margin: 0;
            position: relative; 
            animation: changeColor 5s infinite ease; 
            }

            @keyframes changeColor {
                30% {
                    color: #fff;
                }
                30% {
                    color: #007BFF;
                }
                40% {
                    color: #db386a;
                }
            }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid  #000000;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        tr:hover {
            background-color: #85d09e;
        }

        th {
            background-color: #f2f2f2;
        }

        .tambah {
            color: #00000;
            background-color: #fff;
            border-radius: 5px;
            padding: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
        }

        .tambah:hover {
            background-color: #007BFF;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Efek bayangan saat dihover */
            transform: scale(1.1);
        }

        .action-links a {
            margin-right: 10px;
            color: #007BFF;
        }

        .action-links a:last-child {
            margin-right: 0;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="profile">
    <h1>Create Your Profile</h1>
    </div>
    <form method="post">
        <table>
            <tr>
                <td>Nama:</td>
                <td><input type="text" name="nama" required></td>
            </tr>
            <tr>
            <td>Alamat:</td>
                <td><input type="text" name="alamat" required></td>
            </tr>
            <tr>
                <td>Pekerjaan:</td>
                <td><input type="text" name="pekerjaan" required></td>
            </tr>
            <tr>
            <td>Jenis Kelamin:</td>
                <td><input type="text" name="gender" required></td>
            </tr>
            <tr>
                <td>Tanggal Lahir:</td>
                <td><input type="date" name="tgl_lahir" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="tambah" value="Tambah"></td>
            </tr>
        </table>
    </form>
</div>
    
</body>
</html>

