<?php
/**
 * SEMESTER MANAGE: semester_manage.php
 */
include '../../server/config/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$semester_id = $_GET['id'] ?? null;
$name = "";
$date = "";

if ($semester_id) {
    $res = $conn->query("SELECT * FROM semesters WHERE semester_id = $semester_id AND user_id = $user_id");
    if ($row = $res->fetch_assoc()) {
        $name = $row['semester_name'];
        $date = $row['semester_date'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['semester_name'];
    $date = $_POST['semester_date'];

    if ($semester_id) {
        $sql = "UPDATE semesters SET semester_name = '$name', semester_date = '$date' WHERE semester_id = $semester_id";
    } else {
        $sql = "INSERT INTO semesters (user_id, semester_name, semester_date) VALUES ($user_id, '$name', '$date')";
    }

    if ($conn->query($sql)) {
        header("Location: semesters.php?success=Saved");
    } else {
        $error = "Error saving semester.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="mb-4">
        <a href="semesters.php" class="btn btn-sm btn-outline-secondary mb-3">← Back to List</a>
        <h2 class="fw-bold"><?php echo $semester_id ? 'Edit Semester' : 'Add New Semester'; ?></h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="custom-card">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Semester Name</label>
                        <input type="text" name="semester_name" class="form-control" placeholder="e.g. Semester 1" value="<?php echo $name; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date / Period</label>
                        <input type="text" name="semester_date" class="form-control" placeholder="e.g. Fall 2024" value="<?php echo $date; ?>">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save Semester</button>
                        <a href="semesters.php" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
