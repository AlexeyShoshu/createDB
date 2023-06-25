<?php

$connDatabase = new mysqli("localhost", "root", "root", "", "3306");
if ($connDatabase->connect_error) {
    die("Ошибка: " . $connDatabase->connect_error);
}
if (!$connDatabase->query("CREATE DATABASE IF NOT EXISTS db1231234")) {
    die("База данных не была создана!");
}
$connTable = new mysqli("localhost", "root", "root", "db1231234", "3306");
if ($connTable->connect_error) {
    die("Ошибка: " . $connTable->connect_error);
}
$createTable = "CREATE TABLE IF NOT EXISTS people (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, surname VARCHAR(30), name VARCHAR(30),  patronymic VARCHAR(30), birth_date DATE, gender BOOLEAN, phone VARCHAR(30), mail VARCHAR(100), height INT, weight FLOAT(1))";
if (!$connTable->query($createTable)) {
    die("Таблица не была создана!");
}

$showAll = "SELECT * FROM people";

$id = 6;
$findParameter = 'phone';
$findValue = '+375295618065';
$showRowParameter = 'name';
$showRowValue = 'Алексей';
$surname = 'Прохоров';
$name = 'Игорь';
$patronymic = 'Андреевич';
$birth_date = date("Y-m-d", strtotime('19.12.2003'));
$gender = 1; 
$phone = '+375294447744'; 
$phonePattern = '/^(\+375|80)(29|25|44|33)(\d{7})$/i';
$mail = 'prohor@gmail.com';
$height = 180;
$weight = 77.2;

$surnameNew = 'Ношгм';
$nameNew = '';
$patronymicNew = '';
$birth_dateNew = date("Y-m-d", strtotime('22.12.2022'));
$genderNew = 0;
$phoneNew = '+375295555555'; 
$mailNew = 'prohor555@gmail.com';
$heightNew = '';
$weightNew = 100.2;
$newStringsArray = ['surname' => $surnameNew, 'name' => $nameNew, 'patronymic' => $patronymicNew, 'birth_date' => $birth_dateNew, 'phone' => $phoneNew, 'mail' => $mailNew];
$newIntegersArray = ['gender' => $genderNew, 'height' => $heightNew, 'weight' => $weightNew];

if ((!filter_var($mail, FILTER_VALIDATE_EMAIL)) || (!filter_var($mailNew, FILTER_VALIDATE_EMAIL))) {
    die("Неверно указана почта!");
}

if ((!preg_match($phonePattern, $phone)) || (!preg_match($phonePattern, $phoneNew))) {
    die("Номер телефона не соответствует формату!");
}

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
    echo "<table><tr><th>ID</th><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Дата рождения</th><th>Пол</th><th>Телефон</th><th>Почта</th><th>Рост</th><th>Вес</th></tr>";
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["surname"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["patronymic"] . "</td>";
        echo "<td>" . $row["birth_date"] . "</td>";
        if ($row["gender"] == 0) {
            echo "<td>" . 'ж' . "</td>"; 
        } elseif ($row["gender"] == 1) {
            echo "<td>" . 'м' . "</td>"; 
        } else {
            var_dump($row["gender"]);
            die('Неверно введен пол в таблицу!');
        }
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

function showRow($connTable, $showRowParameter, $showRowValue)
{
    $showOne = "SELECT * FROM people WHERE {$showRowParameter} ='{$showRowValue}'";
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

function updateInfo($newStringsArray, $newIntegersArray, $connTable, $id) // динамическое обновление не всей информации -> новые переменные и их проверка с массивом??
{
    foreach ($newStringsArray as $key => $value) {
        if (!empty($value)) {
            $updateOne = "UPDATE people SET {$key} = '{$value}'  WHERE id = {$id}";
            if (!$connTable->query($updateOne)) {
                echo "Ошибка: " . $connTable->error;
            }
        }
    }
    foreach ($newIntegersArray as $key => $value) {
        if (!empty($value)) {
            $updateOne = "UPDATE people SET {$key} = {$value}  WHERE id = {$id}";
            if (!$connTable->query($updateOne)) {
                echo "Ошибка: " . $connTable->error;
            }
        }
    }
}

function deleteInfo($id, $connTable)
{
    $deleteOne = "DELETE FROM people WHERE id = {$id}";
    if (!$connTable->query($deleteOne)) {
        echo "Ошибка: " . $connTable->error;
    }
}

function findInfo($findParameter, $findValue, $connTable)
{
    if (gettype($findValue) === "string") {
        $findInfo = "SELECT * FROM people WHERE {$findParameter} LIKE '{$findValue}'";
    } else {
        $findInfo = "SELECT * FROM people WHERE {$findParameter} LIKE {$findValue}";
    }
    if ($result = $connTable->query($findInfo)) {
        showInfo($result);
    } else {
        echo "Ошибка: " . $connTable->error;
    }
}

addFirstInfo($connTable, $showAll);
showAllTables($connTable, $showAll);
// showRow($connTable, $showRowParameter, $showRowValue);
// addInfo($surname, $name, $patronymic, $birth_date, $gender, $phone, $mail, $height, $weight, $connTable);
// updateInfo($newStringsArray, $newIntegersArray, $connTable, $id);
// deleteInfo($id, $connTable);
// findInfo($findParameter, $findValue, $connTable);
