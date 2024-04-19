<?php

$servername = "127.0.0.1:3306";
$username = "root";
$password = "Nexion21866611";
$dbname = "test_quest_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получение даты поездки из запроса
$tripDate = $_GET['tripDate'];

// запрос для выборки поездок по указанной дате
$sql = "SELECT * FROM trips WHERE DATE(departure_date) = '$tripDate'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>Курьер: " . $row['courier_id'] . ", Регион: " . $row['region_id'] . ", Дата отправления: " . $row['departure_date'] . ", Дата прибытия: " . $row['arrival_date'] . "</p>";
    }
} else {
    echo "Поездок на указанную дату не найдено.";
}

$conn->close();
?>