<?php
session_start();

if (!isset($_SESSION['trainee_username'])) {
    header('Location: samsunglogintrainee.php');
    exit();
}

include 'dbconnect.php';

$trainee_username = $_SESSION['trainee_username'];

$query = "SELECT trainee_name FROM trainee WHERE trainee_username = '$trainee_username'";
$result_name = mysqli_query($conn, $query);

if ($result_name && mysqli_num_rows($result_name) > 0) {
    $row_name = mysqli_fetch_assoc($result_name);
    $trainee_name = $row_name['trainee_name'];
} else {
    echo "<script>
            alert('Trainee not found!');
            window.location.href = 'hometrainee.php';
          </script>";
    exit();
}

$sql = "SELECT * FROM `leave` WHERE leave_trainee = '$trainee_name' ORDER BY leave_no DESC";
$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Request Leave & Medical Checkup</title>
  <link rel="shortcut icon" href="images/logo.png" />

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: Arial, sans-serif;
      display: flex;
      background-image: url('images/3.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      min-height: 100vh;
      position: relative;
      color: #fff;
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
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 20px;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 2;
    }

    .sidebar img { width: 120px; margin-bottom: 20px; cursor: pointer; }

    .sidebar button {
      width: 80%;
      padding: 12px;
      margin: 8px 0;
      border: none;
      background-color: #fff;
      color: #336699;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .sidebar button:hover {
      background-color: #000;
      color: #fff;
    }

    .main-content {
      margin-left: 250px;
      padding: 40px;
      width: calc(100% - 250px);
      position: relative;
      z-index: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    h1 { margin-bottom: 20px; color: #fff; }

    .page-buttons {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }

    .page-buttons button {
      padding: 12px 24px;
      border: none;
      background-color: #336699;
      color: #fff;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .page-buttons button:hover {
      background-color: #000;
    }

    .leave-form {
      background-color: rgba(255,255,255,0.9);
      padding: 20px;
      border-radius: 10px;
      max-width: 500px;
      width: 100%;
      margin-bottom: 10px;
      display: block;
    }

    .leave-form label {
      color: #333;
      font-weight: bold;
      margin-top: 10px;
      display: block;
    }

    .leave-form input,
    .leave-form select {
      padding: 10px;
      margin-bottom: 10px;
      width: 100%;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .submit-btn {
      background-color: #336699;
      color: #fff;
      padding: 12px;
      border-radius: 5px;
      border: none;
      cursor: pointer;
      transition: 0.3s;
      font-size: 16px;
      width: 100%;
    }

    .submit-btn:hover { background-color: #000; }

    h2.leave-list-title {
      margin-top: 10px;
      color: #fff;
    }

    table {
      width: 100%;
      background-color: rgba(255,255,255,0.9);
      color: #333;
      border-collapse: collapse;
      margin-top: 10px;
      border-radius: 10px;
      overflow: hidden;
      max-width: 800px;
    }

    table th, table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    table th {
      background-color: #336699;
      color: #fff;
    }

    table tr:hover {
      background-color: #f5f5f5;
    }

    .badge {
      display: inline-block;
      padding: 8px 14px;
      font-size: 14px;
      font-weight: 600;
      border-radius: 20px;
      text-align: center;
      transition: background-color 0.3s ease;
    }

    .approved {
      background-color: #28a745;
      color: white;
    }

    .pending {
      background-color: #ffc107;
      color: black;
    }

    .rejected {
      background-color: #dc3545;
      color: white;
    }

  </style>
</head>
<body>

  <!-- Sidebar -->
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

  <!-- Main content -->
  <div class="main-content">
    <h1>Request Leave Page</h1>
    <br>

    <!-- Leave Request Form -->
    <form class="leave-form" method="post" action="submitleave.php">
      <label for="leave_date">Today Date</label>
      <input type="date" name="leave_date" required>

      <label for="leave_category">Leave Category</label>
      <select name="leave_category" required>
        <option value="">Select Category</option>
        <option value="Annual Leave">Annual Leave</option>
        <option value="Medical Leave">Medical Leave</option>
        <option value="Emergency Leave">Emergency Leave</option>
      </select>

      <label for="leave_req">Request Date (Start)</label>
      <input type="date" name="leave_req" required>

      <label for="leave_until">Until (End Date)</label>
      <input type="date" name="leave_until" required>

      <button type="submit" class="submit-btn">Submit</button>
    </form>

    <!-- Leave Request List -->
    <br>
    <h2 class="leave-list-title">Leave Request List</h2>
    <br>

    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>Date</th>
          <th>Category Leave</th>
          <th>Request Date</th>
          <th>Until</th>
          <th>Status</th>
		  <th>Update</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $status = htmlspecialchars($row['leave_status']);
                $badgeClass = '';

                if ($status === 'Approved') {
                    $badgeClass = 'approved';
                } elseif ($status === 'Pending') {
                    $badgeClass = 'pending';
                } elseif ($status === 'Rejected') {
                    $badgeClass = 'rejected';
                }

                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['leave_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['leave_category']) . "</td>";
                echo "<td>" . htmlspecialchars($row['leave_req']) . "</td>";
                echo "<td>" . htmlspecialchars($row['leave_until']) . "</td>";
                echo "<td><span class='badge $badgeClass'>$status</span></td>";
			    echo "<td><a href='traineeleaveupdate.php?leave_no=" . urlencode($row['leave_no']) . "'>Update</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No leave requests found.</td></tr>";
        }
        ?>
      </tbody>
    </table>

  </div>

</body>
</html>

<?php mysqli_close($conn); ?>
