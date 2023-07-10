<?php




// Database credentials
$host = 'localhost';
$dbName = 'football';
$user = 'root';
$password = '';

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optional: Set character set
    $pdo->exec("SET NAMES utf8");
} catch (PDOException $e) {
    // Handle database connection error
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Assuming you have an active database connection

// Start or resume the session
session_start();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate form inputs (you can add more validation rules as needed)
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = "Please fill in all fields.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "New password and confirm password do not match.";
    } else {
        // Verify the user's current password
        $name = $_SESSION['name'] ?? null; // Get the user name from the session

        if (!$name) {
            $error = "User not found.";
        } else {
            // Retrieve the user's stored password hash from the database
            $query = "SELECT password FROM signin WHERE name = :name";
            $statement = $pdo->prepare($query);
            $statement->bindValue(':name', $name);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                $error = "User not found.";
            } else {
                $storedPasswordHash = $result['password'];

                // Verify the current password
                if (!password_verify($currentPassword, $storedPasswordHash)) {
                    $error = '<script>
                    alert("Invalid Current Password");
                    window.location.href="resetpass.php";
                    </script>';
                } else {
                    // Generate a new password hash
                    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                    // Update the user's password in the database
                    $query = "UPDATE signin SET password = :newPassword WHERE name = :name";
                    $statement = $pdo->prepare($query);
                    $statement->bindValue(':newPassword', $newPasswordHash);
                    $statement->bindValue(':name', $name);
                    $statement->execute();

                    // Provide success message to the user
                    $success = '<script>
                    alert("password changed successful");
                    window.location.href="index.php";
                    </script>';

                   // header('location:../index.php');

                }
            }
        }
    }
}
?>

<!-- HTML form -->

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Design by foolishdeveloper.com -->
    <title>Change Pasword</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <style media="screen">
      *,
*:before,
*:after{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
/* body{
    background-color: #080710;
} */
.background{
    width: 430px;
    height: 520px;
    position: absolute;
    transform: translate(-50%,-50%);
    left: 50%;
    top: 50%;
}
.background .shape{
    height: 200px;
    width: 200px;
    position: absolute;
    border-radius: 50%;
}
.shape:first-child{
    background: linear-gradient(
        #1845ad,
        #23a2f6
    );
    left: -80px;
    top: -80px;
}
.shape:last-child{
    background: linear-gradient(
        to right,
        #ff512f,
        #f09819
    );
    right: -30px;
    bottom: -80px;
}
form{
    height: 520px;
    width: 400px;
    /* background-color: rgba(255,255,255,0.13); */
    background-color: #080710;
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 50px 35px;
}
form *{
    font-family: 'Poppins',sans-serif;
    color: #ffffff;
    letter-spacing: 0.5px;
    outline: none;
    border: none;
}
form h3{
    font-size: 32px;
    font-weight: 500;
    line-height: 42px;
    text-align: center;
}

label{
    display: block;
    margin-top: 30px;
    font-size: 16px;
    font-weight: 500;
}
input{
    display: block;
    height: 50px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 14px;
    font-weight: 300;
}
::placeholder{
    color: #e5e5e5;
}
input[type=submit]{
    margin-top: 25px;
    width: 100%;
    background-color: #ffffff;
    color: #080710;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
}



    </style>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="POST">
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } elseif (isset($success)) { ?>
        <p><?php echo $success; ?></p>
    <?php } ?>
        <h3>Change Pass</h3>

        <label for="username">Current Password</label>
        <input type="password" placeholder="Enter current password" id="current_password" name="current_password">

        <label for="password">New Password</label>
        <input type="password" placeholder="Enter New pass" id="new_password" name="new_password">
        <label for="password">Confirm Password</label>
        <input type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password">

        <input type="submit" value="Change Password">
    
    </form>
</body>
</html>

