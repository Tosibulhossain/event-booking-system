<?php
require_once 'includes/header.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Verify user exists and password matches
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>

<div class="card" style="max-width: 400px; margin: 0 auto;">
    <h2>Login</h2>
    
    <?php if ($error): ?>
        <p style="color: #f85149; font-weight: bold;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <div style="margin-bottom: 15px; text-align: left;">
            <label for="email" style="display: block; margin-bottom: 5px;">Email Address</label>
            <input type="email" id="email" name="email" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9; box-sizing: border-box;" required>
        </div>
        <div style="margin-bottom: 20px; text-align: left;">
            <label for="password" style="display: block; margin-bottom: 5px;">Password</label>
            <input type="password" id="password" name="password" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9; box-sizing: border-box;" required>
        </div>
        <button type="submit" class="btn" style="width: 100%; box-sizing: border-box;">Login</button>
    </form>
    <p style="margin-top: 20px;">Don't have an account? <a href="register.php" style="color: #58a6ff; text-decoration: none;">Register here</a></p>
</div>

<?php require_once 'includes/footer.php'; ?>