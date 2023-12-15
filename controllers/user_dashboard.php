<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

include 'database.php';

$id_user = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM customer WHERE id_user = ?");
$stmt->execute([$id_user]);
$profil = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        th {
            background-color: #f2f2f2;
        }

        .create {
        font-weight: Bold;
        color: #007BFF; 
        text-decoration: underline; 
        transition: color 0.3s; 
        }

        .create:hover {
            color: #db386a; 
        }

.action-links a {
    margin-right: 10px;
    color: #fff;
}

.action-links a:last-child {
    margin-right: 0;
}
</style>

</head>
<body>
<div class="container">
<div class="user">
    <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    </div>

<nav>
<a href="../index.php">Home</a>
<a href="order.php" class="button">Shopping</a>
<a href="logout.php">Logout</a>
</nav>

<h2>Your Profile</h2>
<?php if ($profil): ?>
<p>Nama: <?php echo $profil['nama']; ?></p>
<p>Alamat: <?php echo $profil['alamat']; ?></p>
<p>Pekerjaan: <?php echo $profil['pekerjaan']; ?></p>
<p>Jenis Kelamin: <?php echo $profil['gender']; ?></p>
<p>Tanggal Lahir: <?php echo $profil['tgl_lahir']; ?></p>
<?php else: ?>
<p>You haven't filled out your profile yet. <a href="create_profile.php" class="create">Create Profile</a></p>
<?php endif; ?>

</div>
</body>
</html>

