<?php
include 'config/db.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>BRACU Lost & Found</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="hero-section">
    <div class="hero-content">
        <img class = brac src="assets\bracu_logo_12-0-2022.png" alt="">
        <h1>BRACU Lost & Found</h1>
        <p>Report lost items or help return found ones</p>

        <div class="hero-buttons">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="pages/post-item.php" class="btn btn-primary">Post Item</a>
                <a href="pages/view-posts.php" class="btn btn-secondary">Browse Items</a>
            <?php else: ?>
                <a href="pages/login.php" class="btn btn-primary">Login</a>
                <a href="pages/register.php" class="btn btn-secondary">Register</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
