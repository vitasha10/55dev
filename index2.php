<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>55dev.ru</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet"> 
    <style>
*{
    padding:0;
    margin:0;
    font-family: 'Roboto Slab', serif;
}
header nav ul li{
    display:block;
    float:left;
    text-decoration:none;
}
header nav{
    width:70vw;
    margin:0 auto;
}
header nav:before{
    content:'';
    display:block;
    background:#fff;
    height:10vh;
    width:100%;
    background-color:#000000;
    position:absolute;
    left:0;
    z-index:-1;
}
ul{
    list-style:none;
    height:10vh;
}
header nav ul li a{
    color:#fff;
    display:block;
    height:10vh;
    padding:0 3vh;
    text-transform:uppercase;
    text-decoration:none;
    line-height:10vh;
    transition:0.2s;
}
header nav ul li a:hover{
    background:#b2b2b2;
    color:#000;
    transition:0.2s;
}
.big_logo{
    width:95vw;
    height:90vh;
    display:block;
}
.about_div{
    width:80vw;
    height:100vh;
    margin:0 auto;
}
.about_div:before{
    content:'';
    display:block;
    width:100%;
    height:100vh;
    background-color:#2b2b2b;
    position:absolute;
    left:0;
    z-index:-1;
}
.about_h2{
    color:white;
    padding-top:10vh;
    font-size:4vh;
}
footer nav table tr td li a{
    color:#fff;
    height:10vh;
    padding:0 3vh;
    text-transform:uppercase;
    text-decoration:none;
    line-height:3vh;
    transition:0.2s;
    font-size:1.5vh;
}
footer nav table tr td p{
    color:#fff;
    display:block;
    height:10vh;
    padding:0 2vh;
    text-transform:uppercase;
    text-decoration:none;
    line-height:10vh;
    transition:0.2s;
    font-size:2vh;
}
footer nav{
    width:70vw;
    margin:0 auto;
}
footer nav:before{
    content:'';
    display:block;
    background:#fff;
    height:30vh;
    width:100%;
    background-color:#000000;
    position:absolute;
    left:0;
    z-index:-1;
}
.ils{
    position:absolute;
    color:#fff;
    background-color:#000;
    visibility:hidden;
}
#projects:hover .ils{
    visibility:visible;
}
.teammates_list{
    position:absolute;
    color:#fff;
    height:50vh;
    background-color:#000;
    visibility:hidden;
}
#teammates_header:hover .teammates_list{
    visibility:visible;
}
    </style>
</head>
<body>
    <header>
        <nav class="header">
            <ul>
                <li><a href="/">HOME</a></li>
                <li><a href="/about">ABOUT</a></li>
                <li id="projects"><a href="/projects">PROJECTS</a>
                    <ul class="ils">
                        <li><a href="/ils">I love squares!</a></li>
                    </ul>
                </li>
                <li id="teammates_header"><a href="/teammates">TEAMMATES</a>
                    <ul class="teammates_list">
                        <li>
                            <ul><a href="/teammates/?t=1">Василий Гайсен</a></ul>
                            <ul><a href="/teammates/?t=2">Виталий Сухоплечев</a></ul>
                            <ul><a href="/teammates/?t=3">Максим Ермолаев</a></ul>
                            <ul><a href="/teammates/?t=4">Кирилл Зылёв</a></ul>
                            <ul><a href="/teammates/?t=5">Никита Комягин</a></ul>
                        </li>
                        <li>
                            <ul><a href="/teammates/?t=6">Руслан Идоленко</a></ul>
                            <ul><a href="/teammates/?t=7">Алексей Катаев</a></ul>
                            <ul><a href="/teammates/?t=8">Николай Белявский</a></ul>
                            <ul><a href="/teammates/?t=9">Максим Никоненко</a></ul>
                            <ul><a href="/teammates/?t=10">Макс Дробиденко</a></ul>
                        </li>
                    </ul>
                </li>
                <li><a href="/login">LOGIN</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <img class="big_logo" src="img/big_logo.jpg" alt="big_logo">
        <div class="about_div">
            <h2 class="about_h2">О нас:</h2>
        </div>
    </main>
    <footer>
        <nav class="footer">
            <table>
                <tr>
                    <td>
                        <p>Ссылки:</p>
                    </td>
                    <td>
                        <p>Наша команда:</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <li><a href="/">Главная</a></li>
                        <li><a href="/about">О нас</a></li>
                        <li><a href="/projects">Проекты</a></li>
                        <li><a href="/teammates">Команда</a></li>
                        <li><a href="/login">Логин</a></li>
                    </td>
                    <td>
                        <li><a href="/teammates/?t=1">Василий Гайсен</a></li>
                        <li><a href="/teammates/?t=2">Виталий Сухоплечев</a></li>
                        <li><a href="/teammates/?t=3">Максим Ермолаев</a></li>
                        <li><a href="/teammates/?t=4">Кирилл Зылёв</a></li>
                        <li><a href="/teammates/?t=5">Никита Комягин</a></li>
                    </td>
                    <td>
                        <li><a href="/teammates/?t=6">Руслан Идоленко</a></li>
                        <li><a href="/teammates/?t=7">Алексей Катаев</a></li>
                        <li><a href="/teammates/?t=8">Николай Белявский</a></li>
                        <li><a href="/teammates/?t=9">Максим Никоненко</a></li>
                        <li><a href="/teammates/?t=10">Макс Дробиденко</a></li>
                    </td>
                </tr>
            </table>
        </nav>
    </footer>
</body>
</html>