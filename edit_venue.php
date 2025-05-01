<?php
require_once 'config.php';
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Check if venue ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Venue ID is required.";
    header('Location: admin.php');
    exit;
}

$venue_id = $_GET['id'];
$venue = null;
$error = null;

// Get venue details
try {
    $stmt = $pdo->prepare("SELECT * FROM venues WHERE id = ?");
    $stmt->execute([$venue_id]);
    $venue = $stmt->fetch();
    
    if (!$venue) {
        $_SESSION['error'] = "Venue not found.";
        header('Location: admin.php');
        exit;
    }
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}

// Process form submission for updating venue
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $venue_name = trim($_POST['venue_name']);
    $event_type = trim($_POST['event_type']);
    $venue_price = trim($_POST['venue_price']);
    $venue_description = trim($_POST['venue_description']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Initialize image path with current value
    $image_path = $venue['image'];
    
    // Check if a new image was uploaded
    if (isset($_FILES['venue_image']) && $_FILES['venue_image']['size'] > 0) {
        // Handle file upload
        $target_dir = "images/venues/";
        
        // Create directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES["venue_image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        // Check if image file is a actual image
        $check = getimagesize($_FILES["venue_image"]["tmp_name"]);
        if($check === false) {
            $error = "File is not an image.";
        }
        
        // Check file size (limit to 5MB)
        else if ($_FILES["venue_image"]["size"] > 5000000) {
            $error = "Sorry, your file is too large.";
        }
        
        // Allow certain file formats
        else if($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif" ) {
            $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
        
        // Try to upload file
        else if (move_uploaded_file($_FILES["venue_image"]["tmp_name"], $target_file)) {
            // File uploaded successfully, update image path
            $image_path = $target_file;
            
            // Delete old image file if it exists
            if (file_exists($venue['image']) && $venue['image'] != $image_path) {
                unlink($venue['image']);
            }
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
    
    // If no errors, update venue in database
    if (!$error) {
        try {
            $stmt = $pdo->prepare("UPDATE venues SET name = ?, event_type = ?, price = ?, image = ?, description = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$venue_name, $event_type, $venue_price, $image_path, $venue_description, $is_active, $venue_id]);
            
            $_SESSION['success'] = "Venue updated successfully!";
            header('Location: admin.php');
            exit;
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}

// Include header
include_once 'includes/header.php';
?>

<div class="container" style="margin: 100px auto 30px; max-width: 800px; padding: 20px;">
    <h1>Edit Venue</h1>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form action="edit_venue.php?id=<?php echo $venue_id; ?>" method="post" enctype="multipart/form-data">
        <div style="margin-bottom: 20px;">
            <label for="venue_name">Venue Name</label>
            <input type="text" id="venue_name" name="venue_name" value="<?php echo htmlspecialchars($venue['name']); ?>" required style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 20px;">
            <label for="event_type">Event Type</label>
            <select id="event_type" name="event_type" required style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="wedding" <?php echo ($venue['event_type'] == 'wedding') ? 'selected' : ''; ?>>Wedding</option>
                <option value="birthday" <?php echo ($venue['event_type'] == 'birthday') ? 'selected' : ''; ?>>Birthday</option>
                <option value="anniversary" <?php echo ($venue['event_type'] == 'anniversary') ? 'selected' : ''; ?>>Anniversary</option>
                <option value="corporate" <?php echo ($venue['event_type'] == 'corporate') ? 'selected' : ''; ?>>Corporate</option>
                <option value="other" <?php echo ($venue['event_type'] == 'other') ? 'selected' : ''; ?>>Other Events</option>
            </select>
        </div>
        
        <div style="margin-bottom: 20px;">
            <label for="venue_price">Price</label>
            <input type="text" id="venue_price" name="venue_price" value="<?php echo htmlspecialchars($venue['price']); ?>" required style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 20px;">
            <label for="venue_image">Current Image</label>
            <img src="<?php echo $venue['image']; ?>" alt="<?php echo $venue['name']; ?>" style="display: block; max-width: 300px; margin: 10px 0;">
            <label for="venue_image">Upload New Image (leave empty to keep current image)</label>
            <input type="file" id="venue_image" name="venue_image" style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 20px;">
            <label for="venue_description">Description</label>
            <textarea id="venue_description" name="venue_description" rows="4" required style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"><?php echo htmlspecialchars($venue['description']); ?></textarea>
        </div>
        
        <div style="margin-bottom: 20px;">
            <label>
                <input type="checkbox" name="is_active" <?php echo ($venue['is_active']) ? 'checked' : ''; ?>> Active
            </label>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background-color: #8a2be2; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold;">Update Venue</button>
            <a href="admin.php" style="background-color: #666; color: white; border: none; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: bold;">Cancel</a>
        </div>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>