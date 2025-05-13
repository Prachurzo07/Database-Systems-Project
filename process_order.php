<?php
session_start();
include 'connect.php';

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to generate unique token number
function generateToken($conn) {
    // Get the highest token number from a tokens table (create this table if not exists)
    $sql = "CREATE TABLE IF NOT EXISTS order_tokens (
        token_id INT AUTO_INCREMENT PRIMARY KEY,
        order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql);
    
    // Insert new token
    $sql = "INSERT INTO order_tokens (token_id) VALUES (NULL)";
    $conn->query($sql);
    
    // Return the new token ID
    return $conn->insert_id;
}

// Check if checkout items exist in session
if (!isset($_SESSION['checkout_items']) || empty($_SESSION['checkout_items'])) {
    header("Location: checkout.php");
    exit;
}

// Generate a unique token for this order
$token = generateToken($conn);
$orderSuccess = false;
$errorMessage = "";

// Process each item in the checkout
$items = $_SESSION['checkout_items'];
$orderSuccess = true;

// Create pending_orders table if it doesn't exist
$createPendingOrdersTable = "CREATE TABLE IF NOT EXISTS pending_orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    token_number INT NOT NULL,
    order_details TEXT NOT NULL,
    order_total DECIMAL(10,2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'delivered') DEFAULT 'pending'
)";
mysqli_query($conn, $createPendingOrdersTable);

// Modified approach: Group items by name and sum quantities
$groupedItems = [];
foreach ($items as $item) {
    $name = $item['name'];
    $price = (int)$item['price'];
    $amount = (int)$item['quantity'];
    
    // If the item already exists in our grouped array, just add to the quantity
    if (isset($groupedItems[$name])) {
        $groupedItems[$name]['amount'] += $amount;
    } else {
        // First time seeing this item
        $groupedItems[$name] = [
            'name' => $name,
            'price' => $price,
            'amount' => $amount
        ];
    }
}

// Now process each unique item
foreach ($groupedItems as $item) {
    $name = mysqli_real_escape_string($conn, $item['name']);
    $price = $item['price'];
    $amount = $item['amount'];
    
    // Begin transaction to ensure data consistency
    mysqli_begin_transaction($conn);
    
    try {
        // 1. First check if we have enough quantity in the food table
        $checkFoodSql = "SELECT amount FROM food WHERE name = '$name'";
        $foodResult = mysqli_query($conn, $checkFoodSql);
        
        if (mysqli_num_rows($foodResult) > 0) {
            $foodRow = mysqli_fetch_assoc($foodResult);
            $currentAmount = $foodRow['amount'];
            
            // Check if we have enough quantity
            if ($currentAmount < $amount) {
                throw new Exception("Not enough $name available. Only $currentAmount left.");
            }
            
            // 2. Update the food table to decrease the amount
            $newFoodAmount = $currentAmount - $amount;
            $updateFoodSql = "UPDATE food SET amount = $newFoodAmount WHERE name = '$name'";
            if (!mysqli_query($conn, $updateFoodSql)) {
                throw new Exception("Error updating food inventory: " . mysqli_error($conn));
            }
            
            // 3. Check if this item already exists in the sold_item table
            $checkSoldSql = "SELECT * FROM sold_item WHERE name = '$name'";
            $soldResult = mysqli_query($conn, $checkSoldSql);
            
            if (mysqli_num_rows($soldResult) > 0) {
                // Item exists in sold_item, update the amount
                $soldRow = mysqli_fetch_assoc($soldResult);
                $newSoldAmount = $soldRow['amount'] + $amount;
                
                $updateSoldSql = "UPDATE sold_item SET amount = $newSoldAmount WHERE name = '$name'";
                if (!mysqli_query($conn, $updateSoldSql)) {
                    throw new Exception("Error updating sold items: " . mysqli_error($conn));
                }
            } else {
                // Item doesn't exist in sold_item, insert new record
                $insertSql = "INSERT INTO sold_item (name, price, amount) VALUES ('$name', $price, $amount)";
                if (!mysqli_query($conn, $insertSql)) {
                    throw new Exception("Error: " . mysqli_error($conn));
                }
            }
            
            // Commit the transaction if everything was successful
            mysqli_commit($conn);
        } else {
            throw new Exception("Item '$name' not found in inventory.");
        }
    } catch (Exception $e) {
        // Rollback the transaction if there was an error
        mysqli_rollback($conn);
        $orderSuccess = false;
        $errorMessage = $e->getMessage();
        break;
    }
}

