<?php
session_start();
include('dbconnect.php'); 

if (isset($_POST['submit'])) {
    $myusername1 = $_POST['username'];
    $mypassword2 = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM staff WHERE staff_username = ? AND staff_password = ?");
    $stmt->bind_param("ss", $myusername1, $mypassword2);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION["staff_username"] = $myusername1; 

        header("Location: homestaff.php");
        exit();
   } else {
    echo "<script>
            alert('Wrong username or password, Please try again!');
            window.location.href = 'index.php';
          </script>";
}
	
    $stmt->close();
    $conn->close();
}
?>
