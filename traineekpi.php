<?php
session_start();
include 'dbconnect.php';

if (!isset($_SESSION['trainee_username'])) {
    header('Location: samsunglogintrainee.php');
    exit();
}

$trainee_username = $_SESSION['trainee_username'];

$queryTrainee = "SELECT trainee_name FROM trainee WHERE trainee_username = '$trainee_username'";
$resultTrainee = mysqli_query($conn, $queryTrainee);

if (mysqli_num_rows($resultTrainee) > 0) {
    $rowTrainee = mysqli_fetch_assoc($resultTrainee);
    $trainee_name = $rowTrainee['trainee_name'];
} else {
    echo "<script>alert('Trainee not found.'); window.location.href='samsunglogintrainee.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>KPI Report Page</title>
  <link rel="shortcut icon" href="images/logo.png" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

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

    h1, h2 {
      margin-bottom: 20px;
      color: #fff;
    }

    .kpi-form {
      background-color: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 10px;
      max-width: 600px;
      width: 100%;
      margin-bottom: 20px;
    }

    .kpi-form label {
      color: #333;
      font-weight: bold;
      margin-top: 10px;
      display: block;
    }

    .kpi-form input {
      padding: 12px;
      margin-bottom: 15px;
      width: 100%;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 14px;
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

    .submit-btn:hover {
      background-color: #000;
    }

    table {
      width: 100%;
      background-color: rgba(255, 255, 255, 0.9);
      color: #333;
      border-collapse: collapse;
      margin-top: 10px;
      border-radius: 10px;
      overflow: hidden;
      max-width: 800px;
    }

    table th, table td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    table th {
      background-color: #336699;
      color: #fff;
    }

    table tr:hover {
      background-color: #f5f5f5;
    }

    /* Status badges */
    .status-badge {
      padding: 5px 10px;
      border-radius: 5px;
      font-weight: bold;
      display: inline-block;
    }

    .approved {
      background-color: #28a745;
      color: #fff;
    }

    .pending {
      background-color: #ffc107; 
      color: #000;
    }

    .rejected {
      background-color: #dc3545; 
      color: #fff;
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

  <!-- Main Content -->
  <div class="main-content">
    <br>
    <h1>Key Performance Indicator Report</h1>
    <br>

    <!-- KPI Report Form -->
    <form class="kpi-form" method="post" action="submitkpi.php">
      <label for="report_date">Start Date</label>
      <input type="date" id="report_date" name="kpi_date" required>
      
      <label for="end_date">End Date</label>
      <input type="date" id="end_date" name="kpi_enddate" required>

      <label for="store_visit">Total Store Visit</label>
      <input type="number" id="store_visit" name="kpi_store" required>

      <label for="working_hour">Total Working Hour</label>
      <input type="number" id="working_hour" name="kpi_hour" required>

      <button type="submit" class="submit-btn">Submit</button>
    </form>

    <!-- KPI Report List -->
    <br>
    <h2>KPI Report List</h2>

    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Total Store Visit</th>
          <th>Total Working Hour</th>
          <th>KPI Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $queryKPI = "SELECT * FROM kpi WHERE kpi_trainee = '$trainee_name' ORDER BY kpi_date DESC";
          $resultKPI = mysqli_query($conn, $queryKPI);

          $counter = 1;
          if (mysqli_num_rows($resultKPI) > 0) {
              while ($row = mysqli_fetch_assoc($resultKPI)) {
                  $badgeClass = '';

                  if ($row['kpi_status'] == 'Fully Achieve') {
                      $badgeClass = 'approved';
                  } elseif ($row['kpi_status'] == 'Under Review') {
                      $badgeClass = 'pending';
                  } elseif ($row['kpi_status'] == 'Not Achieve') {
                      $badgeClass = 'rejected';
                  }

                  echo "<tr>
                          <td>{$counter}</td>
                          <td>{$row['kpi_date']}</td>
                          <td>{$row['kpi_enddate']}</td>
                          <td>{$row['kpi_store']}</td>
                          <td>{$row['kpi_hour']}</td>
                          <td><span class='status-badge {$badgeClass}'>{$row['kpi_status']}</span></td>
                        </tr>";
                  $counter++;
              }
          } else {
              echo "<tr><td colspan='6'>No KPI reports found.</td></tr>";
          }

          mysqli_close($conn);
        ?>
      </tbody>
    </table>
  </div>

</body>
</html>
