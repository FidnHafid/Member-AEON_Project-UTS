<?php
session_start();
// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['loggedin']) || $_SESSION['username'] != 'admin') {
    header("Location: login.php");
    exit;
}

include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);  // Ingat untuk menggunakan enkripsi yang lebih aman di produksi

    $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);
 
    header("Location: admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
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

        .add {
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
            border-bottom: 1px solid #201e1f;
            }

        nav a {
            color: #fff;
            background-color: #3eb686;
            border-radius: 5px;
            padding: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
            }

        nav a:hover {
            background-color: #db386a;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Efek bayangan saat dihover */
            transform: scale(1.1);
            }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #000000;
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
            background-color: #2196f3;
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
        
        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }

        .button:hover {
            background-color: #0056b3;
        }

</style>
</head>
<body>
<div class="container">
    <div class="add">
    <h1>Add User</h1>
    </div>
<nav>
    <a href="admin_dashboard.php">Daftar User</a>
    <a href="add_user.php" class="button">Tambah User</a>
    <a href="logout.php">Logout</a>
</nav>
<form method="post">
    <table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="username" required></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="email" name="email" required></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" required></td>
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
