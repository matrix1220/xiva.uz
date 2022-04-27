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
if (empty($_GET['copy'])){echo'Ошибка! Не выбран файл/папка для копирования!'; include_once"foot.php";exit;}
$_GET['copy']=str_replace("/","%2f",$_GET['copy']);
if (!isset($_GET['action'])){

$up=dirname(realpath($_GET['did']));
$up=str_replace("/","%2f",$up);
$vi=realpath($_GET['did']);


$dir_array=array();
$dir = opendir ($_GET['did']);
$bc=str_replace("/","%2f",$_GET['did']); echo'<a href="copy.php?action=copy&amp;did='.$bc.'&amp;copy='.$_GET['copy'].'">Выбрать</a><br><a href="copy.php?did=..%2f'.$bc.'&amp;copy='.$_GET['copy'].'">Вверх</a><br>';
while ($file = readdir ($dir)) {
if($file=="."||$file=="..") continue;
$dir_array[]=$file; }
closedir ($dir);
asort($dir_array);

$total = count($dir_array);
if (file_exists($_GET['did'])){ if (!$total<1){
for ($i = 0; $i < $total; $i++){
$_GET['did']=str_replace("%2f","/",$_GET['did']);
if (is_dir($_GET['did']."$dir_array[$i]")){
$_GET['did']=str_replace("/","%2f",$_GET['did']);
echo'<img src="img/dir.gif" alt="/"> <a href="copy.php?did='.$_GET['did'].''.$dir_array[$i].'%2f&amp;copy='.$_GET['copy'].'">'.$dir_array[$i].'</a><br>';}
}}else{echo'<center><b>Папка пуста!</b></center><br>';}}else{echo'<center><b>Не верно указан путь!</b></center>';} }

if ($_GET['action']=="copy"){
$_GET['fid']=realpath(str_replace("%2f","/",$_GET['fid'])); $_GET['did']=realpath(str_replace("%2f","/",$_GET['did'])); $_GET['copy']=realpath(str_replace("%2f","/",$_GET['copy']));
$ext = strtolower(substr($_GET['copy'], 1 + strrpos($_GET['copy'], "/")));
if (copy($_GET['copy'],"".$_GET['did']."/".$ext."")){
echo'<br><b>Файл успешно скопирован!</b><br>';
}else{ echo'Ошибка копирование файла!<br>'; }
}include_once"foot.php";
?>