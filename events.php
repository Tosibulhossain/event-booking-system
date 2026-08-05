<?php
require_once 'includes/header.php';

// Handle search and filtering inputs
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';$location_query = isset($_GET['location']) ? trim($_GET['location']) : '';

// Base query for upcoming events
$sql = "SELECT * FROM events WHERE event_date >= NOW()";
$params = [];

// Append conditions dynamically based on user input
if (!empty($search_query)) {$sql .= " AND (title LIKE ? OR description LIKE ?)";
    $params[] = "\%$search_query%";
    $params[] = "\%$search_query%";
}

if (!empty($location_query)) {$sql .= " AND location LIKE ?";
    $params[] = "\%$location_query%";
}

$sql .= " ORDER BY event_date ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$events =$stmt->fetchAll();
?>

<div style="text-align: center; margin-bottom: 20px;">
    <h2>Upcoming Events</h2>
    <p style="color: #8b949e;">Discover and book your next great experience.</p>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto 30px auto; padding: 20px; background-color: #21262d; border: 1px solid #30363d;">
    <form method="GET" action="events.php" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center; justify-content: center;">
        <input type="text" name="search" placeholder="Search events..." value="<?php echo htmlspecialchars($search_query); ?>" style="flex: 1; min-width: 200px; padding: 10px; border-radius: 5px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9;">
        <input type="text" name="location" placeholder="Filter by location..." value="<?php echo htmlspecialchars($location_query); ?>" style="flex: 1; min-width: 200px; padding: 10px; border-radius: 5px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9;">
        <button type="submit" class="btn" style="padding: 10px 20px; background-color: #1f6feb; border-color: #388bfd;">Search</button>
        <a href="events.php" class="btn" style="padding: 10px 20px; background-color: #21262d; border-color: #30363d; color: #c9d1d9;">Clear</a>
    </form>
</div>

<div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
    <?php if (count($events) > 0): ?>
        <?php foreach ($events as$event): ?>
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
                    echo (strlen($desc) > 100) ? substr($desc, 0, 100) . '...' :$desc; 
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
            <h3 style="color: #8b949e;">No Events Found</h3>
            <p>We couldn't find any events matching your search criteria. Try adjusting your filters.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>