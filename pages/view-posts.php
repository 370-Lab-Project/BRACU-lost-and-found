<?php
include '../config/db.php';

$filter_type = isset($_GET['type']) ? $_GET['type'] : 'All';
$filter_category = isset($_GET['category']) ? $_GET['category'] : 'All';

$query = "SELECT p.*, u.name, c.category_name FROM post p 
          JOIN users u ON p.user_id = u.user_id 
          JOIN category c ON p.category_id = c.category_id 
          WHERE p.status = 'Active' AND p.is_deleted = FALSE";

if ($filter_type != 'All') {
    $query .= " AND p.post_type = '$filter_type'";
}

if ($filter_category != 'All') {
    $query .= " AND p.category_id = '$filter_category'";
}

$query .= " ORDER BY p.date_posted DESC";
$result = $conn->query($query);

$categories = $conn->query("SELECT * FROM category");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Browse Items - BRACU Lost & Found</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="container">
        <h2>Browse Items</h2>

        <div class="filters">
            <form method="GET">
                <select name="type">
                    <option value="All">All Types</option>
                    <option value="Lost" <?php echo $filter_type == 'Lost' ? 'selected' : ''; ?>>Lost</option>
                    <option value="Found" <?php echo $filter_type == 'Found' ? 'selected' : ''; ?>>Found</option>
                </select>

                <select name="category">
                    <option value="All">All Categories</option>
                    <?php while ($cat = $categories->fetch_assoc()): ?>
                        <option value="<?php echo $cat['category_id']; ?>" <?php echo $filter_category == $cat['category_id'] ? 'selected' : ''; ?>>
                            <?php echo $cat['category_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <button type="submit" class="btn btn-small">Filter</button>
            </form>
        </div>

        <div class="posts-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post-card">
                    <img src="../<?php echo $row['picture_url']; ?>" alt="Item">
                    <h3><?php echo $row['title']; ?></h3>
                    <p><strong>Type:</strong> <span
                            class="badge <?php echo strtolower($row['post_type']); ?>"><?php echo $row['post_type']; ?></span>
                    </p>
                    <p><strong>Category:</strong> <?php echo $row['category_name']; ?></p>
                    <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
                    <p><strong>Posted by:</strong> <?php echo $row['name']; ?></p>
                    <p><strong>Priority:</strong> <span
                            class="priority <?php echo strtolower($row['priority']); ?>"><?php echo $row['priority']; ?></span>
                    </p>
                    <p class="description"><?php echo substr($row['description'], 0, 100); ?>...</p>

                    <?php if (isset($_SESSION['user_id'])): ?>

                        <?php if ($_SESSION['user_id'] == $row['user_id']): ?>
                            <a href="edit-post.php?post_id=<?php echo $row['post_id']; ?>" class="btn btn-small">
                                Edit Post
                            </a>
                        <?php else: ?>
                            <a href="claims.php?post_id=<?php echo $row['post_id']; ?>" class="btn btn-small">
                                Claim Item
                            </a>
                        <?php endif; ?>

                    <?php else: ?>
                        <a href="login.php" class="btn btn-small">
                            Login to Claim
                        </a>
                    <?php endif; ?>

                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>