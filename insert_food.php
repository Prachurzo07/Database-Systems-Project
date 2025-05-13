<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="খাবার দাবার Cafeteria Management"/>
    <meta name="author" content="খাবার দাবার"/>
    <title>খাবার দাবার Cafeteria</title>
    
    <!-- core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/font-awesome.min.css" rel="stylesheet"/>
    <link href="css/animate.min.css" rel="stylesheet"/>
    <link href="css/main.css" rel="stylesheet"/>
    
    <style>
        body {
            background-color: #e8f5e9;
            color: #1b5e20;
            font-family: Arial, sans-serif;
        }
        #header {
            background-color: #2e7d32;
            padding: 15px 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .logo-text span:first-child {
            color: #4caf50;
            font-weight: bold;
        }
        .logo-text span:last-child {
            color: #ff3333;
            font-weight: bold;
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo-image {
            margin-right: 10px;
            height: 50px;
        }
        #header a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
            padding: 8px 15px;
            border-radius: 4px;
            background-color: #1b5e20;
        }
        #header a:hover {
            background-color: #388e3c;
        }
        #section1 {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            margin: 0 auto;
            max-width: 800px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .title {
            font-size: 28px;
            color: #2e7d32;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .form_design {
            background-color: #f1f8e9;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #c8e6c9;
        }
        .form_design label {
            display: inline-block;
            width: 150px;
            margin-bottom: 15px;
            font-weight: bold;
            color: #2e7d32;
        }
        .form_design input, .form_design select {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #a5d6a7;
            background-color: white;
            width: 70%;
            color: #1b5e20;
        }
        .form_design input:focus, .form_design select:focus {
            outline: none;
            border-color: #4caf50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }
        .form_design input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            width: auto;
            font-weight: bold;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .form_design input[type="submit"]:hover {
            background-color: #388e3c;
        }
        #footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            background-color: #2e7d32;
            color: white;
        }
        .copyright {
            font-size: 14px;
            color: #e8f5e9;
        }
    </style>
</head>

<body>
    <!-- Menubar section -->
    <section id="header">
        <div class="row">
            <div class="col-md-10 logo-container" style="font-size: 30px;">
                <img src="images.png" alt="খাবার দাবার Logo" class="logo-image">
                <div class="logo-text">
                    <span>খাবার</span> <span>দাবার</span>
                </div>
            </div>
            <div class="col-md-2" style="text-align: right">
                <a href="home_host.php">Home</a>
            </div>
        </div>
    </section>

    <!-- Food Item Entry Form -->
    <section id="section1">
        <div class="title">Add New Food Item</div>
        
        <form action="add_food.php" class="form_design" method="post">
            <div>
                <label for="name">Food Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            
            <div>
                <label for="price">Price (Tk):</label>
                <input type="number" name="price" id="price" step="0.01" required>
            </div>
            
            <div>
                <label for="amount">Amount:</label>
                <input type="text" name="amount" id="amount" placeholder="e.g., 250g, 1 plate" required>
            </div>
            
            <div>
                <label for="category">Category:</label>
                <select name="category" id="category" required>
                    <option value="">Select Category</option>
                    <option value="Breakfast">Breakfast</option>
                    <option value="Lunch">Lunch</option>
                    <option value="Beverages">Beverages</option>
                    <option value="Snacks">Snacks</option>
                </select>
            </div>
            
            <div>
                <label for="healthtag">Health Tag:</label>
                <select name="healthtag" id="healthtag">
                    <option value="">Select Health Tag</option>
                    <option value="Allergic">Allergic</option>
                    <option value="Vegetarian">Vegetarian</option>
                    <option value="High-Calorie">High-Calorie</option>
                    <option value="High-Protein">High-Protein</option>
                    <option value="Spicy">Spicy</option>
                    <option value="Sugary">Sugary</option>
                </select>
            </div>
            
            <div style="text-align: center;">
                <input type="submit" value="Add Food Item">
            </div>
        </form>
    </section>

    <!-- Footer -->
    <section id="footer">
        <div class="copyright">
            &copy; 2025 খাবার দাবার Cafeteria. All rights reserved.
        </div>
    </section>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/wow.min.js"></script>
</body>
</html>