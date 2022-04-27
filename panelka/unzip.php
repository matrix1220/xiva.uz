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
include_once"pclzip.php";
if (!isset($_GET['zip'])){echo'<title>Ошибка!</title>Ошибка! Не выбран архив!'; include_once"foot.php"; exit; }
$_GET['zip']=str_replace("/","%2f", $_GET['zip']);
if (!isset($_GET['action'])){

$up=dirname(realpath($_GET['did'])); 
$up=str_replace("/","%2f",$up); 
$vi=realpath($_GET['did']);

$dir_array=array();
$dir = opendir ($_GET['did']);
$bc=str_replace("/","%2f",$_GET['did']); 
if (!$_GET['q']){
echo'<a href="unzip.php?action=unzip&did='.$bc.'&zip='.$_GET['zip'].'">Выбрать</a><br>'; 
}else{echo'<table><a href="unzip.php?action=inzips&did='.$bc.'&zip='.$_GET['zip'].'&name='.$_GET['name'].'">Сохранить</a><br>'; }
while ($file = readdir ($dir)) {
if($file=="."||$file==".."||$file=="cpanel") continue;
$dir_array[]=$file; }  
closedir ($dir); 
asort($dir_array);

$total = count($dir_array);  
if (file_exists($_GET['did'])){ if (!$total<1){ 
for ($i = 0; $i < $total; $i++){
$_GET['did']=str_replace("%2f","/",$_GET['did']);
if (is_dir($_GET['did']."$dir_array[$i]")){
$_GET['did']=str_replace("/","%2f",$_GET['did']);
echo'<img src="img/dir.gif" alt="/"> <a href="unzip.php?did='.$_GET['did'].''.$dir_array[$i].'%2f&zip='.$_GET['zip'].'&q='.$_GET['q'].'&name='.$_GET['name'].'">'.$dir_array[$i].'</a><br>';}
}}else{echo'<center><b>Папка пуста!</b></center><br>';}}else{echo'<center><b>Не верно указан путь!</b></center>';} }

if ($_GET['action']=="unzip"){
$_GET['zip']=realpath(str_replace("%2f","/",$_GET['zip'])); 
$_GET['did']=realpath(str_replace("%2f","/",$_GET['did']));

$archive = new PclZip($_GET['zip']);
$value = $archive->extract(PCLZIP_OPT_PATH, $_GET['did']);
$_GET['did']=str_replace("/","%2f", $_GET['did']);
if ($value){ echo'<br><b>Распаковка выполнена</b><br><a href="index.php?did='.$_GET['did'].'%2f">К папке</a>';
 }else{ echo'<br><b>Ошибка распаковки</b><br>'.$archive->errorInfo(true).' <br>'; }
}
if ($_GET['action']=="inzips"){
echo'<title>Запаковка архивов</title>';
$_GET['zip']=realpath(str_replace("%2f","/",$_GET['zip'])); 
$_GET['did']=realpath(str_replace("%2f","/",$_GET['did'])); 
$archive = new PclZip("".$_GET['did']."/".$_GET['name']."");
$value = $archive->add($_GET['zip'],PCLZIP_OPT_REMOVE_PATH, $_GET['did']);
if ($value){ echo'Файл/Папка успешно запакованы!';
}else{echo'Ошибка архивации! <br>  '.$archive->errorInfo(true).'<br>';}
}


 if ($_GET['action']=="inzip"){ 
$_GET['did']=str_replace("/","%2f", $_GET['did']);
echo'<form action="?" method="get"/>
Название архива: .zip .jar<br>
<input name="name" value="archive.zip">
<input type="hidden" name="zip" value="'.$_GET['zip'].'">
<input type="hidden" name="q" value="1">
<input type="submit" value="Далее (1/2)"/></form>'; 
echo'<a href="index.php?did='.$_GET['did'].'%2f">Назад</a>';
}
//----------------------КОНЕЦ-------------------
if (!isset($_GET['action'])){
}

include_once"foot.php";
?>