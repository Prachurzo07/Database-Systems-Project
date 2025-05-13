<?php
// Include database connection
require_once('connect.php');

// Check if name is provided
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $name = $_GET['name'];
    
    // First check if the connection is valid
    if (!$conn) {
        header("Location: home_host.php?error=Database connection failed");
        exit();
    }
    
    // Sanitize the name parameter to prevent SQL injection
    $sanitized_name = mysqli_real_escape_string($conn, $name);
    
    // Create DELETE query based on name
    $sql = "DELETE FROM food WHERE name = '$sanitized_name'";
    
    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Check if any rows were affected
        if (mysqli_affected_rows($conn) > 0) {
            // Success - redirect back to home_host.php with success message
            header("Location: home_host.php?success=Item '" . urlencode($name) . "' has been deleted successfully");
            exit();
        } else {
            // No rows were deleted - item might not exist
            header("Location: home_host.php?error=Item '" . urlencode($name) . "' was not found in the database");
            exit();
        }
    } else {
        // Error - redirect back to home_host.php with error message
        header("Location: home_host.php?error=Failed to delete item: " . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    // No name provided - redirect back to home_host.php with error message
    header("Location: home_host.php?error=Food name not provided");
    exit();
}

// Close database connection
mysqli_close($conn);
?>