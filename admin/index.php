<?php
session_start();
include "db.php";

$msg = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM login WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        header("Location: admincategory.php");
        exit();
    } else {
        $msg = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>SkyBoom Admin Login</title>
    <link rel="icon" type="image/png" href="../images/icon.png">
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>

    <div class="login-box">
        <h2>SkyBoom Admin Login</h2>

        <?php if ($msg != "") {
            echo "<p class='error'>$msg</p>";
        } ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>

</body>

</html>