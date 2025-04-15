<?php
session_start();

if (!isset($_SESSION['trainee_username'])) {
    header('Location: samsunglogintrainee.php');
    exit();
}

include 'dbconnect.php';

if (!isset($_GET['mc_no'])) {
    echo "<script>alert('Invalid request!'); window.location.href='traineemedical.php';</script>";
    exit();
}

$mc_no = intval($_GET['mc_no']);

$query = "SELECT * FROM medical WHERE mc_no = $mc_no";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<script>alert('Record not found!'); window.location.href='traineemedical.php';</script>";
    exit();
}

$medical = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mc_senddate = mysqli_real_escape_string($conn, $_POST['mc_senddate']);
    $mc_date = mysqli_real_escape_string($conn, $_POST['mc_date']);

    $mc_slip = $medical['mc_slip']; 

    if (!empty($_FILES['mc_slip']['name'])) {
        $target_dir = "uploads/";
        $mc_slip = basename($_FILES["mc_slip"]["name"]);
        $target_file = $target_dir . $mc_slip;

        if (move_uploaded_file($_FILES["mc_slip"]["tmp_name"], $target_file)) {
            
        } else {
            echo "<script>alert('Error uploading file.');</script>";
            exit();
        }
    }

    $update_query = "UPDATE medical 
                     SET mc_senddate = '$mc_senddate', mc_date = '$mc_date', mc_slip = '$mc_slip' 
                     WHERE mc_no = $mc_no";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Medical record updated successfully.'); window.location.href='traineemedical.php';</script>";
    } else {
        echo "<script>alert('Error updating record.');</script>";
    }

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Medical Checkup</title>
    <link rel="shortcut icon" href="images/logo.png" />
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            background-image: url('images/3.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
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
            top: 0; left: 0; bottom: 0;
            overflow: hidden;
            z-index: 2;
        }

        .sidebar img {
            width: 120px;
            margin-bottom: 20px;
            cursor: pointer;
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
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 1;
            position: relative;
            color: #fff;
            width: calc(100% - 250px);
        }

        .main-content h1 {
            color: #ffffff;
            margin-bottom: 30px;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 500px;
            color: #333;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container input[type="date"],
        .form-container input[type="file"],
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #336699;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #000000;
        }

        .back-link {
            margin-top: 20px;
            color: #ffffff;
            text-decoration: underline;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                flex-direction: row;
                justify-content: space-around;
                padding: 10px 0;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .sidebar button {
                margin: 5px;
                width: auto;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <a href="hometrainee.php">
        <img src="images/logo.png" alt="Logo" />
    </a>
    <button onclick="location.href='hometrainee.php'">Profile</button>
    <button onclick="location.href='traineestorevisit.php'">Store Visit Attendance</button>
    <button onclick="location.href='traineeleave.php'">Request Leave</button>
    <button onclick="location.href='traineemedical.php'">Medical Checkup</button>
    <button onclick="location.href='traineekpi.php'">KPI Report</button>
    <br><br><br><br><br><br><br><br><br>
    <button onclick="location.href='traineelogout.php'">Log Out</button>
</div>

<div class="main-content">
    <h1>Update Medical Record</h1>

    <div class="form-container">
        <form method="post" enctype="multipart/form-data">
            <label for="mc_senddate">Date of Submission:</label>
            <input type="date" id="mc_senddate" name="mc_senddate"
                   value="<?php echo htmlspecialchars($medical['mc_senddate']); ?>" required>

            <label for="mc_date">Medical Checkup Date:</label>
            <input type="date" id="mc_date" name="mc_date"
                   value="<?php echo htmlspecialchars($medical['mc_date']); ?>" required>

            <label for="mc_slip">Medical Slip (Upload if you want to change):</label>
            <input type="file" id="mc_slip" name="mc_slip" accept="image/*,application/pdf">

            <button type="submit">Update</button>
        </form>

        <div style="color: black;" class="back-link" onclick="location.href='traineemedical.php'">← Cancel / Back</div>
    </div>
</div>

</body>
</html>
