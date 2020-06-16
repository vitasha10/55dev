<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>55dev.ru</title>
    
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="style1.css" rel="stylesheet">

</head>

<body id="page-top">

<?php
if(!isset($_COOKIE['userid'])){
    echo '<h1>Не авторизован</h1>';
    echo '<meta http-equiv="refresh" content="0;URL=/login">';
}else{
    $link = mysqli_connect('localhost','j92230e0_root','rootroot','j92230e0_root'); // Соединяемся с базой
    // Ругаемся, если соединение установить не удалось
    if (!$link) {
        echo 'Не могу соединиться с БД. Код ошибки: '.mysqli_connect_errno().', ошибка: '.mysqli_connect_error();
        exit;
    }
    date_default_timezone_set('Asia/Yekaterinburg');//выбираем часовой пояс
    $date=date("20y-m-d H:i:s");
    
    //запросы к бд
    $sql1 = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `peoples` WHERE `userid`='{$_COOKIE['userid']}'"));
    $result = mysqli_fetch_array(mysqli_query($link, "SELECT `name`, `orname`, `birthday`, `ava`, `vk`, `dis`, `tg`, `priv` FROM `peoples` WHERE `userid`='{$_COOKIE['userid']}'"));
    //$sql = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `_server_` WHERE `userid`={$_COOKIE['userid']}"));
    $news = mysqli_fetch_array(mysqli_query($link, "SELECT `data` FROM `_server_` WHERE `name`='news'"));
    $pravila = mysqli_fetch_array(mysqli_query($link, "SELECT `data` FROM `_server_` WHERE `name`='pravila'"));
    $version = mysqli_fetch_array(mysqli_query($link, "SELECT `data` FROM `_server_` WHERE `name`='version'"));
    $logo1 = mysqli_fetch_array(mysqli_query($link, "SELECT `data` FROM `_server_` WHERE `name`='logo1'"));

    
    //Отправка сообщений
    if(isset($_POST["text"])) {
        if(isset($_GET['b'])){
            $string = $_GET['b'];
        }else if($_GET['ls']>$_COOKIE['userid']){
            $array = array($_COOKIE['userid'], $_GET['ls']);
            $string = serialize($array);
        }else if($_GET['ls']==$_COOKIE['userid']){
            $array = array($_GET['ls'], $_COOKIE['userid']);
            $string = serialize($array);
        }else if($_GET['ls']<$_COOKIE['userid']){
            $array = array($_GET['ls'], $_COOKIE['userid']);
            $string = serialize($array);
        }else{
            echo"ОШИБКА";
        }
        if($_POST["text"]!=""){ //Пустые сообщения отправлять нельзя
            $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '{$_POST['text']}', '{$date}')");
        }
    }
    if(isset($_GET['b'])){
            $string = $_GET['b'];
    }else if($_GET['ls']>$_COOKIE['userid']){
        $array = array($_COOKIE['userid'], $_GET['ls']);
        $string = serialize($array);
    }else if($_GET['ls']==$_COOKIE['userid']){
        $array = array($_GET['ls'], $_COOKIE['userid']);
        $string = serialize($array);
    }else if($_GET['ls']<$_COOKIE['userid']){
        $array = array($_GET['ls'], $_COOKIE['userid']);
        $string = serialize($array);
    }else{
        echo"ОШИБКА";
    }
    
    //фото
    if(isset($_FILES) && $_FILES['inputfile']['error'] == 0 && $_FILES['inputfile']['name']!='' && isset($_POST['photo'])){ // Проверяем, загрузил ли пользователь файл
        $destiation_dir = dirname(__FILE__) .'/files/'.$_FILES['inputfile']['name']; // Директория для размещения файла
        move_uploaded_file($_FILES['inputfile']['tmp_name'], $destiation_dir ); // Перемещаем файл в желаемую директорию
        $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '<img class=\'imgchat\' src=\'http://55dev.ru/fc/files/{$_FILES['inputfile']['name']}\' alt=\'ava\'><br>', '{$date}')");
    }
    //музыка
    if(isset($_FILES) && $_FILES['inputfile']['error'] == 0 && $_FILES['inputfile']['name']!='' && isset($_POST['music'])){ // Проверяем, загрузил ли пользователь файл
        $destiation_dir = dirname(__FILE__) .'/files/'.$_FILES['inputfile']['name']; // Директория для размещения файла
        move_uploaded_file($_FILES['inputfile']['tmp_name'], $destiation_dir ); // Перемещаем файл в желаемую директорию
        $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '<audio src=\'http://55dev.ru/fc/files/{$_FILES['inputfile']['name']}\' preload=\'none\' controls></audio>', '{$date}')");
    }
    //файл
    if(isset($_FILES) && $_FILES['inputfile']['error'] == 0 && $_FILES['inputfile']['name']!='' && isset($_POST['file'])){ // Проверяем, загрузил ли пользователь файл
        $destiation_dir = dirname(__FILE__) .'/files/'.$_FILES['inputfile']['name']; // Директория для размещения файла
        move_uploaded_file($_FILES['inputfile']['tmp_name'], $destiation_dir ); // Перемещаем файл в желаемую директорию
        $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '<a href = \'http://55dev.ru/fc/files/{$_FILES['inputfile']['name']}\'>Файл: {$_FILES['inputfile']['name']}</a><br>', '{$date}')");
    }
    //видео
    if(isset($_FILES) && $_FILES['inputfile']['error'] == 0 && $_FILES['inputfile']['name']!='' && isset($_POST['video'])){ // Проверяем, загрузил ли пользователь файл
        $destiation_dir = dirname(__FILE__) .'/files/'.$_FILES['inputfile']['name']; // Директория для размещения файла
        move_uploaded_file($_FILES['inputfile']['tmp_name'], $destiation_dir ); // Перемещаем файл в желаемую директорию
        $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '<video class=\'video\' src=\'http://55dev.ru/fc/files/{$_FILES['inputfile']['name']}\' controls /><br>', '{$date}')");
    }
    
    
    //смайлики
    if(isset($_POST["sm1"])) {
        $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '&#128515;', '{$date}')");
    }
    if(isset($_POST["sm2"])) {
        $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '&#128514;', '{$date}')");
    }
    if(isset($_POST["sm3"])) {
        $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '&#129315;', '{$date}')");
    }
    if(isset($_POST["sm4"])) {
        $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '&#128527;', '{$date}')");
    }
    if(isset($_POST["sm5"])) {
        $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '&#128528;', '{$date}')");
    }
    if(isset($_POST["sm6"])) {
        $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '&#128541;', '{$date}')");
    }
    if(isset($_POST["sm7"])) {
        $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '&#128526;', '{$date}')");
    }
    if(isset($_POST["sm8"])) {
        $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '&#128545;', '{$date}')");
    }
    if(isset($_POST["sm9"])) {
        $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '&#128524;', '{$date}')");
    }
    
    //очистка беседы
    if(isset($_POST['truncate'])){
        $sql = mysqli_query($link, "DELETE FROM `chat` WHERE `chat`.`beceda` = '{$_POST['beceda']}'");
    }
    
    if(isset($_POST['beceda_name'])){
        $sql = mysqli_query($link, "UPDATE `conv` SET `name` = '{$_POST['beceda_name']}' WHERE `id`={$_GET['b']}");
    }
    
    //Смена темы
    if(isset($_POST["light"])){ //светлая
        $sql = mysqli_query($link, "UPDATE `peoples` SET `style` = '1' WHERE `userid`={$_COOKIE['userid']}");
    }
    
    if(isset($_POST["night"])){ //тёмная
        $sql = mysqli_query($link, "UPDATE `peoples` SET `style` = '2' WHERE `userid`={$_COOKIE['userid']}");
    }
    
    
    //Темы
    //if($sql1["style"]==1 or $_POST['light']){
      //  echo'<link rel="stylesheet" href="style.css" type="text/css">';
    //}else{
      //  echo'<link rel="stylesheet" href="night.css" type="text/css">';
    //}
    
    
    //Редактируем профиль
    if (isset($_POST["pass2"])) {
        $sql = mysqli_query($link, "UPDATE `peoples` SET `name`='{$_POST['name2']}', `pass` = '{$_POST['pass2']}', `ava` = '{$_POST['ava1']}',`birthday`='{$_POST['birthday1']}',`vk` = '{$_POST['vk1']}',`dis` = '{$_POST['dis1']}',`tg` = '{$_POST['tg1']}' WHERE `userid`={$_COOKIE['userid']}");
    }
    //Редактор участников
    if (isset($_POST["name1"])) {
        //Если это запрос на обновление, то обновляем
        if (isset($_GET['red_id'])) {
            $sql = mysqli_query($link, "UPDATE `peoples` SET `userid` = '{$_POST['id1']}', `name` = '{$_POST['name1']}',`pass` = '{$_POST['pass1']}',`priv` = '{$_POST['priv1']}', `ava` = '{$_POST['ava1']}' WHERE `userid`={$_GET['red_id']}");
        } else {
            //Иначе вставляем данные, подставляя их в запрос
            $sql = mysqli_query($link, "INSERT INTO `peoples` (`userid`, `name`, `pass`, `priv`, `ava`) VALUES ('{$_POST['id1']}', '{$_POST['name1']}', '{$_POST['pass1']}', '{$_POST['priv1']}', '{$_POST['ava1']}')");
        }
        
        
        if ($sql) {
        //Если вставка прошла успешно
        } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
        }
    }
    
    //Редактируем задания
    if (isset($_POST["zad1"])) {
        $sql = mysqli_query($link, "UPDATE `peoples` SET `zadania` = '{$_POST['zad1']}' WHERE `name`='{$_POST['name5']}'");
    }
        
        
    
    
    if (isset($_GET['del_id'])) { //проверяем, есть ли переменная
      //удаляем строку из таблицы
      $sql = mysqli_query($link, "DELETE FROM `peoples` WHERE `userid` = {$_GET['del_id']}");
      if ($sql) {
        //Удаление успешно
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
      }
    }
    
    //Удаляем сообщение
    if (isset($_POST['dell_sms'])) { //проверяем, есть ли переменная
      //удаляем строку из таблицы
      $sql = mysqli_query($link, "DELETE FROM `chat` WHERE `ID` = {$_POST['dell_sms']}");
      if ($sql) {
        //Удаление успешно
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
      }
    }
    
    
    //Редактор всех профилей    
    //Если передана переменная red_id, то надо обновлять данные. Для начала достанем их из БД
    if (isset($_GET['red_id'])) {
      $sql = mysqli_query($link, "SELECT `userid`, `name`, `pass`, `priv`, `ava` FROM `peoples` WHERE `userid`={$_GET['red_id']}");
      $product = mysqli_fetch_array($sql);
    }
   
    
    if (isset($_GET['red_zad'])) {
      $sql = mysqli_query($link, "SELECT `name`, `zadania` FROM `peoples` WHERE `userid`={$_GET['red_zad']}");
      $product = mysqli_fetch_array($sql);
    }



    //запросы к бд
    $sql1 = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `peoples` WHERE `userid`='{$_COOKIE['userid']}'"));
    $result = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `peoples` WHERE `userid`='{$_COOKIE['userid']}'"));
    //$sql = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `_server_` WHERE `userid`={$_COOKIE['userid']}"));
    $news = mysqli_fetch_array(mysqli_query($link, "SELECT `data` FROM `_server_` WHERE `name`='news'"));
    $pravila = mysqli_fetch_array(mysqli_query($link, "SELECT `data` FROM `_server_` WHERE `name`='pravila'"));
    $version = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `_server_` WHERE `name`='version'"));
    $logo1 = mysqli_fetch_array(mysqli_query($link, "SELECT `data` FROM `_server_` WHERE `name`='logo1'"));
  













