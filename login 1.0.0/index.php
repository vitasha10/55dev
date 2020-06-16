<?php 
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
    $result2=$_COOKIE['userid'];
    //Если переменная ID передана
    if (isset($_POST["name1"])) {
        $result1=mysqli_fetch_array(mysqli_query($link, "SELECT `userid` FROM `peoples` WHERE `peoples`.`name`='{$_POST['name1']}'"));
        $result = mysqli_fetch_array(mysqli_query($link, "SELECT `pass` FROM `peoples` WHERE `peoples`.`name`='{$_POST['name1']}'"));
    
        if($result['pass']==""){
            echo"пользователь не найден";
        }else{
        if ($_POST["Pass"]==$result['pass']){
            $result2=$result1["userid"];
            setcookie('userid', $result1["userid"], time()+86400, '/');
        }
        else{
            echo"Данные не верны";
        }}
        
    }
    
    
?>







<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>LOGIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div>
        <form action="" method="post">
            <table>
              <tr>
                <td>Ник пользователя:</td>
                <td><input class="btn" type="text" name="name1" value=""></td>
              </tr>
              <tr>
                <td>Пароль пользователя:</td>
                <td><input class="btn" type="text" name="Pass" value=""></td>
              </tr>
              <tr>
                <td colspan="2"><input class="btn" type="submit" value="OK"></td>
              </tr>
            </table>
        </form>
    </div>
    <?php
    if(isset($result2)){
        $result3=mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `peoples` WHERE `peoples`.`userid`='{$result2['userid']}'"));
        echo "Ваш НИК: ".$result3["name"]."<br>";
        echo "<a href='../fc' > Заходите на сайт)</a>";
    }
    ?>
    
</body>
</html>