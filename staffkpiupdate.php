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

$kpi_no = isset($_GET['kpi_no']) ? intval($_GET['kpi_no']) : 0;

$sql = "SELECT * FROM kpi WHERE kpi_no = $kpi_no";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "KPI report not found.";
    exit();
}

$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kpi_status = mysqli_real_escape_string($conn, $_POST['kpi_status']);

    $update_sql = "UPDATE kpi SET kpi_status = '$kpi_status' WHERE kpi_no = $kpi_no";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('KPI report updated successfully.'); window.location.href='staffkpi.php';</script>";
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update KPI Report</title>
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

        form {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            color: #333;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        form input[type="text"],
        form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        form button {
            width: 100%;
            padding: 12px;
            background-color: #336699;
            color: #fff;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #000000;
        }

        .back-button {
            margin-top: 20px;
            text-align: center;
        }

        .back-button a {
            color: #ffffff;
            text-decoration: underline;
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

            form {
                width: 90%;
            }
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
    <h1>Update KPI Report</h1>

    <form method="POST" action="">
        <label for="kpi_trainee">Trainee Name</label>
        <input type="text" id="kpi_trainee" name="kpi_trainee" value="<?php echo htmlspecialchars($row['kpi_trainee']); ?>" readonly>

        <label for="kpi_date">Date</label>
        <input type="text" id="kpi_date" name="kpi_date" value="<?php echo htmlspecialchars($row['kpi_date']); ?>" readonly>

        <label for="kpi_store">Store</label>
        <input type="text" id="kpi_store" name="kpi_store" value="<?php echo htmlspecialchars($row['kpi_store']); ?>" readonly>

        <label for="kpi_hour">Hour</label>
        <input type="text" id="kpi_hour" name="kpi_hour" value="<?php echo htmlspecialchars($row['kpi_hour']); ?>" readonly>

        <label for="kpi_status">Status</label>
        <select name="kpi_status" id="kpi_status" required>
            <option value="">-- Select Status --</option>
            <option value="Pending" <?php if ($row['kpi_status'] === 'Pending') echo 'selected'; ?>>Under Review</option>
            <option value="Fully Achieve" <?php if ($row['kpi_status'] === 'Fully Achieve') echo 'selected'; ?>>Fully Achieve</option>
            <option value="Not Achieve" <?php if ($row['kpi_status'] === 'Not Achieve') echo 'selected'; ?>>Not Achieve</option>
        </select>

        <button type="submit">Update KPI</button>
		
 		<div style="color: black;" class="back-link" onclick="location.href='staffkpi.php'"><br>← Back to KPI Report List</div>
        
    </form>
</div>

</body>
</html>
