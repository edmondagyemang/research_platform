<?php
include 'includes/header.php';
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM projects WHERE owner_id = ?");
$stmt->execute([$user_id]);
$projects = $stmt->fetchAll();
?>

<h2>Your Projects</h2>
<link rel="stylesheet" href="css/style.css">

<a href="project.php" style="text-decoration: none; background-color: #007BFF; color: #fff; padding: 10px 20px; border-radius: 5px;">Create New Project</a>
<div style="display: flex; flex-wrap: wrap; justify-content: center; margin-top: 20px;">
    <?php foreach ($projects as $project): ?>
        <div class="card">
            <img src="images/project_icon.png" alt="Project Icon" style="width: 100%; border-radius: 8px;">
            <h3><?= htmlspecialchars($project['title']); ?></h3>
            <p><?= htmlspecialchars($project['description']); ?></p>
            <a href="project.php?project_id=<?= $project['project_id']; ?>" style="color: #007BFF;">View Project</a>
        </div>
    <?php endforeach; ?>
</div>
<?php include 'includes/footer.php'; ?>
