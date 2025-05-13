<?php
    // Database connection
    require_once("connect.php");
    
    // Get category type from URL
    $category = "";
    if(isset($_GET['type'])) {
        $category = mysqli_real_escape_string($conn, $_GET['type']);
    }
    
    // Set category name for display (capitalize first letter)
    $categoryName = ucfirst($category);
    
    // Get category icon
    $categoryIcon = "";
    switch($category) {
        case "beverages":
            $categoryIcon = "fa-coffee";
            break;
        case "chicken":
            $categoryIcon = "fa-drumstick-bite";
            break;
        case "snacks":
            $categoryIcon = "fa-cookie";
            break;
        case "rice":
            $categoryIcon = "fa-bowl-rice";
            break;
        case "desserts":
            $categoryIcon = "fa-ice-cream";
            break;
        case "baked":
            $categoryIcon = "fa-bread-slice";
            break;
        case "breakfast":
            $categoryIcon = "fa-egg";
            break;
        case "lunch":
            $categoryIcon = "fa-utensils";
            break;
        case "afternoon":
            $categoryIcon = "fa-mug-hot";
            break;
        case "vegetable":
            $categoryIcon = "fa-carrot";
            break;
        default:
            $categoryIcon = "fa-utensils";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>খাবার দাবার - <?php echo $categoryName; ?></title>
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
        
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
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
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            color: #2e8b57;
        }

        .items-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .item-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            position: relative;
        }

        .item-card:hover {
            transform: translateY(-5px);
        }

        .item-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .item-details {
            padding: 15px;
        }

        .item-title {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .item-price {
            color: #2e8b57;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .item-rating {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .rating-stars {
            color: #ffc107;
            margin-right: 5px;
        }
        
        .rating-count {
            color: #777;
            font-size: 14px;
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

        .no-items {
            grid-column: 1 / -1;
            text-align: center;
            padding: 50px 0;
            color: #777;
            font-size: 18px;
        }

        /* Health tag styles */
        .health-tag {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .health-tag.spicy {
            background-color: rgba(220, 53, 69, 0.8);
        }
        
        .health-tag.vegetarian {
            background-color: rgba(40, 167, 69, 0.8);
        }
        
        .health-tag.high-calorie {
            background-color: rgba(255, 193, 7, 0.8);
        }
        
        .health-tag.high-protein {
            background-color: rgba(23, 162, 184, 0.8);
        }
        
        .health-tag.allergic {
            background-color: rgba(111, 66, 193, 0.8);
        }
        
        .health-tag.sugary {
            background-color: rgba(253, 126, 20, 0.8);
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

        @media (max-width: 992px) {
            .items-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .items-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .items-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-container">
                <a href="home.php" class="logo">
                    <img src="images.png" alt="খাবার দাবার Logo" style="width: 60px; height: 60px;">
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
        </div>
    </header>

    <main class="container">
        <h2 class="section-title">
            <i class="fas <?php echo $categoryIcon; ?>"></i>
            <?php echo $categoryName; ?>
        </h2>
        
        <div class="items-grid">
            <?php 
                // SQL query to fetch items based on category
                $sql = "SELECT f.*, 
                        AVG(fr.rating) as avg_rating, 
                        COUNT(fr.rating) as rating_count 
                        FROM food f 
                        LEFT JOIN food_ratings fr ON f.name = fr.food 
                        WHERE f.category = '$category' 
                        GROUP BY f.name";
                        
                $result = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($result) > 0) {
                    // Output each food item
                    while($row = mysqli_fetch_assoc($result)) {
                        $id = isset($row['name']) ? $row['price'] : $row['category']; 
                        
                        $name = $row['name'];
                        $price = $row['price'];
                        $image = !empty($row['image_url']) ? $row['image_url'] : 'default_food.jpg';
                        $healthtag = isset($row['healthtag']) ? $row['healthtag'] : '';
                        
                        // Determine health tag CSS class
                        $healthtagClass = '';
                        switch(strtolower($healthtag)) {
                            case 'spicy':
                                $healthtagClass = 'spicy';
                                break;
                            case 'vegetarian':
                                $healthtagClass = 'vegetarian';
                                break;
                            case 'high-calorie':
                                $healthtagClass = 'high-calorie';
                                break;
                            case 'high-protein':
                                $healthtagClass = 'high-protein';
                                break;
                            case 'allergic':
                                $healthtagClass = 'allergic';
                                break;
                            case 'sugary':
                                $healthtagClass = 'sugary';
                                break;
                        }
                        
                        // Rating data
                        $avgRating = isset($row['avg_rating']) ? round($row['avg_rating'], 1) : 0;
                        $ratingCount = isset($row['rating_count']) ? $row['rating_count'] : 0;
                        
                        // Generate stars based on rating
                        $fullStars = floor($avgRating);
                        $halfStar = ($avgRating - $fullStars) >= 0.5 ? 1 : 0;
                        $emptyStars = 5 - $fullStars - $halfStar;
            ?>
                <div class="item-card">
                    <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" class="item-image">
                    <?php if (!empty($healthtag)): ?>
                        <div class="health-tag <?php echo $healthtagClass; ?>"><?php echo $healthtag; ?></div>
                    <?php endif; ?>
                    <div class="item-details">
                        <h3 class="item-title"><?php echo $name; ?></h3>
                        <p class="item-price">৳<?php echo $price; ?></p>
                        <div class="item-rating">
                            <div class="rating-stars">
                                <?php
                                    // Display full stars
                                    for ($i = 0; $i < $fullStars; $i++) {
                                        echo '<i class="fas fa-star"></i>';
                                    }
                                    
                                    // Display half star if applicable
                                    if ($halfStar) {
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    }
                                    
                                    // Display empty stars
                                    for ($i = 0; $i < $emptyStars; $i++) {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                ?>
                            </div>
                            <span class="rating-count">(<?php echo $ratingCount; ?> reviews)</span>
                        </div>
                        <button class="add-to-cart" onclick="addToCart(<?php echo $id; ?>)">Add to Cart</button>
                    </div>
                </div>
            <?php
                    }
                } else {
                    // If no items found in the category
                    echo '<div class="no-items">No items available in this category yet.</div>';
                }
            ?>
        </div>
    </main>

    <nav class="bottom-nav">
        <a href="home.php" class="nav-item active">
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
        <a href="account.php" class="nav-item">
            <i class="fas fa-user"></i>
            <span>Account</span>
        </a>
    </nav>

    <script>
function addToCart(itemId) {
    // Get the item details from the DOM
    const itemCard = event.target.closest('.item-card');
    const itemName = itemCard.querySelector('.item-title').textContent;
    const itemPrice = parseFloat(itemCard.querySelector('.item-price').textContent.replace('৳', ''));
    
    // Get existing cart from localStorage or create empty array if none exists
    let cart = JSON.parse(localStorage.getItem('foodCart')) || [];
    
    // Check if item already exists in cart
    const existingItemIndex = cart.findIndex(item => item.id === itemId);
    
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
    confirmMessage.style.cssText = `
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
    `;
    
    document.body.appendChild(confirmMessage);
    
    // Update cart count if you have a counter element
    updateCartCount();
    
    // Remove the confirmation message after 2 seconds
    setTimeout(() => {
        confirmMessage.remove();
    }, 2000);
}

function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('foodCart')) || [];
    const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
    
   
    const cartNav = document.querySelector('.nav-item:nth-child(3)');
    
    // Check if we already have a cart count indicator
    let cartCountElement = cartNav.querySelector('.cart-count');
    
    if (!cartCountElement && cartCount > 0) {
        // Create new cart count indicator
        cartCountElement = document.createElement('span');
        cartCountElement.className = 'cart-count';
        cartCountElement.style.cssText = `
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
        `;
        
        // Make the cart icon position relative for absolute positioning of the badge
        cartNav.style.position = 'relative';
        
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