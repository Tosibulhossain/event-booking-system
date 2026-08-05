<?php
require_once 'includes/header.php';

// Protect the route: Ensure user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}

// Handle event deletion
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $deleteStmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    $deleteStmt->execute([$delete_id]);
    $success_msg = "Event deleted successfully.";
}

// Fetch all events
$stmt = $pdo->query("SELECT * FROM events ORDER BY event_date DESC");
$events = $stmt->fetchAll();
?>

<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Manage Events</h2>
        <a href="create_event.php" class="btn" style="margin: 0;">+ Create New Event</a>
    </div>

    <?php if (isset($success_msg)): ?>
        <p style="color: #2ea043; font-weight: bold; background: rgba(46, 160, 67, 0.1); padding: 10px; border-radius: 5px;">
            <?php echo htmlspecialchars($success_msg); ?>
        </p>
    <?php endif; ?>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #30363d;">
                    <th style="padding: 12px; color: #8b949e;">ID</th>
                    <th style="padding: 12px; color: #8b949e;">Title</th>
                    <th style="padding: 12px; color: #8b949e;">Date</th>
                    <th style="padding: 12px; color: #8b949e;">Capacity</th>
                    <th style="padding: 12px; color: #8b949e;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($events) > 0): ?>
                    <?php foreach ($events as $event): ?>
                        <tr style="border-bottom: 1px solid #30363d;">
                            <td style="padding: 12px;"><?php echo $event['id']; ?></td>
                            <td style="padding: 12px; color: #58a6ff; font-weight: bold;"><?php echo htmlspecialchars($event['title']); ?></td>
                            <td style="padding: 12px;"><?php echo date('M j, Y g:i A', strtotime($event['event_date'])); ?></td>
                            <td style="padding: 12px;"><?php echo $event['total_capacity']; ?></td>
                            <td style="padding: 12px;">
                                <a href="manage_events.php?delete_id=<?php echo $event['id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this event? This will also delete all associated bookings.');" 
                                   style="color: #f85149; text-decoration: none; font-weight: bold;">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="padding: 20px; text-align: center; color: #8b949e;">No events found. Start by creating one.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>