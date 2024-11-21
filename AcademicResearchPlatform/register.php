<?php
include 'includes/header.php';
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);

    header('Location: login.php');
    exit();
}
?>

<div style="text-align: center; margin-top: 20px;">
    <img src="images/logo.png" alt="Platform Logo" style="width: 150px; margin-bottom: 20px;">
</div>

<h2 style="text-align: center; font-size: 1.8em; color: #28A745;">Register</h2>
<form method="POST" action="register.php" style="max-width: 400px; margin: auto; font-size: 1.2em;">
    <div style="margin-bottom: 15px;">
        <label for="username" style="display: block;">Username:</label>
        <input type="text" name="username" id="username" placeholder="Choose a username" required style="width: 100%; padding: 10px; font-size: 1em;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="email" style="display: block;">Email:</label>
        <input type="email" name="email" id="email" placeholder="Enter your email" required style="width: 100%; padding: 10px; font-size: 1em;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="password" style="display: block;">Password:</label>
        <input type="password" name="password" id="password" placeholder="Create a password" required style="width: 100%; padding: 10px; font-size: 1em;">
    </div>
    <button type="submit" style="width: 100%; padding: 10px; font-size: 1.2em; background-color: #28A745; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Register</button>
</form>

<div style="text-align: center; margin-top: 20px;">
    <p>Already have an account? <a href="login.php" style="color: #28A745;">Login here</a>.</p>
</div>
<?php include 'includes/footer.php'; ?>
