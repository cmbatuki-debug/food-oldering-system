<?php
require_once 'config/db.php';
require_once 'config/functions.php';

requireLogin();

$order_id = intval($_GET['id'] ?? 0);
$order = getOrderById($order_id);

// Verify order belongs to user
if (!$order || ($order['user_id'] != $_SESSION['user_id'] && !isAdmin())) {
    setFlash('error', 'Order not found!');
    header('Location: dashboard.php');
    exit();
}

$order_items = getOrderItems($order_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?php echo $order_id; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1>Order #<?php echo $order_id; ?></h1>
        </div>
    </section>

    <section class="order-details-section">
        <div class="container">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            
            <div class="order-info">
                <div class="order-summary">
                    <h3>Order Details</h3>
                    <p><strong>Date:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
                    <p><strong>Status:</strong> <span class="status status-<?php echo $order['status']; ?>"><?php echo ucfirst($order['status']); ?></span></p>
                    <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($order['delivery_address'])); ?></p>
                    <?php if ($order['notes']): ?>
                        <p><strong>Notes:</strong> <?php echo nl2br(htmlspecialchars($order['notes'])); ?></p>
                    <?php endif; ?>
                </div>
                
                <h3>Ordered Items</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Food</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['food_name']); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>TZS <?php echo number_format($item['price'], 0); ?></td>
                                <td>TZS <?php echo number_format($item['price'] * $item['quantity'], 0); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Total:</strong></td>
                            <td><strong>TZS <?php echo number_format($order['total_amount'], 0); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
