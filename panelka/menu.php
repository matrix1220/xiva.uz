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

include_once"config.php";
include_once"head.php";
echo'<div class="phdr"><b>Меню</b><br/></div>';
echo '<div class="list1">';

if (!isset($_GET['action'])){echo'
<a href="?action=menu">Логин/Пароль</a><br/>
<a href="?action=other">Прочие настройки</a><br/>';
echo '<a href="faq.php">FAQ</a><br/>';
echo'<a href="?action=exit">Выход</a><br><br>';
echo'<b><a href="index.php">Файловый менеджер</a></b><br>';}
if ($_GET['action']=="other"){
echo'<div class="list1"><form action="?action=others" method="post" />';
echo'<br/>Число строк на страницу в редакторе (max:150):<br/><input type="text" name="str" value="'.(int)$udata[2].'"/><br/>Высота поля ввода (2-15):<br/><input type="text" name="rws" value="'.(int)$udata[4].'"/><br/>Показывать вес папок?<br/><input type="radio" name="pods" value="0" checked="checked"/> Нет<br/><input type="radio" name="pods" value="1"/> Да (<span class="red">Возрастает нагрузка!</span>)<br/>';
echo'<p><input type="submit" value="Изменить"/></p></form></div>';
}
if ($_GET['action']=="exit"){
@SetCookie("cookielog","");
@SetCookie("cookiepass","");
header("Location: index.php"); }
if ($_GET['action']=="others"){ 

if ($_POST['str']==""){echo'<div class="rmenu">Вы забыли ввести колличество строк в редакторе на страницу!<br/>* <a href="?action=other">Назад</a></div>';
echo'<div class="gmenu"><a href="index.php">Файловый менеджер</a></div>'; include_once"foot.php";exit;}
if ($_POST['rws']==""){echo'<div class="rmenu">Вы забыли ввести высоту поля!<br/>* <a href="?action=other">Назад</a></div>';
echo'<div class="gmenu"><a href="index.php">Файловый менеджер</a></div>'; include_once"foot.php";exit;}

if(eregi("[^0-9]",$_POST['str'])){
echo'<div class="rmenu">Не правильный ввод! Нужно вводить только числа!<br>* <a href="?action=other">Назад</a></div>';
echo'<a href="index.php">Файловый менеджер</a><br>'; include_once"foot.php"; exit;}
if(eregi("[^0-9]",$_POST['rws'])){
echo'<div class="rmenu">Не правильный ввод! Нужно вводить только числа!<br>* <a href="?action=other">Назад</a></div>';
echo'<a href="index.php">Файловый менеджер</a><br>'; include_once"foot.php"; exit;}

if($_POST['str'] > 150){
echo'<div class="rmenu">Не правильный ввод! Максимальное число 150 строк на страницу!<br>* <a href="?action=other">Назад</a></div>';
echo'<div class="gmenu">* <a href="index.php">Файловый менеджер</a></div>'; include_once"foot.php";exit;}
if(($_POST['rws'] > 15) || ($_POST['rws'] < 2)){
echo'<div class="rmenu">Не правильный ввод! Высота поля ввода должна быть не менее 2 и не более 15!<br/>* <a href="?action=other">Назад</a></div>';
echo'<div class="gmenu">* <a href="index.php">Файловый менеджер</a></div>'; include_once"foot.php";exit;}

$text=$udata[0].'|'.$udata[1].'|'.$_POST['str'].'|'.$_POST['pods'].'|'.$_POST['rws'].'|';

$fp=fopen("data/user.dat","w");
chmod($fp,666);
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
flock ($fp,LOCK_UN);
chmod($fp,644);
fclose($fp);
echo'<br/><b>Данные успешно изменены!</b><br><br> <a href="menu.php">К настройкам</a><br><a href="index.php">Файловый менеджер</a><br>';

}
if ($_GET['action']=="menu"){ 
echo'<div class="list1"><form action="?action=nastr" method="post" />';
echo'Старый логин:<br/><input type="text" name="log"/><br/>';
echo'Новый логин:<br/><input type="text" name="logs"/><br/>';
echo'Старый пароль:<br/><input type="text" name="par"/><br/>';
echo'Новый пароль:<br/><input type="text" name="pars"/>';
echo'<p><input type="submit" value="Изменить"/></p></form><br/><a href="index.php">В менеджер</a></div>';
}
if ($_GET['action']=="nastr"){
if ($_POST['logs']==""){echo'Не введены важные данные! <b>(Логин)</b><br>* <a href="index.php">В менеджер</a><br>* <a href="?">Вернуться</a><br>';include_once"foot.php";exit;}
if (md5(md5($_POST['log']))!=$udata[0]){echo'Ошибка! Не верно введён <b>старый логин</b><br><a href="index.php">В менеджер</a><br>* <a href="?">Вернуться</a><br>';include_once"foot.php";exit;}
if (md5(md5($_POST['par']))!=$udata[1]){echo'Ошибка! Не верно введён <b>старый пароль</b><br>* <a href="index.php">В менеджер</a><br>* <a href="?">Вернуться</a><br>';include_once"foot.php";exit;}
if ($_POST['pars']==""){echo'Не введены важные данные! <b>(Пароль)</b><br>* <a href="index.php">В менеджер</a><br>* <a href="?">Вернуться</a><br>';include_once"foot.php";exit;}
$_POST['logs']=md5(md5(htmlspecialchars($_POST['logs'])));
$_POST['pars']=md5(md5(htmlspecialchars($_POST['pars'])));
$text=$_POST['logs'].'|'.$_POST['pars'].'|'.$udata[2].'|';
$text=no_br($text);
$fp=fopen("data/user.dat","w");
chmod($fp,666);
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
flock ($fp,LOCK_UN);
chmod($fp,644);
fclose($fp);
echo'<br><b>Данные успешно изменены</b><br>';
echo'<br><a href="index.php">В менеджер</a><br>
* <a href="?">Вернуться</a><br>';
}
echo '</div>';
include_once"foot.php";
?>