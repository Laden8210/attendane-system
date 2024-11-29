<?php
require_once 'repository/config.php'; // Database connection and other configs
session_start();

// Verify if the token exists in the query string
if (!isset($_GET['token']) || empty($_GET['token'])) {
    die('Invalid or missing token.');
}

$token = $_GET['token'];


$stmt = $conn->prepare("SELECT * FROM password_reset_tokens WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Invalid or expired token.');
}

$resetRecord = $result->fetch_assoc();
$userId = $resetRecord['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match.";
    } elseif (strlen($newPassword) < 8) {
        $error = "Password must be at least 8 characters long.";
    } else {



        $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $updateStmt->bind_param("si", $newPassword, $userId);

        if ($updateStmt->execute()) {

            $deleteStmt = $conn->prepare("DELETE FROM password_reset_tokens WHERE token = ?");
            $deleteStmt->bind_param("s", $token);
            $deleteStmt->execute();


            header('Location: index.php?view=login');
            exit;
        } else {
            $error = "Failed to update password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center font-poppins  bg-violet-900">
  <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-2xl font-bold text-center text-[#003C68] mb-6">Change Your Password</h1>

    <!-- Error Message -->
    <?php if (!empty($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
      <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>

    <!-- Password Change Form -->
    <form action="" method="POST" class="space-y-4">
      <div>
        <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
        <input type="password" name="new_password" id="new_password" required minlength="8"
          class="w-full px-4 py-2 mt-1 text-sm border rounded-lg focus:outline-none focus:ring-[#003C68] focus:border-[#003C68]" />
      </div>

      <div>
        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm_password" required minlength="8"
          class="w-full px-4 py-2 mt-1 text-sm border rounded-lg focus:outline-none focus:ring-[#003C68] focus:border-[#003C68]" />
      </div>

      <button type="submit"
        class="w-full bg-[#4CB4FF] hover:bg-[#003C68] text-white font-bold py-2 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
        Change Password
      </button>
    </form>

    <div class="text-center mt-6">
      <a href="login.php" class="text-sm text-[#003C68] underline">Back to Login</a>
    </div>
  </div>

</body>

</html>

