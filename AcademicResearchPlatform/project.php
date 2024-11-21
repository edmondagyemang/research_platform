<?php
include 'includes/header.php';
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $owner_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO projects (title, description, owner_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $description, $owner_id]);

    header('Location: dashboard.php');
    exit();
}
?>

<h2>Create New Project</h2>
<form method="POST" action="project.php">
    <input type="text" name="title" placeholder="Project Title" required>
    <textarea name="description" placeholder="Project Description"></textarea>
    <button type="submit">Create</button>
</form>
<?php include 'includes/footer.php'; ?>
