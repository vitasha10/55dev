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
    if($_COOKIE['userid']!=1){
        echo '<meta http-equiv="refresh" content="0;URL=/error1">';
    }

    //######################################################################################################
    //##################@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@#########################
    //######################################################################################################
    //Если переменная Name передана
    if (isset($_POST["name1"])) {
        //Если это запрос на обновление, то обновляем
        if (isset($_GET['red_id'])) {
            $sql = mysqli_query($link, "UPDATE `peoples` SET `name` = '{$_POST['name1']}',`pass` = '{$_POST['pass1']}',`priv` = '{$_POST['priv1']}', `ava` = '{$_POST['ava1']}' WHERE `userid`={$_GET['red_id']}");
        } else {
            //Иначе вставляем данные, подставляя их в запрос
            $sql = mysqli_query($link, "INSERT INTO `peoples` (`name`, `pass`, `priv`, `ava`) VALUES ('{$_POST['name1']}', '{$_POST['pass1']}', '{$_POST['priv1']}', '{$_POST['ava1']}')");
        }
        
        //Если вставка прошла успешно
        if ($sql) {
        echo '<p>Успешно!</p>';
        } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
        }
    }
    
    if (isset($_GET['del_id'])) { //проверяем, есть ли переменная
      //удаляем строку из таблицы
      $sql = mysqli_query($link, "DELETE FROM `peoples` WHERE `userid` = {$_GET['del_id']}");
      if ($sql) {
        echo "<p>Участник удален.</p>";
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
      }
    }
    $product="";
    //Если передана переменная red_id, то надо обновлять данные. Для начала достанем их из БД
    if (isset($_GET['red_id'])) {
      $sql = mysqli_query($link, "SELECT `userid`, `name`, `pass`, `priv`, `ava` FROM `peoples` WHERE `userid`={$_GET['red_id']}");
      $product = mysqli_fetch_array($sql);
    }
    ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>УЧАСТНИКИ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <form action="" method="post">
    <table>
      <tr>
        <td>Имя, Фамилия:</td>
        <td><input type="text" name="name1" value="<?= $product['name']; ?>"></td>
      </tr>
      <tr>
        <td>Пароль:</td>
        <td><input type="text" name="pass1" value="<?= $product['pass']; ?>"></td>
      </tr>
      <tr>
        <td>Привилегия:</td>
        <td><input type="text" name="priv1" value="<?= $product['priv']; ?>"></td>
      </tr>
      <tr>
        <td>Аватарка:</td>
        <td><input type="text" name="ava1" value="<?= $product['ava']; ?>"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" value="OK"></td>
      </tr>
    </table>
    </form>
    <table border='1'>
    <tr>
      <td>Имя, Фамилия</td></td>
      <td>Пароль</td>
      <td>Привилегия</td>
      <td>Аватарка</td>
      <td>Удаление</td>
      <td>Редактирование</td>
    </tr>
    <?php
      $sql = mysqli_query($link, 'SELECT `userid`, `name`, `pass`, `priv`, `ava` FROM `peoples`');
      while ($result = mysqli_fetch_array($sql)) {
        echo '<tr>' .
             "<td>{$result['name']}</td>" .
             "<td>{$result['pass']}</td>" .
             "<td>{$result['priv']}</td>" .
             "<td>{$result['ava']}</td>" .
             "<td><a href='?del_id={$result['userid']}'>Удалить</a></td>" .
             "<td><a href='?red_id={$result['userid']}'>Изменить</a></td>" .
             '</tr>';
      }
    ?>
    </table>
</body>
</html>