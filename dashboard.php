<?php
require_once 'includes/header.php';

// Protect the route: Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['user_role'] ?? 'customer';
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
    <p>This is your control panel. You are currently logged in with <strong><?php echo htmlspecialchars(ucfirst($role)); ?></strong> privileges.</p>
    
    <?php if ($role === 'admin'): ?>
        <div style="margin-top: 30px; text-align: left; background-color: #21262d; padding: 20px; border-radius: 6px; border: 1px solid #30363d;">
            <h3 style="margin-top: 0;">Admin Controls</h3>
            <p style="color: #8b949e;">Manage your platform's events and oversee all user reservations.</p>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="manage_events.php" class="btn" style="background-color: #1f6feb; border-color: #388bfd;">Manage Events</a>
                <a href="admin_bookings.php" class="btn" style="background-color: #238636; border-color: #2ea043;">View All Bookings</a>
            </div>
        </div>
    <?php else: ?>
        <div style="margin-top: 30px; text-align: left; background-color: #21262d; padding: 20px; border-radius: 6px; border: 1px solid #30363d;">
            <h3 style="margin-top: 0;">Your Bookings</h3>
            <p style="color: #8b949e;">View your ticket history and manage your upcoming event reservations.</p>
            <a href="my_bookings.php" class="btn" style="background-color: #1f6feb; border-color: #388bfd;">View My Bookings</a>
            <a href="events.php" class="btn">Browse New Events</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>