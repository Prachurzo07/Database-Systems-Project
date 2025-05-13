<?php
require_once('connect.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: firstpage.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>খাবার দাবার - Cafeteria Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="account.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Hind Siliguri', Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            padding-bottom: 70px; /* Added padding to account for fixed bottom nav */
        }

        .header {
            background-color: #2e8b57; /* Green color */
            padding: 15px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        .logo {
            color: white;
            font-size: 28px;
            font-weight: bold;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo img {
            margin-right: 10px;
            height: 40px;
        }

        .search-box {
            display: flex;
            flex: 1;
            margin: 0 20px;
        }

        .search-box input {
            flex: 1;
            padding: 10px 15px;
            border: none;
            border-radius: 4px 0 0 4px;
            font-size: 16px;
        }

        .search-box button {
            background-color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            padding: 0 15px;
            cursor: pointer;
        }

        .section-title {
            font-size: 24px;
            margin: 30px 0 20px;
            color: #333;
            font-weight: bold;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-bottom: 40px;
        }

        .category-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
        }

        .category-card:hover {
            transform: translateY(-5px);
        }

        .category-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .category-title {
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-title i {
            margin-right: 8px;
            color: #2e8b57;
            font-size: 18px;
        }

        .featured-section {
            margin-bottom: 40px;
        }

        .featured-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .featured-item {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .featured-item:hover {
            transform: translateY(-5px);
        }

        .featured-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .featured-details {
            padding: 15px;
        }

        .featured-title {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .featured-price {
            color: #2e8b57;
            font-weight: bold;
            font-size: 18px;
        }

        /* Bottom Navigation Bar Styles */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 0;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #777;
            font-size: 12px;
            font-weight: 500;
        }

        .nav-item i {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .nav-item.active {
            color: #2e8b57; /* Green color for active item */
        }

        /* Account Page Specific Styles */
        .tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 600;
            color: #777;
        }

        .tab.active {
            color: #2e8b57;
            border-bottom: 2px solid #2e8b57;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card-header {
            background-color: #f8f9fa;
            padding: 15px;
            font-weight: 600;
            border-bottom: 1px solid #eee;
        }

        .card-body {
            padding: 15px;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-label {
            width: 150px;
            font-weight: 600;
            color: #555;
        }

        .info-value {
            flex: 1;
        }

        .booking-item {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 15px;
            margin-bottom: 15px;
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .booking-token {
            font-weight: 600;
            color: #2e8b57;
        }

        .booking-date {
            color: #777;
        }

        .food-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            padding: 5px 0;
        }

        .food-name {
            flex: 2;
        }

        .food-quantity {
            flex: 1;
            text-align: center;
        }

        .food-price {
            flex: 1;
            text-align: right;
        }

        .special-request {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #eee;
            font-style: italic;
            color: #555;
        }

        .no-bookings {
            text-align: center;
            padding: 20px;
            color: #777;
        }

        /* Logout Button Styles */
        .logout-btn {
            background-color: #ff6b6b;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            margin-left: 15px;
        }

        .logout-btn i {
            margin-right: 6px;
        }

        .logout-btn:hover {
            background-color: #ff5252;
        }

        .header-right {
            display: flex;
            align-items: center;
        }

        @media (max-width: 768px) {
            .categories-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 480px) {
            .categories-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container" style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center;">
                <a href="#" class="logo">
                    <img src="images.png" alt="খাবার দাবার Logo" style="width: 60px; height: 60px; margin-right: 10px;">
                    খাবার দাবার
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
            <div class="header-right">
                <a href="firstpage.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </div>
    </header>

    <main class="container">
        <h2 class="section-title">Account Information</h2>
        
        <div class="tabs">
            <div class="tab active" onclick="openTab('profile')">Profile</div>
            <div class="tab" onclick="openTab('bookings')">My Bookings</div>
        </div>
        
        <?php
        $user_id = $_SESSION['user_id'];
        // Fetch user profile data
        $sql = "SELECT * FROM user WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div id="profile" class="tab-content active">
                    <div class="card">
                        <div class="card-header">User Details</div>
                        <div class="card-body">
                            <div class="info-row">
                                <div class="info-label">User ID:</div>
                                <div class="info-value">'.$user_id.'</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Username:</div>
                                <div class="info-value">'.$row["username"].'</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Mobile:</div>
                                <div class="info-value">'.$row["mobile"].'</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Client Type:</div>
                                <div class="info-value">'.$row["role"].'</div>
                            </div>
                        </div>
                    </div>
                </div>';
                }
            } else {
                echo "No results found.";
            }
        } else {
            echo "Error fetching user data.";
        }
        ?>   
        
        <!-- Bookings Tab Content -->
        <div id="bookings" class="tab-content">
            <?php
            // Fetch booking data for the user
            $booking_sql = "SELECT * FROM advance_booking WHERE user_id = '$user_id' ORDER BY booking_date DESC, booking_time DESC";
            $booking_result = mysqli_query($conn, $booking_sql);
            
            if ($booking_result && mysqli_num_rows($booking_result) > 0) {
                while ($booking = mysqli_fetch_assoc($booking_result)) {
                    $food_items = json_decode($booking['food_items'], true);
                    $total = 0;
                    
                    echo '<div class="booking-item">
                        <div class="booking-header">
                            <span class="booking-token">Booking #'.$booking['booking_token'].'</span>
                            <span class="booking-date">'.$booking['booking_date'].' at '.$booking['booking_time'].'</span>
                        </div>';
                    
                    foreach ($food_items as $item) {
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                        
                        echo '<div class="food-item">
                            <div class="food-name">'.$item['name'].'</div>
                            <div class="food-quantity">'.$item['quantity'].' x</div>
                            <div class="food-price">৳'.number_format($item['price'], 2).'</div>
                        </div>';
                    }
                    
                    echo '<div class="food-item" style="font-weight:600; margin-top:10px;">
                        <div class="food-name">Total</div>
                        <div class="food-quantity"></div>
                        <div class="food-price">৳'.number_format($total, 2).'</div>
                    </div>';
                    
                    if (!empty($booking['special_request'])) {
                        echo '<div class="special-request">
                            <strong>Special Request:</strong> '.$booking['special_request'].'
                        </div>';
                    }
                    
                    echo '</div>';
                }
            } else {
                echo '<div class="no-bookings">
                    <i class="fas fa-calendar-times" style="font-size: 40px; margin-bottom: 10px; color: #ddd;"></i>
                    <p>You don\'t have any bookings yet.</p>
                </div>';
            }
            ?>
        </div>
    </main>

    <nav class="bottom-nav">
        <a href="home.php" class="nav-item">
            <i class="fas fa-utensils"></i>
            <span>Food</span>
        </a>
        <a href="feedback.php" class="nav-item">
            <i class="fas fa-comment-alt"></i>
            <span>Feedback</span>
        </a>
        <a href="cart.php" class="nav-item">
            <i class="fas fa-shopping-cart"></i>
            <span>Cart</span>
        </a>
        <a href="account.php" class="nav-item active">
            <i class="fas fa-user"></i>
            <span>Account</span>
        </a>
    </nav>

</body>
<script>
    function openTab(tabName) {
        // Hide all tab content
        var tabContents = document.getElementsByClassName("tab-content");
        for (var i = 0; i < tabContents.length; i++) {
            tabContents[i].classList.remove("active");
        }
        
        // Remove active class from all tabs
        var tabs = document.getElementsByClassName("tab");
        for (var i = 0; i < tabs.length; i++) {
            tabs[i].classList.remove("active");
        }
        
        // Show the selected tab content and mark the button as active
        document.getElementById(tabName).classList.add("active");
        
        // Find and activate the tab button
        var tabButtons = document.getElementsByClassName("tab");
        for (var i = 0; i < tabButtons.length; i++) {
            if (tabButtons[i].getAttribute("onclick").includes(tabName)) {
                tabButtons[i].classList.add("active");
            }
        }
    }
    
    function setRating(rating) {
        var stars = document.querySelectorAll("#add-feedback .stars .star");
        for (var i = 0; i < stars.length; i++) {
            if (i < rating) {
                stars[i].classList.add("filled");
            } else {
                stars[i].classList.remove("filled");
            }
        }
    }
</script>
</html>