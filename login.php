<?php
session_start();
require 'config.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Fetch user data
    $stmt = $pdo->prepare('SELECT id, username, password, role FROM users WHERE username = :username');
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    // Validate credentials
    if ($user && $password === $user['password']) { // Assuming passwords are not hashed. Otherwise, use `password_verify()`.
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'admin' || $user['role'] === 'member') {
            header('Location: resources.php');
        } else {
            header('Location: resources_guest.php');
        }
        exit;
    } else {
        echo "Oops! Wrong username or password.";
    }
}


// include 'header.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GamerGurl</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png" width="72">
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

        <form action="login.php" id="contactForm" method="POST">
            <h1>Login</h1>
            <label for="username">Username</label>
            <input type="username" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>


        </form>

        <p> Don't have an account? </p>
        
        
        <a href="signup.php">
            
            <button>Sign Up</button>
        
        </a>


        <p>Or just continue as: <a href="resources_guest.php"></p>
            
        
        
        <button>Guest</button></a>  

    </section>


</main>

<?php include 'footer.php' ?>

</body>

</html>
