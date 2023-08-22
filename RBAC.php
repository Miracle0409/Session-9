<?php
session_start();

// Define roles
define('ROLE_A', 'role_a');
define('ROLE_B', 'role_b');

// Check if the user is authenticated
if (!isset($_SESSION['user'])) {
    // Redirect to login page or show an error message
    header("Location: login.php");
    exit;
}

// Check the user's role
$userRole = $_SESSION['user']['role'];

// Function to check if the user has the necessary role
function hasRole($requiredRole) {
    global $userRole;
    return $userRole === $requiredRole;
}

// Check if the user has the necessary role for accessing certain features
if (hasRole(ROLE_A)) {
    // Allow access to features for role A
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Your existing file upload logic here
        echo "File uploaded successfully.";
    } else {
        // Display the form for uploading files
        echo '<form method="POST" action="index.php" enctype="multipart/form-data">
            <input type="file" name="image" />
            <input type="submit" value="Upload" />
        </form>';
    }
} elseif (hasRole(ROLE_B)) {
    // Deny access to features for role B
    echo "You don't have permission to access this feature.";
} else {
    // Handle any other roles here
    echo "Unknown role.";
}
?>
