<?php
// Connect to the database
require_once('connect.php');

// Check if we received the required parameters
if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['action'])) {
    // Get the parameters
    $id = (int)$_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $action = $_POST['action'];
    
    // First, get the current amount using the name as primary key
    $query = "SELECT amount FROM food WHERE name = '$name'";
    $result = mysqli_query($conn, $query);
    
    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentAmount = $row['amount'];
        
        // Calculate new amount based on action
        $newAmount = $currentAmount;
        if($action === 'increase') {
            $newAmount = $currentAmount + 1;
        } elseif($action === 'decrease') {
            // Don't allow negative amounts
            $newAmount = max(0, $currentAmount - 1);
        }
        
        // Update the amount in the database
        $updateQuery = "UPDATE food SET amount = $newAmount WHERE name = '$name'";
        $updateResult = mysqli_query($conn, $updateQuery);
        
        if($updateResult) {
            // Check if rows were affected
            if(mysqli_affected_rows($conn) > 0) {
                $action_text = ($action === 'increase') ? 'increased' : 'decreased';
                $success_message = "Amount for '{$name}' {$action_text} successfully.";
                header("Location: home_host.php?success=" . urlencode($success_message));
                exit();
            } else {
                $error_message = "No changes made to amount for '{$name}'.";
                header("Location: home_host.php?error=" . urlencode($error_message));
                exit();
            }
        } else {
            $error_message = "Failed to update amount for '{$name}'. Error: " . mysqli_error($conn);
            header("Location: home_host.php?error=" . urlencode($error_message));
            exit();
        }
    } else {
        $error_message = "Failed to find item '{$name}' in the database. Error: " . mysqli_error($conn);
        header("Location: home_host.php?error=" . urlencode($error_message));
        exit();
    }
} else {
    // If parameters are missing, return an error
    $error_message = "Missing required parameters.";
    header("Location: home_host.php?error=" . urlencode($error_message));
    exit();
}

// Close the database connection
mysqli_close($conn);
?>