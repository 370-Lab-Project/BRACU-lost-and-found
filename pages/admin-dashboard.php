<?php
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<h2>Access Denied!</h2>";
    exit;
}

// Fetch all users
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");

// Fetch all posts
$posts = $conn->query("SELECT p.*, u.name FROM post p JOIN users u ON p.user_id = u.user_id ORDER BY date_posted DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/navbar.php'; ?>

<div class="container">
    <h2>Admin Dashboard</h2>

    <h3>Users</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Type</th><th>Banned?</th><th>Action</th>
        </tr>
        <?php while($user = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $user['user_id']; ?></td>
                <td><?= $user['name']; ?></td>
                <td><?= $user['email']; ?></td>
                <td><?= $user['user_type']; ?></td>
                <td><?= $user['is_banned'] ? 'Yes' : 'No'; ?></td>
                <td>
                    <?php if($user['is_banned']): ?>
                        <a href="unban-user.php?id=<?= $user['user_id']; ?>" class="btn-small">Unban</a>
                    <?php else: ?>
                        <a href="ban-user.php?id=<?= $user['user_id']; ?>" class="btn-small">Ban</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h3>Posts</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th><th>Title</th><th>Type</th><th>Status</th><th>Author</th><th>Action</th>
        </tr>
        <?php while($post = $posts->fetch_assoc()): ?>
            <tr>
                <td><?= $post['post_id']; ?></td>
                <td><?= $post['title']; ?></td>
                <td><?= $post['post_type']; ?></td>
                <td><?= $post['status']; ?></td>
                <td><?= $post['name']; ?></td>
                <td>
                    <a href="delete-post.php?id=<?= $post['post_id']; ?>" class="btn-small" onclick="return confirm('Are you sure to delete?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
