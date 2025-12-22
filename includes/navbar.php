<?php if(!isset($_SESSION)) session_start(); ?>
<nav class="navbar">
    <div class="nav-container">
        <a href="<?php echo strpos($_SERVER['PHP_SELF'], 'pages') ? '../' : './'; ?>index.php" class="logo"> <img class = "navlogo" src="assets\bracu_logo_12-0-2022.png" alt=""> BRACU Lost & Found</a>
        <ul class="nav-menu">
            <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'pages') ? '../' : './'; ?>index.php">Home</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'pages') ? '' : 'pages/'; ?>post-item.php">Post Item</a></li>
                <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'pages') ? '' : 'pages/'; ?>view-posts.php">Browse</a></li>
                <li><span>Welcome, <?php echo $_SESSION['name']; ?>!</span></li>
                <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'pages') ? '../' : './'; ?>logout.php" class="btn-logout">Logout</a></li>
            <?php else: ?>
                <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'pages') ? '' : 'pages/'; ?>login.php">Login</a></li>
                <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'pages') ? '' : 'pages/'; ?>register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
