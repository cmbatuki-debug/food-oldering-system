<?php
require_once 'config/db.php';
require_once 'config/functions.php';

requireLogin();

$page_title = "My Cart";
$cart = getCart();

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $food_id => $quantity) {
            updateCart($food_id, intval($quantity));
        }
        setFlash('success', 'Cart has been updated!');
    } elseif (isset($_POST['place_order'])) {
        if (empty($cart)) {
            setFlash('error', 'Cart appears to be empty!', true);
        } else {
            $delivery_address = sanitize($_POST['delivery_address'] ?? '');
            $notes = sanitize($_POST['notes'] ?? '');
            
            if (empty($delivery_address)) {
                setFlash('error', 'Please enter delivery address!');
            } else {
                $total = getCartTotal();
                $order_id = createOrder($_SESSION['user_id'], $total, $delivery_address, $notes);
                
                foreach ($cart as $item) {
                    createOrderItem($order_id, $item['food_id'], $item['quantity'], $item['price']);
                }
                
                clearCart();
                setFlash('success', 'Your order has been placed! Order #: ' . $order_id);
                header('Location: dashboard.php');
                exit();
            }
        }
    }
}
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
            <h1>My Cart</h1>
        </div>
    </section>

    <section class="cart-section">
        <div class="container">
            <?php $flash = getFlash(); ?>
            <?php if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
            <?php endif; ?>
            
            <?php if (empty($cart)): ?>
                <div class="empty-cart">
                    <h2>Cart is empty!</h2>
                    <p>There is no food in your cart.</p>
                    <a href="foods.php" class="btn btn-primary">Go to Menu</a>
                </div>
            <?php else: ?>
                <form method="POST">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Food</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td>TZS <?php echo number_format($item['price'], 0); ?></td>
                                    <td>
                                        <input type="number" name="quantity[<?php echo $item['food_id']; ?>]" 
                                               value="<?php echo $item['quantity']; ?>" min="1" max="10">
                                    </td>
                                    <td>TZS <?php echo number_format($item['price'] * $item['quantity'], 0); ?></td>
                                    <td>
                                        <a href="cart.php?remove=<?php echo $item['food_id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"><strong>Total:</strong></td>
                                <td colspan="2"><strong>TZS <?php echo number_format(getCartTotal(), 0); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <div class="cart-actions">
                        <button type="submit" name="update_cart" class="btn btn-secondary">Update Cart</button>
                    </div>
                    
                    <div class="order-form">
                        <h3>Submit Order</h3>
                        <div class="form-group">
                            <label for="delivery_address">Delivery Address *</label>
                            <textarea id="delivery_address" name="delivery_address" rows="3" required 
                                      placeholder="Enter your delivery address..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="notes">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="2" 
                                      placeholder="Other details..."></textarea>
                        </div>
                        <button type="submit" name="place_order" class="btn btn-primary btn-block">Submit Order</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
