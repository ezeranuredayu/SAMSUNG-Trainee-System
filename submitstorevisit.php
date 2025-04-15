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
    echo "<script>alert('Trainee not found.'); window.location.href='traineestorevisit.php';</script>";
    exit();
}

$store_date = $_POST['store_date'];
$store_outlet = $_POST['store_outlet'];
$store_category = $_POST['store_category'];
$store_topic = $_POST['store_topic'];
$store_pic = $_POST['store_pic'];

$target_dir = "uploads/";

$dealer_chop_file = $target_dir . basename($_FILES["store_chop"]["name"]);
$dealer_chop_tmp = $_FILES["store_chop"]["tmp_name"];
move_uploaded_file($dealer_chop_tmp, $dealer_chop_file);

$store_picture_file = $target_dir . basename($_FILES["store_picture"]["name"]);
$store_picture_tmp = $_FILES["store_picture"]["tmp_name"];
move_uploaded_file($store_picture_tmp, $store_picture_file);

$sql = "INSERT INTO store_visit 
    (store_trainee, store_date, store_outlet, store_category, store_topic, store_pic, store_chop, store_picture)
    VALUES 
    ('$trainee_name', '$store_date', '$store_outlet', '$store_category', '$store_topic', '$store_pic', '$dealer_chop_file', '$store_picture_file')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Store visit attendance submitted successfully!'); window.location.href='traineestorevisit.php';</script>";
} else {
    echo "<script>alert('Error: " . addslashes($conn->error) . "'); window.location.href='traineestorevisit.php';</script>";
}

$conn->close();
?>
