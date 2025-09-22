<?php
// contracts.php - Contract management (simple hire)
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'client') {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
include 'db.php';
 
if (isset($_GET['proposal_id'])) {
    $proposal_id = $_GET['proposal_id'];
    $proposal = $pdo->query("SELECT * FROM proposals WHERE id = $proposal_id")->fetch(PDO::FETCH_ASSOC);
 
    if ($proposal) {
        $stmt = $pdo->prepare("INSERT INTO contracts (job_id, freelancer_id, client_id, payment) VALUES (?, ?, ?, ?)");
        $stmt->execute([$proposal['job_id'], $proposal['freelancer_id'], $_SESSION['user_id'], $proposal['bid']]);
 
        $update = $pdo->prepare("UPDATE proposals SET status = 'accepted' WHERE id = ?");
        $update->execute([$proposal_id]);
 
        echo "<script>window.location.href = 'jobs.php';</script>";
    }
}
 
// To list proposals for client's jobs
$client_id = $_SESSION['user_id'];
$proposals = $pdo->query("SELECT p.*, j.title, u.username FROM proposals p JOIN jobs j ON p.job_id = j.id JOIN users u ON p.freelancer_id = u.id WHERE j.client_id = $client_id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contracts</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7f9; }
        .container { max-width: 800px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .proposal { padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        a { color: #007bff; text-decoration: none; }
        @media (max-width: 768px) { .container { margin: 20px; padding: 15px; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Proposals & Contracts</h2>
        <?php foreach ($proposals as $prop): ?>
            <div class="proposal">
                <p>Job: <?php echo htmlspecialchars($prop['title']); ?></p>
                <p>Freelancer: <?php echo htmlspecialchars($prop['username']); ?></p>
                <p>Bid: $<?php echo $prop['bid']; ?></p>
                <p>Message: <?php echo htmlspecialchars($prop['message']); ?></p>
                <?php if ($prop['status'] == 'pending'): ?>
                    <a href="contracts.php?proposal_id=<?php echo $prop['id']; ?>">Hire</a>
                <?php else: ?>
                    <p>Status: <?php echo $prop['status']; ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
