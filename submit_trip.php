<?php
$servername = "127.0.0.1";
$username = "root";
$password = "Nexion21866611";
$dbname = "test_quest_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$region = $_POST['region'];
$departureDate = $_POST['departureDate'];
$courier = $_POST['courier'];

$stmt = $conn->prepare("SELECT * FROM trips WHERE courier_id = ? AND departure_date = ?");
$stmt->bind_param("ss", $courier, $departureDate);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Ошибка: Курьер уже отправлен в этот регион на указанную дату!";
} else {

    $stmt = $conn->prepare("SELECT travel_duration FROM regions WHERE id = ?");
    $stmt->bind_param("s", $region);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $travelDuration = $row['travel_duration'];

    $arrivalDate = date('Y-m-d', strtotime($departureDate . ' + ' . $travelDuration . ' days'));

    $stmt = $conn->prepare("INSERT INTO trips (courier_id, region_id, departure_date, arrival_date)
                            VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $courier, $region, $departureDate, $arrivalDate);
    if ($stmt->execute()) {
        echo "Поездка успешно добавлена!";
    } else {
        echo "Ошибка: " . $stmt->error;
    }
}

// Закрытие соединения
$stmt->close();
$conn->close();
?>