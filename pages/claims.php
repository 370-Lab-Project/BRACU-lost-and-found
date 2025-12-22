<?php
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : 0;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $notes = $conn->real_escape_string($_POST['notes']);
    $user_id = $_SESSION['user_id'];
    
    
    $check = $conn->query("SELECT * FROM bid WHERE post_id = $post_id AND user_id = $user_id");
    
    if($check->num_rows > 0){
        $error = "You have already claimed this item!";
    } else {
        $sql = "INSERT INTO bid (post_id, user_id, notes) VALUES ($post_id, $user_id, '$notes')";
        
        if($conn->query($sql)){
            $success = "Claim submitted! Waiting for owner's approval.";
        } else {
            $error = "Failed to submit claim!";
        }
    }
}

$post = $conn->query("SELECT * FROM post WHERE post_id = $post_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Claim Item - BRACU Lost & Found</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container">
        <div class="form-container">
            <h2>Claim Item: <?php echo $post['title']; ?></h2>
            <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
            <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
            
            <form method="POST">
                <textarea name="notes" placeholder="Why do you think this is your item? Provide details..." rows="6" required></textarea>
                <button type="submit" class="btn btn-primary">Submit Claim</button>
            </form>
        </div>
    </div>
</body>
</html>