// If order was successful, store order details in pending_orders table
if ($orderSuccess) {
    $_SESSION['last_token'] = $token;
    
    // Store order details in pending_orders table
    $orderTotal = $_SESSION['checkout_total'];
    $orderDetails = json_encode($_SESSION['checkout_items']);
    
    $insertOrderSql = "INSERT INTO pending_orders (token_number, order_details, order_total, status) 
                      VALUES ($token, '$orderDetails', $orderTotal, 'pending')";
    
    if (!mysqli_query($conn, $insertOrderSql)) {
        // Log error but don't affect user experience
        error_log("Error storing order in pending_orders: " . mysqli_error($conn));
    }
    
    unset($_SESSION['checkout_items']);
    unset($_SESSION['checkout_total']);
    
    // Clear localStorage cart via JavaScript (will be executed when page loads)
    $clearCart = true;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - খাবার দাবার</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        .header {
            background-color: #2e8b57;
            padding: 15px;
            display: flex;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
        }
        
        .logo img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }
        
        .logo h1 {
            font-size: 24px;
            font-weight: bold;
        }
        
        .confirmation-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .confirmation-title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #2e8b57;
        }
        
        .confirmation-message {
            font-size: 16px;
            margin-bottom: 30px;
            color: #555;
        }
        
        .token-box {
            background-color: #f7f7f7;
            border: 2px dashed #2e8b57;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0 30px;
        }
        
        .token-label {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }
        
        .token-number {
            font-size: 42px;
            font-weight: bold;
            color: #2e8b57;
            margin: 10px 0;
        }
        
        .token-info {
            font-size: 14px;
            color: #777;
        }
        
        .buttons {
            margin-top: 30px;
        }
        
        .home-button {
            background-color: #2e8b57;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }
        
        .home-button:hover {
            background-color: #236b43;
        }
        
        .error-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffe6e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .error-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #ff4d4d;
        }
        
        .error-message {
            font-size: 16px;
            margin-bottom: 30px;
            color: #555;
        }
        
        .back-button {
            background-color: #ff4d4d;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }
        
        .back-button:hover {
            background-color: #e63939;
        }
        
        .footer {
            background-color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
            display: flex;
            justify-content: space-around;
            padding: 15px 0;
            border-top: 1px solid #eee;
        }
        
        .footer-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #777;
            font-size: 12px;
        }
        
        .footer-item.active {
            color: #2e8b57;
        }
        
        .footer-icon {
            font-size: 20px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="home.php" class="logo">
            <img src="images.png" alt="খাবার দাবার">
            <h1>খাবার দাবার</h1>
        </a>
    </div>

    <?php if ($orderSuccess): ?>
    <div class="confirmation-container">
        <h1 class="confirmation-title">Order Placed Successfully!</h1>
        <p class="confirmation-message">Thank you for your order. We have received your order and it is being prepared.</p>
        
        <div class="token-box">
            <div class="token-label">Your Token Number</div>
            <div class="token-number"><?php echo $token; ?></div>
            <div class="token-info">Please keep this token number for your reference</div>
        </div>
        
        <p>Please show this token number to the counter to receive your order.</p>
        
        <div class="buttons">
            <a href="home.php" class="home-button">Return to Home</a>
        </div>
    </div>
    <?php else: ?>
    <div class="error-container">
        <h1 class="error-title">Oops! Something went wrong</h1>
        <p class="error-message"><?php echo $errorMessage; ?></p>
        
        <div class="buttons">
            <a href="checkout.php" class="back-button">Back to Checkout</a>
        </div>
    </div>
    <?php endif; ?>

    <div class="footer">
        <a href="home.php" class="footer-item">
            <span class="footer-icon">🍴</span>
            <span>Menu</span>
        </a>
        <a href="#" class="footer-item">
            <span class="footer-icon">💬</span>
            <span>Feedback</span>
        </a>
        <a href="cart.php" class="footer-item">
            <span class="footer-icon">🛒</span>
            <span>Cart</span>
        </a>
        <a href="#" class="footer-item">
            <span class="footer-icon">👤</span>
            <span>Account</span>
        </a>
    </div>

    <?php if (isset($clearCart) && $clearCart): ?>
    <script>
        // Clear the cart in localStorage after successful order
        localStorage.removeItem('foodCart');
    </script>
    <?php endif; ?>
</body>
</html>