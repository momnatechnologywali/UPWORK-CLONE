<?php
// submit_proposal.php - Submit proposal for freelancers
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'freelancer' || !isset($_GET['job_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
include 'db.php';
 
$job_id = $_GET['job_id'];
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bid = $_POST['bid'];
    $message = $_POST['message'];
    $freelancer_id = $_SESSION['user_id'];
 
    $stmt = $pdo->prepare("INSERT INTO proposals (job_id, freelancer_id, bid, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$job_id, $freelancer_id, $bid, $message]);
    echo "<script>window.location.href = 'jobs.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Proposal</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7f9; }
        .form-container { max-width: 600px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        @media (max-width: 768px) { .form-container { margin: 20px; padding: 15px; } }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Submit Proposal</h2>
        <form method="POST">
            <input type="number" name="bid" placeholder="Your Bid" required>
            <textarea name="message" placeholder="Proposal Message" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
