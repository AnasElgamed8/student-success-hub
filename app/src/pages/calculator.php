<?php
/**
 * CALCULATOR PAGE: calculator.php
 * A manual tool for quick GPA calculations.
 */
include '../../server/config/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold">Quick GPA Calculator</h2>
        <p class="text-muted">Calculate a potential GPA without saving it to your record.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="custom-card">
                <div id="calc-container">
                    <!-- Course rows will be added here by JS -->
                </div>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button class="btn btn-outline-primary" onclick="addCourseRow()">+ Add Course</button>
                    <div class="text-end">
                        <span class="h5 me-2">Calculated GPA:</span>
                        <span id="calc-result" class="h3 fw-bold text-primary">0.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let courseCount = 0;

function addCourseRow() {
    courseCount++;
    const container = document.getElementById('calc-container');
    const row = document.createElement('div');
    row,className = "row g-3 mb-3 align-items-end";
    row.innerHTML = `
        <div class="col-md-6">
            <label class="form-label small">Course Name</label>
            <input type="text" class="form-control course-name" placeholder="Course Name">
        </div>
        <div class="col-md-3">
            <label class="form-label small">Grade</label>
            <input type="number" step="0.01" class="form-control course-grade" oninput="calculateQuickGPA()" placeholder="4.0">
        </div>
        <div class="col-md-2">
            <label class="form-label small">Credits</label>
            <input type="number" class="form-control course-credits" oninput="calculateQuickGPA()" placeholder="3">
        </div>
        <div class="col-md-1">
            <button class="btn btn-outline-danger" onclick="this.parentElement.parentElement.remove(); calculateQuickGPA();">×</button>
        </div>
    `;
    container.appendChild(row);
}

function calculateQuickGPA() {
    const grades = document.querySelectorAll('.course-grade');
    const credits = document.querySelectorAll('.course-credits');
    
    let totalWeighted = 0;
    let totalCredits = 0;

    grades.forEach((g, i) => {
        const grade = parseFloat(g.value);
        const credit = parseInt(credits[i].value);
        if (!isNaN(grade) && !isNaN(credit)) {
            totalWeighted += (grade * credit);
            totalCredits += credit;
        }
    });

    const gpa = totalCredits > 0 ? (totalWeighted / totalCredits) : 0;
    document.getElementById('calc-result').innerText = gpa.toFixed(2);
}

// Add first row by default
window.onload = addCourseRow;
</script>

<?php include 'includes/footer.php'; ?>
