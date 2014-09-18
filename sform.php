
<?php

if (isset($_GET['name'])) {
    
    $input = $_GET['name'];
    
    $inputTxt = isset($_GET['content']) ? $_GET['content'] : 'Текст не введен :(';
    
    $input.= $inputTxt;
    
    header('Content-Type: text/html; charset=utf-8');
    
    printf('Hello %s', htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
} else {
?>

<html>
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <form method="get" action="">
        <label>Имя</label><input type="text" name="name" /><br>
        <label>Текст</label><textarea name="content"></textarea>
        <input type="submit" />
        </form>
    </body>
</html>

<?php
}