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
            window.location.href = 'traineemedical.php'; 
          </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mc_senddate = mysqli_real_escape_string($conn, $_POST['mc_senddate']);
    $mc_date = mysqli_real_escape_string($conn, $_POST['mc_date']);

    $target_dir = "uploads/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["mc_slip"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($_FILES["mc_slip"]["size"] > 5000000) { 
        echo "<script>alert('File is too large.'); window.location.href='traineemedical.php';</script>";
        $uploadOk = 0;
    }

    $allowed_types = array("jpg", "jpeg", "png", "pdf");
    if (!in_array($fileType, $allowed_types)) {
        echo "<script>alert('Only JPG, PNG, and PDF files are allowed.'); window.location.href='traineemedical.php';</script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.'); window.location.href='traineemedical.php';</script>";
    } else {
		
        if (move_uploaded_file($_FILES["mc_slip"]["tmp_name"], $target_file)) {

            $filename = basename($_FILES["mc_slip"]["name"]);

            $sql = "INSERT INTO medical 
                    (mc_trainee, mc_senddate, mc_date, mc_slip) 
                    VALUES 
                    ('$trainee_name', '$mc_senddate', '$mc_date', '$filename')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>
                        alert('Medical submission uploaded successfully!');
                        window.location.href = 'traineemedical.php'; 
                      </script>";
            } else {
                echo "<script>
                        alert('Database error: " . mysqli_error($conn) . "');
                        window.location.href = 'traineemedical.php'; 
                      </script>";
            }

        } else {
            echo "<script>
                    alert('Sorry, there was an error uploading your file.');
                    window.location.href = 'traineemedical.php'; 
                  </script>";
        }
    }

} else {
    header("Location: traineemedical.php");
    exit();
}

mysqli_close($conn);
?>
