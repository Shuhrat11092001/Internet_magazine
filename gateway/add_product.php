<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gateway";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из формы
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$year = $_POST['year'];
$Make_Model = $_POST['Make_Model'];
$Submodel_Trim = $_POST['Submodel_Trim'];
$Engine = $_POST['Engine'];
$Transmission = $_POST['Transmission'];
$Exterior_Color = $_POST['Exterior_Color'];
$Interior_Color = $_POST['Interior_Color'];
$Odometer_Reading = $_POST['Odometer_Reading'];

$upload_directory = "uploads/";

// Проверяем существует ли папка, если нет, то создаем
if (!file_exists($upload_directory)) {
    mkdir($upload_directory, 0777, true); // Создаем папку с правами на запись
}

$photo_path = "uploads/" . basename($_FILES["photo"]["name"]);
move_uploaded_file($_FILES["photo"]["tmp_name"], $photo_path);

// Запрос на добавление товара в базу данных
$sql = "INSERT INTO products (name, price, description, photo_path, stock, year, Make_Model, Submodel_Trim, Engine, Transmission, Exterior_color, Interior_Color, Odometer_Reading) 
VALUES ('$name', '$price', '$description', '$photo_path', '$stock', '$year', '$Make_Model', '$Submodel_Trim', '$Engine', '$Transmission', '$Exterior_Color', '$Interior_Color','$Odometer_Reading')";

if ($conn->query($sql) === TRUE) {
    echo "Товар успешно добавлен";
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
