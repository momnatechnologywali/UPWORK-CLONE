<?php
// signup.php - User signup
session_start();
include 'db.php';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = $_POST['user_type'];
 
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $user_type]);
        echo "<script>window.location.href = 'login.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7f9; }
        .form-container { max-width: 400px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        input, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        @media (max-width: 768px) { .form-container { margin: 20px; padding: 15px; } }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Signup</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="user_type" required>
                <option value="client">Client</option>
                <option value="freelancer">Freelancer</option>
            </select>
            <button type="submit">Signup</button>
        </form>
    </div>
    <script>
        // Inline JS for form validation or fun
        document.querySelector('form').addEventListener('submit', function(e) {
            if (document.querySelector('input[name="password"]').value.length < 6) {
                alert('Password too short!');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
