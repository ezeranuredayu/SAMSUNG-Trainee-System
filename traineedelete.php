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
    $delete_sql = "DELETE FROM trainee WHERE trainee_username = '$username'";

    if (mysqli_query($conn, $delete_sql)) {
        header("Location: stafftraineelist.php?msg=deleted");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid trainee ID!";
}

mysqli_close($conn);
?>
