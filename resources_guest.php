<?php
// Database connection
require 'config.php';




// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'insert') {
        $stmt = $pdo->prepare('INSERT INTO resources (title, type, content) VALUES (:title, :type, :content)');
        $stmt->execute([
            ':title' => $_POST['title'],
            ':type' => $_POST['type'],
            ':content' => $_POST['content']
        ]);
    } elseif ($action === 'update') {
        $stmt = $pdo->prepare('UPDATE resources SET title = :title, type = :type, content = :content WHERE id = :id');
        $stmt->execute([
            ':id' => $_POST['id'],
            ':title' => $_POST['title'],
            ':type' => $_POST['type'],
            ':content' => $_POST['content']
        ]);
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM resources WHERE id = :id');
        $stmt->execute([':id' => $_POST['id']]);
    }
}


// Handle kudos (like) submission
if (isset($_POST['kudos_action']) && isset($_POST['resource_id'])) {
    $resource_id = $_POST['resource_id'];
    $stmt = $pdo->prepare('UPDATE resources SET kudos = kudos + 1 WHERE id = :id');
    $stmt->execute([':id' => $resource_id]);
}



// Fetch resources
$stmt = $pdo->query('SELECT * FROM resources ORDER BY id ASC');
$resources = $stmt->fetchAll();
?>

<?php include 'header.php'; ?>

<main>


    <div class="banner-container">
        <img class="banner" src="images/resources.jpeg" alt="Banner">
        <div class="banner-text">Our Resource Library</div>
    </div>




    <section>
        
        <h2>Add Resources and Aid the Community!</h2>

        <p>What are you waiting for? Login now and add your own resources! </p>
            
        <p>Enjoy with your fellow Gamer Gurls!</p>

        <span>

            <a href="login.php">
                <button>Login</button>
            </a>

        </span>

        <p> Not a member yet? </p>

        <span>

            <a href="signup.php">
                <button>Sign Up</button>
            </a>

        </span>

    </section>

    <section>

        <table id="resourceTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Content</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resources as $resource): ?>
                    <tr>
                        <td><?= htmlspecialchars($resource['id']) ?></td>
                        <td><?= htmlspecialchars($resource['title']) ?></td>
                        <td><?= htmlspecialchars($resource['type']) ?></td>
                        <td><?= htmlspecialchars($resource['content']) ?></td>
                        <td><?= htmlspecialchars($resource['username']) ?></td> 
                        <td>
                            <!-- View details link -->
                            <a href="resource_detail.php?id=<?= $resource['id'] ?>" class="view-details-btn">
                                <i class="fas fa-eye"></i> View Details
                            </a>


                            <!-- Kudos button -->
                            <form action="resources.php" method="POST" style="display:inline;">
                                <input type="hidden" name="resource_id" value="<?= htmlspecialchars($resource['id']) ?>">
                                <button class="kudos-btn" data-resource-id=" <?= $resource['id']; ?>">
                                <i class="fas fa-thumbs-up"></i> Kudos:   <span class="kudos-count"> <?= $resource['kudos']; ?></span>
                                </button>
                            </form>

                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>    
    </section>
</main>

<?php include 'footer.php'; ?>