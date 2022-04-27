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

if (!isset($_GET['action'])){
echo'<title>Ошибка!</title><br><b>Ошибка! Не выбранна команда!</b><br>';
include_once"foot.php";
exit;}
if (!file_exists($_GET['did'])){
echo'<title>Ошибка!</title>
<br><b>Ошибка!</b>
<br><br>Такой директории не существует!<br>'; 
include_once"foot.php";
exit;}
if ($_GET['action']=="deldir"){
if ($_GET['r']=="1"){
function deldir($directory) { 
$dir = opendir($directory); 
while($file = readdir($dir)){
if(is_file("$directory/$file")){
unlink("$directory/$file"); 
 } 	elseif (is_dir("$directory/$file") && $file !== "." && $file !== "..") {
deldir("$directory/$file");
		}
		}
		closedir($dir);
if(rmdir($directory))
			return true; }
if (deldir($_GET['did'])){
echo'<title>Выполнено!</title>
<br><b>Директория удалена!</b><br>';
}else{echo'<title>Ошибка!</title>
<br><b>Ошибка удаления директории!</b>
<br>Посмотрите, возможно права доступа не разраешают удалять файлы/папки';}
}else{
$_GET['did']=str_replace("/","%2f",$_GET['did']);
echo'<title>Удалить?</title>';
echo'<br><b>Вы подтверждаете что хотите удалить дерикторию?</b><br>
<a href="?action=deldir&r=1&did='.$_GET['did'].'">Да</a> <a href="index.php?action=viewdir&did='.$_GET['did'].'">Нет</a><br>'; } }
if ($_GET['action']=="rename"){
echo'<title>Переименование</title>';
$_GET['did']=str_replace("%2f","/",$_GET['did']);
$exp = dirname(realpath($_GET['did'])); $exts = realpath($_GET['did']);  $exti=str_replace($exp,$exts,$exts); $ext = strtolower(substr($exti, 1 + strrpos($exti, "/")));
$_GET['did']=str_replace("/","%2f",$_GET['did']); echo'<form action="?action=renamer&did='.$_GET['did'].'" method="post" />';
echo'<b>Перименование файла/папки</b><br/><br/>Название:<br/> <input type="hidden" name="starname" value="'.$ext.'"/><br/>'; echo'<input name="newname" value="'.$ext.'"/><br/>';
echo'<input type="submit" value="Переименовать"/></form>';
}
if ($_GET['action']=="renamer"){ 
if(eregi("[^a-z_0-9-]",$_POST['newname'])){ echo'<title>Ошибка!</title> <br>Ошибка! Не верное название файла! Допустимые символы: a-z _ 0-9 -<br>'; include_once"foot.php";exit;}
$a=str_replace($_POST['starname'],$_POST['newname'],$_GET['did']);
 if (rename($_GET['did'],$a)){echo'<title>Выполнено!</title><br>Файл/Папка успешно переминована!<br>'; 
}else{echo'<title>Ошибка!</title> Ошибка переименования Файла/Папки'; }
}
if ($_GET['action']=="cleardir"){
if ($_GET['r']=="1"){
function deldir($directory) { 
$dir = opendir($directory); 
while($file = readdir($dir)){
if(is_file("$directory/$file")){
unlink("$directory/$file");
 } 	elseif (is_dir("$directory/$file") && $file !== "." && $file !== "..") {
deldir("$directory/$file");
		}
		}
		closedir($dir);
if(rmdir($directory))
if(mkdir($directory))
			return true; }
if (deldir($_GET['did'])){
echo'<title>Выполнено!</title><br>
<b>Директория успешно очищена!</b><br>';
}else{
echo'<title>Ошибка!</title>
<br><b>Ошибка очистки директории!</b><br>'; }
}else{
$_GET['did']=str_replace("/","%2f",$_GET['did']);
echo'<title>Очистить?</title>';
echo'<br><b>Вы подтверждаете что хотите очистить директорию?</b><br>
<a href="?action=cleardir&r=1&did='.$_GET['did'].'">Да</a> <a href="index.php?action=viewdir&did='.$_GET['did'].'">Нет</a><br>'; } }
if ($_GET['action']=="chmod"){
$ext=substr(sprintf("%o",fileperms($_GET['did'])),-3);
$_GET['did']=str_replace("/","%2f", $_GET['did']);
echo'<form action="?action=chmode&did='.$_GET['did'].'" method="post" /><title>Права доступа</title><b>Права доступа</b><br>';
echo'Chmod:<br/><input name="chmod" size="5" value="'.$ext.'"/><br/>';
echo'<input type="submit" value="Установить"/></form>';
}
if ($_GET['action']=="chmode"){
$_GET['did']=str_replace("%2f","/", $_GET['did']);
if(eregi("[^0-9]",$_POST['chmod'])){ echo'<title>Ошибка!</title> Не верно введены права доступа! Вводите только числа!'; include_once"foot.php"; exit;}
$chmod='0'.$_POST['chmod']; if (chmod($_GET['did'],$chmod)){  echo'<title>Выполнено!</title> <br>Прова доступа установлены! ('.$_POST['chmod'].')<br>';
 }else{echo'<title>Ошибка</title>Ошибка установки прав доступа! Операция не позволяет! ('.$_POST['chmod'].')<br>';}
}
if ($_GET['action']=="info"){ 
echo'<title>Информация</title>
';
echo'Размер папки: '.formatsize(read_dir($_GET['did'])).'';
echo'<br>
Права доступа: '.substr(sprintf("%o",fileperms($_GET['did'])),-3).'<br>';}
include_once"foot.php";
?>