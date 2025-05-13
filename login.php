<?php
// first of all, we need to connect to the database
require_once('connect.php');

// we need to check if the input in the form textfields are not empty
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['mobile'])) {
    // get the input values
    $u = $_POST['username'];
    $p = $_POST['password'];
    $m = $_POST['mobile'];

    // write the query to check if this username, password, and mobile exist in our database
    $sql = "SELECT * FROM user WHERE username = '$u' AND password = '$p' AND mobile = '$m'";

    // Execute the query 
    $result = mysqli_query($conn, $sql);

    // Check if it returns a non-empty set
    if ($result && mysqli_num_rows($result) != 0) {
        $row = mysqli_fetch_assoc($result); // fetch the row
        
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['mobile'] = $row['mobile'];
        
        // Check role from database
        if ($row['role'] == 'host') {
            header("Location: home_host.php");
            exit();
        } elseif ($row['role'] == 'user') {
            header("Location: home.php");
            exit();
        } else {
            // Unexpected role
            header("Location: login.php");
            exit();
        }
    } else {
        // Username, Password, or Mobile is wrong
        header("Location: login.php");
        exit();
    }
}
?>

