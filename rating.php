<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Gallery</title>
    <style>
        :root {
            --dark-green: #1b8c3a; /* Updated to match screenshot */
            --light-green: #269e44; /* Updated to match screenshot */
            --cream: #f9f6f0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--cream);
            color: var(--dark-green);
            margin: 0;
            padding: 0;
        }
        
        header {
            background-color: var(--dark-green);
            color: white;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        
        /* Modified navigation menu for top right positioning */
        .nav-menu {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
        }
        
        .nav-menu a {
            display: inline-block;
            background-color: var(--dark-green);
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin: 0 5px;
            border-radius: 25px;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 2px solid white;
        }
        
        .nav-menu a i {
            margin-right: 5px;
        }
        
        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .food-item {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        
        .food-item:hover {
            transform: translateY(-5px);
        }
        
        .food-image {
            height: 180px;
            background-color: var(--light-green);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .food-info {
            padding: 1rem;
        }
        
        .food-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 0 0 0.5rem 0;
            color: var(--dark-green);
        }
        
        .rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .rating-value {
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .rating-stars {
            color: goldenrod;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            overflow: auto;
        }
        
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 2rem;
            width: 80%;
            max-width: 700px;
            border-radius: 10px;
            position: relative;
        }
        
        .close {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            color: var(--dark-green);
        }
        
        .modal-image {
            height: 200px;
            background-color: var(--light-green);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }
        
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: var(--dark-green);
            color: white;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .db-error {
            background-color: #ffdddd;
            color: #cc0000;
            padding: 1rem;
            border-radius: 5px;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Food Gallery</h1>
        <!-- Navigation menu moved inside header for top right positioning -->
        <div class="nav-menu">
            <a href="home_host.php"><i class="fas fa-home"></i> Home</a>
        </div>
    </header>
    
    <main>
        <?php
        // Database connection settings
        $host = "localhost";    // Replace with your host if different
        $dbname = "cse370";     // Database name as specified
        $username = "root";     // Replace with your database username
        $password = "";         // Replace with your database password
        
        try {
            // Create a database connection
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Fetch all food ratings from the database
            $stmt = $conn->prepare("SELECT * FROM food_ratings ORDER BY created_at DESC");
            $stmt->execute();
            $foodRatings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Group food items by name and calculate average ratings
            $groupedFoods = [];
            
            foreach ($foodRatings as $item) {
                if (!isset($groupedFoods[$item['food']])) {
                    $groupedFoods[$item['food']] = [
                        'name' => $item['food'],
                        'ratings' => [],
                        'allEntries' => []
                    ];
                }
                $groupedFoods[$item['food']]['ratings'][] = $item['rating'];
                $groupedFoods[$item['food']]['allEntries'][] = $item;
            }
            
            // Calculate average ratings for each food
            $foodsWithAvgRating = [];
            foreach ($groupedFoods as $food) {
                $sum = array_sum($food['ratings']);
                $avgRating = $sum / count($food['ratings']);
                $food['avgRating'] = number_format($avgRating, 1);
                $foodsWithAvgRating[] = $food;
            }
            
            // Sort foods by average rating (highest first)
            usort($foodsWithAvgRating, function($a, $b) {
                return $b['avgRating'] <=> $a['avgRating'];
            });
            
            // Function to generate stars based on rating
            function getStars($rating) {
                $fullStars = floor($rating);
                $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                $emptyStars = 5 - $fullStars - $halfStar;
                
                return str_repeat('★', $fullStars) . 
                       ($halfStar ? '½' : '') . 
                       str_repeat('☆', $emptyStars);
            }
        ?>
        
        <div class="gallery" id="foodGallery">
            <?php foreach ($foodsWithAvgRating as $index => $food): ?>
                <div class="food-item" onclick="openFoodDetails(<?php echo $index; ?>)">
                    <div class="food-image"><?php echo htmlspecialchars($food['name']); ?></div>
                    <div class="food-info">
                        <h3 class="food-title"><?php echo htmlspecialchars($food['name']); ?></h3>
                        <div class="rating">
                            <span class="rating-value"><?php echo $food['avgRating']; ?></span>
                            <span class="rating-stars"><?php echo getStars(floatval($food['avgRating'])); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php
        } catch(PDOException $e) {
            echo '<div class="db-error">Database connection failed: ' . $e->getMessage() . '</div>';
        }
        ?>
    </main>
    
    <div id="foodModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modalContent">
                <!-- Modal content will be populated here by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Adding Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script>
        // PHP data is transferred to JavaScript
        const foods = <?php echo json_encode($foodsWithAvgRating ?? []); ?>;
        
        // Function to get stars (same as PHP function, for consistency)
        function getStars(rating) {
            const fullStars = Math.floor(rating);
            const halfStar = (rating - fullStars) >= 0.5 ? 1 : 0;
            const emptyStars = 5 - fullStars - halfStar;
            
            return '★'.repeat(fullStars) + (halfStar ? '½' : '') + '☆'.repeat(emptyStars);
        }
        
        // Format date for display
        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleString();
        }
        
        // Open modal with food details
        function openFoodDetails(index) {
            const food = foods[index];
            const modal = document.getElementById('foodModal');
            const modalContent = document.getElementById('modalContent');
            
            if (!food) return;
            
            let ratingsTableRows = '';
            food.allEntries.forEach(entry => {
                ratingsTableRows += `
                    <tr>
                        <td>${entry.user_id}</td>
                        <td>${entry.rating}</td>
                        <td>${formatDate(entry.created_at)}</td>
                        <td>${entry.feedback || '-'}</td>
                    </tr>
                `;
            });
            
            modalContent.innerHTML = `
                <div class="modal-image">${food.name}</div>
                <h2>${food.name}</h2>
                <p><strong>Average Rating:</strong> ${food.avgRating} <span class="rating-stars">${getStars(parseFloat(food.avgRating))}</span></p>
                <p><strong>Number of Ratings:</strong> ${food.ratings.length}</p>
                
                <h3>All Ratings</h3>
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Rating</th>
                            <th>Date</th>
                            <th>Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${ratingsTableRows}
                    </tbody>
                </table>
            `;
            
            modal.style.display = 'block';
        }

        // Close modal
        function closeModal() {
            const modal = document.getElementById('foodModal');
            modal.style.display = 'none';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('foodModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>