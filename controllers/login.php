<?php
session_start();

include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['password']);  // Ganti dengan enkripsi yang lebih aman

    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        if($user['username'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit;
    } else {
        echo "Invalid login credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(#2196f3, #e91e63);
            overflow: hidden;
        }
        .box {
            position: relative;
            width: 400px;
            height: 500px;
        }
        .form-box {
                    position: absolute;
                    top: 0;
                    left: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    width: 100%;
                    height: 100%;
                    background: #fff;
                    box-shadow: 0 0 10px rgba(0, 0, 0, .2);
                }
         h2 {
            font-size: 30px;
            color: #555;
            text-align: center;
        }
        if($user['username'] == 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: user_dashboard.php");
                }
                exit;
            } else {
                echo "Invalid login credentials.";
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(#2196f3, #e91e63);
            overflow: hidden;
        }

        .box {
            position: relative;
            width: 400px;
            height: 500px;
        }

        .form-box {
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
        }

        h2 {
            font-size: 30px;
            color: #555;
            text-align: center;
        }

        .input-group {
            position: relative;
            width: 320px;
            margin: 30px 0;
        }


        .input-group input {
            width: 100%;
            height: 40px;
            font-size: 16px;
            color: #333;
            padding: 0 10px;
            background: transparent;
            border: 1px solid #333;
            outline: none;
            border-radius: 5px;
        }


        .forgot-pass {
            margin: -15px 0 15px;
        }

        .forgot-pass a {
            color: #333;
            font-size: 14px;
            text-decoration: none;
        }

        .forgot-pass a:hover {
            text-decoration: underline;
        }

        .btn {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background: linear-gradient(to right, #2196f3, #e91e63);
            box-shadow: 0 2px 10px rgba(0, 0, 0, .4);
            font-size: 16px;
            color: #fff;
            font-weight: 500;
            cursor: pointer;
            border-radius: 5px;
            border: none;
            outline: none;
        }

        .sign-link {
            font-size: 14px;
            text-align: center;
            margin: 25px 0;
        }

        .sign-link p {
            color: #333;
        }

        .sign-link p a {
            color: #e91e63;
            text-decoration: none;
            font-weight: 600;
        }

        .sign-link p a:hover {
            text-decoration: underline;
        }


    </style>
</head>

<body>
<div class="box">
        <div class="form-box sign-in">
            <form method="post">
                <h2>Login</h2>
                <div class="input-group">
                Email: <input type="email" name="email" required><br>
                </div>
                <div class="input-group">
                Password: <input type="password" name="password" required><br>
                </div>
                <div class="forgot-pass">
                <a href="#">Lupa Password?</a>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="sign-link">
                <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                </div>
            </form>
    </div>
</body>

</html>


      