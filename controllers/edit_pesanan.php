<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

include 'database.php';

$stmtGetKategori = $pdo->query("SELECT * FROM kategori");
$querykategori = $stmtGetKategori->fetchAll(PDO::FETCH_ASSOC);


$t = time();
$tanggal_pembelian = date("Y-m-d", $t);

// Tambahkan validasi jika form sudah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id = $_POST['id'];
    $id_user = $_POST['id_user'];
    $id_kategori = $_POST['id_kategori'];
    $nama_produk = $_POST['nama_produk'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $tanggal_pembelian = isset($_POST['tanggal_pembelian']) ? $_POST['tanggal_pembelian'] : date("Y-m-d");
    
    // Lakukan update ke database
    $stmt = $pdo->prepare("UPDATE pembelian SET id_user = ?, id_kategori = ?, nama_produk = ?, jumlah = ?, harga = ?, tanggal_pembelian = ? WHERE id_pembelian = ?");
    $stmt->execute([$id_user, $id_kategori, $nama_produk, $jumlah, $harga, $tanggal_pembelian, $id]);
    header("Location: Keranjang.php");
    exit;

} else {
    // Jika form belum di-submit, ambil data dari database
    $id_pembelian = isset($_GET['id_pembelian']) ? $_GET['id_pembelian'] : null;
    $stmt = $pdo->prepare("SELECT * FROM pembelian WHERE id_pembelian = ?");
    $stmt->execute([$id_pembelian]);
    $users = $stmt->fetch();
   
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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

        .Edit {
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

        .update {
            color: #00000;
            background-color: #fff;
            border-radius: 5px;
            padding: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
        }
        .update:hover {
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
    <div class="profile">
    <h1>Update Pesanan</h1>
    </div>
    <form method="post">
        <table>
        <td>
            <input type="hidden" name="id_pembelian" value="<?php echo $users['id_pembelian']; ?>">
            <input type="hidden" name="id_user" value="<?php echo $users['id_user']; ?>">
            </td>
        <tr>
            <td>Kategori:</td>
                <td>
                <select name="id_kategori" value="<?php echo $users['id_kategori']; ?>" required>
                    <option value="">Pilih Kategori</option>
                        <?php
                        foreach ($querykategori as $data) {
                        ?>
                        <option value="<?php echo $data['id'] ?>"><?php echo $data['nama'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
            </tr>
            <tr>
            <td>Nama Produk:</td>
                <td><input type="text" name="nama_produk" required></td>
            </tr>

            <tr>
            <td>Jumlah:</td>
                <td><input type="number" name="jumlah" required min="1"></td>
            </tr>
            <tr>
            <td>Harga:</td>
                <td><input type="number" name="harga" required></td>
            </tr>
            <tr>
            <td>Tanggal_Membeli:</td>
                <td><input type="text" name="tanggal_pembelian" value="<?php echo $tanggal_pembelian; ?>">
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="tambah" value="Update"></td>
            </tr>
        </table>
    </form>
</div>
    
</body>
</html>

