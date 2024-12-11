<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resource_id = $_POST['resource_id'];

    if (is_numeric($resource_id)) {
        // Increment kudos in the database
        $stmt = $pdo->prepare("UPDATE resources SET kudos = kudos + 1 WHERE id = :id");
        $stmt->execute([':id' => $resource_id]);

        // Fetch the updated kudos count
        $stmt = $pdo->prepare("SELECT kudos FROM resources WHERE id = :id");
        $stmt->execute([':id' => $resource_id]);
        $resource = $stmt->fetch();

        if ($resource) {
            echo json_encode([
                'success' => true,
                'kudosCount' => $resource['kudos']
            ]);
            exit;
        }
    }
}

// Error response
echo json_encode([
    'success' => false
]);