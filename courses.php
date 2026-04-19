<?php
/**
 * COURSES LIST: courses.php
 * Displays all courses across all semesters for the logged-in user.
 * Includes a search bar for "easy" extra polish.
 */
include 'includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$search = $_GET['search'] ?? '';

// SQL query to get all courses and their associated semester names
$query = "SELECT c.*, s.semester_name 
          FROM courses c 
          JOIN semesters s ON c.semester_id = s.semester_id 
          WHERE s.user_id = $user_id";

if ($search) {
    $query .= " AND c.course_name LIKE '%$search%'";
}

$result = $conn->query($query);
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">All Courses</h2>
        <a href="course_manage.php" class="btn btn-primary">+ Add New Course</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Search courses..." value="<?php echo $search; ?>">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="custom-card">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Course Name</th>
                            <th>Semester</th>
                            <th>Grade</th>
                            <th>Credits</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="fw-bold"><?php echo $row['course_name']; ?></td>
                            <td><?php echo $row['semester_name']; ?></td>
                            <td><span class="badge bg-primary"><?php echo $row['grade']; ?></span></td>
                            <td><?php echo $row['credits']; ?></td>
                            <td class="text-end">
                                <a href="course_manage.php?id=<?php echo $row['course_id']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <a href="includes/delete_course.php?id=<?php echo $row['course_id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this course?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if ($result->num_rows == 0): ?>
                            <tr><td colspan="5" class="text-center text-muted">No courses found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
