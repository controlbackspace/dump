<?php
session_start();
include 'connect.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['email']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $currentStatus = $_POST['currentStatus'];
    
    // Toggle the admin status
    $newStatus = $currentStatus ? 0 : 1;
    
    $sql = "UPDATE users SET is_admin = ? WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $newStatus, $userId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?> 