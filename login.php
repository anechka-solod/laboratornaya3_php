<?php
require 'vendor/autoload.php';

if ($_POST['username'] ?? false) {
    $db = new PDO('sqlite:db.sqlite');
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password_hash = ?");
    $stmt->execute([$_POST['username'], md5($_POST['password'])]);
    $user = $stmt->fetch();
    if ($user) {
        session_start();
        $_SESSION['user'] = $user['username'];
        $_SESSION['bg_color'] = $user['bg_color'] ?? '#ffffff';
        $_SESSION['text_color'] = $user['text_color'] ?? '#000000';
        if (!empty($_POST['remember'])) {
            setUserCookie($user['username']);
        }
        header('Location: dashboard.php');
        exit;
    }
}
?>
<form method="post">
    <input name="username" placeholder="Username" required>
    <input name="password" type="password" placeholder="Password" required>
    <label><input type="checkbox" name="remember"> Remember me</label>
    <button>Login</button>
</form>