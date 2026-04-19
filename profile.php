<?php
/**
 * PROFILE PAGE: profile.php
 * Allows users to view and update their basic information.
 */
include 'includes/db_connect.php';
session_start();

// Protection: If user is not logged in, send them back to login page.
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_query = $conn->query("SELECT * FROM users WHERE user_id = $user_id");
$user = $user_query->fetch_assoc();
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">User Profile</h2>
        <span class="badge bg-primary">Student Account</span>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="custom-card text-center">
                <div class="mb-3">
                    <!-- Placeholder for a profile image -->
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['full_name']); ?>&background=random" 
                         class="rounded-circle shadow-sm" width="120" alt="Profile">
                </div>
                <h4 class="fw-bold"><?php echo $user['full_name']; ?></h4>
                <p class="text-muted"><?php echo $user['email']; ?></p>
                <hr>
                <div class="text-start small">
                    <p><strong>Member Since:</strong> <?php echo date('M d, Y', strtotime($user['created_at'])); ?></p>
                    <p><strong>Account Status:</strong> <span class="text-success">Active</span></p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="custom-card">
                <h5 class="fw-bold mb-4">Update Information</h5>
                <form action="includes/profile_update.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control" value="<?php echo $user['full_name']; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">University Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
