<?php
require_once 'includes/header.php';

// Protect the route: Ensure user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}

// Fetch all bookings with user and event details
$query = "
    SELECT b.id AS booking_id, b.booking_date, b.status, 
           u.name AS user_name, u.email, 
           e.title AS event_title, e.event_date 
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN events e ON b.event_id = e.id
    ORDER BY b.booking_date DESC
";
$stmt = $pdo->query($query);
$all_bookings = $stmt->fetchAll();
?>

<div class="card" style="max-width: 1000px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">System Bookings Overview</h2>
        <a href="dashboard.php" style="color: #8b949e; text-decoration: none;">&larr; Back to Dashboard</a>
    </div>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #30363d;">
                    <th style="padding: 12px; color: #8b949e;">ID</th>
                    <th style="padding: 12px; color: #8b949e;">Customer</th>
                    <th style="padding: 12px; color: #8b949e;">Event Booked</th>
                    <th style="padding: 12px; color: #8b949e;">Event Date</th>
                    <th style="padding: 12px; color: #8b949e;">Booking Date</th>
                    <th style="padding: 12px; color: #8b949e;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($all_bookings) > 0): ?>
                    <?php foreach ($all_bookings as $b): ?>
                        <tr style="border-bottom: 1px solid #30363d;">
                            <td style="padding: 12px; color: #8b949e;">#<?php echo $b['booking_id']; ?></td>
                            <td style="padding: 12px;">
                                <strong><?php echo htmlspecialchars($b['user_name']); ?></strong><br>
                                <span style="font-size: 0.85em; color: #8b949e;"><?php echo htmlspecialchars($b['email']); ?></span>
                            </td>
                            <td style="padding: 12px; color: #58a6ff; font-weight: bold;"><?php echo htmlspecialchars($b['event_title']); ?></td>
                            <td style="padding: 12px;"><?php echo date('M j, Y', strtotime($b['event_date'])); ?></td>
                            <td style="padding: 12px;"><?php echo date('M j, Y g:i A', strtotime($b['booking_date'])); ?></td>
                            <td style="padding: 12px;">
                                <?php if ($b['status'] === 'booked'): ?>
                                    <span style="color: #2ea043; font-weight: bold; font-size: 0.9em; background: rgba(46, 160, 67, 0.1); padding: 4px 8px; border-radius: 12px;">Active</span>
                                <?php else: ?>
                                    <span style="color: #f85149; font-weight: bold; font-size: 0.9em; background: rgba(248, 81, 73, 0.1); padding: 4px 8px; border-radius: 12px;">Cancelled</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="padding: 20px; text-align: center; color: #8b949e;">No bookings have been made yet on the platform.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>