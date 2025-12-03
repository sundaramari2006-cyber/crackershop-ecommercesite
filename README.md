<!DOCTYPE html>
<html>
<body>

<h1>SkyBoom Cracker Shop</h1>
<p>
    SkyBoom Cracker Shop is a PHP + MySQL based web application for managing cracker products,
    categories, orders, cart, discounts, and admin login. This README explains how to set up
    the project, database, and run the application.
</p>

<hr>

<h2>📌 Project Features</h2>
<ul>
    <li>Product listing and category-based browsing</li>
    <li>Add to cart and checkout system</li>
    <li>Order management panel</li>
    <li>Discount system</li>
    <li>Admin login authentication</li>
    <li>Product image support</li>
</ul>

<hr>

<h2>📁 Database Name</h2>
<p><b>skyboomcrackershop</b></p>

<hr>

<h2>📦 Database Tables</h2>

<h3>1. cart</h3>
<p>Stores temporary shopping cart items.</p>
<ul>
    <li>order_id</li>
    <li>product_id</li>
    <li>product_name</li>
    <li>cost</li>
    <li>quantity</li>
    <li>total_cost</li>
    <li>product_image_path</li>
</ul>

<h3>2. category</h3>
<p>Stores category names for grouping products.</p>
<ul>
    <li>id</li>
    <li>category_name</li>
</ul>

<h3>3. discount</h3>
<p>Stores discount percentage for order calculation.</p>
<ul>
    <li>discount_range</li>
</ul>

<h3>4. login</h3>
<p>Admin login table.</p>
<ul>
    <li>admin_id</li>
    <li>username</li>
    <li>password</li>
</ul>

<h3>5. orderedpro</h3>
<p>Stores products inside each order.</p>
<ul>
    <li>orderedpro_id</li>
    <li>ordercus_id</li>
    <li>cost</li>
    <li>product_name</li>
    <li>total_cost</li>
    <li>quantity</li>
    <li>product_image_path</li>
</ul>

<h3>6. orders</h3>
<p>Master order table.</p>
<ul>
    <li>order_id</li>
    <li>customer_name</li>
    <li>contact_no</li>
    <li>address</li>
  <li>mail_id</li>
  <li>total</li>
  <li>packing_cost</li>
    <li>total_cost</li>
    <li>orderedpro_id</li>
  <li>order_date</li>
    <li>status</li>
</ul>

<h3>7. product</h3>
<p>Stores product information.</p>
<ul>
    <li>prodct_id</li>
    <li>product_name</li>
    <li>category</li>
    <li>cost</li
    <li>stock_status</li>
  <li>pcs_details</li>
    <li>product_image_path</li>
</ul>

<hr>

<h2>⚙️ How to Install</h2>
<ol>
    <li>Install XAMPP/WAMP.</li>
    <li>Place project folder inside <b>htdocs/</b>.</li>
    <li>Open phpMyAdmin at: <code>http://localhost/phpmyadmin</code></li>
    <li>Create a database: <b>skyboomcrackershop</b></li>
    <li>Import SQL file:
        <br><code>database/skyboomcrackershop.sql</code>
    </li>
    <li>Configure database in <code>db.php</code>:
        <pre>
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "skyboomcrackershop";
$conn = mysqli_connect($host, $user, $pass, $dbname);
        </pre>
    </li>
    <li>Run the website:
        <br><code>http://localhost/skyboomcrackershop/</code>
    </li>
</ol>

<hr>



<h2>Screen Shots</h2>
<ol>
    <li>admin_category</li>
  <img width="1366" height="768" alt="1 admin-category" src="https://github.com/user-attachments/assets/f37daae3-62ef-4242-8f6f-d10a49b114a0" />

    <li>admin_product 1</li>
    <img width="1366" height="768" alt="2 admin-product 1" src="https://github.com/user-attachments/assets/302dc855-f157-4dcf-8f42-d7df8c9baf19" />

    <li>admin_product 2</li>
    <img width="1366" height="768" alt="3 admin-product 2" src="https://github.com/user-attachments/assets/37b3681e-5137-4670-992d-be0d7971f182" />

    <li>admin_discount</li>
    <img width="1366" height="768" alt="4 admin-discount" src="https://github.com/user-attachments/assets/a7fbc0dc-248d-4f7d-a5f2-4cc7dddf1c6b" />

    <li>admin order 1</li>
    <img width="1366" height="768" alt="5 admin-orders" src="https://github.com/user-attachments/assets/b4ee5ceb-68ac-4eb4-b89b-acf15d82fb93" />

    <li>user product 1</li>
    <img width="1366" height="768" alt="6 user-product 1" src="https://github.com/user-attachments/assets/66d52310-1b99-4256-8f9d-7e286f4a5861" />

    <li>user product 2</li>
    <img width="1366" height="768" alt="7 user-product 2" src="https://github.com/user-attachments/assets/65c3cf4c-c75b-46a2-9974-1c5eb7cd8a42" />

    <li>user product 3</li>
    <img width="1366" height="768" alt="8 user-product 3" src="https://github.com/user-attachments/assets/a3b6f814-0467-4ac9-8fb2-36d751c484e6" />

  <li>user cart</li>
  <img width="1366" height="768" alt="9 user-cart" src="https://github.com/user-attachments/assets/f35f045d-ab06-4514-899a-f07fa9d0ce89" />

    <li>user place order 1</li>
    <img width="1366" height="768" alt="10 user-placeorder 1" src="https://github.com/user-attachments/assets/e787d8cf-b320-4931-916d-3445bb04a0a3" />

   <li>user place order 2</li>
   <img width="1366" height="768" alt="11 user-placeorder 2" src="https://github.com/user-attachments/assets/71d40c19-f277-4f95-af58-26af44587130" />

    <li>user safty tips</li>
    <img width="1366" height="768" alt="12 user-saftytips" src="https://github.com/user-attachments/assets/e33fc91a-f6d0-4dfd-817f-281a7c62245d" />

    <li>user my order 1</li>
    <img width="1366" height="768" alt="13 user-myorders 1" src="https://github.com/user-attachments/assets/2faf9f70-0e87-49bc-9cc6-67efb11d3249" />

    <li>user my order 2</li>
    <img width="1366" height="768" alt="14 user-myorders 2" src="https://github.com/user-attachments/assets/1fda4ce3-3819-4d11-b9cd-f5fa75512d56" />

    <li>user aboutus</li>
    <img width="1366" height="768" alt="15 user-aboutus" src="https://github.com/user-attachments/assets/a53fb838-f8de-4bfc-8208-8f2a7074a95c" />


</ol>

</body>
</html>
