<?php
/*
Автор скрипта: Juse
http://mafix.ru
Модификация: Jasis
http://mirmastera.ru
Глобальное обновление от Pillott
http://delowap.ru
admin@delowap.ru
-------
Установка
Распаковать архив в корень и перейти по адресу http://ваш_сайт.ru/panelka/
Логин: admin
Пароль: 12345
Потом смените в настройках
-------
*/

error_reporting(0); 
include_once"head.php";
echo '<div class="centrik">'; 
$file=file("data/user.dat"); 
$udata=explode("|",$file[0]);
if ($_GET['isset']=="noauth"){echo'<div class="rmenu">Не корректная пара! <br/>Логин или Пароль!</div>';
}else{echo'<div class="rmenu">Введите логин и пароль!</div>';}
if (!isset($_GET['action'])){ 
echo'<form action="?action=auth" method="post" />';
echo'<div class="menu"><b>Логин:</b><br/><input type="text" name="login"/><br/>';
echo'<b>Пароль:</b><br/><input type="password" name="pass"/>';
echo'<p><input type="submit" value="Войти" /></p></form></div>';
}
if ($_GET['action']=="auth"){ 
$_POST['login']=md5(md5(htmlspecialchars($_POST['login']))); $_POST['pass']=md5(md5(htmlspecialchars($_POST['pass']))); if ($udata[0]==$_POST['login'] && $udata[1]==$_POST['pass']){ 
SetCookie("cookielog",htmlspecialchars($_POST['login']),time()+3600);
SetCookie("cookiepass",htmlspecialchars($_POST['pass']),time()+3600);
header("Location: index.php"); 
}else{header('Location: ?isset=noauth&'); exit;} 
}
echo '</div>';
include'foot.php';
?>
