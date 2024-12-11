<?php

require 'config.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);


    $response = [
        'success' => false,
        'message' => ''
    ];

  
    if (!empty($name) && !empty($email) && !empty($message)) {
        try {
            // Execute!
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)");
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':message' => $message
            ]);

            // 
            $response = [
                'success' => true,
                'message' => 'Your message has been sent successfully!'
            ];

        } catch (PDOException $e) {
            // 
            $response = [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    } else {
        // Error when empty
        $response = [
            'success' => false,
            'message' => 'Please fill in all fields'
        ];
    }

    // JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

include 'header.php';

?>

<main>
        <div class="banner-container">
            <img class="banner" src="images/contact.jpeg" alt="Banner">
            <div class="banner-text">Contact Us!</div>
        </div>

    <section>
        <h2>Contact Us</h2>

        <p>If you have any questions or would like to get in touch, feel free to contact us using the form below.</p>

        <form id="contactForm" method="POST">
            <h2>Contact Us</h2>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit">Send Message</button>

             <!-- Success message -->
            <div id="successMessage" style="display:none; color: green;">
                Your message has been sent successfully!
            </div>

            <!-- Error message -->
            <div id="errorMessage" style="display:none; color: red;">
                There was an error sending your message. Please try again.
            </div>




        </form>

       

    </section>
</main>

<?php include 'footer.php'; ?>