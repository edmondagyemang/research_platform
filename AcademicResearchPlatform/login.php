<?php
include 'includes/header.php';
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid credentials. Please try again.";
    }
}
?>

<div style="text-align: center; margin-top: 20px;">
    <img src="images/logo.png" alt="Platform Logo" style="width: 150px; margin-bottom: 20px;">
</div>

<h2 style="text-align: center; font-size: 1.8em; color: #007BFF;">Login</h2>
<?php if (!empty($error)) echo "<p style='color: red; text-align: center;'>$error</p>"; ?>
<form method="POST" action="login.php" style="max-width: 400px; margin: auto; font-size: 1.2em;">
    <div style="margin-bottom: 15px;">
        <label for="username" style="display: block;">Username:</label>
        <input type="text" name="username" id="username" placeholder="Enter your username" required style="width: 100%; padding: 10px; font-size: 1em;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="password" style="display: block;">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required style="width: 100%; padding: 10px; font-size: 1em;">
    </div>
    <button type="submit" style="width: 100%; padding: 10px; font-size: 1.2em; background-color: #007BFF; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Login</button>
</form>

<div style="text-align: center; margin-top: 20px;">
    <p>Don't have an account? <a href="register.php" style="color: #007BFF;">Register here</a>.</p>
</div>
<?php include 'includes/footer.php'; ?>
