
<?php
session_start();
require 'config.php'; 


if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}


$username = $_SESSION['username'];
$role = $_SESSION['role'];

//Insert, Update, and Delete

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    
    if ($action === 'insert') {
        
        // Insert
        
        $stmt = $pdo->prepare('INSERT INTO resources (title, type, content, username) VALUES (:title, :type, :content, :username)');
        $stmt->execute([
            ':title' => $_POST['title'],
            ':type' => $_POST['type'],
            ':content' => $_POST['content'],
            ':username' => $username,
        ]);
        echo "Resource added successfully.";
    } 
    // update
    elseif ($action === 'update') {
        $resourceId = $_POST['id'];

        // owner or admin can update
        $stmt = $pdo->prepare('SELECT username FROM resources WHERE id = :id');
        $stmt->execute([':id' => $resourceId]);
        $resource = $stmt->fetch();

        if ($resource && ($resource['username'] === $username || $role === 'admin')) {
            // Update resource
            $stmt = $pdo->prepare('UPDATE resources SET title = :title, type = :type, content = :content WHERE id = :id');
            $stmt->execute([
                ':id' => $resourceId,
                ':title' => $_POST['title'],
                ':type' => $_POST['type'],
                ':content' => $_POST['content'],
            ]);
            echo "Resource updated successfully.";
        } else {
            echo "Unauthorized action.";
        }
    } 
    // Handle delete action
    elseif ($action === 'delete') {
        $resourceId = $_POST['id'];

        //owner or admin can delete
        $stmt = $pdo->prepare('SELECT username FROM resources WHERE id = :id');
        $stmt->execute([':id' => $resourceId]);
        $resource = $stmt->fetch();

        if ($resource && ($resource['username'] === $username || $role === 'admin')) {
            // Delete
            $stmt = $pdo->prepare('DELETE FROM resources WHERE id = :id');
            $stmt->execute([':id' => $resourceId]);
            echo "Resource deleted successfully.";
        } else {
            echo "Unauthorized action.";
        }
    }
}


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
        <h2>Manage Resources</h2>

        <form id="resourceForm" action="resources.php" method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="hidden" name="id" value=""> 

            <label for="title">Title</label>
            <input type="text" id="title" name="title" placeholder="Enter resource title" required>

            <label for="type">Type</label>
            <select id="type" name="type" required>
                <option value="">Select Type</option>
                <option value="article">Article</option>
                <option value="video">Video</option>
                <option value="url">URL</option>
            </select>

            <label for="content">Content</label>
            <textarea id="content" name="content" placeholder="Enter resource content" required></textarea>

            <button type="submit">Add Resource</button>
        </form>
    </section>

    <section>
        <h2>Resources</h2>
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

                            <?php if ($resource['username'] === $username || $role === 'admin'): ?>
                                <!-- Edit button -->
                                <button class="edit-btn" onclick="populateForm(<?= htmlspecialchars(json_encode($resource)) ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <!-- Delete button -->
                                <form action="resources.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($resource['id']) ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button class="delete-btn" type="submit">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Kudos button -->
                            <form action="resources.php" method="POST" style="display:inline;">
                                <input type="hidden" name="resource_id" value="<?= htmlspecialchars($resource['id']) ?>">
                                <button class="kudos-btn" data-resource-id="<?= $resource['id']; ?>">
                                    <i class="fas fa-thumbs-up"></i> Kudos: <span class="kudos-count"><?= $resource['kudos']; ?></span>
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






