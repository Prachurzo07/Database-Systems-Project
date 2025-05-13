<?php
session_start();
include 'connect.php';

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle marking order as delivered - DELETE instead of UPDATE
if (isset($_POST['mark_delivered']) && isset($_POST['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    
    // Delete the order from pending_orders
    $deleteSql = "DELETE FROM pending_orders WHERE order_id = $order_id";
    if (mysqli_query($conn, $deleteSql)) {
        // Redirect to refresh the page
        header("Location: manage_orders.php");
        exit;
    } else {
        $error = "Error removing order: " . mysqli_error($conn);
    }
}

// Fetch all pending orders
$sql = "SELECT * FROM pending_orders WHERE status = 'pending' ORDER BY order_date ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Orders - খাবার দাবার</title>
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
            justify-content: space-between;
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
        
        .page-title {
            font-size: 20px;
            color: white;
        }
        
        .home-btn {
            background-color: white;
            color: #2e8b57;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .home-btn:hover {
            background-color: #f0f0f0;
        }
        
        .orders-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 15px;
        }
        
        .orders-heading {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        
        .orders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .order-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s;
        }
        
        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .token-number {
            font-size: 24px;
            font-weight: bold;
            color: #2e8b57;
        }
        
        .order-date {
            font-size: 14px;
            color: #777;
        }
        
        .order-items {
            margin-bottom: 15px;
            max-height: 200px;
            overflow-y: auto;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #eee;
        }
        
        .item-name {
            font-weight: bold;
        }
        
        .item-quantity {
            color: #555;
        }
        
        .order-total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin: 15px 0;
        }
        
        .order-actions {
            display: flex;
            justify-content: center;
        }
        
        .delivered-btn {
            background-color: #2e8b57;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        
        .delivered-btn:hover {
            background-color: #236b43;
        }
        
        .no-orders {
            text-align: center;
            font-size: 18px;
            color: #777;
            padding: 40px 0;
        }
        

        
        /* Auto refresh styles */
        .refresh-info {
            text-align: center;
            margin: 10px 0;
            color: #777;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="home.php" class="logo">
            <img src="images.png" alt="খাবার দাবার">
            <h1>খাবার দাবার</h1>
        </a>
        <div class="page-title">Manager Dashboard</div>
        <a href="home_host.php" class="home-btn">Home</a>
    </div>

    <div class="orders-container">
        <h2 class="orders-heading">Pending Orders</h2>
        
        <div class="refresh-info">Page refreshes automatically every 30 seconds</div>
        
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="orders-grid">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php 
                    $orderDetails = json_decode($row['order_details'], true);
                    $orderDate = date('h:i A', strtotime($row['order_date']));
                    ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div class="token-number">Token #<?php echo $row['token_number']; ?></div>
                            <div class="order-date"><?php echo $orderDate; ?></div>
                        </div>
                        
                        <div class="order-items">
                            <?php foreach ($orderDetails as $item): ?>
                                <div class="order-item">
                                    <span class="item-name"><?php echo $item['name']; ?></span>
                                    <span class="item-quantity">x<?php echo $item['quantity']; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="order-total">
                            Total: ৳<?php echo $row['order_total']; ?>
                        </div>
                        
                        <div class="order-actions">
                            <form method="post" action="">
                                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                <button type="submit" name="mark_delivered" class="delivered-btn">Mark as Delivered</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-orders">No pending orders at the moment</div>
            <?php endif; ?>
        </div>
    </div>



    <!-- Script to auto-refresh the page every 30 seconds -->
    <script>
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
</body>
</html>