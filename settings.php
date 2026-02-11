<?php
require_once 'config/db.php';
require_once 'config/functions.php';

requireLogin();

$page_title = 'Settings';
$error = '';
$success = '';

$user = getUserById($conn, $_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'delete_account') {
        $password = $_POST['password'] ?? '';

        if (empty($password)) {
            $error = 'Please enter your password to confirm account deletion.';
        } elseif (!verifyPassword($password, $user['password'])) {
            $error = 'Incorrect password.';
        } else {
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $_SESSION['user_id']);

            if ($stmt->execute()) {
                session_destroy();
                header('Location: index.php');
                exit();
            } else {
                $error = 'Failed to delete account. Please try again.';
            }
            $stmt->close();
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="form-container">
    <h1>Settings</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <div class="card">
        <h2>Danger Zone</h2>
        <p>Delete your account permanently. This action cannot be undone.</p>
        
        <button onclick="document.getElementById('deleteModal').style.display='block'" class="btn btn-danger">Delete Account</button>
    </div>

    <div class="button-group">
        <a href="dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
        <a href="profile.php" class="btn btn-secondary">Edit Profile</a>
        <a href="index.php" class="btn btn-secondary">Home</a>
    </div>
</div>

<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('deleteModal').style.display='none'">&times;</span>
        <h2>Delete Account</h2>
        <p>Are you sure you want to delete your account? This action cannot be undone.</p>
        
        <form method="POST" action="settings.php">
            <input type="hidden" name="action" value="delete_account">
            
            <div class="form-group">
                <label for="password">Enter your password to confirm</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-danger">Delete My Account</button>
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('deleteModal').style.display='none'">Cancel</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
    window.onclick = function(event) {
        let modal = document.getElementById('deleteModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
