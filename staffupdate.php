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

$username = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

$sql = "SELECT * FROM staff WHERE staff_username = '$username'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Staff not found!");
}

$staff = mysqli_fetch_assoc($result);
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['staff_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['staff_phone']);
    $email = mysqli_real_escape_string($conn, $_POST['staff_email']);
    $area = mysqli_real_escape_string($conn, $_POST['staff_area']);
    
    $update_sql = "UPDATE staff SET
                    staff_name = '$name',
                    staff_phone = '$phone',
                    staff_email = '$email',
                    staff_area = '$area'
                    WHERE staff_username = '$username'";

    if (mysqli_query($conn, $update_sql)) {
        $message = "Staff updated successfully!";
        $result = mysqli_query($conn, $sql);
        $staff = mysqli_fetch_assoc($result);
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Staff Form</title>
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

        .form-container input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
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
        <h1>Update Staff</h1>
        <div class="form-container">
            <?php if ($message != '') echo "<p class='message'>$message</p>"; ?>
            <form method="post">
                <label>Username:</label>
                <input type="text" name="staff_username" value="<?php echo htmlspecialchars($staff['staff_username']); ?>" readonly>

                <label>Full Name:</label>
                <input type="text" name="staff_name" value="<?php echo htmlspecialchars($staff['staff_name']); ?>" required>

                <label>Phone:</label>
                <input type="text" name="staff_phone" value="<?php echo htmlspecialchars($staff['staff_phone']); ?>" required>

                <label>Email:</label>
                <input type="email" name="staff_email" value="<?php echo htmlspecialchars($staff['staff_email']); ?>" required>

                <label>Coverage Area:</label>
                <input type="text" name="staff_area" value="<?php echo htmlspecialchars($staff['staff_area']); ?>" required>

                <button type="submit">Update Staff</button>
            </form>
			<a style="color: black; display: block; text-align: left;" class="back-link" onclick="location.href='stafflist.php'"><br>← Back to Staff List</a>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
