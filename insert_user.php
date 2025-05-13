<?php
require_once('connect.php');

if (isset($_POST['username'], $_POST['password'], $_POST['Confirm_Password'], $_POST['mobile'], $_POST['role'])) {
    
    // Get form data
    $u = $_POST['username'];
    $p = $_POST['password'];
    $cp = $_POST['Confirm_Password'];
    $a = $_POST['mobile'];
    $r = $_POST['role'];
    
    // Check if password and confirm password match
    if ($p !== $cp) {
        // If passwords don't match, redirect back with error
        echo "<script>
            alert('Passwords do not match. Please try again.');
            window.location.href = 'client_registration.php';
        </script>";
        exit();
    }
    
    // If passwords match, prepare statement for database insertion
    $stmt = $conn->prepare("INSERT INTO user (username, password, mobile, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $u, $p, $a, $r);
    
    if ($stmt->execute()) {
        header("Location: firstpage.php");
    } else {
        echo "<script>
            alert('Registration failed. Please try again.');
            window.location.href = 'client_registration.php';
        </script>";
    }
    
    $stmt->close();
} else {
    // If required fields are missing
    echo "<script>
        alert('Please fill in all required fields.');
        window.location.href = 'client_registration.php';
    </script>";
}
?>