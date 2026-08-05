<?php
require_once 'includes/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email is already registered.';
        } else {
            // Hash the password securely
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $insertStmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            
            if ($insertStmt->execute([$name, $email, $hashedPassword])) {
                $success = 'Registration successful! You can now login.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<div class="card" style="max-width: 400px; margin: 0 auto;">
    <h2>Register</h2>
    
    <?php if ($error): ?>
        <p style="color: #f85149; font-weight: bold;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <p style="color: #2ea043; font-weight: bold;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <div style="margin-bottom: 15px; text-align: left;">
            <label for="name" style="display: block; margin-bottom: 5px;">Full Name</label>
            <input type="text" id="name" name="name" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9; box-sizing: border-box;" required>
        </div>
        <div style="margin-bottom: 15px; text-align: left;">
            <label for="email" style="display: block; margin-bottom: 5px;">Email Address</label>
            <input type="email" id="email" name="email" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9; box-sizing: border-box;" required>
        </div>
        <div style="margin-bottom: 20px; text-align: left;">
            <label for="password" style="display: block; margin-bottom: 5px;">Password</label>
            <input type="password" id="password" name="password" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9; box-sizing: border-box;" required>
        </div>
        <button type="submit" class="btn" style="width: 100%; box-sizing: border-box;">Create Account</button>
    </form>
    <p style="margin-top: 20px;">Already have an account? <a href="login.php" style="color: #58a6ff; text-decoration: none;">Login here</a></p>
</div>

<?php require_once 'includes/footer.php'; ?>