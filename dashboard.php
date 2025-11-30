<?php
require 'vendor/autoload.php';
session_start();

$db = new PDO('sqlite:db.sqlite');

if (!isset($_SESSION['user'])) {
    require 'auth.php';
    if (!autoLoginFromCookie($db)) {
        header('Location: login.php');
        exit;
    }
}


$bg = $_SESSION['bg_color'];
$text = $_SESSION['text_color'];

if ($_POST['bg_color'] ?? false) {
    $stmt = $db->prepare("UPDATE users SET bg_color = ?, text_color = ? WHERE username = ?");
    $stmt->execute([$_POST['bg_color'], $_POST['text_color'], $_SESSION['user']]);
    $_SESSION['bg_color'] = $_POST['bg_color'];
    $_SESSION['text_color'] = $_POST['text_color'];
    $bg = $_POST['bg_color'];
    $text = $_POST['text_color'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { background: <?=htmlspecialchars($bg)?>; color: <?=htmlspecialchars($text)?>; }
    </style>
</head>
<body>
    <h1>Dashboard</h1>
    <p>Welcome, <?=htmlspecialchars($_SESSION['user'])?>!</p>
    <form method="post">
        Background: <input name="bg_color" value="<?=htmlspecialchars($bg)?>" type="color">
        Text: <input name="text_color" value="<?=htmlspecialchars($text)?>" type="color">
        <button>Save</button>
    </form>
    <a href="logout.php">Logout</a>
</body>
</html>