<?php
include '../config/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = $conn->real_escape_string($_POST['phone']);
    $department = $conn->real_escape_string($_POST['department']);
    $user_type = $conn->real_escape_string($_POST['user_type']);

    $check = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if($check->num_rows > 0){
        $error = "Email already registered!";
    } else {
        $sql = "INSERT INTO users (name, email, password, phone, department, user_type) 
                VALUES ('$name', '$email', '$password', '$phone', '$department', '$user_type')";
        
        if($conn->query($sql)){
            $success = "Registration successful! Please login.";
        } else {
            $error = "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - BRACU Lost & Found</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container">
        <div class="form-container">
            <h2>Register</h2>
            <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
            <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
            
            <form method="POST">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="tel" name="phone" placeholder="Phone Number">
                <input type="text" name="department" placeholder="Department">
                <select name="user_type" required>
                    <option value="Student">Student</option>
                    <option value="Staff">Staff</option>
                </select>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
