<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khabar Dabar - Sold Items Report</title>
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
            background-color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo-container img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .logo-container h1 {
            font-size: 24px;
        }
        .logo-container h1 span.green {
            color: #228B22;
        }
        .logo-container h1 span.red {
            color: red;
        }
        .search-container {
            display: flex;
            align-items: center;
        }
        .search-container input {
            padding: 8px 15px;
            border-radius: 20px 0 0 20px;
            border: 1px solid #ccc;
            outline: none;
            width: 250px;
        }
        .search-container button {
            padding: 8px 15px;
            border-radius: 0 20px 20px 0;
            border: none;
            background-color: #228B22;
            color: white;
            cursor: pointer;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-weight: bold;
        }
        .btn-green {
            background-color: #228B22;
        }
        .main-content {
            padding: 20px;
        }
        .page-title {
            color: #333;
            margin-bottom: 20px;
        }
        .sold-items-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 5px;
            overflow: hidden;
        }
        .sold-items-table th {
            background-color: #228B22;
            color: white;
            text-align: left;
            padding: 12px 15px;
        }
        .sold-items-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }
        .sold-items-table tr:last-child td {
            border-bottom: none;
        }
        .sold-items-table tr:hover {
            background-color: #f5f5f5;
        }
        .tag {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }
        .tag-snacks {
            background-color: #228B22;
        }
        .tag-beverages {
            background-color: #228B22;
        }
        .rank {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #228B22;
            color: white;
            font-weight: bold;
        }
        .rank-1 {
            background-color: gold;
            color: #333;
        }
        .rank-2 {
            background-color: silver;
            color: #333;
        }
        .rank-3 {
            background-color: #cd7f32;
        }
        .footer {
            text-align: center;
            padding: 15px;
            margin-top: 20px;
            color: #555;
        }
        .navbar {
            background-color: #f0f0f0;
            padding: 10px 20px;
            display: flex;
            gap: 15px;
        }
        .navbar a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .navbar a.active {
            color: #228B22;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="images.png" alt="Khabar Dabar Logo">
            <h1><span class="green">খাবার</span> <span class="red">দাবার</span></h1>
        </div>
        <div class="action-buttons">
            <a href="home_host.php" class="btn btn-green">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 5px;">
                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
                    <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"/>
                </svg>
                Home
            </a>
        </div>
    </div>
    
    <div class="main-content">
        <h2 class="page-title">Sold Items Report</h2>
        
        <table class="sold-items-table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Item</th>
                    <th>Price (Tk)</th>
                    <th>Quantity Sold</th>
                    <th>Total Revenue (Tk)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connect to the cse370 database
                $conn = new mysqli("localhost", "root", "", "cse370");
                
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                // Query to get sold items data ordered by total revenue (price * amount) in descending order
                $sql = "SELECT name, price, amount FROM sold_item ORDER BY (price * amount) DESC";
                $result = $conn->query($sql);
                
                // Check if query was successful
                if ($result === false) {
                    echo "<tr><td colspan='5' style='text-align: center;'>Error executing query: " . $conn->error . "</td></tr>";
                } 
                elseif ($result->num_rows > 0) {
                    $rank = 1;
                    while($row = $result->fetch_assoc()) {
                        $totalRevenue = $row["price"] * $row["amount"];
                        $rankClass = ($rank <= 3) ? "rank-".$rank : "";
                        
                        echo "<tr>";
                        echo "<td><div class='rank $rankClass'>$rank</div></td>";
                        echo "<td>".$row["name"]."</td>";
                        echo "<td>".$row["price"]."</td>";
                        echo "<td>".$row["amount"]."</td>";
                        echo "<td>".number_format($totalRevenue)."</td>";
                        echo "</tr>";
                        
                        $rank++;
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align: center;'>No items found in the database</td></tr>";
                }
                
                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        © 2025 Khabar Dabar - Cafeteria Management System
    </div>
</body>
</html>