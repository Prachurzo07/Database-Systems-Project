<?php
// Include the database connection
include 'connect.php';

// Get the search query
$search_query = "";
if (isset($_GET['query'])) {
    $search_query = $_GET['query'];
}

// Prepare and execute the search query if a search term was provided
$results = [];
if (!empty($search_query)) {
    // Use LIKE with % for partial matching
    $sql = "SELECT * FROM food WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    
    // Add wildcards to search term
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    // Fetch all matching results
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - খাবার দাবার</title>
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

        /* Results grid styling */
        .results-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .food-item {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .food-item:hover {
            transform: translateY(-5px);
        }

        .food-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #eee;
        }

        .food-details {
            padding: 15px;
        }

        .food-title {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .food-price {
            color: #2e8b57;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 8px;
        }

        .food-description {
            color: #777;
            font-size: 14px;
            margin-top: 8px;
            margin-bottom: 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .category-tag, .health-tag {
            background-color: #f0f0f0;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        
        .category-tag {
            background-color: #e6f7ff;
            color: #0072b1;
        }
        
        .health-tag {
            background-color: #f6ffe6;
            color: #7cb305;
        }
        
        .rating {
            color: #ff9800;
            font-weight: 500;
        }

        .add-to-cart {
            background-color: #2e8b57;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            display: block;
            width: 100%;
            text-align: center;
        }

        .add-to-cart:hover {
            background-color: #236b43;
        }

        .no-results {
            text-align: center;
            padding: 40px 0;
            color: #777;
            font-size: 18px;
        }

        .confirm-message {
            position: fixed;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #2e8b57;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 1000;
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
            position: relative;
        }

        .nav-item i {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .nav-item.active {
            color: #2e8b57; /* Green color for active item */
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .results-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 480px) {
            .results-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container" style="display: flex; align-items: center;">
            <a href="index.html" class="logo">
                <img src="images.png" alt="খাবার দাবার Logo" style="width: 60px; height: 60px; margin-right: 10px;">
                খাবার দাবার
            </a>
            <form action="search.php" method="GET" style="display: flex; flex: 1; margin: 0 20px;">
                <div class="search-box" style="width: 100%">
                    <input type="text" name="query" placeholder="Search for food items" value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2e8b57" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </header>

    <main class="container">
        <h2 class="section-title">
            <?php if (!empty($search_query)): ?>
                Search Results for "<?php echo htmlspecialchars($search_query); ?>"
            <?php else: ?>
                Search Results
            <?php endif; ?>
        </h2>

        <?php if (!empty($search_query)): ?>
            <?php if (count($results) > 0): ?>
                <div class="results-grid">
                    <?php foreach ($results as $item): ?>
                        <div class="food-item">
                            <div class="food-image">
                                <i class="fas fa-utensils" style="font-size: 50px; color: #ccc;"></i>
                            </div>
                            <div class="food-details">
                                <h3 class="food-title"><?php echo htmlspecialchars($item['name']); ?></h3>
                                <div class="food-price">৳<?php echo htmlspecialchars($item['price']); ?></div>
                                <p class="food-description">
                                    <span class="category-tag"><?php echo htmlspecialchars($item['category']); ?></span>
                                    <span class="health-tag"><?php echo htmlspecialchars($item['healthtag']); ?></span>
                                    <span class="rating">
                                              Rating: 
                                          <?php 
                                             echo isset($item['rating']) ? htmlspecialchars($item['rating']) . "/5" : "No rating available";
                                          ?>
                                    </span>
                                </p>
                                <button class="add-to-cart" onclick="addToCart('<?php echo htmlspecialchars($item['name']); ?>', <?php echo htmlspecialchars($item['price']); ?>)">Add to Cart</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <i class="fas fa-search" style="font-size: 50px; color: #ccc; margin-bottom: 20px;"></i>
                    <p>No food items found matching "<?php echo htmlspecialchars($search_query); ?>"</p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="no-results">
                <i class="fas fa-search" style="font-size: 50px; color: #ccc; margin-bottom: 20px;"></i>
                <p>Please enter a search term to find food items</p>
            </div>
        <?php endif; ?>
    </main>

    <nav class="bottom-nav">
        <a href="home.php" class="nav-item">
            <i class="fas fa-utensils"></i>
            <span>Food</span>
        </a>
        <a href="feedback.html" class="nav-item">
            <i class="fas fa-comment-alt"></i>
            <span>Feedback</span>
        </a>
        <a href="cart.php" class="nav-item">
            <i class="fas fa-shopping-cart"></i>
            <span>Cart</span>
        </a>
        <a href="account.html" class="nav-item">
            <i class="fas fa-user"></i>
            <span>Account</span>
        </a>
    </nav>

    <script>
        // Function to add item to the cart
        function addToCart(itemName, itemPrice) {
            // Get existing cart from localStorage or create empty array if none exists
            let cart = JSON.parse(localStorage.getItem('foodCart')) || [];
            
            // Use the item name as the ID for simplicity
            const itemId = itemName;
            
            // Check if item already exists in cart
            const existingItemIndex = cart.findIndex(item => item.name === itemName);
            
            if (existingItemIndex !== -1) {
                // Item already exists, increment quantity
                cart[existingItemIndex].quantity += 1;
            } else {
                // Item doesn't exist, add new item
                cart.push({
                    id: itemId,
                    name: itemName,
                    price: itemPrice,
                    quantity: 1
                });
            }
            
            // Save updated cart back to localStorage
            localStorage.setItem('foodCart', JSON.stringify(cart));
            
            // Show confirmation message
            const confirmMessage = document.createElement('div');
            confirmMessage.className = 'confirm-message';
            confirmMessage.textContent = `${itemName} added to cart!`;
            
            document.body.appendChild(confirmMessage);
            
            // Update cart count
            updateCartCount();
            
            // Remove the confirmation message after 2 seconds
            setTimeout(() => {
                confirmMessage.remove();
            }, 2000);
        }

        // Function to update cart count in the UI
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('foodCart')) || [];
            const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
            
            // Get the cart nav item
            const cartNav = document.querySelector('.nav-item:nth-child(3)');
            
            // Check if we already have a cart count indicator
            let cartCountElement = cartNav.querySelector('.cart-count');
            
            if (!cartCountElement && cartCount > 0) {
                // Create new cart count indicator
                cartCountElement = document.createElement('span');
                cartCountElement.className = 'cart-count';
                
                cartNav.appendChild(cartCountElement);
            }
            
            // Update cart count or remove if zero
            if (cartCountElement) {
                if (cartCount > 0) {
                    cartCountElement.textContent = cartCount;
                } else {
                    cartCountElement.remove();
                }
            }
        }

        // Initialize cart count when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });
    </script>
</body>
</html>