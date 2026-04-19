<?php
/**
 * DASHBOARD PAGE: dashboard.php
 * The central hub. Shows the overall CGPA and Total Credits.
 * This page uses SQL aggregation (SUM and AVG) to calculate totals.
 */
include 'includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// SQL query to calculate total credits and weighted CGPA across all semesters
// Formula: Sum(grade * credits) / Total Credits
$stats_query = $conn->query("
    SELECT 
        SUM(c.credits) as total_credits, 
        SUM(c.grade * c.credits) as weighted_sum 
    FROM courses c 
    JOIN semesters s ON c.semester_id = s.semester_id 
    WHERE s.user_id = $user_id
");

$stats = $stats_query->fetch_assoc();
$total_credits = $stats['total_credits'] ?? 0;
$weighted_sum = $stats['weighted_sum'] ?? 0;
$cgpa = ($total_credits > 0) ? ($weighted_sum / $total_credits) : 0;
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Academic Overview</h2>
        <span class="text-muted">Welcome back, <?php echo $_SESSION['user_name']; ?>!</span>
    </div>

    <!-- STATS ROW -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="custom-card text-center">
                <div class="text-muted small mb-1">Overall CGPA</div>
                <h1 class="display-5 fw-bold text-primary"><?php echo number_format($cgpa, 2); ?></h1>
                <p class="text-muted small">Across all completed semesters</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="custom-card text-center">
                <div class="text-muted small mb-1">Total Credits</div>
                <h1 class="display-5 fw-bold text-secondary"><?php echo $total_credits; ?></h1>
                <p class="text-muted small">Earned credits to date</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="custom-card text-center">
                <div class="text-muted small mb-1">Academic Standing</div>
                <h1 class="display-6 fw-bold text-success">
                    <?php 
                        if ($cgpa >= 3.5) echo "Excellent";
                        elseif ($cgpa >= 3.0) echo "Good";
                        elseif ($cgpa >= 2.0) echo "Satisfactory";
                        else echo "Needs Improvement";
                    ?>
                </h1>
                <p class="text-muted small">Based on your current CGPA</p>
            </div>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="row">
        <div class="col-md-12">
            <div class="custom-card">
                <h5 class="fw-bold mb-3">Quick Navigation</h5>
                <div class="d-flex gap-3">
                    <a href="semesters.php" class="btn btn-outline-primary">Manage Semesters</a>
                    <a href="courses.php" class="btn btn-outline-primary">Manage Courses</a>
                    <a href="simulator.php" class="btn btn-primary">Try the GPA Simulator</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
