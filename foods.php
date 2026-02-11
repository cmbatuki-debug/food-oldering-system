<?php
require_once 'config/db.php';
require_once 'config/functions.php';

$page_title = "Our Foods";
$search = sanitize($_GET['search'] ?? '');
$category_id = intval($_GET['category'] ?? 0);
$food_id = intval($_GET['id'] ?? 0);

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    requireLogin();
    $food_id = intval($_POST['food_id']);
    $quantity = intval($_POST['quantity'] ?? 1);
    addToCart($food_id, $quantity);
    setFlash('success', 'Food has been added to cart!');
    header('Location: cart.php');
    exit();
}

// Get foods
if ($search) {
    $foods = searchFoods($search);
} elseif ($category_id) {
    $foods = getFoodsByCategory($category_id);
} else {
    $foods = getAvailableFoods();
}

$categories = getAllCategories();
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
            <h1>Our Foods</h1>
            <p>Choose the food you want</p>
        </div>
    </section>

    <section class="foods-section">
        <div class="container">
            <!-- Search and Filter -->
            <div class="search-filter">
                <form action="" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Search food..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                
                <div class="categories-filter">
                    <a href="foods.php" class="btn <?php echo !$category_id ? 'btn-primary' : 'btn-secondary'; ?>">All</a>
                    <?php foreach ($categories as $cat): ?>
                        <a href="foods.php?category=<?php echo $cat['id']; ?>" class="btn <?php echo $category_id == $cat['id'] ? 'btn-primary' : 'btn-secondary'; ?>">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Food Details Modal -->
            <?php if ($food_id > 0): ?>
                <?php $food = getFoodById($food_id); ?>
                <?php if ($food): ?>
                    <div class="food-details">
                        <div class="food-details-content">
                            <button class="close-btn" onclick="window.location='foods.php'">&times;</button>
                            <h2><?php echo htmlspecialchars($food['name']); ?></h2>
                            <p class="category">Category: <?php echo htmlspecialchars($food['category_name'] ?? ''); ?></p>
                            <p class="description"><?php echo htmlspecialchars($food['description'] ?? ''); ?></p>
                            <p class="price">TZS <?php echo number_format($food['price'], 0); ?></p>
                            
                            <?php if (isLoggedIn()): ?>
                                <form method="POST">
                                    <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
                                    <div class="form-group">
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="10">
                                    </div>
                                    <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                                </form>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-secondary">Login to order</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Foods Grid -->
            <div class="foods-grid">
                <?php foreach ($foods as $food): ?>
                    <div class="food-card">
                        <div class="food-info">
                            <h3><?php echo htmlspecialchars($food['name']); ?></h3>
                            <p class="category"><?php echo htmlspecialchars($food['category_name'] ?? ''); ?></p>
                            <p class="description"><?php echo htmlspecialchars($food['description'] ?? ''); ?></p>
                            <p class="price">TZS <?php echo number_format($food['price'], 0); ?></p>
                            <a href="foods.php?id=<?php echo $food['id']; ?>" class="btn btn-secondary">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <?php if (empty($foods)): ?>
                    <p class="no-data">No food found!</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
