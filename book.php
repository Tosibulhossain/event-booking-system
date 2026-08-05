<?php
session_start();
require_once 'config/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($event_id === 0) {
    header("Location: events.php");
    exit;
}

// 1. Check if the event exists and has capacity
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) {
    die("Event not found.");
}

// 2. Check how many bookings currently exist for this event
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE event_id = ? AND status = 'booked'");
$countStmt->execute([$event_id]);
$current_bookings = $countStmt->fetchColumn();

if ($current_bookings >= $event['total_capacity']) {
    die("Sorry, this event is fully booked.");
}

// 3. Check if the user has already booked this event
$checkStmt = $pdo->prepare("SELECT * FROM bookings WHERE user_id = ? AND event_id = ? AND status = 'booked'");
$checkStmt->execute([$user_id, $event_id]);
if ($checkStmt->fetch()) {
    die("You have already booked a ticket for this event. Check your dashboard.");
}

// 4. Process the booking
$bookStmt = $pdo->prepare("INSERT INTO bookings (user_id, event_id, status) VALUES (?, ?, 'booked')");
if ($bookStmt->execute([$user_id, $event_id])) {
    // Redirect to their bookings page with a success flag
    header("Location: my_bookings.php?success=1");
    exit;
} else {
    die("An error occurred while processing your booking. Please try again.");
}
?>