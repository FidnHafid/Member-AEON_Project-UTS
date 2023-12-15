<?php

include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Ganti dengan enkripsi yang lebih aman

    $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

* {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body, form-box {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: linear-gradient(#2196f3, #e91e63);
        overflow: hidden;
    }
    .wrapper {
        position: relative;
        width: 400px;
        height: 500px;
    }
    .form-wrapper {
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

    .input-group label {
        position: absolute;
        top: 50%;
        left: 5px;
        transform: translateY(-50%);
        font-size: 16px;
        color: #333;
        padding: 0 5px;
        pointer-events: none;
        transition: .5s;
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

    .input-group input:focus~label,
    .input-group input:valid~label {
        top: 0;
        font-size: 12px;
        background: #fff;
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
<div class="wrapper">
        <div class="form-wrapper sign-up">
            <form method="post">
                <h2>Sign Up</h2>
                <div class="input-group">
                Username: <input type="text" name="username" required><br>
                </div>
                <div class="input-group">
                Email: <input type="email" name="email" required><br>
                </div>
                <div class="input-group">
                Password: <input type="password" name="password" required><br>
                </div>
                <button type="submit" class="btn">Sign Up</button>
                <div class="sign-link">
                <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
                </div>
            </form>
        </div>