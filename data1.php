<?php
session_start();
include('dbconnect.php'); 

if (isset($_POST['submit'])) {
    $myusername1 = $_POST['username'];
    $mypassword2 = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM trainee WHERE trainee_username = ? AND trainee_password = ?");
    $stmt->bind_param("ss", $myusername1, $mypassword2);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION["trainee_username"] = $myusername1; 

        header("Location: hometrainee.php");
        exit();
   } else {
    echo "<script>
            alert('Wrong username or password, Please try again!');
            window.location.href = 'samsunglogintrainee.php';
          </script>";
}
	
    $stmt->close();
    $conn->close();
}
?>
