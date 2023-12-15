<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['username'] != 'admin') {
    header("Location: login.php");
    exit;
}

include 'database.php';

$stmt = $pdo->prepare("SELECT * FROM report");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #2196f3, #e91e63);
            margin: 0;
            padding: 0;
            }

            .container {
                max-width: 850px;
                margin: 50px auto;
                background-color: #e3d396;
                padding: 50px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                height: 100%;
                overflow-y : auto;
            }

            .welcome {
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
                background-color: #5aacec;
                text-align : center;
            }

            .action-links {
                text-align: center; 
            }

            .action-links a {
                display: inline-block;
                padding: 3px;
                color: #fff;
                border: none;
                border-radius: 5px;
                text-decoration: none;
                transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
            }

            .action-links a:hover {
                        background-color: #db386a;
                        border-radius: 5px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                        transform: scale(1.1);
                    }

            .action-links a.edit {
                margin-right: 1px;
                margin-bottom: 3px;
                background-color: #007BFF;
            }

            .action-links a.delete {
                margin-left: none; /* Menambahkan margin-left pada tombol Delete */
                margin-bottom: 3px;
                background-color: #ff0000; /* Ganti warna tombol Delete sesuai kebutuhan */
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
    <div class="welcome">
    <h1>Welcome, Admin</h1>
    </div>
    <nav>
        <!-- <a href="home.php">Home</a> -->
        <a href="admin_dashboard.php">Daftar User</a>
        <a href="logout.php">Logout</a>
    </nav>

    <h2>Daftar Laporan</h2>
    <table>
    <tr>
            <th>ID User</th>
            <th>Total</th>
            <th>Diskon</th>
            <th>Total Setelah Diskon</th>
            <th>Tanggal Checkout</th>
            <th>Ket</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id_user']; ?></td>
            <td><?php echo $user['total']; ?></td>
            <td><?php echo $user['diskon']; ?></td>
            <td><?php echo $user['total_setelah_diskon']; ?></td>
            <td><?php echo date('Y-m-d'); ?></td>
            <td class="action-links">
                <a href="" class="edit">Success</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</div> 

</body>
</html>
