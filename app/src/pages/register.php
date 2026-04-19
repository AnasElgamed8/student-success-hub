<?php
/**
 * REGISTER PAGE: register.php
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Student Success Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="no-sidebar d-flex align-items-center justify-content-center vh-100">

    <div class="custom-card shadow-lg" style="width: 420px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Join the Hub</h2>
            <p class="text-muted">Create your account to start tracking your GPA</p>
        </div>

        <form action="../../server/routes/auth_process.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Enter your full name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">University Email</label>
                <input type="email" name="email" class="form-control" placeholder="name@univ.edu" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100 py-2">Create Account</button>
        </form>

        <div class="text-center mt-4">
            <p class="mb-0">Already have an account? <a href="index.php" class="text-decoration-none">Login here</a></p>
        </div>
    </div>

</body>
</html>
