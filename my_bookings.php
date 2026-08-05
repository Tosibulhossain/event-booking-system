<?php
require_once 'includes/header.php';

// Protect the route
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle Cancellation
if (isset($_GET['cancel_id'])) {
    $cancel_id = (int)$_GET['cancel_id'];
    
    // Ensure the booking belongs to the logged-in user before cancelling
    $cancelStmt = $pdo->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = ? AND user_id = ?");
    if ($cancelStmt->execute([$cancel_id, $user_id])) {
        $cancel_msg = "Booking successfully cancelled.";
    }
}

// Fetch user's bookings joined with event details
$query = "
    SELECT b.id AS booking_id, b.booking_date, b.status, e.title, e.event_date, e.location 
    FROM bookings b
    JOIN events e ON b.event_id = e.id
    WHERE b.user_id = ?
    ORDER BY e.event_date DESC
";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();
?>

<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">My Bookings</h2>
        <a href="events.php" class="btn" style="margin: 0; background-color: #21262d; border-color: #30363d; color: #c9d1d9;">Browse More Events</a>
    </div>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <p style="color: #2ea043; font-weight: bold; background: rgba(46, 160, 67, 0.1); padding: 10px; border-radius: 5px;">
            Ticket booked successfully!
        </p>
    <?php endif; ?>

    <?php if (isset($cancel_msg)): ?>
        <p style="color: #f85149; font-weight: bold; background: rgba(248, 81, 73, 0.1); padding: 10px; border-radius: 5px;">
            <?php echo htmlspecialchars($cancel_msg); ?>
        </p>
    <?php endif; ?>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #30363d;">
                    <th style="padding: 12px; color: #8b949e;">Event Name</th>
                    <th style="padding: 12px; color: #8b949e;">Event Date</th>
                    <th style="padding: 12px; color: #8b949e;">Location</th>
                    <th style="padding: 12px; color: #8b949e;">Status</th>
                    <th style="padding: 12px; color: #8b949e;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($bookings) > 0): ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr style="border-bottom: 1px solid #30363d;">
                            <td style="padding: 12px; color: #58a6ff; font-weight: bold;"><?php echo htmlspecialchars($booking['title']); ?></td>
                            <td style="padding: 12px;"><?php echo date('M j, Y g:i A', strtotime($booking['event_date'])); ?></td>
                            <td style="padding: 12px;"><?php echo htmlspecialchars($booking['location']); ?></td>
                            <td style="padding: 12px;">
                                <?php if ($booking['status'] === 'booked'): ?>
                                    <span style="color: #2ea043; font-weight: bold;">Confirmed</span>
                                <?php else: ?>
                                    <span style="color: #f85149; font-weight: bold;">Cancelled</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px;">
                                <?php 
                                // Only allow cancellation if the event is in the future and status is 'booked'
                                $is_future = strtotime($booking['event_date']) > time();
                                if ($booking['status'] === 'booked' && $is_future): 
                                ?>
                                    <a href="my_bookings.php?cancel_id=<?php echo $booking['booking_id']; ?>" 
                                       onclick="return confirm('Are you sure you want to cancel this booking?');" 
                                       style="color: #f85149; text-decoration: none; font-weight: bold; font-size: 0.9em;">Cancel Ticket</a>
                                <?php elseif (!$is_future): ?>
                                    <span style="color: #8b949e; font-size: 0.9em;">Past Event</span>
                                <?php else: ?>
                                    <span style="color: #8b949e; font-size: 0.9em;">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="padding: 20px; text-align: center; color: #8b949e;">You haven't booked any events yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>