<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "cse370";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get advance bookings
$sql = "SELECT * FROM advance_booking";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advance Bookings - খাবার দাবার</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .header {
            background-color: #2e8b57;
            color: white;
            padding: 15px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            display: flex;
            align-items: center;
            margin-left: 15px;
        }
        .logo img {
            height: 40px;
            margin-right: 10px;
        }
        .logo h1 {
            font-size: 24px;
            margin: 0;
        }
        .nav-link {
            color: white;
            text-decoration: none;
            background-color: white;
            color: #2e8b57;
            padding: 8px 15px;
            border-radius: 5px;
            margin-right: 15px;
        }
        .booking-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        .booking-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }
        .booking-actions {
            margin-top: 15px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .accept-btn {
            background-color: #2e8b57;
            color: white;
            border: none;
        }
        .reject-btn {
            background-color: #dc3545;
            color: white;
            border: none;
        }
        .container {
            padding: 30px 15px;
        }
        h2 {
            margin-bottom: 25px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="https://via.placeholder.com/40" alt="খাবার দাবার Logo">
            <h1>খাবার দাবার</h1>
        </div>
        <div class="title">
            <h2>Advance Bookings</h2>
        </div>
        <a href="home_host.php" class="nav-link">Home</a>
    </div>

    <div class="container">
        <h2>Pending Advance Bookings</h2>
        
        <?php
        if ($result && $result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                // Using the exact column names from your advance_booking table
                $bookingToken = isset($row["booking_token"]) ? $row["booking_token"] : "Unknown";
                $userId = isset($row["user_id"]) ? $row["user_id"] : "N/A";
                $foodItems = isset($row["food_items"]) ? $row["food_items"] : "None";
                $bookingDate = isset($row["booking_date"]) ? $row["booking_date"] : "N/A";
                $bookingTime = isset($row["booking_time"]) ? $row["booking_time"] : "N/A";
                $specialRequest = isset($row["special_request"]) ? $row["special_request"] : "None";
                
                // Assume status is not a field in your table, so we'll mark all as pending
                $status = "Pending";
                
                ?>
                <div class="booking-card">
                    <div class="booking-header">
                        <h3>Booking #<?php echo $bookingToken; ?></h3>
                        <span class="badge bg-warning">Pending</span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>User ID:</strong> <?php echo htmlspecialchars($userId); ?></p>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($bookingDate); ?></p>
                            <p><strong>Time:</strong> <?php echo htmlspecialchars($bookingTime); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Food Items:</strong> <?php echo htmlspecialchars($foodItems); ?></p>
                            <p><strong>Special Request:</strong> <?php echo htmlspecialchars($specialRequest); ?></p>
                        </div>
                    </div>
                    <div class="booking-actions">
                        <form action="insert_food.php" method="POST" style="display: inline;">
                            <input type="hidden" name="booking_token" value="<?php echo $bookingToken; ?>">
                            <input type="hidden" name="id_field" value="booking_token">
                            <input type="hidden" name="action" value="accept">
                            <button type="submit" class="btn accept-btn">Accept Booking</button>
                        </form>
                        <form action="home_host.php" method="POST" style="display: inline;">
                            <input type="hidden" name="booking_token" value="<?php echo $bookingToken; ?>">
                            <input type="hidden" name="id_field" value="booking_token">
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="btn reject-btn">Reject Booking</button>
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            if (!$result) {
                echo "<div class='alert alert-danger'>Error executing query: " . $conn->error . "</div>";
            } else {
                echo "<div class='alert alert-info'>No pending advance bookings found.</div>";
            }
        }
        $conn->close();
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>