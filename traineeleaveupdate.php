<?php
session_start();
if (!isset($_SESSION['trainee_username'])) {
    header('Location: index.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "samsung");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$leave_no = isset($_GET['leave_no']) ? intval($_GET['leave_no']) : 0;

// Fetch the leave details
$sql_leave = "SELECT * FROM `leave` WHERE leave_no = '$leave_no'";
$result = mysqli_query($conn, $sql_leave);

if (mysqli_num_rows($result) != 1) {
    echo "Leave request not found.";
    exit();
}

$leave = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $leave_date = mysqli_real_escape_string($conn, $_POST['leave_date']);
    $leave_category = mysqli_real_escape_string($conn, $_POST['leave_category']);
    $leave_req = mysqli_real_escape_string($conn, $_POST['leave_req']);
    $leave_until = mysqli_real_escape_string($conn, $_POST['leave_until']);

    $update_sql = "UPDATE `leave` 
                   SET leave_date = '$leave_date', 
                       leave_category = '$leave_category', 
                       leave_req = '$leave_req', 
                       leave_until = '$leave_until' 
                   WHERE leave_no = '$leave_no'";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Leave request updated successfully.'); window.location.href='traineeleave.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Leave Request</title>
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
            top: 0;
            left: 0;
            bottom: 0;
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
    <h1>Update Your Leave Request</h1>

    <div class="form-container">
        <form method="post" action="">
            <label for="leave_trainee">Trainee Name</label>
            <input type="text" id="leave_trainee" name="leave_trainee"
                   value="<?php echo htmlspecialchars($leave['leave_trainee']); ?>" readonly>

            <label for="leave_date">Today Date</label>
            <input type="date" id="leave_date" name="leave_date"
                   value="<?php echo htmlspecialchars($leave['leave_date']); ?>" required>

            <label for="leave_category">Leave Category</label>
            <select name="leave_category" id="leave_category" required>
                <option value="">Select Category</option>
                <option value="Annual Leave" <?php if($leave['leave_category'] == 'Annual Leave') echo 'selected'; ?>>Annual Leave</option>
                <option value="Medical Leave" <?php if($leave['leave_category'] == 'Medical Leave') echo 'selected'; ?>>Medical Leave</option>
                <option value="Emergency Leave" <?php if($leave['leave_category'] == 'Emergency Leave') echo 'selected'; ?>>Emergency Leave</option>
            </select>

            <label for="leave_req">Request Date</label>
            <input type="date" id="leave_req" name="leave_req"
                   value="<?php echo htmlspecialchars($leave['leave_req']); ?>" required>

            <label for="leave_until">Until</label>
            <input type="date" id="leave_until" name="leave_until"
                   value="<?php echo htmlspecialchars($leave['leave_until']); ?>" required>

            <label for="leave_status">Status</label>
            <input type="text" id="leave_status"
                   value="<?php echo htmlspecialchars($leave['leave_status']); ?>" readonly>

            <button type="submit">Update Leave Request</button>
        </form>

        <div style="color: black;" class="back-link" onclick="location.href='traineeleave.php'">← Back to Leave Requests</div>
    </div>
</div>

</body>
</html>
