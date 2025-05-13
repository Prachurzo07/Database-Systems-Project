<?php
require_once('connect.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: firstpage.php");
}

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_feedback'])) {
    $food_id = $_POST['food_id'];
    $rating = $_POST['rating'];
    $feedback_text = $_POST['feedback_text']; 
    $user_id = $_SESSION['user_id'];
    
    // First check if the user has already rated this food item
    $check_sql = "SELECT * FROM food_ratings WHERE user_id = '$user_id' AND food = '$food_id'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        // Update existing rating
        $update_sql = "UPDATE food_ratings SET rating = '$rating', feedback = '$feedback_text' WHERE user_id = '$user_id' AND food = '$food_id'";
        mysqli_query($conn, $update_sql);
    } else {
        // Insert new rating
        $insert_sql = "INSERT INTO food_ratings (user_id, food, rating,feedback) VALUES ('$user_id', '$food_id', '$rating','$feedback_text')";
        mysqli_query($conn, $insert_sql);
    }
    
    // Calculate new average rating for the food item
    $avg_sql = "SELECT AVG(rating) as avg_rating FROM food_ratings WHERE food = '$food_id'";
    $avg_result = mysqli_query($conn, $avg_sql);
    $avg_row = mysqli_fetch_assoc($avg_result);
    $avg_rating = round($avg_row['avg_rating'], 1);
    
    // Update the food item's rating
    $update_food_sql = "UPDATE food SET rating = '$avg_rating' WHERE name = '$food_id'";
    mysqli_query($conn, $update_food_sql);
    
    $success_message = "Thank you for your feedback! Your rating has been submitted.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>খাবার দাবার - Feedback</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Hind Siliguri', Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            padding-bottom: 70px;
        }

        .header {
            background-color: #2e8b57;
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

        .tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
        }

        .tab.active {
            border-bottom: 3px solid #2e8b57;
            color: #2e8b57;
            font-weight: bold;
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
            background-color: #2e8b57;
            color: white;
            padding: 15px;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
        }

        .info-row {
            display: flex;
            margin-bottom: 15px;
            align-items: center;
        }

        .info-label {
            font-weight: bold;
            width: 120px;
            color: #555;
        }

        .info-value {
            flex: 1;
        }

        /* Feedback Form Styles */
        .feedback-form {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .rating-stars {
            display: flex;
            margin: 10px 0;
        }

        .rating-stars .star {
            font-size: 24px;
            color: #ddd;
            cursor: pointer;
            margin-right: 5px;
        }

        .rating-stars .star.filled {
            color: #FFD700; /* Gold color for filled stars */
        }

        .submit-btn {
            background-color: #2e8b57;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .submit-btn:hover {
            background-color: #236b43;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: <?php echo isset($success_message) ? 'block' : 'none'; ?>;
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
            color: #2e8b57;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container" style="display: flex; align-items: center;">
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
    </header>

    <main class="container">
        <h2 class="section-title">Give Feedback</h2>
        
        <div class="tabs">
            
            <div class="tab active" onclick="openTab('feedback')">Rate Food</div>
        </div>
        
        <?php if (isset($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        
        
        <div id="feedback" class="tab-content active">
            <div class="feedback-form">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="food_id">Select Food Item</label>
                        <select name="food_id" id="food_id" required>
                            <option value="">-- Select a food item --</option>
                            <?php
                            $food_sql = "SELECT * FROM food ORDER BY name";
                            $food_result = mysqli_query($conn, $food_sql);
                            
                            if ($food_result && mysqli_num_rows($food_result) > 0) {
                                while ($food_row = mysqli_fetch_assoc($food_result)) {
                                    echo '<option value="'.$food_row['name'].'">'.$food_row['name'].' (৳'.$food_row['price'].')</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Your Rating</label>
                        <div class="rating-stars">
                            <span class="star" onclick="setRating(1)">★</span>
                            <span class="star" onclick="setRating(2)">★</span>
                            <span class="star" onclick="setRating(3)">★</span>
                            <span class="star" onclick="setRating(4)">★</span>
                            <span class="star" onclick="setRating(5)">★</span>
                        </div>
                        <input type="hidden" name="rating" id="rating-value" value="0" required>
                    </div>
                    <div class="form-group">
                        <label for="feedback_text">Your Feedback (Optional)</label>
                        <textarea name="feedback_text" id="feedback_text" rows="3" placeholder="Share your thoughts about this food item..."></textarea>
                    </div>
                    
                    <button type="submit" name="submit_feedback" class="submit-btn">Submit Rating</button>
                </form>
            </div>
            
            <div class="card">
                <div class="card-header">Your Previous Ratings</div>
                <div class="card-body">
                    <?php
                    $user_id = $_SESSION['user_id'];
                    $ratings_sql = "SELECT * FROM food_ratings
                                    WHERE user_id = '$user_id'";
                    $ratings_result = mysqli_query($conn, $ratings_sql);
                    
                    if ($ratings_result && mysqli_num_rows($ratings_result) > 0) {
                        while ($rating_row = mysqli_fetch_assoc($ratings_result)) {
                            $food_sql = "SELECT * FROM food WHERE name = '".$rating_row['food']."'";
                            $food_result = mysqli_query($conn, $food_sql);
                            $food_row = mysqli_fetch_assoc($food_result);
                            echo '<div class="rating-container" style="font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; max-width: 500px; margin: 20px auto; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); background: linear-gradient(135deg, #f9f9f9 0%, #ffffff 100%);">';
    
    // Feedback row with improved styling
    echo '<div class="info-row" style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eee;">';
    echo '<div class="info-value" style="font-size: 16px; color: #555; line-height: 1.6;">';
    echo '<span style="font-weight: 600; color: #333;">Feedback:</span> "'.$rating_row['feedback'].'"';
    echo '</div>';
    echo '</div>';
    
    // Food item and price in a side-by-side layout
    echo '<div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 15px;">';
    echo '<div style="flex: 1;">';
    echo '<div class="info-label" style="font-size: 14px; color: #777; margin-bottom: 5px;">Food Item</div>';
    echo '<div class="info-value" style="font-size: 18px; font-weight: 600; color: #2c3e50;">'.$food_row['name'].'</div>';
    echo '</div>';
    
    echo '<div style="flex: 1; text-align: right;">';
    echo '<div class="info-label" style="font-size: 14px; color: #777; margin-bottom: 5px;">Price</div>';
    echo '<div class="info-value" style="font-size: 18px; font-weight: 600; color: #27ae60;">৳'.$food_row['price'].'</div>';
    echo '</div>';
    echo '</div>';
    
    // Rating with stars and animated hover effect
    echo '<div class="info-row" style="text-align: center; padding: 15px; background-color: #f8f9fa; border-radius: 8px; margin-top: 20px;">';
    echo '<div class="info-label" style="font-size: 14px; color: #777; margin-bottom: 8px;">Your Rating</div>';
    echo '<div class="info-value" style="font-size: 24px; line-height: 1;">';
    for ($i = 1; $i <= 5; $i++) {
        $starColor = ($i <= $rating_row['rating']) ? '#FFD700' : '#ddd';
        echo '<span style="cursor: default; transition: all 0.2s; color: '.$starColor.';" onmouseover="this.style.transform=\'scale(1.2)\'" onmouseout="this.style.transform=\'scale(1)\'">';
        echo ($i <= $rating_row['rating']) ? '★' : '☆';
        echo '</span>';
    }
    echo '<span style="display: inline-block; margin-left: 8px; font-size: 16px; font-weight: 600; color: #7f8c8d;">'.$rating_row['rating'].'<span style="font-size: 12px; color: #95a5a6;">/5</span></span>';
    echo '</div>';
    echo '</div>';

echo '</div>';
                            
                            // echo '<div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #eee;">';
                            // echo '<div style="font-weight: bold;">'.$rating_row['name'].' (৳'.$rating_row['price'].')</div>';
                            // echo '<div style="color: #FFD700;">';
                            // for ($i = 1; $i <= 5; $i++) {
                            //     echo ($i <= $rating_row['rating']) ? '★' : '☆';
                            // }
                            // echo ' ('.$rating_row['rating'].'/5)';
                            // echo '</div>';
                            // echo '</div>';
                        }
                    } else {
                        echo '<p>You haven\'t rated any food items yet.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>

    <nav class="bottom-nav">
        <a href="home.php" class="nav-item">
            <i class="fas fa-utensils"></i>
            <span>Food</span>
        </a>
        <a href="feedback.php" class="nav-item active">
            <i class="fas fa-comment-alt"></i>
            <span>Feedback</span>
        </a>
        <a href="cart.php" class="nav-item">
            <i class="fas fa-shopping-cart"></i>
            <span>Cart</span>
        </a>
        <a href="account.php" class="nav-item">
            <i class="fas fa-user"></i>
            <span>Account</span>
        </a>
    </nav>

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
            var stars = document.querySelectorAll(".rating-stars .star");
            for (var i = 0; i < stars.length; i++) {
                if (i < rating) {
                    stars[i].classList.add("filled");
                } else {
                    stars[i].classList.remove("filled");
                }
            }
            document.getElementById("rating-value").value = rating;
        }
    </script>
</body>
</html>