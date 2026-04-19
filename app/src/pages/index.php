<?php
/**
 * LOGIN PAGE: index.php
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Success Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="no-sidebar d-flex align-items-center justify-content-center vh-100">

    <div class="custom-card shadow-lg" style="width: 420px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Welcome Back</h2>
            <p class="text-muted">Please login to access your academic hub</p>
        </div>

        <form action="../../server/routes/auth_process.php" method="POST">
            <div class="mb-3">
                <label class="form-label">University Email</label>
                <input type="email" name="email" class="form-control" placeholder="name@univ.edu" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100 py-2">Login to Dashboard</button>
        </form>

        <div class="text-center mt-4">
            <p class="mb-0">Don't have an account? <a href="register.php" class="text-decoration-none">Create one now</a></p>
        </div>
    </div>

</body>
</html>
