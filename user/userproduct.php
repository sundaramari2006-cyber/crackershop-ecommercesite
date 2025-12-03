<?php
session_start();
include "db.php"; // your DB connection (must set $conn)

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Clear the cart every time the page is loaded
$clear_cart = mysqli_query($conn, "DELETE FROM cart");
if ($clear_cart === false) {
    die("Failed to clear cart: " . mysqli_error($conn));
}

// Get discount %
$discount_q = mysqli_query($conn, "SELECT * FROM discount LIMIT 1");
if (!$discount_q) {
    die("Discount query failed: " . mysqli_error($conn));
}
$discount_row = mysqli_fetch_assoc($discount_q);
$discount_percent = ($discount_row && isset($discount_row['discount_range'])) ? floatval($discount_row['discount_range']) : 0.0;

// Fetch products grouped by category
$prod_q = mysqli_query($conn, "SELECT * FROM product WHERE stock_status='Available' ORDER BY category, product_id ASC");
if (!$prod_q) {
    die("Product query failed: " . mysqli_error($conn));
}

$products = [];
while ($p = mysqli_fetch_assoc($prod_q)) {
    // Group products by category
    $products[$p['category']][] = $p;
}

// Get current page for navigation highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>SkyBoom — Shop</title>
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link rel="stylesheet" href="./css/userpro.css">
    <link rel="stylesheet" href="./css/cart.css">
</head>

