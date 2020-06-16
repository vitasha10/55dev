<?php
$host = 'localhost';  // Хост, у нас все локально
$user = 'j92230e0_root';    // Имя созданного вами пользователя
$pass = 'rootroot'; // Установленный вами пароль пользователю
$db_name = 'j92230e0_root';   // Имя базы данных
$link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой


//$sql = mysqli_query($link, "SELECT * FROM `chat`");
$sql = mysqli_query($link, "SELECT `ID`, `user`, `text`, DATE_FORMAT(`date`,'%d/%m/%Y<br> %H:%i') AS `date` FROM `chat` WHERE `beceda`='{$_POST['beceda']}'");
echo json_encode($sql->fetch_all(MYSQLI_ASSOC));

//$result50 = mysqli_fetch_array(mysqli_query($link, "SELECT `priv` FROM `peoples` WHERE `peoples`.`userid`='{$_COOKIE['userid']}'"));
?>