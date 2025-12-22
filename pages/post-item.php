<?php
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $location = $conn->real_escape_string($_POST['location']);
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $post_type = $conn->real_escape_string($_POST['post_type']);
    $priority = $conn->real_escape_string($_POST['priority']);
    $user_id = $_SESSION['user_id'];
    
    $picture_url = "default.jpg";
    if(isset($_FILES['picture']) && $_FILES['picture']['size'] > 0){
        $target_dir = "../uploads/";
        $filename = time() . "_" . basename($_FILES['picture']['name']);
        $target_file = $target_dir . $filename;
        
        if(move_uploaded_file($_FILES['picture']['tmp_name'], $target_file)){
            $picture_url = "uploads/" . $filename;
        }
    }
    
    $sql = "INSERT INTO post (user_id, category_id, title, description, location, post_type, priority, picture_url) 
            VALUES ($user_id, $category_id, '$title', '$description', '$location', '$post_type', '$priority', '$picture_url')";
    
    if($conn->query($sql)){
        $success = "Item posted successfully!";
    } else {
        $error = "Failed to post item!";
    }
}

$categories = $conn->query("SELECT * FROM category");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Item - BRACU Lost & Found</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container">
        <div class="form-container">
            <h2>Post an Item</h2>
            <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
            <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Item Title" required>
                <textarea name="description" placeholder="Description" rows="4" required></textarea>
                <input type="text" name="location" placeholder="Location where lost/found" required>
                
                <select name="category_id" required>
                    <option value="">Select Category</option>
                    <?php while($cat = $categories->fetch_assoc()): ?>
                        <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['category_name']; ?></option>
                    <?php endwhile; ?>
                </select>
                
                <select name="post_type" required>
                    <option value="">Select Type</option>
                    <option value="Lost">Lost Item</option>
                    <option value="Found">Found Item</option>
                </select>
                
                <select name="priority" required>
                    <option value="Medium">Medium Priority</option>
                    <option value="High">High Priority</option>
                    <option value="Low">Low Priority</option>
                </select>
                
                <input type="file" name="picture" accept="image/*">
                <button type="submit" class="btn btn-primary">Post Item</button>
            </form>
        </div>
    </div>
</body>
</html>
