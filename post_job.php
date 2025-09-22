<?php
// post_job.php - Job posting for clients
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'client') {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
include 'db.php';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $budget = $_POST['budget'];
    $deadline = $_POST['deadline'];
    $job_type = $_POST['job_type'];
    $category = $_POST['category'];
    $client_id = $_SESSION['user_id'];
 
    $stmt = $pdo->prepare("INSERT INTO jobs (title, description, budget, deadline, job_type, category, client_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $budget, $deadline, $job_type, $category, $client_id]);
    echo "<script>window.location.href = 'jobs.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Job</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7f9; }
        .form-container { max-width: 600px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        input, textarea, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        @media (max-width: 768px) { .form-container { margin: 20px; padding: 15px; } }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Post a Job</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Job Title" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="number" name="budget" placeholder="Budget" required>
            <input type="date" name="deadline" required>
            <select name="job_type" required>
                <option value="hourly">Hourly</option>
                <option value="fixed">Fixed</option>
            </select>
            <input type="text" name="category" placeholder="Category" required>
            <button type="submit">Post Job</button>
        </form>
    </div>
</body>
</html>