<body>

    <!-- TOP HEADER -->
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



    <!-- BOTTOM HEADER / NAV -->
    <nav class="bottom-header">
        <div class="view-toggle-group">
            <button id="viewGrid" class="view-toggle active">Grid</button>
            <button id="viewList" class="view-toggle">List</button>
        </div>

        <div class="order-summary">
            <input type="text" id="searchInput" placeholder="Search product or category..." class="search-bar">
            <span>Items: <b id="cart-count">0</b></span>
            <span>Saved: ₹<b id="cart-saved">0.00</b></span>
            <span>Total: ₹<b id="cart-total">0.00</b></span>
            <!-- Cart Button -->
            <a href="#" id="openCartBtn" class="cart-btn">View Cart</a>
        </div>

    </nav>

    <!-- Top moving image/banner -->
    <div class="top-banner">
        <div class="banner-track">
            <img src="../images/banner1.jfif" alt="Banner" class="banner-img">
            <img src="../images/banner2.jfif" alt="Banner" class="banner-img">
            <img src="../images/banner3.jfif" alt="Banner" class="banner-img">
            <img src="../images/banner4.jfif" alt="Banner" class="banner-img">
            <img src="../images/banner5.jfif" alt="Banner" class="banner-img">
            <img src="../images/banner1.jfif" alt="Banner" class="banner-img">
            <img src="../images/banner2.jfif" alt="Banner" class="banner-img">
            <img src="../images/banner3.jfif" alt="Banner" class="banner-img">
            <img src="../images/banner4.jfif" alt="Banner" class="banner-img">
            <img src="../images/banner5.jfif" alt="Banner" class="banner-img">
        </div>
    </div>

    <main class="shop-main">
        <?php if (empty($products)) { ?>
            <p class="no-products">No products available.</p>
        <?php } else { ?>
            <?php foreach ($products as $category => $items) { ?>
                <section class="category-block">
                    <h3 class="category-title"><?= htmlspecialchars($category) ?>
                        <?php if ($discount_percent > 0) { ?>
                            <small>(Discount <?= htmlspecialchars($discount_percent) ?>%)</small>
                        <?php } ?>
                    </h3>

                    <div class="product-grid" data-category="<?= htmlspecialchars($category) ?>">
                        <?php foreach ($items as $p) {
                            $orig = floatval($p['cost']);
                            $discounted = $orig;
                            if ($discount_percent > 0) {
                                $discounted = round($orig * (1 - $discount_percent / 100), 2);
                            }
                            $img = $p['product_image_path'] ? $p['product_image_path'] : 'placeholder.png';
                        ?>
                            <article class="product-card" data-product-id="<?= intval($p['product_id']) ?>"
                                data-price="<?= $orig ?>"
                                data-discounted="<?= $discounted ?>">
                                <div class="product-image">
                                    <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p['product_name']) ?>" onclick="openImage(this.src)">
                                </div>

                                <div class="product-info">
                                    <h4 class="pname"><?= htmlspecialchars($p['product_name']) ?></h4>
                                    <p class="pcs-details"><?= htmlspecialchars($p['pcs_details']) ?></p>
                                    <div class="price-row">
                                        <span class="orig">₹<?= number_format($orig, 2) ?></span>
                                        <?php if ($discount_percent > 0) { ?>
                                            <span class="disc">₹<?= number_format($discounted, 2) ?></span>
                                        <?php } ?>
                                    </div>

                                    <div class="qty-row">
                                        <label>Qty</label>
                                        <input type="number" class="qty-input" min="0" value="0">
                                    </div>

                                    <div class="subtotal">
                                        Subtotal: ₹<span class="subtotal-value">0.00</span>
                                    </div>
                                </div>
                            </article>
                        <?php } ?>
                    </div>
                </section>
            <?php } ?>
        <?php } ?>
    </main>

    <!-- image preview modal -->
    <div id="imgModal" class="img-modal" onclick="closeImage()">
        <img id="modalImg" src="" alt="Preview">
    </div>

    <!-- RIGHT SLIDE CART PANEL (Place at bottom of body; fixed positioning) -->
    <div id="cartPanel" class="cart-panel" aria-hidden="true">
        <div class="cart-header">
            <div class="cart-title">🛒 Your Cart</div>
            <button id="closeCartBtn" class="close-cart" aria-label="Close cart">×</button>
        </div>

        <div id="cartItems" class="cart-items">
            <!-- Filled by cart.php?action=list -->
        </div>


        <div class="cart-summary-panel">
            <div>Saved: ₹<span id="panel-saved">0.00</span></div>
            <div>Total: ₹<span id="panel-total">0.00</span></div>
            <a href="order1.php" class="place-order-btn">Place Order</a>
        </div>
    </div>

    <div id="cartOverlay" class="cart-overlay" aria-hidden="true"></div>

    <script>
        function openImage(src) {
            const modal = document.getElementById('imgModal');
            const modalImg = document.getElementById('modalImg');
            if (!modal || !modalImg) return;
            modalImg.src = src;
            modal.style.display = "flex";
            document.body.style.overflow = "hidden"; // prevent background scroll
        }

        function closeImage() {
            const modal = document.getElementById('imgModal');
            if (!modal) return;
            modal.style.display = "none";
            document.body.style.overflow = ""; // restore scroll
        }

        document.addEventListener("DOMContentLoaded", () => {

            /* ---------- Helper safe-selectors ---------- */
            const $ = (sel, root = document) => root.querySelector(sel);
            const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

            /* ---------- Utilities ---------- */
            function safeText(el, fallback = '') {
                if (!el) return fallback;
                return (el.textContent || el.innerText || '').trim();
            }

            /* ---------- Elements ---------- */
            const searchInput = document.getElementById('searchInput');
            const openBtn = document.getElementById('openCartBtn');
            const closeBtn = document.getElementById('closeCartBtn');
            const overlay = document.getElementById('cartOverlay');
            const cartPanel = document.getElementById('cartPanel');

            /* ---------- Safe image-overlay handlers (only if exist) ---------- */
            const imgOverlay = document.getElementById('cartImgOverlay');
            const overlayImg = document.getElementById('cartOverlayImg');

            if (imgOverlay && overlayImg) {
                // delegate click handler for any future .cart-item-img
                document.body.addEventListener('click', (e) => {
                    const clicked = e.target.closest && e.target.closest('.cart-item-img');
                    if (clicked) {
                        overlayImg.src = clicked.src || '';
                        imgOverlay.classList.add('show');
                    }
                });

                imgOverlay.addEventListener('click', () => {
                    imgOverlay.classList.remove('show');
                });
            }

            /* ---------- attach qty listeners ---------- */
            function attachQtyListeners() {
                $$('.qty-input').forEach(input => {
                    if (input._bound) return;
                    input._bound = true;
                    input.addEventListener('input', (ev) => {
                        const qty = Math.max(0, parseInt(ev.target.value) || 0);
                        const card = ev.target.closest('.product-card');
                        if (!card) return;
                        const productId = card.dataset.productId;
                        const discounted = parseFloat(card.dataset.discounted || card.dataset.price || 0) || 0;

                        const subtotalEl = card.querySelector('.subtotal-value');
                        if (subtotalEl) subtotalEl.innerText = (qty * discounted).toFixed(2);

                        // send to server (best-effort)
                        fetch('cart.php?action=add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                quantity: qty
                            })
                        }).then(r => r.json()).then(resp => {
                            if (!resp.success && resp.success !== undefined) {
                                alert('Error: ' + (resp.message || 'Unable to update cart'));
                            }
                            updateSummary();
                        }).catch(e => console.error('add err', e));
                    });
                });
            }

            /* ---------- Cart helpers ---------- */
            function updateSummary() {
                fetch('cart.php?action=summary')
                    .then(r => r.json())
                    .then(data => {
                        document.getElementById('cart-count').innerText = (data.count || 0);
                        document.getElementById('cart-total').innerText = ((data.total || 0)).toFixed(2);
                        document.getElementById('cart-saved').innerText = ((data.saved || 0)).toFixed(2);
                        const panelTotal = document.getElementById('panel-total');
                        const panelSaved = document.getElementById('panel-saved');
                        if (panelTotal) panelTotal.innerText = ((data.total || 0)).toFixed(2);
                        if (panelSaved) panelSaved.innerText = ((data.saved || 0)).toFixed(2);
                    }).catch(e => console.error('summary err', e));
            }

            function loadCart() {
                fetch('cart.php?action=list')
                    .then(r => r.text())
                    .then(html => {
                        const el = document.getElementById('cartItems');
                        if (el) el.innerHTML = html;
                        updateSummary();
                        bindCartPanelEvents(); // bind events after new HTML
                    }).catch(console.error);
            }


            /* ---------- CART PANEL BUTTONS (Event Delegation) ---------- */
            function bindCartPanelEvents() {
                const cartItems = document.getElementById('cartItems');
                if (!cartItems) return;

                cartItems.addEventListener('click', (e) => {
                    const row = e.target.closest('.cart-row');
                    if (!row) return;
                    const pid = row.dataset.pid;

                    // PLUS
                    if (e.target.classList.contains('qty-plus')) {
                        const input = row.querySelector('.qty-input-panel');
                        let qty = parseInt(input.value) || 0;
                        qty++;
                        updateCart(pid, qty);
                    }

                    // MINUS
                    if (e.target.classList.contains('qty-minus')) {
                        const input = row.querySelector('.qty-input-panel');
                        let qty = parseInt(input.value) || 0;
                        qty = Math.max(0, qty - 1);
                        updateCart(pid, qty);
                    }

                    // REMOVE (no confirm popup)
                    if (e.target.classList.contains('remove-from-cart')) {
                        updateCart(pid, 0); // qty 0 = remove
                    }
                });

                // MANUAL INPUT CHANGE
                cartItems.addEventListener('input', (e) => {
                    const input = e.target.closest('.qty-input-panel');
                    if (!input) return;
                    const row = input.closest('.cart-row');
                    const pid = row.dataset.pid;
                    let qty = Math.max(0, parseInt(input.value) || 0);
                    updateCart(pid, qty);
                });
            }

            /* ---------- Update cart quantity or remove ---------- */
            function updateCart(pid, qty) {
                fetch('cart.php?action=add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: pid,
                            quantity: qty
                        })
                    })
                    .then(r => r.json())
                    .then(resp => {
                        loadCart(); // reload cart and update totals
                    })
                    .catch(console.error);
            }

            function openCart() {
                loadCart();
                if (cartPanel) {
                    cartPanel.classList.add('open');
                    cartPanel.setAttribute('aria-hidden', 'false');
                }
                if (overlay) {
                    overlay.classList.add('show');
                    overlay.setAttribute('aria-hidden', 'false');
                }
                document.body.style.overflow = 'hidden';
            }

            function closeCart() {
                if (cartPanel) {
                    cartPanel.classList.remove('open');
                    cartPanel.setAttribute('aria-hidden', 'true');
                }
                if (overlay) {
                    overlay.classList.remove('show');
                    overlay.setAttribute('aria-hidden', 'true');
                }
                document.body.style.overflow = '';
            }

            /* ---------- Bind cart open/close if buttons exist ---------- */
            if (openBtn) openBtn.addEventListener('click', (e) => {
                e.preventDefault();
                openCart();
            });
            if (closeBtn) closeBtn.addEventListener('click', () => closeCart());
            if (overlay) overlay.addEventListener('click', () => closeCart());
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeCart();
            });

            /* ---------- View toggles ---------- */
            const viewGrid = document.getElementById('viewGrid');
            const viewList = document.getElementById('viewList');
            if (viewGrid) viewGrid.addEventListener('click', () => {
                document.querySelectorAll('.product-grid').forEach(g => g.classList.remove('list'));
                viewGrid.classList.add('active');
                if (viewList) viewList.classList.remove('active');
            });
            if (viewList) viewList.addEventListener('click', () => {
                document.querySelectorAll('.product-grid').forEach(g => g.classList.add('list'));
                viewList.classList.add('active');
                if (viewGrid) viewGrid.classList.remove('active');
            });

            /* ---------- Attach qty listeners after DOM loaded ---------- */
            attachQtyListeners();
            /* ---------- CART BUTTON HANDLERS ---------- */
            function changeCartQty(pid, qty) {
                qty = Math.max(0, parseInt(qty) || 0);
                fetch('cart.php?action=add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: pid,
                            quantity: qty
                        })
                    }).then(r => r.json())
                    .then(resp => {
                        if (!resp.success) alert(resp.message || 'Could not update cart');
                        loadCart(); // reload cart panel
                    }).catch(e => console.error(e));
            }

            function removeFromCart(pid) {
                if (!confirm('Remove this item from cart?')) return;
                fetch('cart.php?action=remove', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: pid
                        })
                    }).then(r => r.json())
                    .then(resp => {
                        if (!resp.success) alert(resp.message || 'Could not remove item');
                        loadCart(); // reload cart panel
                    }).catch(e => console.error(e));
            }

            updateSummary();

            /* ---------- SEARCH (single solid implementation) ---------- */
            if (searchInput) {
                const runSearch = () => {
                    const query = (searchInput.value || '').toLowerCase().trim();
                    document.querySelectorAll('.category-block').forEach(categoryBlock => {
                        // category title's plain text (first child node) fallback to full textContent
                        const ct = categoryBlock.querySelector('.category-title');
                        let categoryName = '';
                        if (ct) {
                            // If small exists, remove its text
                            const small = ct.querySelector('small');
                            if (small) small.remove();
                            categoryName = (ct.childNodes[0] && ct.childNodes[0].textContent) ? ct.childNodes[0].textContent.trim().toLowerCase() : safeText(ct).toLowerCase();
                        }
                        let hasMatch = false;

                        categoryBlock.querySelectorAll('.product-card').forEach(card => {
                            const pname = safeText(card.querySelector('.pname')).toLowerCase();
                            const pcs = safeText(card.querySelector('.pcs-details')).toLowerCase();
                            const match = (!query) ||
                                pname.includes(query) ||
                                pcs.includes(query) ||
                                (categoryName && categoryName.includes(query));

                            card.style.display = match ? '' : 'none';
                            if (match) hasMatch = true;
                        });

                        categoryBlock.style.display = hasMatch ? '' : 'none';
                    });
                };

                // quick debounce so too many inputs don't flood DOM ops
                let searchTimer = null;
                searchInput.addEventListener('input', () => {
                    if (searchTimer) clearTimeout(searchTimer);
                    searchTimer = setTimeout(runSearch, 120);
                });
            } // end if searchInput

        }); // end DOMContentLoaded
    </script>

    <footer class="site-footer">
        <div class="footer-container">
            <!-- About / Intro -->
            <div class="footer-about">
                <h3>🔥 SkyBoom Cracker Shop</h3>
                <p>Bringing joy and sparkle to every celebration! Shop quality crackers for all occasions.</p>

            </div>

            <!-- Contact / Info -->
            <div class="footer-contact">
                <h3>Contact Us</h3>
                <p><strong>Owner:</strong> Sundar</p>
                <p><strong>Address:</strong> 123 R.R.Nagar, Sivakai, Tamil Nadu.</p>
                <p><strong>Phone:</strong> +91 9876543210</p>
            </div>
        </div>
    </footer>

    <!-- Footer copyright -->
    <div class="footer-bottom">
        © 2025 SkyBoom Cracker Shop. All rights reserved.
    </div>
</body>
</html>