<?php
require_once 'config/db.php';
require_once 'config/functions.php';

requireLogin();

if (isAdmin()) {
    header('Location: admin/dashboard.php');
    exit();
}

$page_title = "My Dashboard";
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
            <h1>My Dashboard</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</p>
        </div>
    </section>

    <section class="dashboard-section">
        <div class="container">
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>My Orders</h3>
                    <p class="stat"><?php echo count($orders); ?></p>
                    <a href="my_orders.php" class="btn btn-primary">View All Orders</a>
                </div>
                <div class="dashboard-card">
                    <h3>Cart</h3>
                    <p class="stat"><?php echo getCartCount(); ?> items</p>
                    <a href="cart.php" class="btn btn-secondary">View Cart</a>
                </div>
                <div class="dashboard-card">
                    <h3>Account</h3>
                    <p class="stat">Profile</p>
                    <a href="profile.php" class="btn btn-secondary">Edit Profile</a>
                </div>
            </div>

            <h2>My Recent Orders</h2>
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
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($orders, 0, 5) as $order): ?>
                            <tr>
                                <td>#<?php echo $order['id']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                <td>TZS <?php echo number_format($order['total_amount'], 0); ?></td>
                                <td>
                                    <span class="status status-<?php echo $order['status']; ?>">
                                        <?php echo ucfirst($order['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-secondary">View Details</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (count($orders) > 5): ?>
                    <div class="text-center" style="margin-top: 20px;">
                        <a href="my_orders.php" class="btn btn-primary">View All Orders</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
