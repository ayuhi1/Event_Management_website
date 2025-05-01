<?php
require_once 'config.php';

// Get event type from request
$event_type = isset($_GET['event_type']) ? $_GET['event_type'] : '';

// Validate event type
$valid_event_types = ['Wedding', 'Birthday', 'Anniversary', 'Corporate', 'Other'];
$event_type = in_array($event_type, $valid_event_types) ? strtolower($event_type) : '';

// Initialize response array
$response = ['success' => false, 'venues' => []];

try {
    // Query to get venues based on event type
    if (!empty($event_type)) {
        $stmt = $pdo->prepare("SELECT * FROM venues WHERE event_type = ? AND is_active = 1");
        $stmt->execute([$event_type]);
    } else {
        // Get all venues if no event type specified
        $stmt = $pdo->query("SELECT * FROM venues WHERE is_active = 1");
    }
    
    $venues = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($venues) > 0) {
        $response['success'] = true;
        $response['venues'] = $venues;
    } else {
        $response['message'] = 'No venues found for this event type.';
    }
} catch (PDOException $e) {
    $response['error'] = 'Database error: ' . $e->getMessage();
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);