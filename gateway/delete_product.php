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

// Получение идентификатора удаляемого товара из формы
$product_id = $_POST['product_id'];

// SQL запрос для удаления товара из базы данных
$sql = "DELETE FROM products WHERE id = $product_id";

if ($conn->query($sql) === TRUE) {
    echo "Товар успешно удален";
} else {
    echo "Ошибка при удалении товара: " . $conn->error;
}

$conn->close();
?>
