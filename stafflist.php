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

$sql_staff = "SELECT * FROM staff 
    WHERE staff_username LIKE '%$search%' 
    OR staff_name LIKE '%$search%'
    OR staff_email LIKE '%$search%'
    OR staff_phone LIKE '%$search%'
    OR staff_area LIKE '%$search%'
    ORDER BY staff_name ASC";

$result_staff = mysqli_query($conn, $sql_staff);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff List</title>
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
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
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

        @media screen and (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
                width: calc(100% - 200px);
                padding: 20px;
            }

            table {
                font-size: 14px;
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
    <h1>List of Staff</h1>

    <div class="search-container">
        <form method="get">
            <input type="text" name="search" placeholder="Search staff..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <button class="add-profile-btn" onclick="location.href='staffadd.php'">Add New Staff</button>
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
            if (mysqli_num_rows($result_staff) > 0) {
                $num = 1;
                while ($row = mysqli_fetch_assoc($result_staff)) {
                    echo "<tr>";
                    echo "<td>" . $num++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['staff_username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['staff_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['staff_phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['staff_email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['staff_area']) . "</td>";
                    echo "<td><a href='staffupdate.php?id=" . $row['staff_username'] . "'>Update</a></td>";
                    echo "<td><a href='staffdelete.php?id=" . $row['staff_username'] . "' onclick='return confirm(\"Are you sure you want to delete this staff?\")'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No staff found.</td></tr>";
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
