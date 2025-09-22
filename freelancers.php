<?php
// freelancers.php - Browse freelancers (simple, with filters)
session_start();
include 'db.php';
 
$where = "1=1";
$params = [];
 
if (isset($_GET['skills'])) {
    $skills = "%" . $_GET['skills'] . "%";
    $where .= " AND skills LIKE ?";
    $params[] = $skills;
}
 
$stmt = $pdo->prepare("SELECT u.username, fp.* FROM users u JOIN freelancer_profiles fp ON u.id = fp.user_id WHERE $where");
$stmt->execute($params);
$freelancers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancers</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7f9; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; }
        .filter-form { background: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .freelancer-profile { background: white; border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 8px; }
        @media (max-width: 768px) { .container { padding: 10px; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>Browse Freelancers</h2>
        <form class="filter-form" method="GET">
            <input type="text" name="skills" placeholder="Search Skills...">
            <button type="submit">Filter</button>
        </form>
        <?php foreach ($freelancers as $fl): ?>
            <div class="freelancer-profile">
                <h3><?php echo htmlspecialchars($fl['username']); ?></h3>
                <p>Skills: <?php echo htmlspecialchars($fl['skills']); ?></p>
                <p>Hourly Rate: $<?php echo $fl['hourly_rate']; ?></p>
                <a href="messages.php?to_id=<?php echo $fl['user_id']; ?>">Message</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
