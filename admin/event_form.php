<?php
require '../includes/core.php';
admin();
require '../config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
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

    if (strlen($x['title']) >= 3 && strlen($x['description']) >= 10 && strtotime($x['event_date']) && in_array($x['status'], ['draft', 'published'])) {
        $title_c = mysqli_real_escape_string($conn, $x['title']);
        $desc_c = mysqli_real_escape_string($conn, $x['description']);
        $cat_c = mysqli_real_escape_string($conn, $x['category']);
        $venue_c = mysqli_real_escape_string($conn, $x['venue']);
        $date_c = mysqli_real_escape_string($conn, $x['event_date']);
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
            flash('Event saved successfully.');
            go('events.php');
        } else {
            $err = 'Database error: ' . mysqli_error($conn);
        }
    } else {
        $err = 'Complete every field correctly.';
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
    <?php if (isset($err)): ?>
        <div class="error"><?= e($err) ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="csrf" value="<?= e(token()) ?>">
        <?php if ($id): ?>
            <input type="hidden" name="id" value="<?= e($id) ?>">
        <?php endif; ?>

        <div class="field">
            <label>Title</label>
            <input name="title" required value="<?= e($x['title']) ?>">
        </div>
        
        <div class="field">
            <label>Description</label>
            <textarea name="description" required><?= e($x['description']) ?></textarea>
        </div>

        <div class="fields">
            <div class="field">
                <label>Category</label>
                <select name="category">
                    <?php foreach (['Academic', 'Career', 'Clubs', 'Sports', 'Social', 'Technology'] as $c): ?>
                        <option <?= $x['category'] === $c ? 'selected' : '' ?>><?= e($c) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="field">
                <label>Venue</label>
                <input name="venue" required value="<?= e($x['venue']) ?>">
            </div>

            <div class="field">
                <label>Date & Time</label>
                <input type="datetime-local" name="event_date" required value="<?= e($x['event_date'] ? date('Y-m-d\TH:i', strtotime($x['event_date'])) : '') ?>">
            </div>

            <div class="field">
                <label>Status</label>
                <select name="status">
                    <option value="published" <?= $x['status'] === 'published' ? 'selected' : '' ?>>published</option>
                    <option value="draft" <?= $x['status'] === 'draft' ? 'selected' : '' ?>>draft</option>
                </select>
            </div>
        </div>

        <button class="btn" type="submit">Save event</button>
        <a class="btn alt" href="events.php">Cancel</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>