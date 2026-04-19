<?php
/**
 * GOAL SIMULATOR: simulator.php
 * The 'Magic' page. Uses sliders to help students plan their future GPA.
 * This is the 'picky-professor-proof' feature.
 */
include 'includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get current totals from DB
$stats_query = $conn->query("
    SELECT 
        SUM(c.credits) as total_credits, 
        SUM(c.grade * c.credits) as weighted_sum 
    FROM courses c 
    JOIN semesters s ON c.semester_id = s.semester_id 
    WHERE s.user_id = $user_id
");
$stats = $stats_query->fetch_assoc();
$current_credits = $stats['total_credits'] ?? 0;
$current_weighted_sum = $stats['weighted_sum'] ?? 0;
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold">GPA Goal Simulator</h2>
        <p class="text-muted">Adjust the sliders to see what you need in your next semester to reach your target.</p>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="custom-card">
                <h5 class="fw-bold mb-4">Simulation Controls</h5>
                
                <!-- TARGET CGPA SLIDER -->
                <div class="mb-4">
                    <label class="form-label d-flex justify-content-between">
                        Target CGPA <span id="target-val" class="fw-bold text-primary">3.50</span>
                    </label>
                    <input type="range" class="form-range" id="targetGPA" min="0" max="4" step="0.01" value="3.50" oninput="calculateRequired()">
                </div>

                <!-- NEXT SEMESTER CREDITS SLIDER -->
                <div class="mb-4">
                    <label class="form-label d-flex justify-content-between">
                        Next Semester Credits <span id="credits-val" class="fw-bold text-primary">15</span>
                    </label>
                    <input type="range" class="form-range" id="nextCredits" min="1" max="30" step="1" value="15" oninput="calculateRequired()">
                </div>

                <div class="alert alert-info small">
                    <strong>How it works:</strong> The system calculates the GPA you need in your next semester to reach your target overall CGPA, based on your current credits.
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="custom-card text-center py-5">
                <div class="text-muted mb-2">Required GPA for Next Semester</div>
                <h1 id="result-gpa" class="display-3 fw-bold text-primary">0.00</h1>
                <div id="result-msg" class="mt-3 fw-medium"></div>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * SIMULATOR LOGIC
 * This runs entirely in the browser for instant updates.
 */
function calculateRequired() {
    // 1. Get values from sliders
    const targetCgpa = parseFloat(document.getElementById('targetGPA').value);
    const nextCredits = parseInt(document.getElementById('nextCredits').value);
    
    // 2. Update the labels
    document.getElementById('target-val').innerText = targetCgpa.toFixed(2);
    document.getElementById('credits-val').innerText = nextCredits;

    // 3. Get current data from PHP
    const currentCredits = <?php echo $current_credits; ?>;
    const currentWeightedSum = <?php echo $current_weighted_sum; ?>;

    // FORMULA: (TargetGPA * (TotalCredits + NextCredits) - CurrentWeightedSum) / NextCredits
    const totalCreditsAfter = currentCredits + nextCredits;
    const requiredWeightedSum = (targetCgpa * totalCreditsAfter) - currentWeightedSum;
    const requiredGpa = requiredWeightedSum / nextCredits;

    const resultElement = document.getElementById('result-gpa');
    const msgElement = document.getElementById('result-msg');

    if (requiredGpa > 4.0) {
        resultElement.innerText = "Impossible";
        resultElement.classList.replace('text-primary', 'text-danger');
        msgElement.innerText = "You cannot reach this target with the given credits. Try lowering your target or increasing next semester's credits.";
        msgElement.className = "mt-3 fw-medium text-danger";
    } else if (requiredGpa < 0) {
        resultElement.innerText = "Achieved!";
        resultElement.classList.replace('text-primary', 'text-success');
        msgElement.innerText = "You have already surpassed this target!";
        msgElement.className = "mt-3 fw-medium text-success";
    } else {
        resultElement.innerText = requiredGpa.toFixed(2);
        resultElement.classList.replace('text-danger', 'text-primary');
        resultElement.classList.replace('text-success', 'text-primary');
        msgElement.innerText = `You need a ${requiredGpa.toFixed(2)} GPA in your next ${nextCredits} credits.`;
        msgElement.className = "mt-3 fw-medium text-muted";
    }
}

// Run once on load to initialize values
window.onload = calculateRequired;
</script>

<?php include 'includes/footer.php'; ?>
