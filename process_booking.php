<?php
require_once('connect.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to book items']);
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_data = $_POST['cart_data'];
$booking_date = $_POST['booking_date'];
$booking_time = $_POST['booking_time'];
$special_instructions = $_POST['special_instructions'] ?? '';
$booking_token = rand(1000, 9999);

if (empty($cart_data)) {
    echo json_encode(['success' => false, 'message' => 'Cart is empty']);
    exit();
}

try {
    
    
    $sql = "INSERT INTO advance_booking (user_id, booking_date, booking_time, special_request, booking_token,food_items) VALUES ('$user_id', '$booking_date', '$booking_time', '$special_instructions', '$booking_token' ,'$cart_data')";
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception("Database error: " . $conn->error);
    }