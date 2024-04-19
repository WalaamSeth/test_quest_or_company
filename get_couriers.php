<?php
$servername = "127.0.0.1:3306";
$username = "root";
$password = "Nexion21866611";
$dbname = "test_quest_db";

// Создаю соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяю соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Запрос к базе данных для получения списка курьеров
$sql = "SELECT id, name FROM couriers";
$result = $conn->query($sql);

// Если есть результаты, вывожу их в виде опций выпадающего списка
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    }
} else {
    echo "<option value=''>Нет доступных курьеров</option>";
}

// Закрываю соединение с базой данных
$conn->close();
?>