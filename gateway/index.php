<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список товаров</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    

    <header>

        <div class="navbar_container">

            <img class="logo" src="icons8-apple-100.svg" alt="">

        </div>

    </header>

<main>

    <div class="main__text">
        Classic Cars and Trucks For Sale
    </div>

 <div class="subtext">
    Find Your Dream Classic Here
 </div>

    <h1>Список товаров</h1>

    <div class="product-container"> <!-- Обертка для карточек товаров -->
<?php
// Подключение к базе данных и получение количества товаров
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gateway";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$items_per_page = 10; // Количество товаров на одной странице

// Получаем общее количество товаров
$total_items_sql = "SELECT COUNT(*) AS total FROM products";
$total_items_result = $conn->query($total_items_sql);
$total_items_row = $total_items_result->fetch_assoc();
$total_items = $total_items_row['total'];

// Вычисляем общее количество страниц
$total_pages = ceil($total_items / $items_per_page);

// Получаем номер текущей страницы
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Вычисляем смещение для LIMIT в SQL-запросе
$offset = ($current_page - 1) * $items_per_page;

// Запрос на получение товаров с учетом пагинации
$sql = "SELECT * FROM products LIMIT $offset, $items_per_page";
$result = $conn->query($sql);

// Вывод карточек товаров


if ($result->num_rows > 0) {
    $counter = 0;
    while($row = $result->fetch_assoc()) {
        echo "<div class='product-card'>";
        echo "<h2>" . $row["name"] . "</h2>";
        echo "<p>Цена: " . $row["price"] . "$</p>";
        echo "<p>Описания: " . $row["description"] . "</p";
        // Отладочный вывод
        echo "<p>Путь к изображению: " . $row["photo_path"] . "</p>";
        echo "<img   src='" . $row["photo_path"] . "' alt='" . $row["name"] . "'>";
        echo "<a href='korzina.php?product_id=" . $row["id"] . "' class='buy-button'>Купить</a>";
        echo "</div>";
    }
} else {
    echo "Нет товаров";
}


// Вывод ссылок для перехода между страницами
echo "<div class='pagination'>";
for ($page=1; $page<=$total_pages; $page++) {
    echo "<a class='page_wrap' href='?page=$page'>$page</a>";
}
echo "</div>";

$conn->close();
?>

</div>
</main>


<footer>

</footer>

</body>
</html>
