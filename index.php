<?php

$connDatabase = new mysqli("localhost", "root", "root", "", "3306");
if ($connDatabase->connect_error) {
    die("Ошибка: " . $connDatabase->connect_error);
}
if (!$connDatabase->query("CREATE DATABASE IF NOT EXISTS dbfinal2")) {
    die("База данных не была создана!");
}
$connTable = new mysqli("localhost", "root", "root", "dbfinal2", "3306");
if ($connTable->connect_error) {
    die("Ошибка: " . $connTable->connect_error);
}
$createTable = "CREATE TABLE IF NOT EXISTS people (surname VARCHAR(30), name VARCHAR(30),  patronymic VARCHAR(30), birth_date DATE, gender BOOLEAN, phone VARCHAR(30), mail VARCHAR(100), height INT, weight FLOAT(1))";
if (!$connTable->query($createTable)) {
    die("Таблица не была создана!");
}
$showAll = "SELECT * FROM people";
if ($connTable->query($showAll)->num_rows === 0) {
    $addInfo = "INSERT INTO people (surname, name, patronymic, birth_date, gender, phone, mail, height, weight) VALUES 
    ('Шошу', 'Алексей', 'Сергеевич', '2003-05-15', 1, '+375295618065', 'aliakseishoshu@gmail.com', 185, 77), 
    ('Попов', 'Андрей', 'Николаевич', '1988-06-25', 1, '+375253255555', 'sometext@mail.ru', 190, 72), 
    ('Головашко', 'Ольга', 'Олеговна', '1995-02-22', 0, '+375256667788', 'moretext@gmail.com', 165, 50)";
    if (!$connTable->query($addInfo)) {
        die("Данные в таблицу не были добавлены!");
    }
}

// получение всех значений

// $showAll = "SELECT * FROM people";
// if($result = $connTable->query($showAll)){
//     echo "<table><tr><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Дата рождения</th><th>Пол</th><th>Телефон</th><th>Почта</th><th>Рост</th><th>Вес</th></tr>";
//     foreach($result as $row){
//         echo "<tr>";
//             echo "<td>" . $row["surname"] . "</td>";
//             echo "<td>" . $row["name"] . "</td>";
//             echo "<td>" . $row["patronymic"] . "</td>";
//             echo "<td>" . $row["birth_date"] . "</td>";
//             echo "<td>" . $row["gender"] . "</td>";
//             echo "<td>" . $row["phone"] . "</td>";
//             echo "<td>" . $row["mail"] . "</td>";
//             echo "<td>" . $row["height"] . "</td>";
//             echo "<td>" . $row["weight"] . "</td>";
//         echo "</tr>";
//     }
//     echo "</table>";
// } else{
//     echo "Ошибка: " . $connTable->error;
// }

// получение одного значения

// $showOne = "SELECT * FROM people WHERE surname='Шошу'";
// if($result = $connTable->query($showOne)){
//     echo "<table><tr><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Дата рождения</th><th>Пол</th><th>Телефон</th><th>Почта</th><th>Рост</th><th>Вес</th></tr>";
//     foreach($result as $row){
//         echo "<tr>";
//             echo "<td>" . $row["surname"] . "</td>";
//             echo "<td>" . $row["name"] . "</td>";
//             echo "<td>" . $row["patronymic"] . "</td>";
//             echo "<td>" . $row["birth_date"] . "</td>";
//             echo "<td>" . $row["gender"] . "</td>";
//             echo "<td>" . $row["phone"] . "</td>";
//             echo "<td>" . $row["mail"] . "</td>";
//             echo "<td>" . $row["height"] . "</td>";
//             echo "<td>" . $row["weight"] . "</td>";
//         echo "</tr>";
//     }
//     echo "</table>";
// } else{
//     echo "Ошибка: " . $connTable->error;
// }

// добавление значения

// $addOne = "INSERT INTO people (surname, name, patronymic, birth_date, gender, phone, mail, height, weight) VALUES ('Лобова', 'Кристина', 'Сергеевна', '2000-02-22', 1, '+375295123265', 'aasdasd@gmail.com', 165, 57)";
// if (!$connTable->query($addOne)) {
//     echo "Ошибка: " . $connTable->error;
// }

// изменение значения

// $updateOne = "UPDATE people SET surname = 'Шереметьев', name = 'Максим', patronymic = 'Дмитриевич', birth_date = '1988-06-12', gender = 1, phone = '+375255555555', mail = 'sdasdad@mail.ru', height = 190, weight = 76.4 WHERE name = 'Кристина'";
// if (!$connTable->query($updateOne)) {
//     echo "Ошибка: " . $connTable->error;
// }

// удаление значения
// $deleteOne = "DELETE FROM people WHERE surname='Шереметьев'";
// if (!$connTable->query($deleteOne)) {
// echo "Ошибка: " . $connTable->error;
// }