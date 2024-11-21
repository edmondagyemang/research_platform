<?php
include 'includes/header.php';
include 'includes/db.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch projects associated with the logged-in user
$stmt = $pdo->prepare("SELECT project_id, title FROM projects WHERE owner_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$projects = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_id = $_POST['project_id']; // Get the selected project ID from the dropdown
    $file = $_FILES['file'];

    // Ensure the uploads directory exists
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Validate the file and move it to the uploads directory
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = time() . '_' . basename($file['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Save file metadata in the database
            $stmt = $pdo->prepare("INSERT INTO shared_documents (project_id, filename, uploaded_by) VALUES (?, ?, ?)");
            $stmt->execute([$project_id, $fileName, $_SESSION['user_id']]);

            echo "<p style='color: green; text-align: center;'>File uploaded successfully!</p>";
        } else {
            echo "<p style='color: red; text-align: center;'>Error: Failed to move file to uploads directory.</p>";
        }
    } else {
        echo "<p style='color: red; text-align: center;'>Error: " . $file['error'] . "</p>";
    }
}
?>

<h2 style="text-align: center; margin-top: 20px;">Upload Document</h2>
<form method="POST" enctype="multipart/form-data" style="max-width: 500px; margin: auto; font-size: 1.2em;">
    <div style="margin-bottom: 20px;">
        <label for="project_id" style="display: block;">Select Project:</label>
        <select name="project_id" id="project_id" required style="width: 100%; padding: 10px; font-size: 1.2em; border: 1px solid #ccc; border-radius: 5px;">
            <?php foreach ($projects as $project): ?>
                <option value="<?= $project['project_id']; ?>"><?= htmlspecialchars($project['title']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div style="margin-bottom: 20px;">
        <label for="file" style="display: block;">Choose File:</label>
        <input type="file" name="file" id="file" required style="width: 100%; padding: 10px; font-size: 1.2em; border: 1px solid #ccc; border-radius: 5px;">
    </div>
    <button type="submit" style="width: 100%; padding: 10px; font-size: 1.2em; background-color: #007BFF; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Upload</button>
</form>

<?php include 'includes/footer.php'; ?>
