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

$username = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

if ($username != '') {
    $sql_delete = "DELETE FROM staff WHERE staff_username='$username'";

    if (mysqli_query($conn, $sql_delete)) {
        header("Location: stafflist.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "No staff selected for deletion!";
}

mysqli_close($conn);
?>
