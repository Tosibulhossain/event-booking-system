<?php
require_once 'includes/header.php';

// Fetch all events scheduled for today or in the future, ordered by closest date
$stmt = $pdo->query("SELECT * FROM events WHERE event_date >= NOW() ORDER BY event_date ASC");
$events = $stmt->fetchAll();
?>

<div style="text-align: center; margin-bottom: 40px;">
    <h2>Upcoming Events</h2>
    <p style="color: #8b949e;">Discover and book your next great experience.</p>
</div>

<div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
    <?php if (count($events) > 0): ?>
        <?php foreach ($events as $event): ?>
            <div class="card" style="width: 320px; text-align: left; padding: 25px; box-sizing: border-box;">
                <h3 style="margin-top: 0; color: #58a6ff; font-size: 1.3em;">
                    <?php echo htmlspecialchars($event['title']); ?>
                </h3>
                <p style="color: #8b949e; font-size: 0.9em; border-bottom: 1px solid #30363d; padding-bottom: 10px;">
                    <strong>📅 Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($event['event_date'])); ?><br>
                    <strong>📍 Location:</strong> <?php echo htmlspecialchars($event['location']); ?><br>
                    <strong>🎟️ Capacity:</strong> <?php echo (int)$event['total_capacity']; ?> seats
                </p>
                <p style="font-size: 0.95em; line-height: 1.5;">
                    <?php 
                    $desc = htmlspecialchars($event['description']);
                    echo (strlen($desc) > 100) ? substr($desc, 0, 100) . '...' : $desc; 
                    ?>
                </p>
                
                <div style="margin-top: 20px;">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="book.php?id=<?php echo $event['id']; ?>" class="btn" style="width: 100%; text-align: center; box-sizing: border-box;">Book Ticket</a>
                    <?php else: ?>
                        <a href="login.php" class="btn" style="width: 100%; text-align: center; box-sizing: border-box; background-color: #21262d; border-color: #30363d; color: #8b949e;">Login to Book</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card" style="width: 100%; max-width: 600px;">
            <h3 style="color: #8b949e;">No Events Available</h3>
            <p>There are no upcoming events scheduled at the moment. Please check back later!</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>