<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>খাবার দাবার - Cafeteria Management System</title>
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
        <h2 class="section-title">Categories</h2>
        <div class="categories-grid">
            <a href="category.php?type=beverages" class="category-card">
            <img src="beverage.jpg" alt="Beverages" style="width: 150px;height: 150px; margin-middle:70px;">
                <h3 class="category-title">
                    <i class="fas fa-coffee"></i>
                    Beverages
                </h3>
            </a>
            <a href="category.php?type=snacks" class="category-card">
            <img src="snacks.jpg" alt="Snacks" style="width: 150px;height: 150px; margin-middle:70px;">
                <h3 class="category-title">
                    <i class="fas fa-cookie"></i>
                    Snacks
                </h3>
            </a>
            <a href="category.php?type=breakfast" class="category-card">
            <img src="breakfast.jpg" alt="Breakfast Items" style="width: 150px;height: 150px; margin-middle:70px;">
                <h3 class="category-title">
                    <i class="fas fa-egg"></i>
                    Breakfast Items
                </h3>
            </a>
            <a href="category.php?type=lunch" class="category-card">
            <img src="lunch.jpg" alt="Lunch Items" style="width: 150px;height: 150px; margin-middle:70px;">
                <h3 class="category-title">
                    <i class="fas fa-utensils"></i>
                    Lunch Items
                </h3>
            </a>
        </div>
    </main>

    <nav class="bottom-nav">
        <a href="index.html" class="nav-item active">
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
</body>
</html>