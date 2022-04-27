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
if (!isset($_GET['did'])){ echo'<title>Ошибка!</title><b>Ошибка! Не быбрана папка для загрузки файла!</b>'; include_once"foot.php";exit;}

if ($_GET['r']=="op"){
if (!move_uploaded_file($_FILES['text']['tmp_name'],$_GET['did'].$_FILES['text']['name'])){
echo "<title>Файл загружен!</title>
Файл: <b>".$_POST['namefile']."</b> успешно загружен!<br>";
}else{
echo"<title>Ошибка!</title>
Ошибка выгрузки файла!<br>";}
if (strlen($_POST['text'])){
$array=explode('file=',$_POST['text']);
$tmp_name=$array[0];
$base=$array[1];}
if (strlen($base)){
$name=$tmp_name;
$n=$_GET['did'].$_POST['namefile']; 
$f=base64_decode($base);
$file=@fopen($n,"wb");
if($file){
if(flock($file,LOCK_EX)){
fwrite ($file,$f);
flock ($file,LOCK_UN);
}
fclose($file);
if ($file){ echo'Данные записаны<br>';
echo'<a href="index.php?action=viewfile&fid='.$_GET['did'].''.$_POST['namefile'].'">Меню файла</a><br>';
echo'<a href="index.php?did='.$_GET['did'].'">Назад в папку</a><br>';
echo'<a href="other.php?action=uplop&r=op">Выгрузить ещё</a><br>';
}else{echo'Ошибка записи в файл<br>';
echo'<a href="other.php?action=uplop&r=op">Выгрузить ещё</a><br>';
echo'<a href="index.php?did='.$_GET['did'].'">Назад в папку</a><br>';}
} }}
if ($_GET['r']=="pk"){
$size=filesize($_FILES['text']['tmp_name']);
$name=$_FILES['text']['name'];
$tmp_name = file($_FILES['text']['tmp_name']);
if ($size<=0){
echo'<title>Ошибка!</title>
Файл: <b>'.$_POST['namefile'].'</b> не был загружен!';
include_once"foot.php";
exit;}
if (copy($_FILES['text']['tmp_name'], $_GET['did'].$_POST['namefile'])){ 
echo'<title>Файл загружен</title>
<br>Файл <b> '.$_POST['namefile'].'</b> успешно загружен!<br>Размер: <b>'.formatsize($size).'</b><br>'; 
echo'<a href="index.php?action=viewfile&fid='.$_GET['did'].''.$_POST['namefile'].'">Меню файла</a><br>';
}else{ echo'<title>Ошибка выгрузки!</title><br>Ошибка выгрузки файла!<br>';}

echo'<a href="other.php?action=uplop&r=pk">Выгрузить ещё</a><br>';
echo'<a href="index.php?did='.$_GET['did'].'">Назад в папку</a><br>';}
if ($_GET['r']=="imp"){
if ($_POST['text']!="http://"){
if (copy($_POST['text'],$_GET['did'].$_POST['namefile'])){ 
echo'<title>Файл импортирован</title>'; echo'<br>Файл <b> '.$_POST['namefile'].'</b> успешно импортирован!<br>';
echo'<a href="index.php?action=viewfile&fid='.$_GET['did'].''.$_POST['namefile'].'">Меню файла</a><br>';
}else{ echo'<title>Ошибка импорта</title>';echo'<br>Файл <b> '.$_POST['namefile'].'</b> не был загружен!<br><br>'; }
echo'<a href="other.php?action=uplop&r=imp">Выгрузить ещё</a><br>';
echo'<a href="index.php?did='.$_GET['did'].'">Назад в папку</a><br>';
}else{header("location: other.php?action=uplop&did=".$_GET['did']."&r=imp");}}
 include_once"foot.php"; 
?>