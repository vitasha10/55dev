<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>55dev.ru</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="img/big_logo.jpg" type="image/x-icon">
    <style>
        header{
            background: #222930;
            /*
            background: -webkit-linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%);
            background: -moz-linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%);
            background: -o-linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%);
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%);
            */
            height:100vh;
            width:100%;
            text-align:center;
            display:block;
            z-index:-1;
            color:#4EB1BA;
        }
        header nav ul li{
            display:block;
            float:left;
            text-decoration:none;
        }
        header nav ul li a{
            color:#33A9C4;
            display:block;
            height:10vh;
            padding:0 7vw;
            text-transform:uppercase;
            text-decoration:none;
            line-height:10vh;
            transition:0.2s;
            font-size:1.3vw;
        }
        header nav ul li a:hover{
            color:#000;
            transition:0.3s;
        }
        .ils{
            margin:0 0 0 -2vw;
            position:absolute;
            color:#fff;
            visibility:hidden;
        }
        #projects:hover .ils{
            visibility:visible;
        }
        /*
        .teammates_list{
            position:absolute;
            color:#fff;
            height:50vh;
            visibility:hidden;
        }
        #teammates_header:hover .teammates_list{
            visibility:visible;
            margin:0 0 0 -20%;
        }
        */
        nav{
            height:10vh;
            width:100%;
            display:block;
            padding:0 auto;
            color:#E9E9E9;
        }
        main{
            width:100%;
            background:#E9E9E9;
            color:#222930;
        }
        h1{
            font-size:10vh;
            padding-top:30vh;
        }
        *{
            margin:0;
            padding:0;
            font-family: 'Roboto Slab', serif;
        }
        .about{
            height:100vh;
            padding:0 10vh;
        }
        footer{
            border-top:5px;
            border-color:black;
            background-color:#222930;
            height:50vh;
            color:#E9E9E9;
        }
        .footer_hrefs{
            padding:5vh 10vh;
            text-transform:uppercase;
            text-decoration:none;
        }
        .footer_hrefs a{
            color:#33A9C4;
            display:block;
            line-height:5vh;
        }
        .footer_hrefs a:before{
            font-family: 'FontAwesome';
            content: "\f105";
            font-style: normal;
            text-transform:uppercase;
            text-decoration: none;
        }
        .copyright{
            text-align:center;
        }
        h2{
            padding-top: 3vh;
            font-size:10vh;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/">Главная</a></li>
                <li><a href="#about">О нас</a></li>
                <li id="projects"><a href="/projects">Проекты</a>
                    <ul class="ils">
                        <li><a href="/ils">I love squares!</a></li>
                    </ul>
                </li>
                <li id="teammates_header"><a href="/teammates">Команда</a>
                <!--
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
                -->
                </li>
                <li><a href="/login">Логин</a></li>
            </ul>
        </nav>
        <h1>55dev.ru</h1>
    </header>
    <main>
        <div id="about" class="about">
            <h2>О нас</h2>
            <p>Коротко о нашей компании. text1</p>
        </div>
    </main>
    <footer>
        <div class="footer_hrefs">
            <p>Меню:</p>
            <a href="/">Главная</a>
            <a href="#about">О нас</a>
            <a href="/projects">Проекты</a>
            <a href="/teammates">Команда</a>
            <a href="/login">Логин</a>
        </div>
        <p class="copyright">Copyright © All rights reserved</p>
    </footer>
</body>
</html>