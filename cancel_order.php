<?php
require_once 'config/db.php';
require_once 'config/functions.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $order_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];
    
    // Verify the order belongs to the user and is pending
    global $conn;
    $stmt = $conn->prepare("SELECT id, status FROM orders WHERE id = ? AND user_id = ? AND status = 'pending'");
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        if (cancelOrder($order_id, $user_id)) {
            setFlash('success', 'Order cancelled successfully!');
        } else {
            setFlash('error', 'Failed to cancel order.');
        }
    } else {
        setFlash('error', 'Order not found or cannot be cancelled.');
    }
    
    header('Location: my_orders.php');
    exit();
} else {
    header('Location: dashboard.php');
    exit();
}
