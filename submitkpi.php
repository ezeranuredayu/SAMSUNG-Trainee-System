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

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $trainee_name = $row['trainee_name']; 
} else {
    echo "<script>alert('Trainee not found.'); window.location.href='traineekpi.php';</script>";
    exit();
}

$kpi_date = $_POST['kpi_date'];
$kpi_enddate = $_POST['kpi_enddate'];
$kpi_store = $_POST['kpi_store'];
$kpi_hour = $_POST['kpi_hour'];

$kpi_status = "Under Review";

$sql = "INSERT INTO kpi (
            kpi_trainee, 
            kpi_date, 
            kpi_enddate, 
            kpi_store, 
            kpi_hour, 
            kpi_status
        ) VALUES (
            '$trainee_name', 
            '$kpi_date', 
            '$kpi_enddate', 
            '$kpi_store', 
            '$kpi_hour', 
            '$kpi_status'
        )";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('KPI Report submitted successfully!'); window.location.href='traineekpi.php';</script>";
} else {
    echo "<script>alert('Database error: " . mysqli_error($conn) . "'); window.location.href='traineekpi.php';</script>";
}

mysqli_close($conn);
?>
