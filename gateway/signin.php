<?php
session_start();

// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = ""; // Укажите ваш пароль для доступа к базе данных
$dbname = "gateway"; // Укажите имя вашей базы данных

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверка учетных данных в базе данных
    $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Неверное имя пользователя или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в админ панель</title>
</head>
<body>
    <h1>Вход в админ панель</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Имя пользователя:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Войти">
    </form>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
</body>
</html>

<?php
// Закрываем соединение с базой данных
$conn->close();
?>
