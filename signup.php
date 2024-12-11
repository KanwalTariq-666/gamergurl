<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = 'member'; // New joinees can't make admin, only members

    // To check if username exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username');
    $stmt->execute([':username' => $username]);

    if ($stmt->fetch()) {
        $error = "Uh-oh, this username already exists! Please choose another cool one.";
    } else {
        // Insert
        $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)');
        $stmt->execute([
            ':username' => $username,
            ':password' => $password, 
            ':role' => $role
        ]);

        // Set session and redirect to resources
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header('Location: resources.php');
        exit(); // Putting this to ensure no further code is executed after redirection
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GamerGurl</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>

<header>
    <div class="header-container">
        <a href="index.php" class="logo">
            <img src="images/logo.png" alt="GamerGurl Logo">
        </a>

        <h1> <i class="fa-solid fa-gamepad"></i>   Game With Likeminded Females!  <i class="fa-solid fa-dragon"></i> </h1>

    </div>

</header>

<main>
    <section>
        <form action="signup.php" id="contactForm" method="POST">
            <h1>Sign Up</h1>

            <?php if (!empty($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Sign Up</button>
        </form>

        <p>Already have an account?</p>
        <a href="login.php">
            <button>Log In</button>
        </a>

        <p>Or just continue as:</p>
        <a href="resources_guest.php">
            <button>Guest</button>
        </a>  
    </section> 
</main>

</body>
</html>