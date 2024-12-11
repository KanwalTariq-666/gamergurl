<?php
require 'config.php';

session_start();

// Fetch resource details

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid resource ID.");
}

$resource_id = intval($_GET['id']);
$stmt = $pdo->prepare('SELECT * FROM resources WHERE id = :id');
$stmt->execute([':id' => $resource_id]);
$resource = $stmt->fetch();

if (!$resource) {
    die("Resource not found.");
}

// Fetch comments
$comments_stmt = $pdo->prepare('SELECT * FROM comments WHERE resource_id = :id ORDER BY created_at DESC');
$comments_stmt->execute([':id' => $resource_id]);
$comments = $comments_stmt->fetchAll();

// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_action'])) {
    if ($_POST['comment_action'] === 'add_comment') {
        $name = $_POST['name'];
        $comment = $_POST['comment'];

        if ($name && $comment) {
            $stmt = $pdo->prepare('INSERT INTO comments (resource_id, name, comment) VALUES (:resource_id, :name, :comment)');
            $stmt->execute([
                ':resource_id' => $resource_id,
                ':name' => $name,
                ':comment' => $comment
            ]);
            header("Location: resource_detail.php?id=$resource_id");
            exit;
        }
    }
}

// Handle kudos action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kudos_action'])) {
    if ($_POST['kudos_action'] === 'add_kudos') {
        $stmt = $pdo->prepare('UPDATE resources SET kudos = kudos + 1 WHERE id = :id');
        $stmt->execute([':id' => $resource_id]);

        // Return the updated kudos count for AJAX
        $stmt = $pdo->prepare('SELECT kudos FROM resources WHERE id = :id');
        $stmt->execute([':id' => $resource_id]);
        $updatedResource = $stmt->fetch();
        echo $updatedResource['kudos'];
        exit;
    }
}
?>

<?php include 'header.php'; ?>

<main>

    
    <div class="banner-container">
        <img class="banner" src="images/resources.jpeg" alt="Banner">
        <div class="banner-text">Our Resource Library</div>
    </div>


    <section>
        <h1><?= htmlspecialchars($resource['title']); ?></h1>
        <p><strong>Type:</strong> <?= htmlspecialchars($resource['type']); ?></p>
        <p><strong>Content:</strong> <?= htmlspecialchars($resource['content']); ?></p>
        

        <!-- Kudos Button -->
        <button class="kudos-btn" data-resource-id=" <?= $resource['id']; ?>">
            <i class="fas fa-thumbs-up"></i> Kudos:   <span class="kudos-count"><?= $resource['kudos']; ?></span>
        </button>

        <a href="resources.php">
            
            <button>Back to Resources</button>


        </a>
    
    </section>

    <section>
        <h3>Comments</h3>
        <?php if ($comments): ?>
            <ul>
                <?php foreach ($comments as $comment): ?>
                    <li>
                        <strong><?= htmlspecialchars($comment['name']) ?></strong>:
                        <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                        <br><small><?= htmlspecialchars($comment['created_at']) ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No comments yet. Be the first to comment!</p>
        <?php endif; ?>

        <form action="resource_detail.php?id=<?= $resource_id ?>" method="POST" id="commentForm">
            <input type="hidden" name="comment_action" value="add_comment">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Your Name" required>
            
            <label for="comment">Comment:</label>
            <textarea id="comment" name="comment" placeholder="Your Comment" required></textarea>

            <button type="submit">Submit Comment</button>
        </form>
    </section>
</main>


<?php include 'footer.php'; ?>