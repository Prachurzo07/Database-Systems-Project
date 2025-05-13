<?php
// First of all, we need to connect to the database
require_once('connect.php');

// We need to check if the input in the form text fields are not empty
if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['amount']) && isset($_POST['category']) && isset($_POST['healthtag'])) {
    // Assign form values to variables and sanitize them
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $healthtag = mysqli_real_escape_string($conn, $_POST['healthtag']);
    
    // First check if a product with the same name and price already exists
    $check_sql = "SELECT * FROM food WHERE name = '$name' AND price = '$price'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        // Product already exists, update the amount
        $update_sql = "UPDATE food SET amount = amount + $amount WHERE name = '$name' AND price = '$price'";
        $update_result = mysqli_query($conn, $update_sql);
        
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>
                alert('Product amount updated successfully!');
                window.location.href = 'insert_food.php';
            </script>";
        } else {
            echo "<script>
                alert('Failed to update product amount. Please try again.');
                window.location.href = 'insert_food.php';
            </script>";
        }
    } else {
        // Product doesn't exist, insert new record
        $insert_sql = "INSERT INTO food (name, amount, price, category, healthtag) 
                VALUES ('$name', '$amount', '$price', '$category', '$healthtag')";
        
        $insert_result = mysqli_query($conn, $insert_sql);
        
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>
                alert('New food item inserted successfully!');
                window.location.href = 'insert_food.php';
            </script>";
        } else {
            echo "<script>
                alert('Failed to insert food. Please try again.');
                window.location.href = 'insert_food.php';
            </script>";
        }
    }
} else {
    // If any field is missing
    echo "<script>
        alert('All fields are required!');
        window.location.href = 'insert_food.php';
    </script>";
}
?>
