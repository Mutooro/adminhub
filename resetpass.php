<?php
// Assuming you have a database connection established

include '../emg_admin/config.php';

// Function to update the user's password in the database
function updatePassword($email, $newPassword) {
    // Implement your own logic to update the password for the user
    // Assuming you have a "signin" table with columns "email" and "password"
    // Update the "password" column for the user with the given email address

    $dbHost = 'localhost';  // Replace with your database host
    $dbName = 'football';  // Replace with your database name
    $dbUser = 'root';  // Replace with your database username
    $dbPass = '';  // Replace with your database password

    try {
        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);

        // Prepare the SQL statement
        $stmt = $pdo->prepare("UPDATE signin SET password = :password WHERE email = :email");

        // Bind the parameters
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Execute the statement
        $stmt->execute();

        // Close the database connection
        $pdo = null;
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit;
    }
}

// Process the password change request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user's email address and new password from the form
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];

    // Update the user's password in the database
    updatePassword($email, $newPassword);

    // Redirect the user to the login page or any other desired page
    header("Location: ../index.php");
    exit;
}
?>
