<?php
session_start();
?>
<?php
// Get current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SkyBoom — Safety Tips</title>
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link rel="stylesheet" href="./css/usertips.css">

</head>

<body>

    <!-- ======================== NAVBAR ======================== -->
    <!-- TOP HEADER -->


    <header class="top-header">
        <div class="site-title">🔥 SkyBoom Cracker Shop</div>

        <div class="top-header-right">
            <!-- Navigation Buttons -->
            <nav class="main-nav">
                <a href="userproduct.php" class="nav-btn <?= $current_page == 'userproduct1.php' ? 'active' : '' ?>">Products</a>
                <a href="usertips.php" class="nav-btn <?= $current_page == 'usertips.php' ? 'active' : '' ?>">Safety Tips</a>
                <a href="uservieworder.php" class="nav-btn <?= $current_page == 'uservieworder.php' ? 'active' : '' ?>">My Orders</a>
                <a href="userabout.php" class="nav-btn <?= $current_page == 'userabout.php' ? 'active' : '' ?>">About Us</a>
            </nav>
        </div>
    </header>



    <!-- ======================== PAGE TITLE ======================== -->
    <h1 class="page-title">🎇 Crackers Safety Tips</h1>

    <!-- ======================== SAFETY TIPS ======================== -->
    <div class="tips-container">
        <h2>✔ Important Safety Guidelines</h2>
        <ul>
            <li>Always buy crackers from licensed and reputed shops only.</li>
            <li>Read and follow the safety instructions printed on the crackers.</li>
            <li>Light fireworks in open spaces away from houses, vehicles, and trees.</li>
            <li>Keep small children under strict supervision while bursting crackers.</li>
            <li>Always keep a bucket of water or sand nearby for emergency.</li>
            <li>Use a long candle or agarbatti to ignite fireworks safely.</li>
            <li>Never light a cracker holding it in your hand.</li>
            <li>Do not try to relight a cracker that did not ignite.</li>
            <li>Wear cotton clothes; avoid synthetic materials.</li>
            <li>Dispose used fireworks properly and keep the surroundings clean.</li>
        </ul>
    </div>

    <!-- ======================== FOOTER ======================== -->
    <footer class="site-footer">
        <div class="footer-container">

            <div class="footer-about">
                <h3>🔥 SkyBoom Cracker Shop</h3>
                <p>Bringing joy and sparkle to every celebration! Shop quality crackers for all occasions.</p>

            </div>

            <div class="footer-contact">
                <h3>Contact Us</h3>
                <p><strong>Owner:</strong> Sundar</p>
                <p><strong>Address:</strong> 123 R.R.Nagar, Sivakasi, Tamil Nadu</p>
                <p><strong>Phone:</strong> +91 9876543210</p>
            </div>

        </div>
    </footer>

    <div class="footer-bottom">
        © 2025 SkyBoom Cracker Shop. All rights reserved.
    </div>

</body>

</html>