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

include_once"config.php"; include_once"head.php";
echo '<div class="list1">';
if (!isset($_GET['action'])){echo'<title>Ошибка!</title>Не выбранна команда!'; include_once"foot.php";exit; }
if ($_GET['action']=="dir"){
if (!isset($_GET['did'])){ echo'<title>Ошибка</title><b>Ошибка! Не быбранна папка!</b>'; include_once"foot.php"; exit;} 
echo'<title>Создание папки</title><br>Название папки с маленьких латинских букв<br><b>a-z 0-9_</b>';
$_GET['did']=str_replace("/","%2f",$_GET['did']); echo '<br><form action="?action=sdir&did='.$_GET['did'].'" method="post">';
echo '<input type="text" name="name"><br>';
echo'<input type="submit" value="Добавить"/></form>';
echo'<a href="index.php?did='.$_GET['did'].'">Назад</a><br>';
}
if ($_GET['action']=="sdir"){ if(eregi("[^a-z0-9_]",$_POST['name'])){echo'<title>Ошибка!</title>Ошибка! Не допустимое название папки!'; echo'<a href="other.php?action=dir&did='.$_GET['did'].'">Назад</a><br>'; echo'<a href="index.php?did='.$_GET['did'].'">В менеджер</a><br>';include_once"foot.php";exit;
}
$dir=$_GET['did'].$_POST['name']; if (mkdir($dir)){
echo'<title>Выполнено!</title>Папка успешно создана!';
$dir=str_replace("/","%2f",$dir); echo'<br><a href="index.php?did='.$dir.'%2f">К папке</a><br> 
<a href="index.php?action=viewdir&did='.$dir.'%2f">Меню папки</a><br>';
echo'<a href="index.php?did='.$_GET['did'].'">Назад</a><br>';
 }else{echo'<title>Ошибка!</title>Ошибка создания папки!';}}
if ($_GET['action']=="file"){
$_GET['did']=str_replace("/","%2f",$_GET['did']); echo '<title>Создания файла</title>';
echo'<b>Создание файла</b><br><br>';
if (!isset($_GET['did'])){echo'Не быбрана папка для создания в ней файла!<br>';}
echo'<form action="?action=sfile&did='.$_GET['did'].'" method="post">';
echo 'Имя файла: например: <b>index.php</b><br/><input type="text" name="name"><br/>';
echo "Содержимое файла:<br/><textarea rows=\"$udata[4]\" tupe=\"text\" name=\"file\"><?php\n</textarea><br/>";
echo'<input type="submit" value="Создать"/></form>';
echo'<a href="index.php?did='.$_GET['did'].'">Назад</a><br>';
}
if ($_GET['action']=="sfile"){ 
$fp=fopen($_GET['did'].$_POST['name'],"w");
flock ($fp,LOCK_EX);
fputs($fp,$_POST['file']."\r\n");
flock ($fp,LOCK_UN);
fclose($fp);
if ($fp){ echo'<title>Выполнено!</title>'; echo'Файл успешно создан!<br>'; $_GET['did']=str_replace("/","%2f", $_GET['did']);
echo'<a href="index.php?action=viewfile&fid='.$_GET['did'].''.$_POST['name'].'">Меню файла</a><br>';
echo'<a href="index.php?did='.$_GET['did'].'">Назад</a><br>';
echo'<a href="index.php">Файловый менеджер</a><br>';
}else{echo'<title>Ошибка!</title>Ошибка создания файла!';}
}
if ($_GET['action']=="uplop"){ 
if (!isset($_GET['did'])){ echo'Ошибка! Не выбрана директория для загрузки файла!'; include_once"foot.php";exit;}
echo'<title>Загрузка файла</title>';
echo'<br><b>Загрузка файла</b><br><br>';
echo'<br><b>Максимальный размер файла: '.ini_get('upload_max_filesize').'.</b><br>';

$_GET['did']=str_replace("/","%2f", $_GET['did']);
echo'Файл:<br>';
if ($_GET['r']=="op"){
echo'<form enctype="multipart/form-data" method="post" action="upload.php?did='.$_GET['did'].'&r=op">'; 
}
if ($_GET['r']=="pk"){
echo'<form enctype="multipart/form-data" method="post" action="upload.php?did='.$_GET['did'].'&r=pk">'; }
if ($_GET['r']=="imp"){echo'<form method="post" action="upload.php?did='.$_GET['did'].'&r=imp">'; }
if ($_GET['r']=="op"){ 
echo'<input type="text" name="text"><br><a href="op:fileselect">Выбрать файл</a><br>'; 
}
if ($_GET['r']=="pk"){ echo'<input type="file" name="text">';} 
if ($_GET['r']=="imp"){ echo'<input value="http://" name="text" />';}
echo'<br/>Сохранить как:<br/><input type="text" name="namefile"><br>
<input type="submit" value="Загрузить"/></form>';
echo'<table><a href="index.php?did='.$_GET['did'].'">Назад</a><br></table>';
}
echo '</div>';
include_once"foot.php";