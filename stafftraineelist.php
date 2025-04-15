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

$sql_trainee = "SELECT * FROM trainee 
    WHERE trainee_username LIKE '%$search%' 
    OR trainee_name LIKE '%$search%'
    OR trainee_email LIKE '%$search%'
    OR trainee_phone LIKE '%$search%'
    OR trainee_area LIKE '%$search%'
    ORDER BY trainee_name ASC";

$result_trainee = mysqli_query($conn, $sql_trainee);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trainee List</title>
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

        .search-container {
            margin-bottom: 20px;
            display: flex;
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

        .profile-pic {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }

        .add-profile-btn {
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            background-color: #ffffff;
            color: #336699;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-profile-btn:hover {
            background-color: #000000;
            color: #ffffff;
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
        <h1>List of Trainees</h1>

        <div class="search-container">
            <form method="get">
                <input type="text" name="search" placeholder="Search trainees..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button><br>
            </form>
        </div>
		 <button class="add-profile-btn" onclick="location.href='traineeadd.php'">Add New Trainee</button>
<br>
		<?php if ($search != ''): ?>
        <p style="color: #ffffff;">Showing results for: <strong><?php echo htmlspecialchars($search); ?></strong></p>
    <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Coverage Area</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result_trainee) > 0) {
                    $num = 1;
                    while ($row = mysqli_fetch_assoc($result_trainee)) {
                        echo "<tr>";
                        echo "<td>" . $num++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['trainee_username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['trainee_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['trainee_phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['trainee_email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['trainee_area']) . "</td>";
                        echo "<td><a href='traineeupdate.php?id=" . $row['trainee_username'] . "'>Update</a></td>";
                        echo "<td><a href='traineedelete.php?id=" . $row['trainee_username'] . "' onclick='return confirm(\"Are you sure you want to delete this trainee?\")'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No trainees found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

       
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
