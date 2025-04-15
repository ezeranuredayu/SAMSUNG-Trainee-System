<?php
include('dbconnect.php');

if (!isset($_GET['token'])) {
    echo "<script>alert('No token provided.'); window.location.href='index.php';</script>";
    exit();
}

$token = mysqli_real_escape_string($conn, $_GET['token']);

$sql = "SELECT * FROM staff WHERE reset_token='$token'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Invalid or expired token.'); window.location.href='index.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($new_password) || empty($confirm_password)) {
        echo "<script>alert('All fields are required!');</script>";
    } elseif ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
      
       $hashed_password = $new_password;

        $update_sql = "UPDATE staff SET staff_password='$hashed_password', reset_token=NULL WHERE reset_token='$token'";
        if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Password updated! You can login now.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Failed to update password!');</script>";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
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

        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px;
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
        <h2>Reset Password</h2>
        <form method="POST">
    <input type="hidden" name="staff_id" value="123"> 

    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" required><br>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" name="confirm_password" required><br>

    <button type="submit">Reset Password</button>
</form>
        <a class="back-link" href="index.php">Back to Login</a>
    </div>

</body>
</html>

