<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

include 'database.php';

$stmt = $pdo->prepare("SELECT user.id, pembelian.id_kategori, pembelian.nama_produk, pembelian.jumlah, pembelian.harga,
pembelian.tanggal_pembelian FROM user LEFT JOIN pembelian ON user.id = pembelian.id_user WHERE user.id = :user_id");

$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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

            .user {
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
<div class="user">
    <h1>Ini Daftar Pesanan Kamu, <?php echo $_SESSION['username']; ?></h1>
    </div>

<nav>
<a href="order.php">Back</a>
<a href="Tambah_Pesanan.php" class="button">Tambah Pesanan</a>
<a href="checkout.php">Checkout</a>
</nav>

<h2>Daftar Pesanan</h2>
<table>
    <tr>
    <th>ID</th>
        <th>id_kategori</th>
        <th>nama_produk</th>
        <th>jumlah</th>
        <th>harga</th>
        <th>tgl_pembelian</th>
        <th>Action</th>
    </tr>
    <?php foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $users): ?>

    <tr>
            <td><?php echo $users['id']; ?></td>
            <td><?php echo $users['id_kategori']; ?></td>
            <td><?php echo $users['nama_produk']; ?></td>
            <td><?php echo $users['jumlah']; ?></td>
            <td><?php echo $users['harga']; ?></td>
            <td><?php echo $users['tanggal_pembelian']; ?></td>
            <td class="action-links">
                <a href="delete_pesanan.php?id=<?php echo $users['id']; ?>" class="delete">Delete</a>
                </td>
                </tr>
                <?php endforeach; ?>
                </table>
                
</div>
</body>
</html>

