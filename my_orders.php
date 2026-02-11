<?php
require_once 'config/db.php';
require_once 'config/functions.php';

requireLogin();

$page_title = "My Orders - Food Ordering System";
$orders = getUserOrders($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1>My Orders</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</p>
        </div>
    </section>

    <section class="dashboard-section">
        <div class="container">
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>Total Orders</h3>
                    <p class="stat"><?php echo count($orders); ?></p>
                </div>
                <div class="dashboard-card">
                    <h3>Pending</h3>
                    <p class="stat"><?php echo count(array_filter($orders, function($o) { return $o['status'] === 'pending'; })); ?></p>
                </div>
                <div class="dashboard-card">
                    <h3>Approved</h3>
                    <p class="stat"><?php echo count(array_filter($orders, function($o) { return $o['status'] === 'approved'; })); ?></p>
                </div>
                <div class="dashboard-card">
                    <h3>Completed</h3>
                    <p class="stat"><?php echo count(array_filter($orders, function($o) { return $o['status'] === 'completed'; })); ?></p>
                </div>
            </div>

            <h2>Order History</h2>
            
            <?php if (empty($orders)): ?>
                <div class="empty-state">
                    <h2>No Orders Yet</h2>
                    <p>You haven't placed any orders yet.</p>
                    <a href="foods.php" class="btn btn-primary">Start Ordering</a>
                </div>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?php echo $order['id']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                <td>
                                    <?php
                                    // Get order items count
                                    global $conn;
                                    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM order_items WHERE order_id = ?");
                                    $stmt->bind_param("i", $order['id']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $item_count = $result->fetch_assoc();
                                    $stmt->close();
                                    echo $item_count['count'] . ' items';
                                    ?>
                                </td>
                                <td>TZS <?php echo number_format($order['total_amount'], 0); ?></td>
                                <td>
                                    <span class="status status-<?php echo $order['status']; ?>">
                                        <?php echo ucfirst($order['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-secondary">View Details</a>
                                    <?php if ($order['status'] === 'pending'): ?>
                                        <a href="cancel_order.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this order?');">Cancel</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            
            <div class="text-center" style="margin-top: 30px;">
                <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
