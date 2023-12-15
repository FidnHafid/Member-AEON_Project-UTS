<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    // Pengiriman data ke database 
    $id_user = $_SESSION['user_id'];
    $total = $_POST['total'];
    $diskon = $_POST['diskon'];
    $total_setelah_diskon = $_POST['total_setelah_diskon'];
    $tanggal_checkout = $_POST['tanggal_checkout'];

    //  insert ke tabel report 
    $stmt = $pdo->prepare("INSERT INTO report (id_user, total, diskon, total_setelah_diskon, tanggal_checkout) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id_user, $total, $diskon, $total_setelah_diskon, $tanggal_checkout]);

    header("Location: checkout.php");
    exit;
    
    }
    

// Ambil data belanjaan dari customer yang sedang login
$stmt = $pdo->prepare("SELECT user.id, pembelian.id_pembelian,
                            SUM(pembelian.harga) AS total
                        FROM user
                        LEFT JOIN pembelian ON user.id = pembelian.id_user
                        WHERE user.id = :id_user
                        GROUP BY user.id, pembelian.id_pembelian");
$stmt = $pdo->prepare("SELECT id_user, SUM(harga) AS total FROM pembelian WHERE id_user = :id_user GROUP BY id_user");
$stmt->bindParam(':id_user', $_SESSION['user_id']);
$stmt->execute();
$checkoutData = $stmt->fetch();


// Hitung diskon (misalnya diskon 5% jika total belanja > 100000)
$diskonPersen = ($checkoutData['total'] > 100000) ? 5 : 0;
$diskon = $checkoutData['total'] * ($diskonPersen / 100);
$totalSetelahDiskon = $checkoutData['total'] - $diskon;

// Menyimpan total belanja dalam variabel $total_pembayaran
$total = $totalSetelahDiskon;
$id_user = $checkoutData['id_user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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

            .checkout {
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
                #checkoutBtn {
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: background-color 0.3s;
        }

        /* Efek hover */
        #checkoutBtn:hover {
            background-color: #2980b9;
        }

        /* Efek saat tombol diklik */
        #checkoutBtn:active {
            background-color: #1f618d;
        }

        /* Animasi centang */
        #checkoutBtn.checked::after {
            content: '\2713'; /* Karakter Unicode untuk centang */
            font-size: 24px;
            color: #fff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

    </style>
    <div class="container">
    <div class="checkout">
    <h1>Checkout</h1>
    </div>
</head>
<body>
    <h2>Checkout</h2>
    <nav>
        <!-- <a href="home.php">Home</a> -->
        <a href="Keranjang.php">Back</a>
        <a href="logout.php">Logout</a>
    </nav>
    <table border="1">
        <tr>
            <th>ID User</th>
            <th>Total</th>
            <th>Diskon</th>
            <th>Total Setelah Diskon</th>
            <th>Tanggal Checkout</th>
            <th>Action</th>
        </tr>
        <tr>
            <td><?php echo $checkoutData['id_user']; ?></td>
            <td><?php echo $checkoutData['total']; ?></td>
            <td><?php echo $diskonPersen . '%'; ?></td>
            <td><?php echo $totalSetelahDiskon; ?></td>
            <td><?php echo date('Y-m-d'); ?></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="total" value="<?php echo $checkoutData['total']; ?>">
                    <input type="hidden" name="diskon" value="<?php echo $diskon; ?>">
                    <input type="hidden" name="total_setelah_diskon" value="<?php echo $totalSetelahDiskon; ?>">
                    <input type="hidden" name="tanggal_checkout" value="<?php echo date('Y-m-d'); ?>">
                    <button type="submit" name="checkout" id="checkoutBtn" class="<?php echo isset($_POST['checkout']) ? 'checked' : ''; ?>">Checkout
                </button>
                </form>
            </td>
        </tr>
    </table>
    </div> 
</body>
</html>