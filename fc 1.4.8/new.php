<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>55dev.ru</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>
<body>
<div id="t-msg-box"></div>
<table id='msg-box' style='display: block; overflow: auto; max-width: 100wh; max-height:60vh;'>
<?php
echo"
<tr>
  <td>Ава</td>
  <td>Пользователь</td>
  <td>Сообщение</td>
  <td>Дата</td>
  <td>del</td>
</tr>
";
?>
<script>
setInterval(function() {
  $.ajax({
    type: "POST",
    url: 'chat.php',
    data: {beceda:"<?php echo $_GET['b'];?>"},
    success: function(data){
        //Если есть сообщения в принятых данных
        $('#msg-box').remove();
        $("#t-msg-box").append("<table id='msg-box' style='display: block; overflow: auto; max-width: 100wh; max-height:60vh;'></table>");
        //Парсим JSON
        var obj = JSON.parse(data);
        //Проганяем циклом по всем принятым сообщениям
        for(var i=0; i < obj.length; i ++){
            
            //Добавляем в чат сообщениеs
            $("#msg-box").append("<tr>" +
                             "<td><a class='link' href='?u=1'><img class='logo2123' src='{$result1['ava']}' alt='ava'></a></td>"+
                             "<td>"+
                             "<ul style='padding-left:unset; margin-bottom:0;'>"+
                             "<p style='margin: 1vh 0vh 0vh 0vh; color:orange;'>"+obj[i].user+"</p>" +
                             "</ul>" +
                             "<ul style='padding-left:unset;'>"
                             +obj[i].text+
                             "</ul>" +
                             "</td>" +
                             "<td><p style='margin: 1vh 0vh 0vh 0vh; font-size:2vh;'>{$result['date']}" +
                             "<form method='post' action=''>" +
                                      "<input type='hidden' name='dell_sms' value='{$result['ID']}'>" +
                                      "<input class='small_btn123' type='submit' value='Удалить'>" +
                                  "</form></p></td>" +
                             "</tr>");
            //$("#msg-box").append("<li><b>"+obj[i].user+"</b>: "+obj[i].text+"</li>");
        }
        //Прокручиваем чат до самого конца
        //$("#msg-box").scrollTop(2000);
        
    }
});
}, 10000);
//Обновляем чат каждые две секунды
//$("#t-msg-box").everyTime(2000, function () {
//$("#t-msg-box").everyTime(2000, 'refresh', function() {
   //get_message_chat();
//});

</script>
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

</body>
</html>