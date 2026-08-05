<?php require_once 'includes/header.php'; ?>

<div class="card">
    <h1>Welcome to EventSys</h1>
    <p>Discover, book, and manage your event tickets seamlessly.</p>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="register.php" class="btn">Get Started</a>
    <?php else: ?>
        <a href="dashboard.php" class="btn">Go to Dashboard</a>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>