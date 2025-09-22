<?php
// messages.php - Messaging system
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
include 'db.php';
 
$user_id = $_SESSION['user_id'];
 
if (isset($_GET['to_id'])) {
    $to_id = $_GET['to_id'];
} else {
    // For simplicity, assume a default or list users; here we'll just show form if to_id provided
    die('No recipient selected.');
}
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
 
    $stmt = $pdo->prepare("INSERT INTO messages (from_id, to_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $to_id, $message]);
    echo "<script>window.location.href = 'messages.php?to_id=$to_id';</script>";
}
 
$messages = $pdo->prepare("SELECT * FROM messages WHERE (from_id = ? AND to_id = ?) OR (from_id = ? AND to_id = ?) ORDER BY sent_at ASC");
$messages->execute([$user_id, $to_id, $to_id, $user_id]);
$chat = $messages->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7f9; }
        .chat-container { max-width: 600px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .message { padding: 10px; margin: 5px 0; border-radius: 5px; }
        .sent { background: #007bff; color: white; text-align: right; }
        .received { background: #e9ecef; text-align: left; }
        textarea { width: 100%; padding: 10px; margin: 10px 0; }
        button { background: #007bff; color: white; padding: 10px; border: none; cursor: pointer; }
        @media (max-width: 768px) { .chat-container { margin: 20px; padding: 15px; } }
    </style>
</head>
<body>
    <div class="chat-container">
        <h2>Chat with User <?php echo $to_id; ?></h2>
        <?php foreach ($chat as $msg): ?>
            <div class="message <?php echo ($msg['from_id'] == $user_id) ? 'sent' : 'received'; ?>">
                <?php echo htmlspecialchars($msg['message']); ?>
            </div>
        <?php endforeach; ?>
        <form method="POST">
            <textarea name="message" placeholder="Type message..." required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
    <script>
        // Inline JS to scroll to bottom
        document.querySelector('.chat-container').scrollTop = document.querySelector('.chat-container').scrollHeight;
    </script>
</body>
</html>
