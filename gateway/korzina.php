<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gateway";

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получаем идентификатор товара из параметра запроса
$product_id = isset($_GET["product_id"]) ? $_GET["product_id"] : null;

// Выполняем SQL запрос для получения информации о товаре
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

// Проверяем, есть ли результаты
if ($result->num_rows > 0) {
    // Выводим данные о товаре
    $row = $result->fetch_assoc();
    echo "<h1>Покупка товара: " . $row["name"] . "</h1>";
    echo "<p>Цена: $" . $row["price"] . "</p>";
    echo "<p>Описание: " . $row["description"] . "</p>";
    echo "<p>stock: " . $row["stock"] . "</p>";
    echo "<p>year: " . $row["year"] . "</p>";
    echo "<p>Make_Model: " . $row["Make_Model"] . "</p>";
    echo "<p>Submodel_Trim: " . $row["Submodel_Trim"] . "</p>";
    echo "<p>Engine: " . $row["Engine"] . "</p>";
    echo "<p>Transmission: " . $row["Transmission"] . "</p>";
    echo "<p>Exterior_Color: " . $row["Exterior_Color"] . "</p>";
    echo "<p>Odometer_Reading: " . $row["Odometer_Reading"] . "</p>";

  // Здесь можно добавить форму для покупки товара
?>
   <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
        <label for="customer_name">Ваше имя:</label><br>
        <input type="text" id="customer_name" name="customer_name" required><br>
        <label for="customer_email">Ваш Email:</label><br>
        <input type="email" id="customer_email" name="customer_email" required><br>
        <label for="customer_message">Сообщение:</label><br>
        <textarea id="customer_message" name="customer_message" rows="4" required></textarea><br>
        <input type="submit" value="Заказать">
    </form>
<?php
} else {
    echo "Товар не найден.";
}

// Обработка отправки формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $product_name = $_POST['product_name'];
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_message = $_POST['customer_message'];

    // Отправка электронной почты
    $to = "your_email@example.com"; // Замените на ваш адрес электронной почты
    $subject = "Заказ товара: $product_name";
    $message = "Покупатель: $customer_name\n";
    $message .= "Email покупателя: $customer_email\n";
    $message .= "Сообщение от покупателя:\n$customer_message";
    $headers = "From: $customer_email";

    // Отправляем письмо
    if (mail($to, $subject, $message, $headers)) {
        echo "<p>Спасибо за ваш заказ. Мы свяжемся с вами в ближайшее время.</p>";
    } else {
        echo "<p>Произошла ошибка при отправке заказа. Пожалуйста, попробуйте еще раз позже.</p>";
    }
}
// Закрываем соединение с базой данных
$conn->close();
?>



