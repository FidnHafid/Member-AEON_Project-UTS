<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['username'] != 'admin') {
    header("Location: login.php");
    exit;
}

include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);  // Ingat, gunakan enkripsi yang lebih aman

    $stmt = $pdo->prepare("UPDATE user SET username = ?, email = ?, password = ? WHERE id = ?");
    $stmt->execute([$username, $email, $password, $id]);
    header("Location: admin_dashboard.php");
    exit;
} else {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
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
    <div class="Edit">
    <h1>Edit User</h1>
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
                <td>
                    <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                </td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" value="<?php echo $user['email']; ?>" required></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="update" value="Update"></td>
            </tr>
        </table>
    </form>
</div>

</body>
</html>

