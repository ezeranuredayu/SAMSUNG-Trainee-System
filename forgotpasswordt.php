<?php
include('dbconnect.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $check_email = "SELECT * FROM trainee WHERE trainee_email = '$email'";
    $result = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($result) > 0) {

        $token = bin2hex(random_bytes(50));

        $update = "UPDATE trainee SET reset_token='$token' WHERE trainee_email='$email'";
        if (mysqli_query($conn, $update)) {

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'eznredy@gmail.com'; 
                $mail->Password = 'rdajvlngodyrqwso'; 
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('eznredy@gmail.com', 'SAMSUNG Trainee System');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Reset Your Trainee Password';

                $reset_link = "http://localhost/SAMSUNG/resetpasswordt.php?token=" . $token;

                $mail->Body = "Hello,<br><br>Click <a href='$reset_link'>here</a> to reset your password.<br><br>If you didn't request this, please ignore this email.<br><br>Regards,<br>SAMSUNG Trainee System";

                $mail->send();
                echo "<script>alert('Password reset link sent. Please check your email!'); window.location.href='index.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
            }

        } else {
            echo "<script>alert('Failed to save reset token.');</script>";
        }

    } else {
        echo "<script>alert('Email not found!');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trainee Forgot Password</title>
    <link rel="shortcut icon" href="images/logo.png" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body, html {
            height: 100%;
            overflow: hidden;
        }

        #background-video {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            object-fit: cover; 
        }

        .container {
            position: relative;
            background: rgba(51, 102, 153, 0.5); 
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 40px 30px;
            width: 350px;
            margin: 100px auto;
            color: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 8px;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #4d94ff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #336699;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #ddd;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <video autoplay muted loop id="background-video">
        <source src="images/back.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
<br><br><br><br>
    <div class="container">
        <h2>Trainee Forgot Password</h2>
        <form method="POST">
            <label for="email">Enter Your Email:</label>
            <input type="email" name="email" required>
            <button type="submit">Send Reset Link</button>
        </form>
        <a class="back-link" href="index.php">Back to Login</a>
    </div>
</body>
</html>
