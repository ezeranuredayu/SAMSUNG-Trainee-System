<?php
session_start();

if (!isset($_SESSION['trainee_username'])) {
    header('Location: samsunglogintrainee.php');
    exit();
}

include 'dbconnect.php';

$trainee_username = $_SESSION['trainee_username'];

$query = "SELECT trainee_name FROM trainee WHERE trainee_username = '$trainee_username'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $trainee_name = $row['trainee_name'];
} else {
    echo "<script>
            alert('Error: Trainee not found!');
            window.location.href = 'traineeleave.php'; 
          </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $leave_date = mysqli_real_escape_string($conn, $_POST['leave_date']);
    $leave_category = mysqli_real_escape_string($conn, $_POST['leave_category']);
    $leave_req = mysqli_real_escape_string($conn, $_POST['leave_req']);
    $leave_until = mysqli_real_escape_string($conn, $_POST['leave_until']);

    $leave_status = "Pending";

    $sql = "INSERT INTO `leave` 
            (`leave_trainee`, `leave_date`, `leave_category`, `leave_req`, `leave_until`, `leave_status`) 
            VALUES 
            ('$trainee_name', '$leave_date', '$leave_category', '$leave_req', '$leave_until', '$leave_status')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Leave request submitted successfully!');
                window.location.href = 'traineeleave.php'; 
              </script>";
    } else {
        echo "<script>
                alert('Error submitting leave request: " . mysqli_error($conn) . "');
                window.location.href = 'traineeleave.php'; 
              </script>";
    }

} else {
    header("Location: traineeleave.php");
    exit();
}

mysqli_close($conn);
?>
