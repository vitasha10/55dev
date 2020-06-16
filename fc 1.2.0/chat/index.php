<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>55developments</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php
    if(!isset($_COOKIE['userid'])){
        echo '<meta http-equiv="refresh" content="0;URL=/login">';
    }
    $host = 'localhost';  // Хост, у нас все локально
    $user = 'j92230e0_root';    // Имя созданного вами пользователя
    $pass = 'rootroot'; // Установленный вами пароль пользователю
    $db_name = 'j92230e0_root';   // Имя базы данных
    $link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой
    
    // Ругаемся, если соединение установить не удалось
    if (!$link) {
      echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
      exit;
    }
    
    date_default_timezone_set('Asia/Yekaterinburg');
    $date=date("20y-m-d H:i:s");
    
    
    if (isset($_POST["text"])) {
      //Если это запрос на обновление, то обновляем
      //Иначе вставляем данные, подставляя их в запрос
      $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$_POST['text']}', '{$date}')");

    
    }
    
    
    ?>
    <form action='' method='post'>
    <table>
      <tr>
        <td>Сообщение:</td>
        <td><input class='btn' type='text' name='text' value=''></td>
      </tr>
      <tr>
        <td colspan='2'><input class='btn' type='submit' value='OK'></td>
      </tr>
    </table>
    </form>
    <table border='1'>
        
    <table>
    <tr>
      <td>Ава</td>
      <td>Пользователь</td>
      <td>Сообщение</td>
      <td>Дата</td>
    </tr>
    <?php
      $sql = mysqli_query($link, 'SELECT `ID`, `user`, `text`, `date` FROM `chat`');
      $result2 = mysqli_fetch_array($sql);
      $sql1 = mysqli_query($link, "SELECT `name`,`ava` FROM `peoples` WHERE `peoples`.`userid`='{$result2['user']}'");
      $result1 = mysqli_fetch_array($sql1);
      while ($result = mysqli_fetch_array($sql)) { 
        echo '<tr>' .
             "<td><img class='logo2' src='{$result1['ava']}' alt='ava'>
            </td>".
             "<td>{$result1['name']}</td>" .
             "<td>{$result['text']}</td>" .
             "<td>{$result['date']}</td>" .
             '</tr>';
      }
    ?>
    </table>
</body>
</html