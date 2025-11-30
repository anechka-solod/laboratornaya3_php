<?php
$db = new PDO('sqlite:db.sqlite');
$db->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        password_hash TEXT NOT NULL,
        bg_color TEXT DEFAULT '#ffffff',
        text_color TEXT DEFAULT '#000000'
    )
");
echo "DB ready\n";