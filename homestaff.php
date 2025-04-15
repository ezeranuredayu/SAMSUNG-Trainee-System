<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Profile Page</title>
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

    .profile-pic-container {
      position: relative;
      margin-bottom: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .profile-pic {
      width: 150px;
      height: 150px;
      background-color: #ccc;
      border-radius: 50%;
      background-size: cover;
      background-position: center;
      border: 3px solid #fff;
    }

    .upload-btn {
      margin-top: 10px;
      padding: 8px 16px;
      background-color: #ffffff;
      color: #336699;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .upload-btn:hover {
      background-color: #000000;
      color: #ffffff;
    }

    .profile-form {
      width: 100%;
      max-width: 400px;
      display: flex;
      flex-direction: column;
      background-color: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 10px;
    }

    .profile-form label {
      margin-bottom: 5px;
      color: #333;
      font-weight: bold;
    }

    .profile-form input {
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .edit-btn {
      background-color: #336699;
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .edit-btn:hover {
      background-color: #000000;
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

$staff_username = $_SESSION['staff_username'];

$sql_profile = "SELECT * FROM staff WHERE staff_username = '$staff_username'";
$result_profile = mysqli_query($conn, $sql_profile);

if (mysqli_num_rows($result_profile) > 0) {
    $staff = mysqli_fetch_assoc($result_profile);
    
    $profile_image = (!empty($staff['staff_picture'])) ? $staff['staff_picture'] : 'https://cdn-icons-png.flaticon.com/512/149/149071.png';

} else {
    echo "No staff data found!";
    exit();
}
?>

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
  <h1>Staff Profile Page</h1>

  <div class="profile-pic-container">
    <div class="profile-pic" id="profilePic" style="background-image: url('<?php echo $profile_image; ?>');"></div>
   
    <button type="button" class="upload-btn" onclick="triggerUpload()">Upload Photo</button>
  </div>

  <form class="profile-form" method="post" action="updateprofilestaff.php" enctype="multipart/form-data">
    <input type="file" id="profile_image" name="profile_image" accept="image/*" style="display:none;" onchange="previewImage(event)">
    
    <label for="username">Username</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($staff['staff_username']); ?>" readonly>

    <label for="fullname">Full Name</label>
    <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($staff['staff_name']); ?>" required>

    <label for="phone">Phone Number</label>
    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($staff['staff_phone']); ?>" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($staff['staff_email']); ?>" required>

    <label for="coverage">Coverage Area</label>
    <input type="text" id="coverage" name="coverage" value="<?php echo htmlspecialchars($staff['staff_area']); ?>" required>

    <button type="submit" class="edit-btn">Save Changes</button>
  </form>
</div>

<script>
  function triggerUpload() {
    document.getElementById('profile_image').click();
  }

  function previewImage(event) {
    const file = event.target.files[0];
    const profilePic = document.getElementById('profilePic');

    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        profilePic.style.backgroundImage = `url('${e.target.result}')`;
      }
      reader.readAsDataURL(file);
    }
  }
</script>

</body>
</html>
