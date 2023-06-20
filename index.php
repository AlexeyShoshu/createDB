<?php

$connDatabase = new mysqli("localhost", "root", "root", "", "3306");
if ($connDatabase->connect_error) {
    die("Ошибка: " . $connDatabase->connect_error);
}
if (!$connDatabase->query("CREATE DATABASE IF NOT EXISTS db")) {
    die("База данных не была создана!");
}
$connTable = new mysqli("localhost", "root", "root", "db", "3306");
if ($connTable->connect_error) {
    die("Ошибка: " . $connTable->connect_error);
}
$createTable = "CREATE TABLE IF NOT EXISTS people (surname VARCHAR(30), name VARCHAR(30),  patronymic VARCHAR(30), birth_date DATE, gender BOOLEAN, phone VARCHAR(30), mail VARCHAR(100), height INT, weight FLOAT(1))";
if (!$connTable->query($createTable)) {
    die("Таблица не была создана!");
}

$showAll = "SELECT * FROM people";

$surname = 'Прохоров';
$name = 'Игорь';
$patronymic = 'Андреевич';
$birth_date = '1988-08-12'; // перевод введеной даты в тип sql
$gender = 1; // отображение пола для людей если запрашивается
$phone = '+375294447744'; // проверка белорусского телефона
$mail = 'prohor@gmail.com'; // проверка мэйла
$height = 180;
$weight = 77.2;

function addFirstInfo($connTable, $showAll)
{
    if ($connTable->query($showAll)->num_rows === 0) {
        $addInfo = "INSERT INTO people (surname, name, patronymic, birth_date, gender, phone, mail, height, weight) VALUES 
        ('Шошу', 'Алексей', 'Сергеевич', '2003-05-15', 1, '+375295618065', 'aliakseishoshu@gmail.com', 185, 77), 
        ('Попов', 'Андрей', 'Николаевич', '1988-06-25', 1, '+375253255555', 'sometext@mail.ru', 190, 72), 
        ('Головашко', 'Ольга', 'Олеговна', '1995-02-22', 0, '+375256667788', 'moretext@gmail.com', 165, 50)";
        if (!$connTable->query($addInfo)) {
            die("Данные в таблицу не были добавлены!");
        }
    }
}

function showInfo($result)
{
    echo "<table><tr><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Дата рождения</th><th>Пол</th><th>Телефон</th><th>Почта</th><th>Рост</th><th>Вес</th></tr>";
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row["surname"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["patronymic"] . "</td>";
        echo "<td>" . $row["birth_date"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "<td>" . $row["phone"] . "</td>";
        echo "<td>" . $row["mail"] . "</td>";
        echo "<td>" . $row["height"] . "</td>";
        echo "<td>" . $row["weight"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function showAllTables($connTable, $showAll)
{
    if ($result = $connTable->query($showAll)) {
        showInfo($result);
    } else {
        echo "Ошибка: " . $connTable->error;
    }
}

function showRow($connTable)
{
    $showOne = "SELECT * FROM people WHERE surname='Шошу'"; // динамический выбор
    if ($result = $connTable->query($showOne)) {
        showInfo($result);
    } else {
        echo "Ошибка: " . $connTable->error;
    }
}

function addInfo($surname, $name, $patronymic, $birth_date, $gender, $phone, $mail, $height, $weight, $connTable) 
{
    $addOne = "INSERT INTO people (surname, name, patronymic, birth_date, gender, phone, mail, height, weight) VALUES ('{$surname}', '{$name}', '{$patronymic}', '{$birth_date}', {$gender}, '{$phone}', '{$mail}', {$height}, {$weight})";
    if (!$connTable->query($addOne)) {
        echo "Ошибка: " . $connTable->error;
    }
}

function updateInfo($surname, $name, $patronymic, $birth_date, $gender, $phone, $mail, $height, $weight, $connTable) // динамическое обновление не всей информации
{
    $updateOne = "UPDATE people SET surname = '{$surname}', name = '{$name}', patronymic = '{$patronymic}', birth_date = '{$birth_date}', gender = {$gender}, phone = '{$phone}', mail = '{$mail}', height = {$height}, weight = {$weight} WHERE name = 'Андрей'";
    if (!$connTable->query($updateOne)) {
        echo "Ошибка: " . $connTable->error;
    }
}

function deleteInfo($surname, $connTable) // удаление одного а не нескольких (привзяка по ID -> добавление переменной выбора ID -> проверка ID или его вытягивание?)
{
    $deleteOne = "DELETE FROM people WHERE surname='{$surname}'";
    if (!$connTable->query($deleteOne)) {
        echo "Ошибка: " . $connTable->error;
    }
}

function findInfo($connTable)
{
    $findInfo = "SELECT * FROM people WHERE phone LIKE '+375295618065'"; // универсальность поиска
    if ($result = $connTable->query($findInfo)) {
        showInfo($result);
    } else {
        echo "Ошибка: " . $connTable->error;
    }
}

addFirstInfo($connTable, $showAll);
showAllTables($connTable, $showAll);
// showRow($connTable);
// addInfo($surname, $name, $patronymic, $birth_date, $gender, $phone, $mail, $height, $weight, $connTable);
// updateInfo($surname, $name, $patronymic, $birth_date, $gender, $phone, $mail, $height, $weight, $connTable);
// deleteInfo($surname, $connTable);
// findInfo($connTable);

