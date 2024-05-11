<?php
$db = new SQLite3('database.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

// Пользователи
$db->query('CREATE TABLE IF NOT EXISTS "user" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "firstname" VARCHAR,
    "lastname" VARCHAR,
    "patronymic" VARCHAR,
    "phone" VARCHAR,
    "address" VARCHAR
)');

// Администраторы БД
$db->query('CREATE TABLE IF NOT EXISTS "admin" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "login" VARCHAR,
    "password" VARCHAR
)');

// Добавление администратора по умолчанию
$db->query('INSERT INTO "admin" ("login", "password") VALUES ("admin", "admin")');
?>