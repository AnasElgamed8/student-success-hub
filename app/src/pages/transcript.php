<?php
/**
 * TRANSCRIPT PAGE: transcript.php
 */
include '../../server/config/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_res = $conn->query("SELECT * FROM users WHERE user_id = $user_id");
$user = $user_res->fetch_assoc();

$semesters_res = $conn->query("SELECT * FROM semesters WHERE user_id = $user_id ORDER BY semester_id ASC");
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Official Academic Transcript</h2>
        <button onclick="window.print()" class="btn btn-primary">🖨️ Print Transcript</button>
    </div>

    <div class="custom-card bg-white p-5" id="transcript-area">
        <div class="text-center mb-5">
            <h1 class="fw-bold">University Academic Record</h1>
            <p class="text-muted">Official Statement of Results</p>
            <hr>
            <div class="row text-start mt-4">
                <div class="col-6">
                    <p><strong>Student Name:</strong> <?php echo $user['full_name']; ?></p>
                    <p><strong>Student Email:</strong> <?php echo $user['email']; ?></p>
                </div>
                <div class="col-6 text-end">
                    <p><strong>Date Issued:</strong> <?php echo date('M d, Y'); ?></p>
                    <p><strong>Status:</strong> Active</p>
                </div>
            </div>
        </div>

        <?php 
        $total_weighted = 0;
        $total_credits = 0;
        
        while($sem = $semesters_res->fetch_assoc()): 
            $sem_id = $sem['semester_id'];
            $courses_res = $conn->query("SELECT * FROM courses WHERE semester_id = $sem_id");
            $sem_credits = 0;
            $sem_weighted = 0;
        ?>
            <div class="mb-5">
                <h5 class="fw-bold border-bottom pb-2"><?php echo $sem['semester_name']; ?> (<?php echo $sem['semester_date']; ?>)</h5>
                <table class="table table-sm table-borderless">
                    <thead>
                        <tr class="text-muted small">
                            <th>Course</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Credits</th>
                            <th class="text-end">Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($course = $courses_res->fetch_assoc()): 
                            $pts = $course['grade'] * $course['credits'];
                            $sem_credits += $course['credits'];
                            $sem_weighted += $pts;
                        ?>
                        <tr>
                            <td><?php echo $course['course_name']; ?></td>
                            <td class="text-center"><?php echo $course['grade']; ?></td>
                            <td class="text-center"><?php echo $course['credits']; ?></td>
                            <td class="text-end"><?php echo number_format($pts, 2); ?></td>
                        </tr>
                        <?php endwhile; ?>
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Semester Total:</td>
                            <td class="text-end"><?php echo number_format($sem_weighted, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
                <p class="text-end small">Semester GPA: <strong><?php echo ($sem_credits > 0) ? number_format($sem_weighted / $sem_credits, 2) : '0.00'; ?></strong></p>
            </div>
        <?php 
            $total_credits += $sem_credits;
            $total_weighted += $sem_weighted;
        endwhile; 
        ?>

        <div class="mt-5 p-4 bg-light rounded border text-center">
            <h4 class="fw-bold">Cumulative GPA (CGPA)</h4>
            <h1 class="display-4 fw-bold text-primary">
                <?php echo ($total_credits > 0) ? number_format($total_weighted / $total_credits, 2) : '0.00'; ?>
            </h1>
            <p class="text-muted">Total Credits Earned: <?php echo $total_credits; ?></p>
        </div>
    </div>
</div>

<style>
    @media print {
        .sidebar, .btn, .navbar, .main-content { margin: 0; padding: 0; width: 100%; }
        .sidebar { display: none; }
        .main-content { margin-left: 0; }
    }
</style>

<?php include 'includes/footer.php'; ?>
