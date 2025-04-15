<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "samsung");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$trainee_username = $_SESSION['trainee_username'];

$fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$coverage = mysqli_real_escape_string($conn, $_POST['coverage']);

if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profile_image']['tmp_name'];
    $fileName = $_FILES['profile_image']['name'];
    $fileSize = $_FILES['profile_image']['size'];
    $fileType = $_FILES['profile_image']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

    if (in_array($fileExtension, $allowedfileExtensions)) {
		
        $newFileName = $trainee_username . '_' . time() . '.' . $fileExtension;

        $uploadFileDir = 'images/uploads/';
        if (!file_exists($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
           
            $update_query = "UPDATE trainee SET trainee_name='$fullname', trainee_phone='$phone', trainee_email='$email', trainee_area='$coverage', trainee_picture='$dest_path' WHERE trainee_username='$trainee_username'";

            if (mysqli_query($conn, $update_query)) {
                header('Location: hometrainee.php?status=success');
                exit();
            } else {
                echo "Error updating profile with image: " . mysqli_error($conn);
            }
        } else {
            echo 'Error moving the uploaded file!';
        }
    } else {
        echo 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
} else {
  
    $update_query = "UPDATE trainee SET trainee_name='$fullname', trainee_phone='$phone', trainee_email='$email', trainee_area='$coverage' WHERE trainee_username='$trainee_username'";

    if (mysqli_query($conn, $update_query)) {
        header('Location: hometrainee.php?status=success');
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
