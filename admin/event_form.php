<?php
require '../includes/core.php';
admin();
require '../config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$categories = ['Academic', 'Career', 'Clubs', 'Sports', 'Social', 'Technology'];
$errors = [];

$x = [
    'title' => '',
    'description' => '',
    'category' => 'Academic',
    'venue' => '',
    'event_date' => '',
    'status' => 'published'
];

if ($id) {
    $sql_get = "SELECT * FROM events WHERE id = $id";
    $res_get = mysqli_query($conn, $sql_get);
    if ($res_get && mysqli_num_rows($res_get) > 0) {
        $x = mysqli_fetch_assoc($res_get);
    } else {
        flash('Event not found.');
        go('events.php');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check();

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $x['title'] = trim($_POST['title'] ?? '');
    $x['description'] = trim($_POST['description'] ?? '');
    $x['category'] = trim($_POST['category'] ?? '');
    $x['venue'] = trim($_POST['venue'] ?? '');
    $x['event_date'] = trim($_POST['event_date'] ?? '');
    $x['status'] = trim($_POST['status'] ?? '');

    $admin_id = (int)($_SESSION['admin_id'] ?? 1);

    // 1. Title validation
    if (empty($x['title'])) {
        $errors[] = 'Event title is required.';
    } elseif (strlen($x['title']) < 3) {
        $errors[] = 'Event title must be at least 3 characters long.';
    } elseif (strlen($x['title']) > 150) {
        $errors[] = 'Event title cannot exceed 150 characters.';
    }

    // 2. Description validation
    if (empty($x['description'])) {
        $errors[] = 'Event description is required.';
    } elseif (strlen($x['description']) < 10) {
        $errors[] = 'Event description must be at least 10 characters long.';
    }

    // 3. Category validation
    if (!in_array($x['category'], $categories, true)) {
        $errors[] = 'Please select a valid category.';
    }

    // 4. Venue validation
    if (empty($x['venue'])) {
        $errors[] = 'Event venue is required.';
    } elseif (strlen($x['venue']) < 2) {
        $errors[] = 'Venue name must be at least 2 characters long.';
    } elseif (strlen($x['venue']) > 150) {
        $errors[] = 'Venue name cannot exceed 150 characters.';
    }

    // 5. Date validation & formatting
    $timestamp = strtotime($x['event_date']);
    if (empty($x['event_date'])) {
        $errors[] = 'Event date and time is required.';
    } elseif (!$timestamp) {
        $errors[] = 'Invalid date and time format specified.';
    }

    // 6. Status validation
    if (!in_array($x['status'], ['draft', 'published'], true)) {
        $errors[] = 'Status must be either Published or Draft.';
    }

    if (empty($errors)) {
        $title_c = mysqli_real_escape_string($conn, $x['title']);
        $desc_c = mysqli_real_escape_string($conn, $x['description']);
        $cat_c = mysqli_real_escape_string($conn, $x['category']);
        $venue_c = mysqli_real_escape_string($conn, $x['venue']);
        $formatted_date = date('Y-m-d H:i:s', $timestamp);
        $date_c = mysqli_real_escape_string($conn, $formatted_date);
        $status_c = mysqli_real_escape_string($conn, $x['status']);

        if ($id) {
            $sql = "UPDATE events SET 
                    title = '$title_c', 
                    description = '$desc_c', 
                    category = '$cat_c', 
                    venue = '$venue_c', 
                    event_date = '$date_c', 
                    status = '$status_c' 
                    WHERE id = $id";
        } else {
            $sql = "INSERT INTO events (title, description, category, venue, event_date, status, created_by) 
                    VALUES ('$title_c', '$desc_c', '$cat_c', '$venue_c', '$date_c', '$status_c', $admin_id)";
        }

        if (mysqli_query($conn, $sql)) {
            flash($id ? 'Event updated successfully.' : 'Event created successfully.');
            go('events.php');
        } else {
            $errors[] = 'Database error: ' . mysqli_error($conn);
        }
    }
}

// Safely format date for datetime-local input field
$formatted_input_date = '';
if (!empty($x['event_date'])) {
    $ts = strtotime($x['event_date']);
    if ($ts) {
        $formatted_input_date = date('Y-m-d\TH:i', $ts);
    }
}

$title = $id ? 'Edit Event' : 'Create Event';
$base = '../';
$adminMode = true;
include '../includes/header.php';
?>

<div class="head">
    <div>
        <h1><?= e($title) ?></h1>
        <p>Publish or modify a campus event.</p>
    </div>
</div>

<div class="panel">
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $errorMsg): ?>
                <p style="margin: 4px 0;"><?= e($errorMsg) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="csrf" value="<?= e(token()) ?>">
        <?php if ($id): ?>
            <input type="hidden" name="id" value="<?= e($id) ?>">
        <?php endif; ?>

        <div class="field">
            <label>Title</label>
            <input name="title" required value="<?= e($x['title']) ?>" placeholder="e.g. Annual Innovation Workshop">
        </div>
        
        <div class="field">
            <label>Description</label>
            <textarea name="description" required placeholder="Describe the event details..."><?= e($x['description']) ?></textarea>
        </div>

        <div class="fields">
            <div class="field">
                <label>Category</label>
                <select name="category">
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= e($c) ?>" <?= $x['category'] === $c ? 'selected' : '' ?>><?= e($c) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="field">
                <label>Venue</label>
                <input name="venue" required value="<?= e($x['venue']) ?>" placeholder="e.g. Main Auditorium">
            </div>

            <div class="field">
                <label>Date & Time</label>
                <input type="datetime-local" name="event_date" required value="<?= e($formatted_input_date) ?>">
            </div>

            <div class="field">
                <label>Status</label>
                <select name="status">
                    <option value="published" <?= $x['status'] === 'published' ? 'selected' : '' ?>>Published</option>
                    <option value="draft" <?= $x['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                </select>
            </div>
        </div>

        <button class="btn" type="submit"><?= $id ? 'Update Event' : 'Save Event' ?></button>
        <a class="btn alt" href="events.php">Cancel</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>