<?php
// index.php - Homepage
session_start();
include 'db.php';
 
$jobs = $pdo->query("SELECT * FROM jobs ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
$freelancers = $pdo->query("SELECT u.username, fp.skills FROM users u JOIN freelancer_profiles fp ON u.id = fp.user_id ORDER BY RAND() LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upwork Clone - Homepage</title>
    <style>
        /* Amazing, real-looking CSS - Professional, modern, responsive */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f7f9; color: #333; }
        header { background: #007bff; color: white; padding: 20px; text-align: center; }
        nav { display: flex; justify-content: center; background: #0056b3; }
        nav a { color: white; padding: 14px 20px; text-decoration: none; }
        nav a:hover { background: #004085; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; }
        .section { margin-bottom: 40px; }
        .job-listing, .freelancer-profile { background: white; border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .job-listing h3, .freelancer-profile h3 { margin-top: 0; color: #007bff; }
        .categories { display: flex; flex-wrap: wrap; justify-content: space-around; }
        .category { background: #e9ecef; padding: 10px; margin: 5px; border-radius: 5px; text-align: center; flex: 1 1 200px; }
        @media (max-width: 768px) { .container { padding: 10px; } .category { flex: 1 1 100%; } }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Upwork Clone</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="jobs.php">Jobs</a>
        <a href="freelancers.php">Freelancers</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
        <?php endif; ?>
    </nav>
    <div class="container">
        <div class="section">
            <h2>Featured Jobs</h2>
            <?php foreach ($jobs as $job): ?>
                <div class="job-listing">
                    <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                    <p><?php echo htmlspecialchars($job['description']); ?></p>
                    <p>Budget: $<?php echo $job['budget']; ?> | Deadline: <?php echo $job['deadline']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="section">
            <h2>Featured Freelancers</h2>
            <?php foreach ($freelancers as $freelancer): ?>
                <div class="freelancer-profile">
                    <h3><?php echo htmlspecialchars($freelancer['username']); ?></h3>
                    <p>Skills: <?php echo htmlspecialchars($freelancer['skills']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="section categories">
            <h2>Categories</h2>
            <div class="category">Web Development</div>
            <div class="category">Graphic Design</div>
            <div class="category">Writing</div>
            <div class="category">Marketing</div>
        </div>
    </div>
    <script>
        // Inline JS for any interactions, e.g., alert on load for fun
        alert('Welcome! Enjoy the amazing CSS design.');
    </script>
</body>
</html>
