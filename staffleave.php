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

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$sql_leave = "SELECT * FROM `leave` 
    WHERE leave_trainee LIKE '%$search%' 
    OR leave_date LIKE '%$search%'
    OR leave_category LIKE '%$search%'
    OR leave_req LIKE '%$search%'
    OR leave_until LIKE '%$search%'
    OR leave_status LIKE '%$search%'
    ORDER BY leave_date DESC";

$result_leave = mysqli_query($conn, $sql_leave);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of Leave Requests</title>
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

        .search-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-container input[type="text"] {
            padding: 8px;
            width: 300px;
            border-radius: 5px 0 0 5px;
            border: none;
        }

        .search-container button {
            padding: 8px 16px;
            border: none;
            background-color: #ffffff;
            color: #336699;
            cursor: pointer;
            border-radius: 0 5px 5px 0;
            transition: background-color 0.3s;
        }

        .search-container button:hover {
            background-color: #000000;
            color: #ffffff;
        }

        table {
            width: 100%;
            max-width: 1000px;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.95);
            color: #333;
            border-radius: 10px;
            overflow: hidden;
        }

        table th, table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #336699;
            color: #ffffff;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .status-label {
            padding: 5px 10px;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
            display: inline-block;
        }

        .status-label.pending {
            background-color: #f1c40f; 
        }

        .status-label.approved {
            background-color: #2ecc71; 
        }

        .status-label.rejected {
            background-color: #e74c3c;
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

            table {
                font-size: 12px;
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
    <h1>List of Leave Requests Page</h1>

    <div class="search-container">
        <form method="get" action="">
            <input type="text" name="search" placeholder="Search anything..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    <br>
    <?php if ($search != ''): ?>
        <p style="color: #ffffff;">Showing results for: <strong><?php echo htmlspecialchars($search); ?></strong></p>
    <?php endif; ?>

    <table>
        <tr>
            <th>No.</th>
            <th>Trainee Name</th>
            <th>Date</th>
            <th>Category Leave</th>
            <th>Request Date</th>
            <th>Until</th>
            <th>Status</th>
            <th>Update</th>
        </tr>

        <?php
        if (mysqli_num_rows($result_leave) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($result_leave)) {
               
                $status = htmlspecialchars($row['leave_status']);
                $statusColor = '';

                if (strtolower($status) === 'approved') {
                    $statusColor = 'approved';
                } elseif (strtolower($status) === 'pending') {
                    $statusColor = 'pending';
                } elseif (strtolower($status) === 'rejected') {
                    $statusColor = 'rejected';
                }

                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['leave_trainee']) . "</td>";
                echo "<td>" . htmlspecialchars($row['leave_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['leave_category']) . "</td>";
                echo "<td>" . htmlspecialchars($row['leave_req']) . "</td>";
                echo "<td>" . htmlspecialchars($row['leave_until']) . "</td>";
                echo "<td><span class='status-label {$statusColor}'>" . $status . "</span></td>";
                echo "<td><a href='staffleaveupdate.php?leave_no=" . urlencode($row['leave_no']) . "'>Update</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No leave requests found.</td></tr>";
        }

        mysqli_close($conn);
        ?>
    </table>
</div>

</body>
</html>
