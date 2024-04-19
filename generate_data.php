<?php
//Это скрипт для заполнения базы данных
$servername = "127.0.0.1:3306";
$username = "root";
$password = "Nexion21866611";
$dbname = "test_quest_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Заполненяю таблицы regions
$regions = [
    'Санкт-Петербург',
    'Уфа',
    'Нижний Новгород',
    'Владимир',
    'Кострома',
    'Екатеринбург',
    'Ковров',
    'Воронеж',
    'Самара',
    'Астрахань'
];

foreach ($regions as $region) {
    $sql = "INSERT INTO regions (name) VALUES ('$region')";
    if ($conn->query($sql) === FALSE) {
        echo "Ошибка: " . $conn->error;
    }
}

echo "Данные о регионах успешно добавлены в таблицу regions";

// Создание массива ФИО курьеров и вставка данных о курьерах в таблицу couriers
$couriers = [];
for ($i = 0; $i < 10; $i++) { // Генерирую 10 случайных ФИО курьеров и добавляю их в базу данных
    $name = generateRandomFullName();
    $sql = "INSERT INTO couriers (name) VALUES ('$name')";
    if ($conn->query($sql) === FALSE) {
        echo "Ошибка: " . $conn->error;
    }
    $couriers[] = $conn->insert_id; // Сохраняю идентификаторы добавленных курьеров
}

echo "Данные о курьерах успешно добавлены в таблицу couriers";

// Длительность поездки в днях (рандомное значение от 1 до 5)
$travelDurations = [1, 2, 3, 4, 5];

// Генерация случайных поездок за последние 3 месяца
for ($i = 0; $i < 100; $i++) { // 100 случайных поездок
    $randomCourier = $couriers[array_rand($couriers)]; // Выбираю случайного курьера из массива
    $randomRegion = $regions[array_rand($regions)];
    $randomDepartureDate = date('Y-m-d', strtotime("-" . rand(0, 90) . " days")); // Случайная дата за последние 3 месяца
    $randomTravelDuration = $travelDurations[array_rand($travelDurations)];
    $randomArrivalDate = date('Y-m-d', strtotime($randomDepartureDate . ' + ' . $randomTravelDuration . ' days'));

// Вставка данных в базу данных
    $sql = "INSERT INTO trips (courier_id, region_id, departure_date, arrival_date)
VALUES ('$randomCourier', (SELECT id FROM regions WHERE name = '$randomRegion'), '$randomDepartureDate', '$randomArrivalDate')";
    if ($conn->query($sql) === FALSE) {
        echo "Ошибка: " . $conn->error;
    }
}

echo "Данные успешно добавлены в базу данных";

// Закрытие соединения с базой данных
$conn->close();

// Функция для генерации случайного ФИО
function generateRandomFullName()
{
    $firstNames = ['Иван', 'Петр', 'Александр', 'Михаил', 'Андрей', 'Сергей', 'Дмитрий', 'Алексей', 'Владимир', 'Николай'];
    $lastNames = ['Иванов', 'Петров', 'Сидоров', 'Кузнецов', 'Смирнов', 'Попов', 'Федоров', 'Морозов', 'Волков', 'Лебедев'];
    $patronymics = ['Иванович', 'Петрович', 'Александрович', 'Михайлович', 'Андреевич', 'Сергеевич', 'Дмитриевич', 'Алексеевич', 'Владимирович', 'Николаевич'];
    $randomFirstName = $firstNames[array_rand($firstNames)];
    $randomLastName = $lastNames[array_rand($lastNames)];
    $randomPatronymic = $patronymics[array_rand($patronymics)];
    return $randomFirstName . ' ' . $randomPatronymic . ' ' . $randomLastName;
}

?>