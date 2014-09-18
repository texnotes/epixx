
<?php
if (isset($_GET['content'])) {
    
    $input = $_GET['content'];
    
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    
    $inputTxt = isset($_GET['func']) ? $_GET['func'] : '1';
    
    if ($input !== '' && $inputTxt === '1') {
        $message = "Количество слов с четным количеством символов: " . ModTwo($input);
    } elseif ($input !== '' && $inputTxt === '2') {
        $message = "Количество слов: " . StrCount($input);
    } elseif ($input !== '' && $inputTxt === '3') {
        $message = "Результат: " . StrUper($input);
    } elseif ($input !== '' && $inputTxt === '4') {
        $message = "4++";
    } elseif ($input !== '' && $inputTxt === '5') {
        $message = "5++";
    } else $message = "Неверные данные. Повторите ввод.";
    
    header('Content-Type: text/html; charset=utf-8');
    
    printf('Hello: %s', htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));
} else {
?>

<html>
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <form method="get" action="">
        <label>Текст</label><textarea name="content"></textarea><br>
      <select name="func">
        <option value="1">Количество слов с четным количеством символов</option>
        <option value="2">Количество слов</option>
        <option value="3">Каждый второй символ слова строки приводим к верхнему регистру</option>
        <option value="4">Перемешиваем в каждом слове все символы в случайном порядке кроме первого и последнего</option>
        <option value="5">Найти имя файла без расширения</option>
      </select><br> 
        <input type="submit" />
        </form>
    </body>
</html>

<?php
}

function ModTwo($stringMy) {
    
    $arr2 = explode(' ', $stringMy);
    
    $count = 0;
    
    foreach ($arr2 as $value) {
        
        if ($value !== '' && (mb_strlen($value, "UTF-8") % 2) === 0) $count++;
    }
    return $count;
}

function StrCount($stringMy) {
    
    $arr2 = explode(' ', $stringMy);
    
    $count = 0;
    
    foreach ($arr2 as $value) {
        
        if ($value !== '') $count++;
    }
    return $count;
}

function StrUper($stringMy) {
    
    $arr2 = explode(' ', $stringMy);
    
    $count = 0;
    
    foreach ($arr2 as $key => $value) {
        
        if ($value !== '') {
            $value{1} = mb_strtoupper($value{1}, 'UTF-8');
            $arr2[$key] = $value;
        }
    }
    $stringMy = implode(' ', $arr2);
    return $stringMy;
}
