<?php
require_once 'includes/header.php';
?>

<div style="text-align: center; padding: 60px 20px;">
    <h1 style="font-size: 2.8em; color: #58a6ff; margin-bottom: 20px; margin-top: 0;">Welcome to EventHub</h1>
    <p style="font-size: 1.2em; color: #8b949e; max-width: 600px; margin: 0 auto 40px auto; line-height: 1.6;">
        The easiest way to discover, book, and manage tickets for upcoming tech workshops, conferences, and exclusive events.
    </p>
    
    <div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php" class="btn" style="font-size: 1.1em; padding: 15px 30px;">Go to My Dashboard</a>
            <a href="events.php" class="btn" style="font-size: 1.1em; padding: 15px 30px; background-color: #21262d; border-color: #30363d; color: #c9d1d9; margin-left: 10px;">Browse Events</a>
        <?php else: ?>
            <a href="register.php" class="btn" style="font-size: 1.1em; padding: 15px 30px;">Get Started Today</a>
            <a href="events.php" class="btn" style="font-size: 1.1em; padding: 15px 30px; background-color: #21262d; border-color: #30363d; color: #c9d1d9; margin-left: 10px;">View Upcoming Events</a>
        <?php endif; ?>
    </div>
</div>

<div style="display: flex; justify-content: center; gap: 30px; margin-top: 60px; flex-wrap: wrap;">
    <div class="card" style="width: 250px; text-align: center;">
        <h3 style="color: #2ea043; font-size: 2em; margin: 0 0 10px 0;">🎫</h3>
        <h4 style="margin-top: 0;">Easy Booking</h4>
        <p style="color: #8b949e; font-size: 0.9em;">Reserve your seat in just two clicks with our streamlined checkout.</p>
    </div>
    <div class="card" style="width: 250px; text-align: center;">
        <h3 style="color: #f85149; font-size: 2em; margin: 0 0 10px 0;">📅</h3>
        <h4 style="margin-top: 0;">Manage Plans</h4>
        <p style="color: #8b949e; font-size: 0.9em;">View your history and easily cancel reservations if plans change.</p>
    </div>
    <div class="card" style="width: 250px; text-align: center;">
        <h3 style="color: #a371f7; font-size: 2em; margin: 0 0 10px 0;">🔒</h3>
        <h4 style="margin-top: 0;">Secure Platform</h4>
        <p style="color: #8b949e; font-size: 0.9em;">Your data is protected with industry-standard security and hashing.</p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>