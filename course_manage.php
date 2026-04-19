<?php
/**
 * COURSE MANAGE: course_manage.php
 * Handles adding or editing a course.
 */
include 'includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$course_id = $_GET['id'] ?? null;
$semester_id = $_GET['semester_id'] ?? null;
$name = ""; $grade = ""; $credits = "";

// If editing, fetch existing data
if ($course_id) {
    $res = $conn->query("SELECT * FROM courses WHERE course_id = $course_id");
    if ($row = $res->fetch_assoc()) {
        $semester_id = $row['semester_id'];
        $name = $row['course_name'];
        $grade = $row['grade'];
        $credits = $row['credits'];
    }
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $semester_id = $_POST['semester_id'];
    $name = $_POST['course_name'];
    $grade = $_POST['grade'];
    $credits = $_POST['credits'];

    if ($course_id) {
        $sql = "UPDATE courses SET semester_id = '$semester_id', course_name = '$name', grade = '$grade', credits = '$credits' WHERE course_id = $course_id";
    } else {
        $sql = "INSERT INTO courses (semester_id, course_name, grade, credits) VALUES ($semester_id, '$name', '$grade', '$credits')";
    }

    if ($conn->query($sql)) {
        header("Location: courses.php?success=Saved");
    } else {
        $error = "Error saving course.";
    }
}

// Fetch semesters for the dropdown
$semesters = $conn->query("SELECT * FROM semesters WHERE user_id = $user_id");
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="mb-4">
        <a href="courses.php" class="btn btn-sm btn-outline-secondary mb-3">← Back to List</a>
        <h2 class="fw-bold"><?php echo $course_id ? 'Edit Course' : 'Add New Course'; ?></h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="custom-card">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Select Semester</label>
                        <select name="semester_id" class="form-select" required>
                            <option value="">-- Choose Semester --</option>
                            <?php while($s = $semesters->fetch_assoc()): ?>
                                <option value="<?php echo $s['semester_id']; ?>" <?php echo ($s['semester_id'] == $semester_id) ? 'selected' : ''; ?>>
                                    <?php echo $s['semester_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Course Name</label>
                        <input type="text" name="course_name" class="form-control" value="<?php echo $name; ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Grade (e.g., 4.0, 3.7)</label>
                            <input type="number" step="0.01" name="grade" class="form-control" value="<?php echo $grade; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Credits</label>
                            <input type="number" name="credits" class="form-control" value="<?php echo $credits; ?>" required>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save Course</button>
                        <a href="courses.php" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
