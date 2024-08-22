<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Slider</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
      body {
    font-family: Arial, sans-serif;
    background-color: #f7f7e8;
    color: #333;
    margin: 0;
    padding: 20px;
}

.product-section {
    max-width: 1200px;
    margin: auto;
    text-align: center;
}

.section-title {
    font-size: 2rem;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4CAF50;
}

.section-title i {
    margin-right: 10px;
}

.product-slider {
    overflow: hidden;
    position: relative;
}

.slider-wrapper {
    display: flex;
    transition: transform 0.3s ease-in-out;
}

.product-card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 15px;
    text-align: center;
    margin: 0 10px;
    flex: 0 0 33.3333%; /* Each card takes 1/3 of the slider width */
    transition: transform 0.3s ease;
}

.product-card:hover {
    transform: scale(1.05);
}

.product-image {
    max-width: 100%;
    border-radius: 8px;
}

.product-details {
    margin-top: 15px;
}

.product-rating {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
    font-size: 1rem;
}

.stars {
    color: #ffd700;
}

.product-name {
    font-size: 1.2rem;
    margin: 10px 0;
    font-weight: bold;
}

.product-description {
    font-size: 0.9rem;
    color: #777;
}

.product-price {
    font-size: 1.2rem;
    color: #4CAF50;
    margin-bottom: 15px;
}

.add-to-cart {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
}

.add-to-cart i {
    margin-left: 10px;
}

.add-to-cart:hover {
    background-color: #45a049;
}

/* Slider Controls */
.slider-controls {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.slider-btn {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 50%;
    cursor: pointer;
    margin: 0 10px;
}

.slider-btn:hover {
    background-color: #45a049;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .slider-wrapper {
        flex-wrap: nowrap;
        flex-direction: row;
        transform: translateX(0); /* Ensure reset on smaller screens */
    }

    .product-card {
        flex: 0 0 100%; /* Each card takes the full slider width */
    }
}

    </style>
</head>
<body>
    <section class="product-section">
        <h2 class="section-title">
            <i class="fas fa-leaf"></i> Our Products
        </h2>
        <div class="product-slider">
            <div class="slider-wrapper">
                <!-- Product Item 1 -->
                <div class="product-card">
                    <img src="path_to_image" alt="Product Image" class="product-image">
                    <div class="product-details">
                        <div class="product-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-value">(4.5)</span>
                        </div>
                        <h3 class="product-name">Facewash Gel - Grape Glow gel for Digital Defense</h3>
                        <p class="product-description">57% BRIGHTER SKIN IN 2 WEEKS</p>
                        <p class="product-price">₹1300.00</p>
                        <button class="add-to-cart">Add to cart <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- Repeat similar product-card divs for other products -->

            </div>
        </div>

        <!-- Slider controls -->
        <div class="slider-controls">
            <button class="slider-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
            <button class="slider-btn next-btn"><i class="fas fa-chevron-right"></i></button>
        </div>
    </section>

    <script>
      let currentIndex = 0;

const sliderWrapper = document.querySelector('.slider-wrapper');
const productCards = document.querySelectorAll('.product-card');

const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');

const totalItems = productCards.length;
const itemsPerView = 3; // Adjust this based on your design

prevBtn.addEventListener('click', () => {
    if (currentIndex > 0) {
        currentIndex--;
    } else {
        currentIndex = totalItems - itemsPerView;
    }
    updateSliderPosition();
});

nextBtn.addEventListener('click', () => {
    if (currentIndex < totalItems - itemsPerView) {
        currentIndex++;
    } else {
        currentIndex = 0;
    }
    updateSliderPosition();
});

function updateSliderPosition() {
    const cardWidth = productCards[0].clientWidth;
    sliderWrapper.style.transform = `translateX(-${currentIndex * (cardWidth + 20)}px)`; // 20px is the margin
}

    </script>
</body>
</html>
