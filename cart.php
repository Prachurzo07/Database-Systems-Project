<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>খাবার দাবার - Cart</title>
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
        
        .search-container {
            flex: 1;
            margin: 0 20px;
            position: relative;
        }
        
        .search-input {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: none;
            font-size: 16px;
        }
        
        .search-button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
        }
        
        .cart-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .cart-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #2e8b57;
            font-weight: bold;
        }
        
        .cart-empty {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .cart-items {
            margin-bottom: 20px;
        }
        
        .cart-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            align-items: center;
        }
        
        .cart-item-info {
            flex: 1;
        }
        
        .cart-item-name {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .cart-item-price {
            color: #2e8b57;
            font-weight: bold;
        }
        
        .cart-item-quantity {
            display: flex;
            align-items: center;
            margin: 0 20px;
        }
        
        .quantity-btn {
            background-color: #f5f5f5;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
        }
        
        .quantity-input {
            width: 40px;
            text-align: center;
            border: none;
            background: transparent;
            font-size: 16px;
            margin: 0 10px;
        }
        
        .cart-item-total {
            font-weight: bold;
            min-width: 100px;
            text-align: right;
        }
        
        .cart-item-remove {
            margin-left: 15px;
            color: #ff4d4d;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
        }
        
        .cart-summary {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .cart-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .cart-total {
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #ddd;
        }
        
        .checkout-button {
            background-color: #2e8b57;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .checkout-button:hover {
            background-color: #236b43;
        }
        
        .continue-shopping {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2e8b57;
            text-decoration: none;
        }
        
        .continue-shopping:hover {
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
        
        /* Modal styles for booking */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            animation: modalopen 0.3s;
        }
        
        @keyframes modalopen {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .modal-title {
            font-size: 20px;
            font-weight: bold;
            color: #2e8b57;
        }
        
        .close-btn {
            font-size: 24px;
            font-weight: bold;
            color: #777;
            cursor: pointer;
            background: none;
            border: none;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }
        
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 15px;
        }
        
        .form-group textarea {
            min-height: 80px;
            resize: vertical;
        }
        
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        
        .btn {
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .btn-secondary {
            background-color: #e0e0e0;
            color: #333;
        }
        
        .btn-secondary:hover {
            background-color: #d0d0d0;
        }
        
        .btn-primary {
            background-color: #2e8b57;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #236b43;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: none;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .btn-book {
            background-color: #FFB800;
            color: #333;
        }
        
        .btn-book:hover {
            background-color: #e6a600;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="home.php" class="logo">
            <img src="images.png" alt="খাবার দাবার">
            <h1>খাবার দাবার</h1>
        </a>
        <div class="search-box">
                <input type="text" placeholder="Search for food items">
                <a href="search.php">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2e8b57" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </a>
        </div>
    </div>

    <div class="cart-container">
        <h2 class="cart-title">Your Cart</h2>
        
        <div id="success-message" class="success-message"></div>
        
        <div id="cart-items" class="cart-items">
            <!-- Cart items will be displayed here -->
        </div>
        
        <div id="cart-empty" class="cart-empty">
            <p>Your cart is empty</p>
            <a href="home.php" class="continue-shopping">Continue Shopping</a>
        </div>
        
        <div id="cart-summary" class="cart-summary" style="display: none;">
            <div class="cart-summary-row">
                <span>Subtotal</span>
                <span id="subtotal">৳0</span>
            </div>
        
            <div class="cart-summary-row cart-total">
                <span>Total</span>
                <span id="total">৳0</span>
            </div>
            
            <div class="action-buttons">
                <button class="checkout-button" id="checkout-btn">Proceed to Checkout</button>
                <button class="btn btn-book" id="book-btn">Book Order</button>
            </div>
            
            <a href="home.php" class="continue-shopping">Continue Shopping</a>
        </div>
    </div>

    <div class="footer">
        <a href="home.php" class="footer-item">
            <span class="footer-icon">🍴</span>
            <span>Menu</span>
        </a>
        <a href="feedback.php" class="footer-item">
            <span class="footer-icon">💬</span>
            <span>Feedback</span>
        </a>
        <a href="cart.php" class="footer-item active">
            <span class="footer-icon">🛒</span>
            <span>Cart</span>
        </a>
        <a href="account.php" class="footer-item">
            <span class="footer-icon">👤</span>
            <span>Account</span>
        </a>
    </div>

    <!-- Hidden form for checkout -->
    <form id="checkout-form" action="checkout.php" method="post" style="display:none;">
        <input type="hidden" name="cart_data" id="cart-data-input">
    </form>
    
    <!-- Booking Modal -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Book Your Order</div>
                <button class="close-btn">&times;</button>
            </div>
            <form id="bookingForm" method="POST" action="process_booking.php">
                <input type="hidden" name="cart_data" id="booking-cart-data">
                
                <div class="form-group">
                    <label for="booking_date">Booking Date</label>
                    <input type="date" id="booking_date" name="booking_date" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="booking_time">Booking Time</label>
                    <select id="booking_time" name="booking_time" required>
                        <option value="">Select a time</option>
                        <?php
                        $start = strtotime('10:00');
                        $end = strtotime('22:00');
                        for ($i = $start; $i <= $end; $i += 1800) {
                            echo '<option value="'.date('H:i', $i).'">'.date('g:i A', $i).'</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="special_instructions">Special Instructions</label>
                    <textarea id="special_instructions" name="special_instructions" rows="3"></textarea>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Function to load cart data from localStorage
        function loadCart() {
            const cart = JSON.parse(localStorage.getItem('foodCart')) || [];
            const cartItemsContainer = document.getElementById('cart-items');
            const cartEmptyMessage = document.getElementById('cart-empty');
            const cartSummary = document.getElementById('cart-summary');
            
            // Clear previous cart items
            cartItemsContainer.innerHTML = '';
            
            if (cart.length === 0) {
                cartEmptyMessage.style.display = 'block';
                cartSummary.style.display = 'none';
                return;
            }
            
            cartEmptyMessage.style.display = 'none';
            cartSummary.style.display = 'block';
            
            let subtotal = 0;
            
            // Add each item to the cart display
            cart.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                
                const cartItemElement = document.createElement('div');
                cartItemElement.className = 'cart-item';
                cartItemElement.innerHTML = `
                    <div class="cart-item-info">
                        <div class="cart-item-name">${item.name}</div>
                        <div class="cart-item-price">৳${item.price}</div>
                    </div>
                    <div class="cart-item-quantity">
                        <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                        <input type="text" class="quantity-input" value="${item.quantity}" readonly>
                        <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                    </div>
                    <div class="cart-item-total">৳${itemTotal}</div>
                    <button class="cart-item-remove" onclick="removeItem(${index})">×</button>
                `;
                
                cartItemsContainer.appendChild(cartItemElement);
            });
            
            // Update summary
            document.getElementById('subtotal').textContent = `৳${subtotal}`;
            document.getElementById('total').textContent = `৳${subtotal}`;
            
            // Set cart data for booking form
            document.getElementById('booking-cart-data').value = JSON.stringify(cart);
        }
        
        // Function to update item quantity
        function updateQuantity(index, change) {
            const cart = JSON.parse(localStorage.getItem('foodCart')) || [];
            
            if (cart[index]) {
                cart[index].quantity += change;
                
                // Remove item if quantity becomes 0
                if (cart[index].quantity <= 0) {
                    cart.splice(index, 1);
                }
                
                localStorage.setItem('foodCart', JSON.stringify(cart));
                loadCart();
            }
        }
        
        // Function to remove item from cart
        function removeItem(index) {
            const cart = JSON.parse(localStorage.getItem('foodCart')) || [];
            
            if (cart[index]) {
                cart.splice(index, 1);
                localStorage.setItem('foodCart', JSON.stringify(cart));
                loadCart();
            }
        }
        
        // Handle checkout process
        function proceedToCheckout() {
            const cart = JSON.parse(localStorage.getItem('foodCart')) || [];
            
            if (cart.length === 0) {
                alert('Your cart is empty. Add items before checkout.');
                return;
            }
            
            // Set cart data in hidden form
            document.getElementById('cart-data-input').value = JSON.stringify(cart);
            
            // Submit the form to checkout.php
            document.getElementById('checkout-form').submit();
        }
        
        // Modal functionality
        const modal = document.getElementById('bookingModal');
        const bookBtn = document.getElementById('book-btn');
        const closeBtns = document.querySelectorAll('.close-btn');
        const bookingForm = document.getElementById('bookingForm');
        
        bookBtn.addEventListener('click', function() {
            const cart = JSON.parse(localStorage.getItem('foodCart')) || [];
            
            if (cart.length === 0) {
                alert('Your cart is empty. Add items before booking.');
                return;
            }
            
            modal.style.display = 'block';
        });
        
        closeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                modal.style.display = 'none';
            });
        });
        
        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
        
        // Handle date change to disable past times for today
        document.getElementById('booking_date').addEventListener('change', function() {
            const today = new Date().toISOString().split('T')[0];
            const timeSelect = document.getElementById('booking_time');
            
            if (this.value === today) {
                const now = new Date();
                const currentHour = now.getHours();
                const currentMinutes = now.getMinutes();
                
                Array.from(timeSelect.options).forEach(option => {
                    if (option.value) {
                        const [hours, minutes] = option.value.split(':').map(Number);
                        option.disabled = (hours < currentHour || 
                                         (hours === currentHour && minutes < currentMinutes));
                    }
                });
            } else {
                // Enable all options if not today
                Array.from(timeSelect.options).forEach(option => {
                    option.disabled = false;
                });
            }
        });
        
        // Handle booking form submission
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('process_booking.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const successMsg = document.getElementById('success-message');
                    successMsg.textContent = data.message;
                    successMsg.style.display = 'block';
                    
                    // Hide modal
                    modal.style.display = 'none';
                    
                    // Clear cart
                    localStorage.removeItem('foodCart');
                    loadCart();
                    
                    // Hide success message after 5 seconds
                    setTimeout(() => {
                        successMsg.style.display = 'none';
                    }, 5000);
                } else {
                    alert(data.message || 'Booking failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
        
        // Load cart when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadCart();
            
            // Add event listener to checkout button
            document.getElementById('checkout-btn').addEventListener('click', proceedToCheckout);
            
            // Check for success message in URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('booking_success')) {
                const successMsg = document.getElementById('success-message');
                successMsg.textContent = 'Your booking has been confirmed!';
                successMsg.style.display = 'block';
                
                // Remove the parameter from URL
                window.history.replaceState({}, document.title, window.location.pathname);
                
                // Hide success message after 5 seconds
                setTimeout(() => {
                    successMsg.style.display = 'none';
                }, 5000);
            }
        });
    </script>
</body>
</html>