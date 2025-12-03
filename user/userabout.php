<?php
// Get current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>SkyBoom About Us</title>
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link rel="stylesheet" href="./css/userabout.css">
</head>

<body>


    <header class="top-header">
        <div class="site-title">🔥 SkyBoom Cracker Shop</div>

        <div class="top-header-right">
            <!-- Navigation Buttons -->
            <nav class="main-nav">
                <a href="userproduct.php" class="nav-btn <?= $current_page == 'userproduct.php' ? 'active' : '' ?>">Products</a>
                <a href="usertips.php" class="nav-btn <?= $current_page == 'usertips.php' ? 'active' : '' ?>">Safety Tips</a>
                <a href="uservieworder.php" class="nav-btn <?= $current_page == 'uservieworder.php' ? 'active' : '' ?>">My Orders</a>
                <a href="userabout.php" class="nav-btn <?= $current_page == 'userabout.php' ? 'active' : '' ?>">About Us</a>
            </nav>
        </div>
    </header>

    <div class="about-container">
        <div class="about-section">
            <h2>Welcome to SkyBoom Cracker Shop</h2>
            <p>At SkyBoom, we bring joy and sparkle to every celebration! Shop quality crackers for all occasions including Diwali, New Year, Christmas, and birthday parties. Our crackers are safe, colorful, and fun for everyone!</p>
        </div>

        <div class="about-section">
            <h2>Our Popular Crackers</h2>
            <div class="cracker-list">
                <div class="cracker-item">
                    <img src="../images/rocket.jfif" alt="Rocket">
                    <h4>Rocket</h4>
                    <p>High-flying and sparkling fun.</p>
                </div>
                <div class="cracker-item">
                    <img src="../images/chakkar.jfif" alt="Chakra">
                    <h4>Chakra</h4>
                    <p>Spinning firecracker for excitement.</p>
                </div>
                <div class="cracker-item">
                    <img src="../images/flowerpot.jfif" alt="Flower Pot">
                    <h4>Flower Pot</h4>
                    <p>Safe sparkling fountain for all ages.</p>
                </div>
                <div class="cracker-item">
                    <img src="../images/anar.jfif" alt="Anar">
                    <h4>Anar</h4>
                    <p>Small fountain with vibrant sparks.</p>
                </div>
            </div>
        </div>

        <div class="about-section">
            <h2>Shop Details</h2>
            <p>Our shop is located at <strong>123 R.R.Nagar, Sivakasi, Tamil Nadu</strong>. Owner: <strong>Sundar</strong>. Call us at <strong>+91 9876543210</strong> for inquiries or bulk orders.</p>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-about">
                <h3>🔥 SkyBoom Cracker Shop</h3>
                <p>Bringing joy and sparkle to every celebration! Shop quality crackers for all occasions.</p>
            </div>

            <div class="footer-contact">
                <h3>Contact Us</h3>
                <p><strong>Owner:</strong> Sudar</p>
                <p><strong>Address:</strong> 123 R.R.Nagar,Sivakasi,Tamil Nadu</p>
                <p><strong>Phone:</strong> +91 9876543210</p>
            </div>
        </div>
    </footer>

    <div class="footer-bottom">
        © 2025 SkyBoom Cracker Shop. All rights reserved.
    </div>

</body>

</html>