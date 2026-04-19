<?php
/**
 * SEMESTERS LIST: semesters.php
 */
include '../../server/config/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM semesters WHERE user_id = $user_id ORDER BY semester_id DESC");
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">My Semesters</h2>
        <a href="semester_manage.php" class="btn btn-primary">+ Add New Semester</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="custom-card">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Semester Name</th>
                            <th>Date/Period</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="fw-bold"><?php echo $row['semester_name']; ?></td>
                            <td><?php echo $row['semester_date'] ?: 'Not specified'; ?></td>
                            <td class="text-end">
                                <a href="semester_view.php?id=<?php echo $row['semester_id']; ?>" class="btn btn-sm btn-info text-white">View Details</a>
                                <a href="semester_manage.php?id=<?php echo $row['semester_id']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <a href="../../server/routes/delete_semester.php?id=<?php echo $row['semester_id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if ($result->num_rows == 0): ?>
                            <tr><td colspan="3" class="text-center text-muted">No semesters found. Add one to get started!</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
