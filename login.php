<?php
session_start();

if (isset($_SESSION["admin"])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new SQLite3('database.sqlite', SQLITE3_OPEN_READWRITE);

    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $db->prepare('SELECT * FROM "admin" WHERE "login" = :login AND "password" = :password');
    $stmt->bindValue(':login', $login);
    $stmt->bindValue(':password', $password);
    $result = $stmt->execute();

    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $_SESSION['admin'] = true;
        $_SESSION['message'] = 'Вы успешно вошли в систему.';
    } else {
        $_SESSION['message'] = 'Неверный логин или пароль.';
    }
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Вход для администратора</title>
</head>
<body>
    <form action="" method="post">
        <label for="login">Логин:</label>
        <input type="text" id="login" name="login">
        <br>
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password">
        <br>
        <input type="submit" value="Войти">
    </form>
</body>
</html>