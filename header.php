<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="GamerGurl Team">
    <meta name="description" content="GamerGurl is an online platform for womxn gamers to connect, share experiences, and support one another.">
    <meta name="keywords" content="GamerGurl, women gamers, gaming platform, support, community">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#ff0088">

    <!-- Open Graph / Facebook -->

    <!-- Used by Facebook, LinkedIn, and other platforms to generate rich previews. -->

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.gamergurl.com/">
    <meta property="og:title" content="GamerGurl: Connect, Share, Support">
    <meta property="og:description" content="Join GamerGurl, an online platform for womxn gamers to connect, share experiences, and support each other.">
    <meta property="og:image" content="https://www.gamergurl.com/images/og-image.jpg">

    <!-- Twitter, I'm not calling it X -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://www.gamergurl.com/">
    <meta name="twitter:title" content="GamerGurl: Connect, Share, Support">
    <meta name="twitter:description" content="Join GamerGurl, an online platform for womxn gamers to connect, share experiences, and support each other.">
    <meta name="twitter:image" content="https://www.gamergurl.com/images/og-image.jpg">

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
        <h1><i class="fa-solid fa-gamepad"></i> Game With Likeminded Females! <i class="fa-solid fa-dragon"></i></h1>
        <div class="auth-buttons">
            <?php
            // session_start();
            if (isset($_SESSION['username'])): ?>
                <span class="welcome-msg">Hey-o, <?= htmlspecialchars($_SESSION['username']) ?>!</span>
                <a href="logout.php" class="btn logout-btn">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn login-btn">Login</a>
                <a href="signup.php" class="btn signup-btn">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- <nav>  -->
<nav style="margin-top:3.8rem"> 

<!-- As discussed in class, any action I make in the resources is causing the navigation to move upwards. For now to fix it, tried giving it a style directly in the HTML for visual purposes. -->
<!-- It's still weird with responsive -->
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="resources.php">Resources</a></li>
        <li><a href="contact.php">Contact Us</a></li>
    </ul>
</nav>

<script src="main.js"></script>







