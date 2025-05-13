<?php
session_start();
include 'connect.php';

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$total = 0;
$items = [];
$error = '';

// Process form submission if this is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cart_data']) && !empty($_POST['cart_data'])) {
        $cart_data = json_decode($_POST['cart_data'], true);
        
        if ($cart_data && count($cart_data) > 0) {
            foreach ($cart_data as $item) {
                $name = mysqli_real_escape_string($conn, $item['name']);
                $quantity = (int)$item['quantity'];
                $price = (int)$item['price']; // Get price directly from cart data
                
                $subtotal = $price * $quantity;
                $total += $subtotal;
                
                $items[] = [
                    'name' => $name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                    'category' => isset($item['category']) ? $item['category'] : '' // Optional
                ];
            }
            
            // Store in session for order processing
            $_SESSION['checkout_items'] = $items;
            $_SESSION['checkout_total'] = $total;
        } else {
            $error = 'Invalid cart data received';
        }
    } else {
        $error = 'No items in cart';
    }
} else {
    // If not a POST request, check if we can retrieve cart data from JavaScript localStorage
    $error = 'Please add items to your cart first';
}

$grand_total = $total;
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>খাবার দাবার - Checkout</title>
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
        
        .checkout-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .checkout-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #2e8b57;
            font-weight: bold;
        }
        
        .error-message {
            background-color: #ffe6e6;
            color: #ff4d4d;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .order-summary {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .order-title {
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-name {
            font-weight: bold;
        }
        
        .item-price {
            color: #666;
            font-size: 14px;
        }
        
        .item-quantity {
            width: 60px;
            text-align: center;
        }
        
        .item-total {
            font-weight: bold;
            min-width: 100px;
            text-align: right;
        }
        
        .order-total {
            display: flex;
            justify-content: space-between;
            padding-top: 15px;
            margin-top: 15px;
            border-top: 1px dashed #ddd;
            font-size: 18px;
            font-weight: bold;
        }
        
        .checkout-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        
        .payment-options {
            grid-column: span 2;
        }
        
        .payment-title {
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .payment-methods {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .payment-method {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            width: 120px;
            transition: border-color 0.3s;
        }
        
        .payment-method.selected {
            border-color: #2e8b57;
            background-color: #f0f8f4;
        }
        
        .payment-icon {
            font-size: 24px;
            margin-bottom: 8px;
        }
        
        .payment-name {
            font-size: 14px;
            text-align: center;
        }
        
        .place-order-btn {
            background-color: #2e8b57;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
            grid-column: span 2;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .place-order-btn:hover {
            background-color: #236b43;
        }
        
        .back-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2e8b57;
            text-decoration: none;
            grid-column: span 2;
        }
        
        .back-btn:hover {
            text-decoration: underline;
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
        
        @media (max-width: 768px) {
            .checkout-form {
                grid-template-columns: 1fr;
            }
            
            .payment-options, .place-order-btn, .back-btn {
                grid-column: span 1;
            }
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

    <div class="checkout-container">
        <h2 class="checkout-title">Checkout</h2>
        
        <div id="js-cart-data" style="display:none;"></div>
        
        <?php if ($error && empty($items)): ?>
        <div class="error-message">
            <?php echo $error; ?>
            <p><a href="cart.php">Return to Cart</a></p>
        </div>
        <?php else: ?>
        
        <div class="order-summary">
            <h3 class="order-title">Order Summary</h3>
            
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>
                <div class="order-item">
                    <div class="item-details">
                        <div class="item-name"><?php echo $item['name']; ?></div>
                        <div class="item-price">৳<?php echo $item['price']; ?> each</div>
                    </div>
                    <div class="item-quantity">x<?php echo $item['quantity']; ?></div>
                    <div class="item-total">৳<?php echo $item['subtotal']; ?></div>
                </div>
                <?php endforeach; ?>
                
                <div class="order-total">
                    <span>Total Amount</span>
                    <span>৳<?php echo $grand_total; ?></span>
                </div>
            <?php else: ?>
                <div id="js-order-summary">
                    <!-- This will be populated by JavaScript -->
                </div>
            <?php endif; ?>
        </div>
        
        <form action="process_order.php" method="post" class="checkout-form" id="checkout-form">
            <div class="payment-options">
                <h3 class="payment-title">Payment Method</h3>
                <div class="payment-methods">
                    <div class="payment-method" onclick="selectPayment('cash')">
                        <span class="payment-icon">💵</span>
                        <span class="payment-name">Cash </span>
                        <input type="radio" name="payment_method" value="cash" style="display: none;" checked>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="place-order-btn">Place Order</button>
            <a href="cart.php" class="back-btn">Back to Cart</a>
        </form>
        <?php endif; ?>
    </div>

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

    <script>
        function selectPayment(method) {
            // Remove selected class from all payment methods
            const paymentMethods = document.querySelectorAll('.payment-method');
            paymentMethods.forEach(pm => pm.classList.remove('selected'));
            
            // Add selected class to chosen method
            const selectedMethod = document.querySelector(`.payment-method:has(input[value="${method}"])`);
            if (selectedMethod) {
                selectedMethod.classList.add('selected');
                // Select the radio button
                const radio = selectedMethod.querySelector('input[type="radio"]');
                radio.checked = true;
            }
        }
        
        // Initialize - select the first payment method
        document.addEventListener('DOMContentLoaded', function() {
            selectPayment('cash');
            
            // Check if we have items directly from PHP
            <?php if (empty($items)): ?>
            // If not, try to load from localStorage
            const cart = JSON.parse(localStorage.getItem('foodCart')) || [];
            
            if (cart.length > 0) {
                // Create a form to post the cart data
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'checkout.php';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'cart_data';
                input.value = JSON.stringify(cart);
                
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
            <?php endif; ?>
        });
    </script>
</body>
</html>