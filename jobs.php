<?php
// jobs.php - Browse jobs with search and filters
session_start();
include 'db.php';
 
$where = "1=1";
$params = [];
 
if (isset($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%";
    $where .= " AND title LIKE ? OR description LIKE ?";
    $params[] = $search;
    $params[] = $search;
}
if (isset($_GET['category'])) {
    $where .= " AND category = ?";
    $params[] = $_GET['category'];
}
if (isset($_GET['budget_min'])) {
    $where .= " AND budget >= ?";
    $params[] = $_GET['budget_min'];
}
if (isset($_GET['job_type'])) {
    $where .= " AND job_type = ?";
    $params[] = $_GET['job_type'];
}
 
$stmt = $pdo->prepare("SELECT * FROM jobs WHERE $where ORDER BY created_at DESC");
$stmt->execute($params);
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7f9; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; }
        .filter-form { background: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .filter-form input, select { margin: 5px; padding: 8px; }
        .job-listing { background: white; border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 8px; }
        @media (max-width: 768px) { .container { padding: 10px; } .filter-form { flex-direction: column; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>Browse Jobs</h2>
        <form class="filter-form" method="GET">
            <input type="text" name="search" placeholder="Search...">
            <input type="text" name="category" placeholder="Category">
            <input type="number" name="budget_min" placeholder="Min Budget">
            <select name="job_type">
                <option value="">Any Type</option>
                <option value="hourly">Hourly</option>
                <option value="fixed">Fixed</option>
            </select>
            <button type="submit">Filter</button>
        </form>
        <?php foreach ($jobs as $job): ?>
            <div class="job-listing">
                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                <p><?php echo htmlspecialchars($job['description']); ?></p>
                <p>Budget: $<?php echo $job['budget']; ?> | Type: <?php echo $job['job_type']; ?> | Category: <?php echo $job['category']; ?></p>
                <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'freelancer'): ?>
                    <a href="submit_proposal.php?job_id=<?php echo $job['id']; ?>">Apply</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'client'): ?>
            <a href="post_job.php">Post a Job</a>
        <?php endif; ?>
    </div>
    <script>
        // Inline JS for dynamic filter or something
        console.log('Jobs page loaded with amazing CSS!');
    </script>
</body>
</html>
