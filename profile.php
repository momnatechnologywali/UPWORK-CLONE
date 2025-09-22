<?php
// profile.php - Profile management
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
include 'db.php';
 
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($user_type == 'freelancer') {
        $skills = $_POST['skills'];
        $experience = $_POST['experience'];
        $portfolio = $_POST['portfolio'];
        $hourly_rate = $_POST['hourly_rate'];
 
        $stmt = $pdo->prepare("REPLACE INTO freelancer_profiles (user_id, skills, experience, portfolio, hourly_rate) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $skills, $experience, $portfolio, $hourly_rate]);
    } else {
        $company_name = $_POST['company_name'];
        $description = $_POST['description'];
 
        $stmt = $pdo->prepare("REPLACE INTO client_profiles (user_id, company_name, description) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $company_name, $description]);
    }
    echo "<script>alert('Profile updated!'); window.location.href = 'profile.php';</script>";
}
 
$profile = ($user_type == 'freelancer') 
    ? $pdo->query("SELECT * FROM freelancer_profiles WHERE user_id = $user_id")->fetch(PDO::FETCH_ASSOC)
    : $pdo->query("SELECT * FROM client_profiles WHERE user_id = $user_id")->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7f9; }
        .profile-container { max-width: 600px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        @media (max-width: 768px) { .profile-container { margin: 20px; padding: 15px; } }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Edit Profile</h2>
        <form method="POST">
            <?php if ($user_type == 'freelancer'): ?>
                <input type="text" name="skills" placeholder="Skills (comma-separated)" value="<?php echo $profile['skills'] ?? ''; ?>">
                <textarea name="experience" placeholder="Experience"><?php echo $profile['experience'] ?? ''; ?></textarea>
                <textarea name="portfolio" placeholder="Portfolio"><?php echo $profile['portfolio'] ?? ''; ?></textarea>
                <input type="number" name="hourly_rate" placeholder="Hourly Rate" value="<?php echo $profile['hourly_rate'] ?? ''; ?>">
            <?php else: ?>
                <input type="text" name="company_name" placeholder="Company Name" value="<?php echo $profile['company_name'] ?? ''; ?>">
                <textarea name="description" placeholder="Description"><?php echo $profile['description'] ?? ''; ?></textarea>
            <?php endif; ?>
            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
