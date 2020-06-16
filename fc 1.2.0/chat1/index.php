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
    
    date_default_timezone_set('Asia/Yekaterinburg');
    $date=date("20y-m-d H:i:s");
    // Ругаемся, если соединение установить не удалось
    if (!$link) {
      echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
      exit;
    }
    
    
    //djjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj
    if (isset($_POST["text"])) {
      //Если это запрос на обновление, то обновляем
      //Иначе вставляем данные, подставляя их в запрос
      $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$_POST['text']}', '{$date}')");

    
    }
    
    //{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{{
    if(isset($_POST["light"])){
        $sql = mysqli_query($link, "UPDATE `peoples` SET `style` = '1' WHERE `userid`={$_COOKIE['userid']}");
    }
    
    if(isset($_POST["night"])){
        $sql = mysqli_query($link, "UPDATE `peoples` SET `style` = '2' WHERE `userid`={$_COOKIE['userid']}");
    }
    //}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}
    $sql = mysqli_query($link, "SELECT `style` FROM `peoples` WHERE `userid`={$_COOKIE['userid']}");
    $fff = mysqli_fetch_array($sql);
    if($fff["style"]==1){
        echo'<link rel="stylesheet" href="style.css" type="text/css">';
    }else{
        echo'<link rel="stylesheet" href="night.css" type="text/css">';
    }
    //DJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJ
    if (isset($_POST["pass2"])) {
            $sql = mysqli_query($link, "UPDATE `peoples` SET `name`='{$_POST['name2']}', `pass` = '{$_POST['pass2']}', `ava` = '{$_POST['ava1']}' WHERE `userid`={$_COOKIE['userid']}");
    }
    //hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
    //jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj
    //kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk
    if (isset($_POST["name1"])) {
        //Если это запрос на обновление, то обновляем
        if (isset($_GET['red_id'])) {
            $sql = mysqli_query($link, "UPDATE `peoples` SET `userid` = '{$_POST['id1']}', `name` = '{$_POST['name1']}',`pass` = '{$_POST['pass1']}',`priv` = '{$_POST['priv1']}', `ava` = '{$_POST['ava1']}' WHERE `userid`={$_GET['red_id']}");
        } else {
            //Иначе вставляем данные, подставляя их в запрос
            $sql = mysqli_query($link, "INSERT INTO `peoples` (`userid`, `name`, `pass`, `priv`, `ava`) VALUES ('{$_POST['id1']}', '{$_POST['name1']}', '{$_POST['pass1']}', '{$_POST['priv1']}', '{$_POST['ava1']}')");
        }
        
        //Если вставка прошла успешно
        if ($sql) {
        //j
        } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
        }
    }
    //jjjjjjjjjjjjjjjjjjj
    //hhhhhhhhhhhhhhhhhh
    if (isset($_POST["zad1"])) {
        $resultat=$_POST["zad1"];
        $sql = mysqli_query($link, "UPDATE `peoples` SET `zadania` = '{$resultat}' WHERE `name`='{$_POST['name5']}'");
        $product = mysqli_fetch_array($sql);
        
        
    }
        
        
    
    
    if (isset($_GET['del_id'])) { //проверяем, есть ли переменная
      //удаляем строку из таблицы
      $sql = mysqli_query($link, "DELETE FROM `peoples` WHERE `userid` = {$_GET['del_id']}");
      if ($sql) {
        //f
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
    $sql = mysqli_query($link, "SELECT `userid`, `name`, `pass`, `priv`, `ava` FROM `peoples` WHERE `userid`={$_GET['red_id']}");
    $product = mysqli_fetch_array($sql);
    
    if (isset($_GET['red_zad'])) {
      $sql = mysqli_query($link, "SELECT `name`, `zadania` FROM `peoples` WHERE `userid`={$_GET['red_zad']}");
      $product = mysqli_fetch_array($sql);
    }
    ?>

    
    
    
    
    
    <div class="container">
        <div class="header"> 
        <img class='logo1' src="https://pp.userapi.com/c851428/v851428193/54ed6/xXLc-lVBg28.jpg" alt='ava'>
            
        </div>
        <div class="menu">
            <?php 
            $result = mysqli_fetch_array(mysqli_query($link, "SELECT `name`, `priv`, `pass`, `ava` FROM `peoples` WHERE `peoples`.`userid`={$_COOKIE['userid']}"));
            echo "<img class='img1' src={$result['ava']} alt='ava'><br>";
            echo "{$result['name']} <br>";
            echo "{$result['priv']} <br>";
            
            echo '<form action=""  method="post">
                  <input type="submit"  class="btn" name="red_prof" value="Редактировать">
            </form>';
            if($_COOKIE['userid']==1){
                echo '<form action=""  method="post">
                          <input type="submit" class="btn" name="red_users" value="Участники">
                        </form>';
            }
            $result = mysqli_fetch_array(mysqli_query($link, "SELECT `priv` FROM `peoples` WHERE `peoples`.`userid`='{$_COOKIE['userid']}'"));
            if($result['priv']=="null" or $result['priv']=="B"){
                echo '<form action=""  method="post">
                          <input type="submit" class="btn" name="zad" value="Задания">
                        </form>';
            }
            ?>
            <form action="" method="post">
                <input type="submit" class="btn"name="zadania1" value="Мои задания"></td>
            </form>
            <form action="" method="post">
                <input type="submit" class="btn"name="chat1" value="Чат"></td>
            </form>
            <form action="/login" method="post">
                <input type="submit" class="btn"name="del" value="выйти"></td>
            </form>
        </div>
        <div class="content">
            <?php
            $result = mysqli_fetch_array(mysqli_query($link, "SELECT `name`, `priv`, `pass`, `ava` FROM `peoples` WHERE `peoples`.`userid`={$_COOKIE['userid']}"));
            if(isset($_POST["red_prof"])){
                echo "<form action='' method='post'>
              <table>
              <tr>
                <td>Ник:</td>
                <td><input type='text' class='btn'name='name2' value='{$result['name']}'></td>
              </tr>
              <tr>
                <td>Пароль:</td>
                <td><input type='text' class='btn'name='pass2' value='{$result['pass']}'></td>
              </tr>
              <tr>
                <td>Аватарка:</td>
                <td><input type='text' class='btn'name='ava1' value='{$result['ava']}'></td>
              </tr>
              <tr>
                <td colspan='2'><input type='submit' class='btn'value='OK'></td>
              </tr>
            </table>
            </form>
            
            <form action='' method='post'>
                <input type='submit' class='btn' name='light'value='светлая тема'></td>
            </form>
            <form action='' method='post'>
                <input type='submit' class='btn' name='night'value='тёмная тема'></td>
            </form>
            
            <form action='' method='post'>
                <input type='submit' class='btn' name='hghg'value='отмена'></td>
            </form>";
            }
            if(isset($_POST["red_users"]) or isset($_GET['red_id']) or isset($_POST["name1"]) or isset($_GET['del_id'])){
                echo "
                <form action='' method='post'>
                <table>
                  <tr>
                    <td>ID:</td>
                    <td><input type='text' class='btn'name='id1' value='{$product['userid']}'></td>
                  </tr>
                  <tr>
                    <td>НИК:</td>
                    <td><input type='text' class='btn'name='name1' value='{$product['name']}'></td>
                  </tr>
                  <tr>
                    <td>Пароль:</td>
                    <td><input type='text' class='btn'name='pass1' value='{$product['pass']}'></td>
                  </tr>
                  <tr>
                    <td>Уровень доступа:</td>
                    <td><input type='text'class='btn' name='priv1' value='{$product['priv']}'></td>
                  </tr>
                  <tr>
                    <td>Аватарка:</td>
                    <td><input type='text' class='btn'name='ava1' value='{$product['ava']}'></td>
                  </tr>
                  <tr>
                    <td colspan='2'><input type='submit'class='btn' value='OK'></td>
                  </tr>
                </table>
                </form>
                <form action='' method='get'>
                    <input type='submit' class='btn' value='отмена'></td>
                </form>
                <table border='1'>
                <tr>
                  <td>ID</td>
                  <td>НИК</td>
                  <td>Пароль</td>
                  <td>Уровень доступа</td>
                  <td>Аватарка</td>
                  <td>Удаление</td>
                  <td>Редактирование</td>
                </tr>";
                  $sql = mysqli_query($link, 'SELECT `userid`, `name`, `pass`, `priv`, `ava` FROM `peoples`');
                  while ($result = mysqli_fetch_array($sql)) {
                    echo '<tr>' .
                         "<td>{$result['userid']}</td>" .
                         "<td>{$result['name']}</td>" .
                         "<td>{$result['pass']}</td>" .
                         "<td>{$result['priv']}</td>" .
                         "<td>{$result['ava']}</td>" .
                         "<td><a class='link' href='?del_id={$result['userid']}'>Удалить</a></td>" .
                         "<td><a class='link'href='?red_id={$result['userid']}'>Изменить</a></td>" .
                         '</tr>';
                  }
                echo "
                </table>";
            }
            //KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK
            if(isset($_POST["zad"]) or $_POST["zad1"] or isset($_GET['red_zad'])){
                echo"<form action='' method='post'>
                <table>
                  <tr>
                    <td>НИК:</td>
                    <td><input type='text' class='btn' name='name5' value='{$product['name']}'></td>
                  </tr>
                  <tr>
                    <td>Задания:</td>
                    <td><input type='text' class='btn' name='zad1' value='{$product['zadania']}'></td>
                  </tr>
                  <tr>
                    <td colspan='2'><input type='submit'class='btn' value='OK'></td>
                  </tr>
                </table>
                </form>
                <form action='' method='get'>
                    <input type='submit' class='btn' value='отмена'></td>
                </form>
                <table border='1'>
                <tr>
                  <td>НИК</td>
                  <td class='table'>Задание</td>
                  <td>Редактировать</td>
                </tr>";
                  $sql = mysqli_query($link, 'SELECT `userid`,`name`,`zadania` FROM `peoples`');
                  while ($result = mysqli_fetch_array($sql)) {
                    echo '<tr>' .
                         "<td>{$result['name']}</td>" .
                         "<td>{$result['zadania']}</td>" .
                         "<td><a class='link'href='?red_zad={$result['userid']}'>Изменить</a></td>" .
                         '</tr>';
                  }
                echo "
                </table>";
                
        
      
            }  
            
            
            //JJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJj
            $result = mysqli_fetch_array(mysqli_query($link, "SELECT `zadania` FROM `peoples` WHERE `peoples`.`userid`={$_COOKIE['userid']}"));
            if(isset($_POST["zadania1"]) and $result["zadania"]!=""){
                echo $result["zadania"]."<br>
                <form action='' method='get'>
                    <input type='submit' class='btn' value='отмена'></td>
                </form>";
            }else if(isset($_POST["zadania1"])){
                echo "Заданий нет. <br>
                <form action='' method='get'>
                    <input type='submit' class='btn' value='отмена'></td>
                </form>";
            }
            
            
            //ddddddddddddddddddddddddddd
            if(isset($_POST["chat1"])){
                echo"
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
                ";
                $sql = mysqli_query($link, 'SELECT `ID`, `user`, `text`, `date` FROM `chat`');
                
                while ($result = mysqli_fetch_array($sql)) { 
                    $sql1 = mysqli_query($link, "SELECT `name`,`ava` FROM `peoples` WHERE `peoples`.`userid`='{$result['user']}'");
                    $result1 = mysqli_fetch_array($sql1);
                    echo '<tr>' .
                         "<td><img class='logo2' src='{$result1['ava']}' alt='ava'>
                        </td>".
                         "<td>{$result1['name']}</td>" .
                         "<td>{$result['text']}</td>" .
                         "<td>{$result['date']}</td>" .
                         '</tr>';
                }
                echo"</table>";
                
            }    
            ?>
        
        </div>
        <div class="footer">Версия 1.3.0 <br>Copyright © and All rights reserved</div>
    </div>
    
    
    
    

</body>
</html>