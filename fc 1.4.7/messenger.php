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
    <link href="style.css" rel="stylesheet">
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
    $result = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `peoples` WHERE `userid`='{$_COOKIE['userid']}'"));
    //$sql = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `_server_` WHERE `userid`={$_COOKIE['userid']}"));
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
    
    
    
    if(isset($_FILES) && $_FILES['inputfile']['error'] == 0 && $_FILES['inputfile']['name']!=''){
        $destiation_dir = dirname(__FILE__) .'/files/'.$_FILES['inputfile']['name']; // Директория для размещения файла
        move_uploaded_file($_FILES['inputfile']['tmp_name'], $destiation_dir ); // Перемещаем файл в желаемую директорию
        $file=$_FILES['inputfile']['type'];
        if($file){
        if($file=='audio/mp4' or $file=='audio/aac' or $file=='audio/ogg' or $file=='audio/mpeg' or $file=='audio/vnd.wave'){
            $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '<audio src=\'http://55dev.ru/fc/files/{$_FILES['inputfile']['name']}\' preload=\'none\' controls></audio>', '{$date}')");
        }else if($file=='image/gif' or $file=='image/jpeg' or $file=='image/pjpeg' or $file=='image/png' or $file=='image/svg+xml' or $file=='image/tiff' or $file=='image/vnd.microsoft.icon' or $file=='image/vnd.wap.wbmp' or $file=='image/webp'){
            $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `<d></d>ate`) VALUES ('{$_COOKIE['userid']}', '{$string}', '<img class=\'imgchat\' src=\'http://55dev.ru/fc/files/{$_FILES['inputfile']['name']}\' alt=\'ava\'><br>', '{$date}')");
        }else if($file=='video/mpeg' or $file=='video/mp4' or $file=='video/ogg' or $file=='video/webm' or $file=='video/3gpp'){
            $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '<video class=\'video\' src=\'http://55dev.ru/fc/files/{$_FILES['inputfile']['name']}\' controls /><br>', '{$date}')");
        }else{
            $sql = mysqli_query($link, "INSERT INTO `chat` (`user`, `beceda`, `text`, `date`) VALUES ('{$_COOKIE['userid']}', '{$string}', '<a href = \'http://55dev.ru/fc/files/{$_FILES['inputfile']['name']}\'>Файл: {$_FILES['inputfile']['name']}</a><br>', '{$date}')");
        }
        }
    }
    
    
    /*
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
    */
    
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
        <li class='nav-item'>
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
        <li class='nav-item active'>
            <a class='nav-link' href=''>
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
            if(isset($_GET['ls']) or isset($_GET['b']) or isset($_POST["text"]) or isset($_GET['dell_sms']) or isset($_POST["sm1"]) or isset($_POST["sm2"]) or isset($_POST["sm3"]) or isset($_POST["sm4"]) or isset($_POST["sm5"]) or isset($_POST["sm6"]) or isset($_POST["sm7"]) or isset($_POST["sm8"]) or isset($_POST["sm9"])){
            //Чаты  
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
                        <input class='btn123' type='button' value='|||' id='btn31' onclick='buttonClicked2();' />
                    </td>
                    </table>
                    <div id='box2' class='okno123' style='display: none; position: absolute;'>
                        <form action='' method='post'>
                            <table>
                                <tr>
                                    
                                    <td><input type='text' class='btn123' name='beceda_name' value='{$dopresult['name']}'></td>
                                </tr>
                                <tr>
                                    <td colspan='2'><input type='submit' class='btn123' value='OK'></td>
                                </tr>
                            </table>
                        </form>
                        <form action='' method='post'>
                            <input type='hidden' class='btn123' name='beceda' value='{$_GET['b']}'></td>
                            <input type='submit' class='btn123' name='truncate' value='Очистить беседу'></td>
                        </form>
                    </div>
                ";
                }
                echo"<table id='block' style='display: block; overflow: auto; max-width: 100wh; max-height:60vh;'>";
                $sql = mysqli_query($link, "SELECT `ID`, `user`, `text`, DATE_FORMAT(`date`,'%d/%m/%Y<br> %H:%i') AS `date` FROM `chat` WHERE `beceda`='{$string}'");
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
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2123' src='{$result1['ava']}' alt='ava'></a>
                             </td>".
                             "<td>".
                             "<ul style='padding-left:unset; margin-bottom:0;'>".
                             "<p style='margin: 1vh 0vh 0vh 0vh; color:orange;'>{$result1['name']}</p>" .
                             "</ul>".
                             "<ul style='padding-left:unset;'>".
                             "{$result['text']}" .
                             "</ul>".
                             "</td>".
                             "<td><p style='margin: 1vh 0vh 0vh 0vh; font-size:2vh;'>{$result['date']}" .
                             "<form method='post' action=''>
                                      <input type='hidden' name='dell_sms' value='{$result['ID']}'>
                                      <input class='small_btn123' type='submit' value='Удалить'>
                                  </form></p></td>".
                             '</tr>';
                        }
                        if($result1["priv"]=="B"){
                            echo '<tr>' .
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2123' src='{$result1['ava']}' alt='ava'></a>
                             </td>".
                             "<td>".
                             "<ul style='padding-left:unset; margin-bottom:0;'>".
                             "<p style='margin: 1vh 0vh 0vh 0vh; color:#8b00ff;'>{$result1['name']}</p>" .
                             "</ul>".
                             "<ul style='padding-left:unset;'>".
                             "{$result['text']}" .
                             "</ul>".
                             "</td>".
                             "<td><p style='margin: 1vh 0vh 0vh 0vh; font-size:2vh;'>{$result['date']}" .
                             "<form method='post' action=''>
                                      <input type='hidden' name='dell_sms' value='{$result['ID']}'>
                                      <input class='small_btn123' type='submit' value='Удалить'>
                                  </form></p></td>".
                             '</tr>';
                            /*
                            echo '<tr>' .
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2123' src='{$result1['ava']}' alt='ava'></a>
                            </td>".
                             "<td><p style='color:#8b00ff;'>{$result1['name']}</p></td>" .
                             "<td>{$result['text']}</td>" .
                             "<td>{$result['date']}</td>" .
                             "<td><form method='post' action=''>
                                      <input type='hidden' name='dell_sms' value='{$result['ID']}'>
                                      <input class='small_btn123' type='submit' value='Удалить'>
                                  </form></td>".
                             '</tr>';
                             */
                        }
                        if($result1["priv"]=="C"){
                            echo '<tr>' .
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2123' src='{$result1['ava']}' alt='ava'></a>
                             </td>".
                             "<td>".
                             "<ul style='padding-left:unset; margin-bottom:0;'>".
                             "<p style='margin: 1vh 0vh 0vh 0vh; color:blue;'>{$result1['name']}</p>" .
                             "</ul>".
                             "<ul style='padding-left:unset;'>".
                             "{$result['text']}" .
                             "</ul>".
                             "</td>".
                             "<td><p style='margin: 1vh 0vh 0vh 0vh; font-size:2vh;'>{$result['date']}" .
                             "<form method='post' action=''>
                                      <input type='hidden' name='dell_sms' value='{$result['ID']}'>
                                      <input class='small_btn123' type='submit' value='Удалить'>
                                  </form></p></td>".
                             '</tr>';
                            
                        }
                        if($result1["priv"]=="D"){
                            echo '<tr>' .
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2123' src='{$result1['ava']}' alt='ava'></a>
                             </td>".
                             "<td>".
                             "<ul style='padding-left:unset; margin-bottom:0;'>".
                             "<p style='margin: 1vh 0vh 0vh 0vh; color:green;'>{$result1['name']}</p>" .
                             "</ul>".
                             "<ul style='padding-left:unset;'>".
                             "{$result['text']}" .
                             "</ul>".
                             "</td>".
                             "<td><p style='margin: 1vh 0vh 0vh 0vh; font-size:2vh;'>{$result['date']}" .
                             "<form method='post' action=''>
                                      <input type='hidden' name='dell_sms' value='{$result['ID']}'>
                                      <input class='small_btn123' type='submit' value='Удалить'>
                                  </form></p></td>".
                             '</tr>';
                        }
                    }
                    echo"
                    </table>
                    <div id='box' class='okno123' style='display: none; position: absolute;'>
                        <table>
                            <tr>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128515;' id='btn3' onclick='command1();' />
                                </td>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128514;' id='btn3' onclick='command2();' />    
                                </td>
                                <td>
                                    <input class='small_btn123' type='button' value='&#129315;' id='btn3' onclick='command3();' />  
                                </td>    
                            </tr>
                            <tr>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128527;' id='btn3' onclick='command4();' />    
                                </td>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128528;' id='btn3' onclick='command5();' /> 
                                </td>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128541;' id='btn3' onclick='command6();' />
                                </td>    
                            </tr>
                            <tr>
                                <td>    
                                    <input class='small_btn123' type='button' value='&#128526;' id='btn3' onclick='command7();' />    
                                </td>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128545;' id='btn3' onclick='command8();' />
                                </td>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128524;' id='btn3' onclick='command9();' />
                                </td>    
                            </tr>
                        </table>
                    </div>
                    <form action='' method='post'>
                    <table>
                      <tr>
                        <input style='max-width:25vh;' id='value1' type='text' name='text' value=''>
                      </tr>
                      <tr>
                        <input class='btn123' type='button' value='&#128515;' id='btn3' onclick='buttonClicked();' />
                        <input class='btn123' type='submit' value='OK'>
                      </tr>
                    </table>
                    </form>
                    <form method='post' action='' enctype='multipart/form-data'>
                        <table>
                          <tr>
                            <input class='small_btn123' type='file' id='inputfile' name='inputfile'>
                          </tr>
                          <tr>
                            <input class='small_btn123' type='submit' value='Загрузить любой файл'>
                          </tr>
                        </table>
                    </form>
                    <table>
                        <tr>
                            <td>
                            <form action='' method='post'>
                                <input type='submit' class='btn123' value='обновить'></td>
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
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2123' src='{$result1['ava']}' alt='ava'></a>
                             </td>".
                             "<td>".
                             "<ul style='padding-left:unset; margin-bottom:0;'>".
                             "<p style='margin: 1vh 0vh 0vh 0vh; color:blue;'>{$result1['name']}</p>" .
                             "</ul>".
                             "<ul style='padding-left:unset;'>".
                             "{$result['text']}" .
                             "</ul>".
                             "</td>".
                             "<td><p style='margin: 1vh 0vh 0vh 0vh; font-size:2vh;'>{$result['date']}" .
                             "<form method='post' action=''>
                                      <input type='hidden' name='dell_sms' value='{$result['ID']}'>
                                      <input class='small_btn123' type='submit' value='Удалить'>
                                  </form></p></td>".
                             '</tr>';
                            }
                            if($result1["priv"]=="D"){
                            echo '<tr>' .
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2123' src='{$result1['ava']}' alt='ava'></a>
                             </td>".
                             "<td>".
                             "<ul style='padding-left:unset; margin-bottom:0;'>".
                             "<p style='margin: 1vh 0vh 0vh 0vh; color:green;'>{$result1['name']}</p>" .
                             "</ul>".
                             "<ul style='padding-left:unset;'>".
                             "{$result['text']}" .
                             "</ul>".
                             "</td>".
                             "<td><p style='margin: 1vh 0vh 0vh 0vh; font-size:2vh;'>{$result['date']}" .
                             "<form method='post' action=''>
                                      <input type='hidden' name='dell_sms' value='{$result['ID']}'>
                                      <input class='small_btn123' type='submit' value='Удалить'>
                                  </form></p></td>".
                             '</tr>';
                            }
                        }else{
                            if($result1["priv"]=="null"){
                                echo '<tr>' .
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2123' src='{$result1['ava']}' alt='ava'></a>
                             </td>".
                             "<td>".
                             "<ul style='padding-left:unset; margin-bottom:0;'>".
                             "<p style='margin: 1vh 0vh 0vh 0vh; color:orange;'>{$result1['name']}</p>" .
                             "</ul>".
                             "<ul style='padding-left:unset;'>".
                             "{$result['text']}" .
                             "</ul>".
                             "</td>".
                             "<td><p style='margin: 1vh 0vh 0vh 0vh; font-size:2vh;'>{$result['date']}" .
                            "</p></td>".
                             '</tr>';
                            }
                            if($result1["priv"]=="B"){
                                echo '<tr>' .
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2123' src='{$result1['ava']}' alt='ava'></a>
                             </td>".
                             "<td>".
                             "<ul style='padding-left:unset; margin-bottom:0;'>".
                             "<p style='margin: 1vh 0vh 0vh 0vh; color:#8b00ff;'>{$result1['name']}</p>" .
                             "</ul>".
                             "<ul style='padding-left:unset;'>".
                             "{$result['text']}" .
                             "</ul>".
                             "</td>".
                             "<td><p style='margin: 1vh 0vh 0vh 0vh; font-size:2vh;'>{$result['date']}" .
                            "</p></td>".
                             '</tr>';
                            }
                            if($result1["priv"]=="C"){
                                echo '<tr>' .
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2123' src='{$result1['ava']}' alt='ava'></a>
                             </td>".
                             "<td>".
                             "<ul style='padding-left:unset; margin-bottom:0;'>".
                             "<p style='margin: 1vh 0vh 0vh 0vh; color:blue;'>{$result1['name']}</p>" .
                             "</ul>".
                             "<ul style='padding-left:unset;'>".
                             "{$result['text']}" .
                             "</ul>".
                             "</td>".
                             "<td><p style='margin: 1vh 0vh 0vh 0vh; font-size:2vh;'>{$result['date']}" .
                            "</p></td>".
                             '</tr>';
                            }
                            if($result1["priv"]=="D"){
                                echo '<tr>' .
                             "<td><a class='link' href='?u={$result['user']}'><img class='logo2123' src='{$result1['ava']}' alt='ava'></a>
                             </td>".
                             "<td>".
                             "<ul style='padding-left:unset; margin-bottom:0;'>".
                             "<p style='margin: 1vh 0vh 0vh 0vh; color:green;'>{$result1['name']}</p>" .
                             "</ul>".
                             "<ul style='padding-left:unset;'>".
                             "{$result['text']}" .
                             "</ul>".
                             "</td>".
                             "<td><p style='margin: 1vh 0vh 0vh 0vh; font-size:2vh;'>{$result['date']}" .
                            "</p></td>".
                             '</tr>';
                            }
                        }
                    }
                    echo"</table>
                    <div id='box' class='okno123' style='display: none; position: absolute;'>
                        <table>
                            <tr>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128515;' id='btn3' onclick='command1();' />
                                </td>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128514;' id='btn3' onclick='command2();' />    
                                </td>
                                <td>
                                    <input class='small_btn123' type='button' value='&#129315;' id='btn3' onclick='command3();' />  
                                </td>    
                            </tr>
                            <tr>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128527;' id='btn3' onclick='command4();' />    
                                </td>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128528;' id='btn3' onclick='command5();' /> 
                                </td>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128541;' id='btn3' onclick='command6();' />
                                </td>    
                            </tr>
                            <tr>
                                <td>    
                                    <input class='small_btn123' type='button' value='&#128526;' id='btn3' onclick='command7();' />    
                                </td>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128545;' id='btn3' onclick='command8();' />
                                </td>
                                <td>
                                    <input class='small_btn123' type='button' value='&#128524;' id='btn3' onclick='command9();' />
                                </td>    
                            </tr>
                        </table>
                    </div>
                    <form action='' method='post'>
                    <table>
                      <tr>
                        <td>Сообщение:</td>
                        <td><input class='btn123' id='value1' type='text' name='text' value=''></td>
                        <td>
                            <input class='btn123' type='button' value='&#128515;' id='btn3' onclick='buttonClicked();' />
                        </td>
                        <td colspan='2'><input class='btn123' type='submit' value='OK'></td>
                      </tr>
                    </table>
                    </form>
                    <form method='post' action='' enctype='multipart/form-data'>
                        <table>
                          <tr>
                            <td><input class='small_btn123' type='file' id='inputfile' name='inputfile'></br></td>
                            <td colspan='2'><input class='small_btn123' type='submit' value='Загрузить любой файл'></td>
                          </tr>
                        </table>
                    </form>
                    <table>
                        <tr>
                            <td>
                            <form action='' method='post'>
                                <input type='submit' class='btn123' value='обновить'></td>
                            </form>
                            </td>
                        </tr>
                    </table>
                    ";
                }
            }else{
                $massiv=unserialize($sql1['dialogs']);
                foreach($massiv as $value){
                    echo "<a class='link' href='http://55dev.ru/fcver/messenger.php?".$value."'>ссылка</a><br>";
                }
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
    function command1(){
        document.getElementById('value1').value = document.getElementById('value1').value + "&#128515;";
    }
    function command2(){
        document.getElementById('value1').value = document.getElementById('value1').value + "&#128514;";
    }
    function command3(){
        document.getElementById('value1').value = document.getElementById('value1').value + "&#129315;";
    }
    function command4(){
        document.getElementById('value1').value = document.getElementById('value1').value + "&#128527;";
    }
    function command5(){
        document.getElementById('value1').value = document.getElementById('value1').value + "&#128528;";
    }
    function command6(){
        document.getElementById('value1').value = document.getElementById('value1').value + "&#128541;";
    }
    function command7(){
        document.getElementById('value1').value = document.getElementById('value1').value + "&#128526;";
    }
    function command8(){
        document.getElementById('value1').value = document.getElementById('value1').value + "&#128545;";
    }
    function command9(){
        document.getElementById('value1').value = document.getElementById('value1').value + "&#128524;";
    }
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