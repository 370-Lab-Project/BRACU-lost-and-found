<?php
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$post_id = $_GET['post_id'] ?? 0;
$user_id = $_SESSION['user_id'];

$postQuery = $conn->query("
    SELECT * FROM post 
    WHERE post_id = $post_id AND user_id = $user_id
");

if($postQuery->num_rows == 0){
    die("Unauthorized access");
}

$post = $postQuery->fetch_assoc();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $location = $conn->real_escape_string($_POST['location']);
    $category_id = $_POST['category_id'];
    $post_type = $_POST['post_type'];
    $priority = $_POST['priority'];

    $sql = "
        UPDATE post SET
        title='$title',
        description='$description',
        location='$location',
        category_id='$category_id',
        post_type='$post_type',
        priority='$priority'
        WHERE post_id=$post_id AND user_id=$user_id
    ";

    if($conn->query($sql)){
        $success = "Post updated successfully!";
    } else {
        $error = "Update failed.";
    }
}

$categories = $conn->query("SELECT * FROM category");
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include '../includes/navbar.php'; ?>

<div class="container">
    <div class="form-container">
        <h2>Edit Post</h2>

        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>

        <form method="POST">

            <input type="text" name="title"
                   value="<?php echo $post['title']; ?>" required>

            <textarea name="description" required>
<?php echo $post['description']; ?>
            </textarea>

            <input type="text" name="location"
                   value="<?php echo $post['location']; ?>" required>

            <select name="category_id" required>
                <?php while($cat = $categories->fetch_assoc()): ?>
                    <option value="<?php echo $cat['category_id']; ?>"
                        <?php if($cat['category_id'] == $post['category_id']) echo 'selected'; ?>>
                        <?php echo $cat['category_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <select name="post_type">
                <option value="Lost" <?php if($post['post_type']=='Lost') echo 'selected'; ?>>Lost</option>
                <option value="Found" <?php if($post['post_type']=='Found') echo 'selected'; ?>>Found</option>
            </select>

            <select name="priority">
                <option value="High" <?php if($post['priority']=='High') echo 'selected'; ?>>High</option>
                <option value="Medium" <?php if($post['priority']=='Medium') echo 'selected'; ?>>Medium</option>
                <option value="Low" <?php if($post['priority']=='Low') echo 'selected'; ?>>Low</option>
            </select>

            <button type="submit" class="btn btn-primary">
                Update Post
            </button>

        </form>
    </div>
</div>

</body>
</html>
