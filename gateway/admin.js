$(document).ready(function() {
    // Обработчик нажатия на кнопку добавления товара
    $("#addProductBtn").click(function() {
        var formData = new FormData($("#addProductForm")[0]);
        $.ajax({
            url: "add_product.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response); // Выводим сообщение об успешном добавлении (можно изменить на обновление карточек товаров)
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });

    // Обработчик нажатия на кнопку удаления товара
    $(".deleteProductBtn").click(function() {
        var productId = $(this).data("product-id");
        $.ajax({
            url: "delete_product.php",
            type: "POST",
            data: { product_id: productId },
            success: function(response) {
                // Выводим сообщение об успешном удалении
                alert(response);
                // Перезагружаем карточки товаров после удаления
                loadProducts();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });

    // Функция для загрузки карточек товаров после операций добавления/удаления
    function loadProducts() {
        $.ajax({
            url: "load_products.php", // Скрипт, который возвращает карточки товаров
            type: "GET",
            success: function(response) {
                $("#productContainer").html(response); // Обновляем содержимое контейнера с карточками товаров
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
});