echo"


<nav class='navbar navbar-expand navbar-dark bg-dark static-top'>

    <a class='navbar-brand mr-1' href='http://55dev.ru/fc'>55dev.ru</a>
    
    <button class='btn btn-link btn-sm text-white order-1 order-sm-0' id='sidebarToggle' href='#'>
        <i class='fas fa-bars'></i>
    </button>
    
</nav>
    
<div id='wrapper'>

        <!-- Sidebar -->
    <ul class='sidebar navbar-nav'>
        <li class='nav-item active'>
            <a class='nav-link' href='index.php'>
                <i class='fas fa-fw fa-tachometer-alt'></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class='nav-item dropdown'>
            <a class='nav-link dropdown-toggle' href='#' id='pagesDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <i class='fas fa-fw fa-folder'></i>
                <span>Pages</span>
            </a>
            <div class='dropdown-menu' aria-labelledby='pagesDropdown'>
            <!--
                <h6 class='dropdown-header'>Login Screens:</h6>
                <a class='dropdown-item' href='login.html'>Login</a>
                <a class='dropdown-item' href='register.html'>Register</a>
                <a class='dropdown-item' href='forgot-password.html'>Forgot Password</a>
            
                <div class='dropdown-divider'></div>
            
                <h6 class='dropdown-header'>Other Pages:</h6>
            -->    
                <a class='dropdown-item' href='my.php'>Профиль</a>
                <a class='dropdown-item' href='rule.php'>Правила сервера</a>
                <a class='dropdown-item' href='tasks.php'>Задания</a>
                <a class='dropdown-item' href='my_task.php'>Мои задания</a>
            </div>
        </li>
        <!--
        <li class='nav-item'>
            <a class='nav-link' href='charts.html'>
                <i class='fas fa-fw fa-chart-area'></i>
                <span></span>
            </a>
        </li>
        -->
        <li class='nav-item'>
            <a class='nav-link' href='messenger.php'>
                <i class='fas fa-fw fa-table'></i>
                <span>Мессенджер</span>
            </a>
        </li>
    </ul>

    <div id='content-wrapper'>
        <div class='container-fluid'>
            <!-- ===============================================================
            ==========================================================
            ==============================================================
            ===============================================================-->";
            //Профили пользователей
            if(isset($_GET["u"])){
                $result = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `peoples` WHERE `peoples`.`userid`='{$_GET['u']}'"));
                if($result['name']==""){
                    echo"Пользователь не найден!";
                }
                else{
                    echo "
                  <table>
                  <tr>
                    <td>{$result['orname']}</td>
                  </tr>
                  <tr>
                    <td><img class='logo2' src='{$result['ava']}' alt='ava'></td>
                  </tr>
                  <tr>
                    <td>Уровень:</td>
                    <td>{$result['priv']}</td>
                  </tr>
                  <tr>
                    <td>Ник:</td>
                    <td>{$result['name']}</td>
                  </tr>
                  <tr>
                    <td>День Рождения:</td>
                    <td>{$result['birthday']}</td>
                  </tr>
                  <tr>
                    <td>VK:</td>
                    <td><a class='link' href='{$result['vk']}'>{$result['vk']}</a></td>
                  </tr>
                  <tr>
                    <td>Discord:</td>
                    <td><a class='link' href='{$result['dis']}'>{$result['dis']}</a></td>
                  </tr>
                  <tr>
                    <td>Telegram:</td>
                    <td><a class='link' href='{$result['tg']}'>{$result['tg']}</a></td>
                  </tr>
                  
                </table>
                <form action='/fc' method='get'>
                    <input type='hidden' name='ls' value='{$result['userid']}'>
                    <input type='submit' class='btn' value='Сообщения'></td>
                </form>
                <form action='/fc' method='get'>
                    <input type='submit' class='btn' value='отмена'></td>
                </form>";
                }
            }else
            
            
            //Редактор профиля
            if(isset($_POST["red_prof"])){
                echo "<form action='' method='post'>
              <table>
              <tr>
                <td>{$sql1['orname']}</td>
              </tr>
              <tr>
                <td>Уровень:</td>
                <td>{$sql1['priv']}</td>
              </tr>
              <tr>
                <td>Ник:</td>
                <td><input type='text' class='btn'name='name2' value='{$sql1['name']}'></td>
              </tr>
              <tr>
                <td>Пароль:</td>
                <td><input type='text' class='btn'name='pass2' value='{$sql1['pass']}'></td>
              </tr>
              <tr>
                <td>Аватарка:</td>
                <td><input type='text' class='btn'name='ava1' value='{$sql1['ava']}'></td>
              </tr>
              <tr>
                <td>День Рождения:</td>
                <td><input type='text' class='btn'name='birthday1' value='{$sql1['birthday']}'></td>
              </tr>
              <tr>
                <td>VK:</td>
                <td><input type='text' class='btn'name='vk1' value='{$sql1['vk']}'></td>
              </tr>
              <tr>
                <td>Discord:</td>
                <td><input type='text' class='btn'name='dis1' value='{$sql1['dis']}'></td>
              </tr>
              <tr>
                <td>Telegram:</td>
                <td><input type='text' class='btn'name='tg1' value='{$sql1['tg']}'></td>
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
            }else

            //Редактор участников
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
            }else
            //Редактор заданий
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
                
        
      
            }else
            
            
            //Мои задания
            
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
            }else if(isset($_POST["chat1"])){
                echo"<p>Для того, чтобы написать личное сообщение нужно добавить к ссылке вот это - ?ls= 
                и после ровно поставить ID пользователя, чтобы его узнать можно ткнуть по аве и 
                просто посмотреть ID там из ссылки (например будет 55dev.ru/fc?u=1, ID тут ровно 1). 
                Чтобы открыть нашу беседу добавьте к адресу ?b=1 и всё. 
                В обновлении я добавлю норм работу как в вк, пока так.
                </p><h3>Если вы отправили сообщение в лс хоть кому, пишите в общий чат, что отправили. НИКАКИЕ УВЕДОМЛЕНИЯ НЕ ПРИХОДЯТ!!!</h3>
                <a class='link'href='?b=1'>Общий чат (это сслыка)</a>";
            }else
            //Чаты  
            if(isset($_GET['ls']) or isset($_GET['b']) or isset($_POST["text"]) or isset($_GET['dell_sms']) or isset($_POST["sm1"]) or isset($_POST["sm2"]) or isset($_POST["sm3"]) or isset($_POST["sm4"]) or isset($_POST["sm5"]) or isset($_POST["sm6"]) or isset($_POST["sm7"]) or isset($_POST["sm8"]) or isset($_POST["sm9"])){
                /*
                <script>
                    function update() {
                        send_request('load');
                    }
                    interval = setInterval(update,1000);
                </script>
                */
                if(isset($_GET['b'])){
                    $string = $_GET['b'];
                    $dopresult = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `conv` WHERE `conv`.`id`='{$_GET['b']}'"));
                }else if($_GET['ls']>$_COOKIE['userid']){
                    $array = array($_COOKIE['userid'], $_GET['ls']);
                    $string = serialize($array);
                }else if($_GET['ls']==$_COOKIE['userid']){
                    $array = array($_GET['ls'], $_COOKIE['userid']);
                    $string = serialize($array);
                }else if($_GET['ls']<$_COOKIE['userid']){
                    $array = array($_GET['ls'], $_COOKIE['userid']);
                    $string = serialize($array);
                }else{
                    echo"ОШИБКА";
                }
                
            	
                if(isset($_GET['b'])){
                echo"<table>
                    <td>
                        <h3>{$dopresult['name']}</h3>
                    </td>
                    <td>
                        <input class='btn' type='button' value='|||' id='btn31' onclick='buttonClicked2();' />
                    </td>
                    </table>
                    <div id='box2' class='okno' style='display: none; position: absolute;'>
                        <form action='' method='post'>
                            <table>
                                <tr>
                                    <td>Название:</td>
                                    <td><input type='text' class='btn' name='beceda_name' value='{$dopresult['name']}'></td>
                                </tr>
                                <tr>
                                    <td colspan='2'><input type='submit' class='btn' value='OK'></td>
                                </tr>
                            </table>
                        </form>
                        
                        <form action='' method='post'>
                            <input type='hidden' class='btn' name='beceda' value='{$_GET['b']}'></td>
                            <input type='submit' class='btn' name='truncate' value='Очистить беседу'></td>
                        </form>
                    
                        
                    </div>
                ";
                }
                echo"
                
                <table id='block' style='display: block; overflow: auto; max-width: 180vh; max-height:60vh;'>
                    ";
                    
                
                $sql = mysqli_query($link, "SELECT `ID`, `user`, `text`, `date` FROM `chat` WHERE `beceda`='{$string}'");
                $result50 = mysqli_fetch_array(mysqli_query($link, "SELECT `priv` FROM `peoples` WHERE `peoples`.`userid`='{$_COOKIE['userid']}'"));
                if($result50['priv']=="null" or $result50['priv']=="B"){
                    echo"
                    
                    <tr>
                      <td>Ава</td>
                      <td>Пользователь</td>
                      <td>Сообщение</td>
                      <td>Дата</td>
                      <td>del</td>
                    </tr>
                    ";
                    while ($result = mysqli_fetch_array($sql)) { 
                        $sql1 = mysqli_query($link, "SELECT `name`,`ava`,`priv`  FROM `peoples` WHERE `peoples`.`userid`='{$result['user']}'");
                        $result1 = mysqli_fetch_array($sql1);
                        if($result1["priv"]=="null"){
                            echo '<tr>' .
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2' src='{$result1['ava']}' alt='ava'></a>
                            </td>".
                             "<td><p style='color:orange;'>{$result1['name']}</p></td>" .
                             "<td>{$result['text']}</td>" .
                             "<td>{$result['date']}</td>" .
                             "<td><form method='post' action=''>
                                      <input type='hidden' name='dell_sms' value='{$result['ID']}'>
                                      <input class='small_btn' type='submit' value='Удалить'>
                                  </form></td>".
                             '</tr>';
                        }
                        if($result1["priv"]=="B"){
                            echo '<tr>' .
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2' src='{$result1['ava']}' alt='ava'></a>
                            </td>".
                             "<td><p style='color:#8b00ff;'>{$result1['name']}</p></td>" .
                             "<td>{$result['text']}</td>" .
                             "<td>{$result['date']}</td>" .
                             "<td><form method='post' action=''>
                                      <input type='hidden' name='dell_sms' value='{$result['ID']}'>
                                      <input class='small_btn' type='submit' value='Удалить'>
                                  </form></td>".
                             '</tr>';
                        }
                        if($result1["priv"]=="C"){
                            echo '<tr>' .
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2' src='{$result1['ava']}' alt='ava'></a>
                            </td>".
                             "<td><p style='color:blue;'>{$result1['name']}</p></td>" .
                             "<td>{$result['text']}</td>" .
                             "<td>{$result['date']}</td>" .
                             "<td><form method='post' action=''>
                                      <input type='hidden' name='dell_sms' value='{$result['ID']}'>
                                      <input class='small_btn' type='submit' value='Удалить'>
                                  </form></td>".
                             '</tr>';
                        }
                        if($result1["priv"]=="D"){
                            echo '<tr>' .
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2' src='{$result1['ava']}' alt='ava'></a>
                            </td>".
                             "<td><p style='color:green;'>{$result1['name']}</p></td>" .
                             "<td>{$result['text']}</td>" .
                             "<td>{$result['date']}</td>" .
                             "<td><form method='post' action=''>
                                      <input type='hidden' name='dell_sms' value='{$result['ID']}'>
                                      <input class='small_btn' type='submit' value='Удалить'>
                                  </form></td>".
                             '</tr>';
                        }
                    }
                    echo"
                    </table>
                    
                    
                    
                    
                    <div id='box' class='okno' style='display: none; position: absolute;'>
                        <table>
                            <tr>
                                <td>	
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm1'value='&#128515;'>
                                    </form>
                                </td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm2'value='&#128514;'>
                                    </form>
                                </td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm3'value='&#129315;'>
                                    </form>
                                </td>    
                            </tr>
                            <tr>
                                <td>	
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm4'value='&#128527;'>
                                    </form>
                                </td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm5'value='&#128528;'>
                                    </form>
                                </td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm6'value='&#128541;'>
                                    </form>
                                </td>    
                            </tr>
                            <tr>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm7'value='&#128526;'>
                                    </form>
                                </td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm8'value='&#128545;'>
                                    </form>
                                </td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm9'value='&#128524;'>
                                    </form>
                                </td>    
                            </tr>
                        </table>
                    </div>
                    
                    <form action='' method='post'>
                    <table>
                      <tr>
                        <td>Сообщение:</td>
                        <td><input class='btn' type='text' name='text' value=''></td>
                        <td>	
                            <input class='btn' type='button' value='&#128515;' id='btn3' onclick='buttonClicked();' />
                        </td>
                        <td>	
                            <input class='btn' type='button' value='Файл' id='btn31' onclick='buttonClicked1();' />
                        </td>
                        <td colspan='2'><input class='btn' type='submit' value='OK'></td>
                      </tr>
                    </table>
                    </form>



                    <div id='box1' class='okno' style='display: none; position: absolute;'>
                        <table>
                            <tr>
                                <td>
                                    <form method='post' action='' enctype='multipart/form-data'>
                                        <input type='hidden' name='photo'>
                                        <input class='small_btn' type='file' id='inputfile' name='inputfile'></br>
                                        <input class='small_btn' type='submit' value='Загрузить фото'>
                                    </form>
                                </td>
                                <td>
                                    <form method='post' action='' enctype='multipart/form-data'>
                                        <input type='hidden' name='video'>
                                        <input class='small_btn' type='file' id='inputfile' name='inputfile'></br>
                                        <input class='small_btn' type='submit' value='Загрузить видео'>
                                    </form>
                                </td>
                                <td>
                                    <form method='post' action='' enctype='multipart/form-data'>
                                        <input type='hidden' name='file'>
                                        <input class='small_btn' type='file' id='inputfile' name='inputfile'></br>
                                        <input class='small_btn' type='submit' value='Загрузить файл'>
                                    </form>
                                </td>
                                <td>
                                    <form method='post' action='' enctype='multipart/form-data'>
                                        <input type='hidden' name='music'>
                                        <input class='small_btn' type='file' id='inputfile' name='inputfile'></br>
                                        <input class='small_btn' type='submit' value='Загрузить музыку'>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    
                    
                    <table>
                        <tr>
                            <td>
                            <form action='' method='post'>
                                <input type='submit' class='btn' value='обновить'></td>
                            </form>
                            </td>
                            <td>
                            <form action='' method='get'>
                                <input type='submit' class='btn' value='отмена'></td>
                            </form>
                            </td>
                        </tr>
                    </table>
                    ";
                    
                }else{
                    echo"
                    <tr>
                      <td>Ава</td>
                      <td>Пользователь</td>
                      <td>Сообщение</td>
                      <td>Дата</td>
                      <td>Удалить</td>
                    </tr>
                    ";
                    while ($result = mysqli_fetch_array($sql)) { 
                        $sql1 = mysqli_query($link, "SELECT `name`,`ava`,`priv`  FROM `peoples` WHERE `peoples`.`userid`='{$result['user']}'");
                        $result1 = mysqli_fetch_array($sql1);
                        if($result["user"]==$_COOKIE['userid']){
                            if($result1["priv"]=="C"){
                            echo '<tr>' .
                                 "<td><a class='link' href='?u={$result['user']}'><img class='logo2' src='{$result1['ava']}' alt='ava'></a>
                                </td>".
                                 "<td><p style='color:blue;'>{$result1['name']}</p></td>" .
                                 "<td>{$result['text']}</td>" .
                                 "<td>{$result['date']}</td>" .
                                "<td><form method='post' action=''>
                                      <input type='hidden' name='dell_sms' value='{$result['ID']}'>
                                      <input class='small_btn' type='submit' value='Удалить'>
                                  </form></td>".
                                 '</tr>';
                            }
                            if($result1["priv"]=="D"){
                            echo '<tr>' .
                                 "<td><a class='link' href='?u={$result['user']}'><img class='logo2' src='{$result1['ava']}' alt='ava'></a>
                                </td>".
                                 "<td><p style='color:green;'>{$result1['name']}</p></td>" .
                                 "<td>{$result['text']}</td>" .
                                 "<td>{$result['date']}</td>" .
                                 "<td><form method='post' action=''>
                                      <input type='hidden' name='dell_sms' value='{$result['ID']}'>
                                      <input class='small_btn' type='submit' value='Удалить'>
                                  </form></td>".
                                 '</tr>';
                            }
                        }else{
                            if($result1["priv"]=="null"){
                                echo '<tr>' .
                                 "<td><a class='link' href='?u={$result['user']}'><img class='logo2' src='{$result1['ava']}' alt='ava'></a>
                                </td>".
                                 "<td><p style='color:orange;'>{$result1['name']}</p></td>" .
                                 "<td>{$result['text']}</td>" .
                                 "<td>{$result['date']}</td>" .
                                 
                                 '</tr>';
                            }
                            if($result1["priv"]=="B"){
                                echo '<tr>' .
                                 "<td><a class='link' href='?u={$result['user']}'><img class='logo2' src='{$result1['ava']}' alt='ava'></a>
                                </td>".
                                 "<td><p style='color:#8b00ff;'>{$result1['name']}</p></td>" .
                                 "<td>{$result['text']}</td>" .
                                 "<td>{$result['date']}</td>" .
                                 
                                 '</tr>';
                            }
                            if($result1["priv"]=="C"){
                                echo '<tr>' .
                                 "<td><a class='link' href='?u={$result['user']}'><img class='logo2' src='{$result1['ava']}' alt='ava'></a>
                                </td>".
                                 "<td><p style='color:blue;'>{$result1['name']}</p></td>" .
                                 "<td>{$result['text']}</td>" .
                                 "<td>{$result['date']}</td>" .
                                 
                                 '</tr>';
                            }
                            if($result1["priv"]=="D"){
                                echo '<tr>' .
                                 "<td><a class='link' href='?u={$result['user']}'><img class='logo2' src='{$result1['ava']}' alt='ava'></a>
                                </td>".
                                 "<td><p style='color:green;'>{$result1['name']}</p></td>" .
                                 "<td>{$result['text']}</td>" .
                                 "<td>{$result['date']}</td>" .
                                 
                                 '</tr>';
                            }
                        }
                    }
                    echo"</table>
                    <div id='box' class='okno' style='display: none; position: absolute;'>
                        <table>
                            <tr>
                                <td>	
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm1'value='&#128515;'>
                                    </form>
                                </td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm2'value='&#128514;'>
                                    </form>
                                </td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm3'value='&#129315;'>
                                    </form>
                                </td>    
                            </tr>
                            <tr>
                                <td>	
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm4'value='&#128527;'>
                                    </form>
                                </td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm5'value='&#128528;'>
                                    </form>
                                </td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm6'value='&#128541;'>
                                    </form>
                                </td>    
                            </tr>
                            <tr>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm7'value='&#128526;'>
                                    </form>
                                </td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm8'value='&#128545;'>
                                    </form>
                                </td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' class='small_btn' name='sm9'value='&#128524;'>
                                    </form>
                                </td>    
                            </tr>
                        </table>
                    </div>
                    
                    <form action='' method='post'>
                    <table>
                      <tr>
                        <td>Сообщение:</td>
                        <td><input class='btn' type='text' name='text' value=''></td>
                        <td>	
                            <input class='btn' type='button' value='&#128515;' id='btn3' onclick='buttonClicked();' />
                        </td>
                        <td>	
                            <input class='btn' type='button' value='Файл' id='btn31' onclick='buttonClicked1();' />
                        </td>
                        <td colspan='2'><input class='btn' type='submit' value='OK'></td>
                      </tr>
                    </table>
                    </form>



                    <div id='box1' class='okno' style='display: none; position: absolute;'>
                        <table>
                            <tr>
                                <td>
                                    <form method='post' action='' enctype='multipart/form-data'>
                                        <input type='hidden' name='photo'>
                                        <input class='btn' type='file' id='inputfile' name='inputfile'></br>
                                        <input class='btn' type='submit' value='Загрузить фото'>
                                    </form>
                                </td>
                                <td>
                                    <form method='post' action='' enctype='multipart/form-data'>
                                        <input type='hidden' name='video'>
                                        <input class='small_btn' type='file' id='inputfile' name='inputfile'></br>
                                        <input class='small_btn' type='submit' value='Загрузить видео'>
                                    </form>
                                </td>
                                <td>
                                    <form method='post' action='' enctype='multipart/form-data'>
                                        <input type='hidden' name='file'>
                                        <input class='btn' type='file' id='inputfile' name='inputfile'></br>
                                        <input class='btn' type='submit' value='Загрузить файл'>
                                    </form>
                                </td>
                                <td>
                                    <form method='post' action='' enctype='multipart/form-data'>
                                        <input type='hidden' name='music'>
                                        <input class='btn' type='file' id='inputfile' name='inputfile'></br>
                                        <input class='btn' type='submit' value='Загрузить музыку'>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    
                    
                    <table>
                        <tr>
                            <td>
                            <form action='' method='post'>
                                <input type='submit' class='btn' value='обновить'></td>
                            </form>
                            </td>
                            <td>
                            <form action='' method='get'>
                                <input type='submit' class='btn' value='отмена'></td>
                            </form>
                            </td>
                        </tr>
                    </table>
                    ";
                }
                    
            }else if(isset($_POST["prav"])){
                
                echo $pravila['data'];
                echo "<form action='' method='post'>
                    <input type='submit' class='btn' value='отмена'></td>
                </form>";
                
            }else{
                echo $news['data'];
            }}
            

            echo"
            <!--===========================================================-->
            <footer class='sticky-footer'>
                <div class='container my-auto'>
                    <div class='copyright text-center my-auto'>
                        <span>Copyright © Your Website 2019. Version: {$version['data']} {$version['dop1']}</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class='scroll-to-top rounded' href='#page-top'>
    <i class='fas fa-angle-up'></i>
</a>


";
?>

<script type="text/javascript">
    var block = document.getElementById("block");
    block.scrollTop = block.scrollHeight;
    
    function buttonClicked(){
        var display = document.getElementById('box').style.display;
        if(display=='none'){
            document.getElementById('box').style.display='block';
        }else{
            document.getElementById('box').style.display='none';
        }
    }
    
    function buttonClicked1(){
        var display = document.getElementById('box1').style.display;
        if(display=='none'){
            document.getElementById('box1').style.display='block';
        }else{
            document.getElementById('box1').style.display='none';
        }
    }
    function buttonClicked2(){
        var display = document.getElementById('box2').style.display;
        if(display=='none'){
            document.getElementById('box2').style.display='block';
        }else{
            document.getElementById('box2').style.display='none';
        }
    }
</script>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Page level plugin JavaScript-->
<script src="vendor/chart.js/Chart.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.js"></script>
<!-- Custom scripts for all pages-->
<script src="js/sb-admin.min.js"></script>
<!-- Demo scripts for this page-->
<script src="js/demo/datatables-demo.js"></script>
<script src="js/demo/chart-area-demo.js"></script>
</body>
</html>