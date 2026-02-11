<?php
require_once 'config/db.php';
require_once 'config/functions.php';

$page_title = "Home - Food Ordering System";
$foods = getAvailableFoods();
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

    <!-- Hero Slider -->
    <div class="slider-container">
        <div class="slider-track" id="sliderTrack">
            <!-- Slide 1 -->
            <div class="slider-slide">
                <img src="assets/images/food.jpg" alt="Delicious Food">
                <div class="slider-overlay">
                    <div class="slider-content">
                        <h1>WELCOME TO FOOD RESTAURANT</h1>
                        <p>Experience the best cuisine from around the world</p>
                        <a href="foods.php" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="slider-slide">
                <img src="assets/images/menu.jpg" alt="Our Menu">
                <div class="slider-overlay">
                    <div class="slider-content">
                        <h1>WELCOME TO FOOD RESTAURANT</h1>
                        <p>Fresh ingredients, amazing taste, great prices</p>
                        <a href="foods.php" class="btn btn-primary">View Menu</a>
                    </div>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="slider-slide">
                <img src="assets/images/homepage_pic.jpg" alt="Special Dishes">
                <div class="slider-overlay">
                    <div class="slider-content">
                        <h1>WELCOME TO FOOD RESTAURANT</h1>
                        <p>Order your favorite food online - Fast & Easy</p>
                        <a href="foods.php" class="btn btn-primary">Start Ordering</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation Arrows -->
        <button class="slider-arrow prev" onclick="prevSlide()">&#10094;</button>
        <button class="slider-arrow next" onclick="nextSlide()">&#10095;</button>
        
        <!-- Navigation Dots -->
        <div class="slider-nav" id="sliderNav"></div>
    </div>

    <!-- Search Section -->
    <section class="search-section">
        <div class="container">
            <form action="foods.php" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search for food...">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <h2>Our Categories</h2>
            <div class="categories-grid">
                <?php foreach ($categories as $cat): ?>
                    <a href="foods.php?category=<?php echo $cat['id']; ?>" class="category-card">
                        <h3><?php echo htmlspecialchars($cat['name']); ?></h3>
                        <p><?php echo htmlspecialchars($cat['description'] ?? ''); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Popular Foods Section -->
    <section class="foods-section">
        <div class="container">
            <h2>Popular Foods</h2>
            <div class="foods-grid">
                <?php foreach (array_slice($foods, 0, 6) as $food): ?>
                    <div class="food-card">
                        <div class="food-info">
                            <h3><?php echo htmlspecialchars($food['name']); ?></h3>
                            <p class="category"><?php echo htmlspecialchars($food['category_name'] ?? ''); ?></p>
                            <p class="description"><?php echo htmlspecialchars($food['description'] ?? ''); ?></p>
                            <p class="price">TZS <?php echo number_format($food['price'], 0); ?></p>
                            <a href="foods.php?id=<?php echo $food['id']; ?>" class="btn btn-secondary">Add to Cart</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center">
                <a href="foods.php" class="btn btn-primary">View All Foods</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <h2>About Us</h2>
            <p>Food Ordering System is your go-to platform for ordering delicious food online. 
               We offer a wide variety of cuisines from different restaurants, delivered fast and fresh to your doorstep.</p>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <!-- JavaScript for Slider -->
    <script>
        // Slider JavaScript - Vanilla JS (No libraries)
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slider-slide');
        const totalSlides = slides.length;
        const track = document.getElementById('sliderTrack');
        const nav = document.getElementById('sliderNav');
        let autoSlideInterval;
        
        // Create navigation dots
        function createNavDots() {
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('div');
                dot.classList.add('slider-dot');
                if (i === 0) dot.classList.add('active');
                dot.onclick = () => goToSlide(i);
                nav.appendChild(dot);
            }
        }
        
        // Update slider position
        function updateSlider() {
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update dots
            document.querySelectorAll('.slider-dot').forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        }
        
        // Go to specific slide
        function goToSlide(index) {
            currentSlide = index;
            if (currentSlide >= totalSlides) currentSlide = 0;
            if (currentSlide < 0) currentSlide = totalSlides - 1;
            updateSlider();
            resetAutoSlide();
        }
        
        // Next slide
        function nextSlide() {
            goToSlide(currentSlide + 1);
        }
        
        // Previous slide
        function prevSlide() {
            goToSlide(currentSlide - 1);
        }
        
        // Auto slide
        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, 4000); // Change every 4 seconds
        }
        
        // Reset auto slide on manual navigation
        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }
        
        // Initialize slider
        document.addEventListener('DOMContentLoaded', function() {
            createNavDots();
            startAutoSlide();
        });
    </script>
</body>
</html>
