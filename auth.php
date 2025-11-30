<?php
session_start();

function setUserCookie($username) {
    setcookie('remember', $username, time() + 60*60*24*30, '/', '', false, true);
}

function clearUserCookie() {
    setcookie('remember', '', time() - 3600, '/');
}

function autoLoginFromCookie($db) {
    if (!empty($_COOKIE['remember'])) {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$_COOKIE['remember']]);
        $user = $stmt->fetch();
        if ($user) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['bg_color'] = $user['bg_color'];
            $_SESSION['text_color'] = $user['text_color'];
            return true;
        }
    }
    return false;
}

function logout() {
    session_destroy();
    clearUserCookie();
    header('Location: login.php');
    exit;
}