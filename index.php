<?php
session_start();
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
if (!file_exists("database.sqlite")){
    include 'init_database.php';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Главная страница</title>
</head>
<body>
    <?php if ($message): ?>
        <p><?= $message ?></p>
    <?php endif; ?>
    <button onclick="window.location.href='search.php'">Поиск</button>

    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true): ?>
        <button onclick="window.location.href='modify_db.php'">Изменить БД</button>
    <?php else: ?>
        <button onclick="window.location.href='login.php'">Вход</button>
    <?php endif; ?>
</body>
</html>
