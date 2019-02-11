<?php
    /* Подключение к БД и установка кодировки */
    $db = new PDO('mysql:host=localhost;dbname=intervolga', 'root', '');
    $db->exec("SET NAMES UTF8");

    $message = ''; // Сообщение об ошибках
    
    if(count($_POST) > 0){
        /* Проверка введенных данных */
        $name = check_string($_POST['name']);
        $population = check_string($_POST['population']);
        $currency = check_string($_POST['currency']);
        
        if($name == '' || $population == '' || $currency == ''){
            $message .= "Заполните все поля";
        }
        if(strlen($name) > 50 || strlen($currency) > 50){
            $message .= "Очень длинное название";
        }
        
        /* Подготовленный запрос */
        $query = $db->prepare("INSERT INTO countries (country_name, country_population, country_currency) VALUES (:name, :population, :currency)");
        $params = ['name' => $name, 'population' => $population, 'currency' => $currency];
        $query->execute($params);
        header('Location: index.php');
        exit;
    }
    
    /* Вывод стран из БД и запись их в массив */
    $query = $db->prepare("SELECT country_name, country_population, country_currency FROM countries");
    $query->execute();
    $countries = $query->fetchAll();
    
    if(count($countries) == 0){
        $message = "Вы еще не добавили ни одной страны.";
    }
    
    /* Проверка строк на спец-символы и лишние пробелы */
    function check_string($var) {
        $var = trim($var);
        $var = htmlspecialchars($var);
        return $var;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title> Задание 4 </title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div id="maininfo">
            <h2>Список стран</h2>
            <?php if($message != ''): ?>
                <div class="message"><?=$message?></div>
            <?php else: ?>
                <table>
                    <tr>
                        <th>Страна</th><th>Население</th><th>Валюта</th>
                    </tr>
                    <?php foreach($countries as $one): ?>
                        <tr>
                            <td><?=$one['country_name']?></td>
                            <td><?=$one['country_population']?></td>
                            <td><?=$one['country_currency']?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
            <a class="btn-add" href="#add">Добавить страну</a>
            
            <div id="text" style="display: none;">
                <form class="form" action="index.php" method="post">
                    <div class="line">
                        <span class="title">Название</span>
                        <input type="text" name="name" class="inp">
                    </div>
                    <div class="line">
                        <span class="title">Население</span>
                        <input type="text" name="population" class="inp">
                    </div>
                    <div class="line">
                        <span class="title">Валюта</span>
                        <input type="text" name="currency" class="inp">
                    </div>
                    <input type="submit" class="btn-submit">
                </form>
            </div>
        </div>
        <script src="jquery-3.3.1.min.js"></script>
        <script src="jquery.validate.js"></script>
        <script src="script.js"></script>
    </body>
</html>