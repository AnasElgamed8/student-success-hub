<?php
/**
 * SEMESTER VIEW: semester_view.php
 * The 'Deep Dive' page. Shows all courses for one specific semester.
 */
include 'includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$semester_id = $_GET['id'] ?? null;
if (!$semester_id) {
    header("Location: semesters.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 1. Get Semester Info
$sem_res = $conn->query("SELECT * FROM semesters WHERE semester_id = $semester_id AND user_id = $user_id");
$semester = $sem_res->fetch_assoc();

if (!$semester) {
    die("Semester not found.");
}

// 2. Get Courses for this semester
$courses_res = $conn->query("SELECT * FROM courses WHERE semester_id = $semester_id");

// 3. Calculate Semester GPA
$total_weighted = 0;
$total_credits = 0;
$courses_list = [];

while($course = $courses_res->fetch_assoc()) {
    $courses_list[] = $course;
    $total_weighted += ($course['grade'] * $course['credits']);
    $total_credits += $course['credits'];
}

$semester_gpa = ($total_credits > 0) ? ($total_weighted / $total_credits) : 0;
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="semesters.php" class="btn btn-sm btn-outline-secondary mb-3">← Back to Semesters</a>
            <h2 class="fw-bold"><?php echo $semester['semester_name']; ?></h2>
            <p class="text-muted"><?php echo $semester['semester_date'] ?: 'No date set'; ?></p>
        </div>
        <div class="text-end">
            <div class="custom-card d-inline-block text-center px-4">
                <div class="text-muted small">Semester GPA</div>
                <h2 class="fw-bold text-primary mb-0"><?php echo number_format($semester_gpa, 2); ?></h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="custom-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold">Course Breakdown</h5>
                    <a href="course_manage.php?semester_id=<?php echo $semester_id; ?>" class="btn btn-sm btn-primary">+ Add Course</a>
                </div>
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Course Name</th>
                            <th>Grade</th>
                            <th>Credits</th>
                            <th>Weight</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($courses_list as $course): ?>
                        <tr>
                            <td class="fw-bold"><?php echo $course['course_name']; ?></td>
                            <td><span class="badge bg-primary"><?php echo $course['grade']; ?></span></td>
                            <td><?php echo $course['credits']; ?></td>
                            <td><?php echo number_format($course['grade'] * $course['credits'], 2); ?></td>
                            <td class="text-end">
                                <a href="course_manage.php?id=<?php echo $course['course_id']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <a href="includes/delete_course.php?id=<?php echo $course['course_id']; ?>&redirect=semester_view.php?id=<?php echo $semester_id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete course?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($courses_list)): ?>
                            <tr><td colspan="5" class="text-center text-muted">No courses added yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="text-end mt-3">
                    <strong>Total Credits: <?php echo $total_credits; ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
