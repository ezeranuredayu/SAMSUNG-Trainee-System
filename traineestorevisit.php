<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Store Visit Attendance</title>
  <link rel="shortcut icon" href="images/logo.png" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      display: flex;
      background-image: url('images/3.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
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

    /* Sidebar */
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

    /* Main content */
    .main-content {
      margin-left: 250px;
      padding: 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
      z-index: 1;
      position: relative;
      width: calc(100% - 250px);
    }

    .main-content h1 {
      color: #ffffff;
      margin-bottom: 30px;
    }

    .attendance-form {
      width: 100%;
      max-width: 500px;
      display: flex;
      flex-direction: column;
      background-color: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 10px;
    }

    .attendance-form label {
      margin-bottom: 5px;
      color: #333;
      font-weight: bold;
    }

    .attendance-form input[type="text"],
    .attendance-form input[type="date"],
    .attendance-form textarea {
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      width: 100%;
    }

    .attendance-form input[type="file"] {
      margin-bottom: 15px;
      color: #333;
    }

    .submit-btn {
      background-color: #336699;
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      font-size: 16px;
    }

    .submit-btn:hover {
      background-color: #000000;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        flex-direction: row;
        justify-content: space-around;
        position: relative;
      }

      .main-content {
        margin-left: 0;
        width: 100%;
        margin-top: 100px;
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

<?php
session_start();
if (!isset($_SESSION['trainee_username'])) {
    header('Location: samsunglogintrainee.php');
    exit();
}
?>

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
  <h1>Store Visit Attendance Page</h1>

  <form class="attendance-form" method="post" action="submitstorevisit.php" enctype="multipart/form-data">
    
    <label for="date">Date</label>
    <input type="date" id="date" name="store_date" required>

    <label for="location">Outlet Location</label>
    <input type="text" id="location" name="store_outlet" placeholder="Enter outlet location" required>

    <label for="category">Store Category</label>
    <input type="text" id="category" name="store_category" placeholder="Enter store category" required>

    <label for="remark">Training Topic / Remark</label>
    <textarea id="remark" name="store_topic" rows="3" placeholder="Enter training topic or remarks" required></textarea>

    <label for="pic">PIC Name / Contact</label>
    <input type="text" id="pic" name="store_pic" placeholder="Enter PIC name or contact" required>

    <label for="dealer_chop">Dealer Chop & PIC Sign</label>
    <input type="file" id="dealer_chop" name="store_chop" accept=".jpg,.png,.pdf" required>

    <label for="store_picture">Store Picture</label>
    <input type="file" id="store_picture" name="store_picture" accept=".jpg,.png,.jpeg" required>

    <button type="submit" class="submit-btn">Submit</button>

  </form>
</div>

</body>
</html>
