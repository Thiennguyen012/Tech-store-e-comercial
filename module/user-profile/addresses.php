<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    echo '<div class="container mt-5"><div class="alert alert-warning">Please <a href="Login.php">login</a> to view your address book.</div></div>';
    return;
}

require_once __DIR__ . '/../../db/connect.php';

$username = $_SESSION['username'];
$success = $error = "";

// Handle address update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['address'] ?? '');
    if ($address === "") {
        $error = "Address cannot be empty.";
    } else {
        $stmt = $conn->prepare("UPDATE site_user SET address=? WHERE username=?");
        $stmt->bind_param("ss", $address, $username);
        if ($stmt->execute()) {
            $success = "Address updated successfully!";
        } else {
            $error = "Failed to update address.";
        }
        $stmt->close();
    }
}

// Fetch the latest user information
$stmt = $conn->prepare("SELECT address FROM site_user WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($address);
$stmt->fetch();
$stmt->close();
?>

<div class="container py-4">
    <div class="row g-4">
        <!-- Sidebar với menu điều hướng -->
        <div class="col-lg-3">
            <?php include 'user-profile-sidebar.php'; ?>
        </div>
        <div class="col-lg-9">
            <div class="pv-profile-main shadow-sm">
                <h4 class="mb-4 fw-bold">Address Book</h4>
                <!-- Form cập nhật địa chỉ -->
                <div class="d-flex justify-content-center p-3 mb-3" style="background:#fff;border-radius:8px;border:1px dashed #ccc;">
                    <form method="post" class="w-100" style="max-width:500px;">
                        <div class="input-group">
                            <input type="text" name="address" class="form-control" placeholder="Enter your address..." value="<?php echo htmlspecialchars($address ?? ''); ?>" required>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                        </div>
                    </form>
                </div>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php elseif ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <div class="py-3">
                    <h6>Your current address:</h6>
                    <div class="border rounded p-3 bg-light">
                        <?php echo $address ? htmlspecialchars($address) : '<span class="text-muted">No address set yet.</span>'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>