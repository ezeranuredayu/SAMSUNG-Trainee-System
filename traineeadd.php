<?php
session_start();
if (!isset($_SESSION['staff_username'])) {
    header('Location: index.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "samsung");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['trainee_username']);
    $name     = mysqli_real_escape_string($conn, $_POST['trainee_name']);
    $phone    = mysqli_real_escape_string($conn, $_POST['trainee_phone']);
    $email    = mysqli_real_escape_string($conn, $_POST['trainee_email']);
    $area     = mysqli_real_escape_string($conn, $_POST['trainee_area']);

    $check_sql = "SELECT * FROM trainee WHERE trainee_username = '$username'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $message = "Username already exists!";
    } else {
        $insert_sql = "INSERT INTO trainee (trainee_username, trainee_name, trainee_phone, trainee_email, trainee_area)
                       VALUES ('$username', '$name', '$phone', '$email', '$area')";

        if (mysqli_query($conn, $insert_sql)) {
            $message = "Trainee added successfully!";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Trainee</title>
    <link rel="shortcut icon" href="images/logo.png" />
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            background-image: url('images/2.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #336699;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 2;
        }

        .sidebar img {
            width: 120px;
            margin-bottom: 20px;
        }

        .sidebar button {
            width: 80%;
            padding: 12px;
            margin: 8px 0;
            border: none;
            background-color: #ffffff;
            color: #336699;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .sidebar button:hover {
            background-color: #000000;
            color: #ffffff;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            color: #ffffff;
            width: calc(100% - 250px);
            z-index: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .main-content h1 {
            margin-bottom: 30px;
        }

        .form-container {
            width: 400px;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            color: #333;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container input[type="text"],
        .form-container input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #336699;
            color: #ffffff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #000000;
            color: #ffffff;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #ffffff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .message {
            text-align: center;
            color: green;
            margin-bottom: 15px;
        }

        .error-message {
            text-align: center;
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="homestaff.php">
            <img src="images/logo.png" alt="Logo" />
        </a>
        <button onclick="location.href='homestaff.php'">Profile</button>
        <button onclick="location.href='staffstorevisit.php'">Monitor Store Visit</button>
        <button onclick="location.href='staffleave.php'">Request Leave List</button>
        <button onclick="location.href='staffmedical.php'">Medical Checkup List</button>
        <button onclick="location.href='staffkpi.php'">KPI Report</button>
        <button onclick="location.href='stafftraineelist.php'">List of Trainee</button>
        <button onclick="location.href='stafflist.php'">List of Staff</button>
        <br><br><br>
        <button onclick="location.href='stafflogout.php'">Log Out</button>
    </div>

    <div class="main-content">
        <h1>Add New Trainee Form</h1>
        <div class="form-container">
            <?php
            if ($message != '') {
                if ($message == "Username already exists!") {
                    echo "<p class='error-message'>$message</p>";
                } else {
                    echo "<p class='message'>$message</p>";
                }
            }
            ?>
            <form method="post">
                <label>Username:</label>
                <input type="text" name="trainee_username" required>

                <label>Full Name:</label>
                <input type="text" name="trainee_name" required>

                <label>Phone:</label>
                <input type="text" name="trainee_phone" required>

                <label>Email:</label>
                <input type="email" name="trainee_email" required>

                <label>Coverage Area:</label>
                <input type="text" name="trainee_area" required>

                <button type="submit">Add Trainee</button>
            </form>
            <a style="color: black; display: block; text-align: left;" class="back-link" onclick="location.href='stafftraineelist.php'"><br>← Back to Trainee List</a>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
