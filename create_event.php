<?php
require_once 'includes/header.php';

// Protect the route: Ensure user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $event_date = $_POST['event_date'];
    $location = trim($_POST['location']);
    $capacity = (int)$_POST['capacity'];

    if (empty($title) || empty($event_date) || empty($location) || empty($capacity)) {
        $error = 'Please fill in all required fields.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO events (title, description, event_date, location, total_capacity) VALUES (?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$title, $description, $event_date, $location, $capacity])) {
            $success = 'Event created successfully!';
        } else {
            $error = 'Failed to create event. Please try again.';
        }
    }
}
?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2 style="margin: 0;">Create New Event</h2>
        <a href="manage_events.php" style="color: #8b949e; text-decoration: none;">&larr; Back to Events</a>
    </div>
    
    <hr style="border: 0; border-top: 1px solid #30363d; margin: 20px 0;">

    <?php if ($error): ?>
        <p style="color: #f85149; font-weight: bold;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <p style="color: #2ea043; font-weight: bold;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <div style="margin-bottom: 15px; text-align: left;">
            <label for="title" style="display: block; margin-bottom: 5px;">Event Title *</label>
            <input type="text" id="title" name="title" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9; box-sizing: border-box;" required>
        </div>
        
        <div style="margin-bottom: 15px; text-align: left;">
            <label for="description" style="display: block; margin-bottom: 5px;">Description</label>
            <textarea id="description" name="description" rows="4" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9; box-sizing: border-box;"></textarea>
        </div>

        <div style="margin-bottom: 15px; text-align: left;">
            <label for="event_date" style="display: block; margin-bottom: 5px;">Date & Time *</label>
            <input type="datetime-local" id="event_date" name="event_date" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9; box-sizing: border-box;" required>
        </div>

        <div style="margin-bottom: 15px; text-align: left;">
            <label for="location" style="display: block; margin-bottom: 5px;">Location *</label>
            <input type="text" id="location" name="location" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9; box-sizing: border-box;" required>
        </div>

        <div style="margin-bottom: 20px; text-align: left;">
            <label for="capacity" style="display: block; margin-bottom: 5px;">Total Capacity *</label>
            <input type="number" id="capacity" name="capacity" min="1" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9; box-sizing: border-box;" required>
        </div>

        <button type="submit" class="btn" style="width: 100%; box-sizing: border-box; background-color: #1f6feb; border-color: #388bfd;">Create Event</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>