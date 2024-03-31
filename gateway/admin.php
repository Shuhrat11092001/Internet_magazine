<?php
session_start(); // Начинаем сессию
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

// Проверка авторизации пользователя
if (!isset($_SESSION['admin'])) {
    header("Location: signin.php");
    exit();
}


// Выполнение запроса к базе данных для получения товаров
$sql = "SELECT * FROM products";
$result = $conn->query($sql);


// Закрываем подключение
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Административная панель</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Административная панель</h1>
     <!-- Форма для добавления карточки товара -->
     <form id="addProductForm" enctype="multipart/form-data">
        <label for="name">Название товара:</label>
        <input type="text" id="name" name="name" required><br>
        
        <label for="price">Цена:</label>
        <input type="text" id="price" name="price" required><br>

        <label for="description">Описания:</label>
        <Input type="text" id="description" name="description" required><br>

        <label for="characteristics">Характеристики:</label>
        <input type= "text" id="stock" name="stock" required><br>
        <input type= "text" id= "year" name="year" required> <br>
        <input type= "text" id= "Make_Model" name="Make_Model" required> <br>
        <input type= "text" id= "Submodel_Trim" name="Submodel_Trim" required><br>
        <input type= "text" id= "Engine" name="Engine" required> <br>
        <input type= "text" id= "Transmission" name="Transmission" required> <br>
        <input type= "text" id="Exterior_Color" name="Exterior_Color" required> <br>
        <input type= "text" id="Interior_Color" name="Interior_Color" required> <br>
        <input type= "text" id= "Odometer_Reading" name="Odometer_Reading" required> <br>
        <label for="photo">Фотография:</label>
        <input type="file" id="photo" name="photo" accept="image/*"><br>
        
        <input type="button" id="addProductBtn" value="Добавить товар">
    </form>

    <!-- Формы для редактирования и удаления товаров будут здесь -->

    <div class="product-container">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='product-card'>";
                echo "<h2>" . $row["name"] . "</h2>";
                echo "<p>Описания: " . $row["description"] . "</p>";
                echo "<p>Цена: " . $row["price"] ."$ </p>";
                // Отображение изображения товара
                echo "<img src='" . $row["photo_path"] . "' alt='" . $row["name"] . "'>";
                // Кнопка удаления товара
                echo "<form action='delete_product.php' method='post'>";
                echo "<input type='hidden' name='product_id' value='" . $row["id"] . "'>";
                echo "<input type='submit' value='Удалить'>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-products'>Нет товаров</p>";
        }
        ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="admin.js"></script>


    </div>
</body>
</html>
