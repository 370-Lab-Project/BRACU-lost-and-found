<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email' AND is_banned = FALSE");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            if ($user['banned'] == 1) {
                die("You are banned by admin.");
            }
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../index.php");
        } else {
            $error = "Invalid credentials!";
        }
    } else {
        $error = "User not found or banned!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login - BRACU Lost & Found</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="container">
        <div class="form-container">
            <h2>Login</h2>
            <?php if (isset($error))
                echo "<p class='error'>$error</p>"; ?>

            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>

</html>