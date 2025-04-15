<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "samsung");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$staff_username = $_SESSION['staff_username'];

$fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$area = mysqli_real_escape_string($conn, $_POST['coverage']);


if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profile_image']['tmp_name'];
    $fileName = $_FILES['profile_image']['name'];
    $fileSize = $_FILES['profile_image']['size'];
    $fileType = $_FILES['profile_image']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

    if (in_array($fileExtension, $allowedfileExtensions)) {
		
        $newFileName = $staff_username . '_' . time() . '.' . $fileExtension;

   
        $uploadFileDir = 'images/uploads/';
        if (!file_exists($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
          
            $update_query = "UPDATE staff 
                            SET staff_name='$fullname', 
                                staff_phone='$phone', 
                                staff_email='$email', 
                                staff_area='$area', 
                                staff_picture='$dest_path' 
                            WHERE staff_username='$staff_username'";

            if (mysqli_query($conn, $update_query)) {
                header('Location: homestaff.php?status=success');
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
  
    $update_query = "UPDATE staff 
                    SET staff_name='$fullname', 
                        staff_phone='$phone', 
                        staff_email='$email', 
                        staff_area='$area' 
                    WHERE staff_username='$staff_username'";

    if (mysqli_query($conn, $update_query)) {
        header('Location: homestaff.php?status=success');
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
