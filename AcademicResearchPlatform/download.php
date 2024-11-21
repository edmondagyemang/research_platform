<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['file_id'])) {
    $file_id = $_GET['file_id'];

    $stmt = $pdo->prepare("SELECT filename FROM shared_documents WHERE doc_id = ?");
    $stmt->execute([$file_id]);
    $file = $stmt->fetch();

    if ($file) {
        $filePath = "uploads/" . $file['filename'];

        if (file_exists($filePath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filePath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        }
    }
}
?>
