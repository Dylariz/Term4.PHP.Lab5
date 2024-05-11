<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$db = new SQLite3('database.sqlite', SQLITE3_OPEN_READWRITE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $patronymic = $_POST['patronymic'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Проверка корректности данных
    if (preg_match('/^[А-Я][а-я]+$/u', $firstname) &&
    preg_match('/^[А-Я][а-я]+$/u', $lastname) &&
    preg_match('/^[А-Я][а-я]+$/u', $patronymic) &&
    preg_match('/^(\+7|8)[0-9]{10}$/', $phone) &&
    preg_match('/^[А-Я][а-я0-9\s,]+$/u', $address)) {
        if ($id) {
            $stmt = $db->prepare('REPLACE INTO "user" ("id", "firstname", "lastname", "patronymic", "phone", "address") VALUES (:id, :firstname, :lastname, :patronymic, :phone, :address)');
            $stmt->bindValue(':id', $id);
        } else {
            $stmt = $db->prepare('INSERT INTO "user" ("firstname", "lastname", "patronymic", "phone", "address") VALUES (:firstname, :lastname, :patronymic, :phone, :address)');
        }
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':patronymic', $patronymic);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':address', $address);
        $stmt->execute();
    } else {
        echo 'Некорректные данные.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Изменение БД</title>
</head>
<body>
    <form action="" method="post">
        <label for="id">ID (необязательно):</label>
        <input type="text" id="id" name="id">
        <br>
        <label for="firstname">Имя:</label>
        <input type="text" id="firstname" name="firstname">
        <br>
        <label for="lastname">Фамилия:</label>
        <input type="text" id="lastname" name="lastname">
        <br>
        <label for="patronymic">Отчество:</label>
        <input type="text" id="patronymic" name="patronymic">
        <br>
        <label for="phone">Телефон:</label>
        <input type="text" id="phone" name="phone">
        <br>
        <label for="address">Адрес:</label>
        <input type="text" id="address" name="address">
        <br>
        <input type="submit" value="Изменить">
    </form>
</body>
</html>
