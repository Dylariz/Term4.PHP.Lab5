<?php
$db = new SQLite3('database.sqlite', SQLITE3_OPEN_READWRITE);

$searchType = $_POST['searchType'] ?? null;
$searchTerm = $_POST['searchTerm'] ?? null;
$results = [];

if ($searchType && $searchTerm) {
    if ($searchType === 'lastname') {
        $stmt = $db->prepare('SELECT * FROM "user" WHERE "lastname" = :searchTerm');
    } else if ($searchType === 'phone') {
        $stmt = $db->prepare('SELECT * FROM "user" WHERE "phone" = :searchTerm');
    }

    $stmt->bindValue(':searchTerm', $searchTerm);
    $result = $stmt->execute();

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $results[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Поиск</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    <form action="" method="post">
        <label for="searchType">Тип поиска:</label>
        <select id="searchType" name="searchType">
            <option value="lastname">Фамилия</option>
            <option value="phone">Телефон</option>
        </select>
        <br>
        <label for="searchTerm">Поисковый запрос:</label>
        <input type="text" id="searchTerm" name="searchTerm">
        <br>
        <input type="submit" value="Поиск">
    </form>

    <?php if ($searchType && $searchTerm): ?>
        <?php if (count($results) > 0): ?>
            <table>
                <tr>
                    <th>Фамилия</th>
                    <th>Имя</th>
                    <th>Отчество</th>
                    <th>Телефон</th>
                    <th>Адрес</th>
                </tr>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= $row['lastname'] ?></td>
                        <td><?= $row['firstname'] ?></td>
                        <td><?= $row['patronymic'] ?></td>
                        <td><?= $row['phone'] ?></td>
                        <td><?= $row['address'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Пользователи не найдены.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>