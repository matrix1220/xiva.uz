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

$up=dirname(realpath($_GET['did']));
$up=str_replace("/","%2f",$up);
$vi=realpath($_GET['did']);
$vi=str_replace("../","",$vi);
echo'<div class="bmenu">Быстрый переход<span class="red"><b>/</b></span><br/><form action="index.php?action=go" method="post"><input type="text" name="url" value="'.$vi.'/"/><input type="submit" value="Перейти"/></form>
<div class="gmenu"><img src="img/back.png" alt="/"> <a href="?did='.$up.'%2f">Предыдущая директория</a></div>';

$dir_array=array();
$dir = opendir ($_GET['did']);
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
$countdir++;
$_GET['did']=str_replace("/","%2f",$_GET['did']);
$szf=read_dir($_GET['did'].''.$dir_array[$i].'%2f');
if (($szf>=1)&&($szf<1024)) {$szf=$szf.'B';}
if (($szf>=1024)&&($szf<1048576)) {$szf=strtr(round($szf/1024,2),".",",")."K";}
if ($szf>=1048576) {$szf=strtr(round($szf/1024/1024,2),".",",")."M";}
echo'<a href="?action=viewdir&did='.$_GET['did'].''.$dir_array[$i].'%2f"><img src="img/dir.gif" alt=""></a> <a href="?did='.$_GET['did'].''.$dir_array[$i].'%2f">'.$dir_array[$i].'</a> '.$szf.'<br/>';}
else{
$countfid++;
$_GET['did']=str_replace("/","%2f",$_GET['did']);
if($_GET['did']==''){$szd='';}else{
 $szd=filesize($vi.'/'.$dir_array[$i]); if ($szd<1024) {$szd=$szd.'B';} if (($szd>=1024)&&($szd<1048576)) {$szd=strtr(round($szd/1024,2),".",",")."K";} if ($szd>=1048576) {$szd=strtr(round($szd/1024/1024,2),".",",")."M";}     
}
echo'<a href="?action=viewfile&fid='.$_GET['did'].''.$dir_array[$i].'">'.$dir_array[$i].'</a> '.$szd.'<br/>';}
}}else{echo'<center><b>Папка пуста!</b></center><br/>';}}else{echo'<center><b>Не верно указан путь!</b></center>';}
echo'<br/>Папок: '.(int)$countdir.' / Файлов: '.(int)$countfid.'</div>';}

if($_GET['action']=="iconv"){ if(empty($_GET['fid'])){header('Location: index.php?did='.$_GET['did']); exit;} if(!empty($_POST['v']) or !empty($_POST['iz'])){ $fil=str_replace('%2f','/',$_GET['fid']);  $file=file($fil);  for($i=0; $i<count($file); $i++){$f=fopen($fil.'-recode','a+');   $text=iconv($iz,$v,$file[$i]);  fwrite($f,"$text\r\n"); chmod($f,0666); }   echo'Файл перекодирован<br><a href="?">назад</a>';}else{echo'<form action="index.php?action=iconv&amp;fid='.$_GET['fid'].'" method="post">Из<br><input type="radio" value="UTF-8" name="iz">UTF-8<br><input type="radio" value="Windows-1251" name="iz" checked>Windows-1251<br><input type="radio" value="KOI8-U" name="iz">KOI8-U<br>В<br><input type="radio" value="UTF-8" name="v" checked>UTF-8<br><input type="radio" value="Windows-1251" name="v">Windows-1251<br><input type="radio" value="KOI8-U" name="v">KOI8-U<br><input type="submit" value="Перекодировать"/></form>'; }}

if ($_GET['action']=="viewdir"){
if (file_exists($_GET['did'])  || is_dir($_GET['did'])){
$_GET['did']=str_replace("/","%2f",$_GET['did']);
echo'<a href="unzip.php?action=inzip&zip='.$_GET['did'].'&q=1">Запаковать</a>(zip)<br/>

<a href="viewdir.php?action=rename&did='.$_GET['did'].'&">Переименовать</a><br/>';
echo'<a href="viewdir.php?action=deldir&did='.$_GET['did'].'">Удалить</a><br/>';
echo'<a href="copys.php?copy='.$_GET['did'].'&">Копировать</a><br/><a href="perenoss.php?copy='.$_GET['did'].'&">Переместить</a><br/><a href="viewdir.php?action=cleardir&did='.$_GET['did'].'&">Очистить</a><br/>';
echo'<a href="viewdir.php?action=chmod&did='.$_GET['did'].'&">Права доступа</a><br/>';
echo'<a href="viewdir.php?action=info&did='.$_GET['did'].'&">Свойста</a><br/>';
$up=str_replace("%2f","/",$_GET['did']); $up=dirname(realpath($up)); $up=str_replace("/","%2f",$up); echo'<div class="gmenu"><a href="?did='.$up.'%2f">Назад</a></div>';
}else{
echo'Ошибка! Папка не найдена!<br/>'; }
}
if($_GET['action']=="go"){ if(empty($_POST['url'])){header("Location: index.php"); exit;}else{  $_POST['url']=str_replace('/','%2f',$_POST['url']); header('Location: index.php?did='.$_POST['url']); exit;} }
if ($_GET['action']=="viewfile"){
if (file_exists($_GET['fid']) || is_file($_GET['fid'])){
$_GET['fid']=str_replace("/","%2f",$_GET['fid']);
$smf=str_replace("%2f","/",$_GET['fid']);
$p=strtolower(substr($smf, 1 + strrpos($smf, "/")));
$sf=str_replace($root,"",$smf); $sf=str_replace("..","",$sf);
echo'<a href="http://'.$_SERVER['HTTP_HOST'].$sf.'">Просмотреть</a><br/>';
$e = strtolower(substr($sf, 1 + strrpos($sf, ".")));

if ($e=="rar"){echo'<a href="viewfile.php?action=rar_view&amp;fid='.$_GET['fid'].'">Смотреть архив</a><br/>';}
if ($e=="zip" || $e=="jar"){
echo'<a href="unzip.php?zip='.$_GET['fid'].'">Распаковать</a><br/>';
echo'<a href="zip.php?arch='.$_GET['fid'].'">Смотреть архив</a><br/>';
}else{
echo'<a href="edit.php?fid='.$_GET['fid'].'">Редактировать в блокноте</a><br/>';
echo'<a href="unzip.php?action=inzip&zip='.$_GET['fid'].'&q=1">Запаковать</a><br/>';
}
echo'<a href="viewfile.php?action=rename&fid='.$_GET['fid'].'">Переименовать</a><br/>';
echo'<a href="perenos.php?copy='.$_GET['fid'].'">Переместить</a><br/>'; echo'<a href="copy.php?copy='.$_GET['fid'].'">Копировать</a><br/>';
echo'<a href="viewfile.php?action=delfile&fid='.$_GET['fid'].'">Удалить</a><br/>';
echo'<a href="?action=iconv&fid='.$_GET['fid'].'">Изменить кодировку</a><br/>'; echo'<a href="viewfile.php?action=chmod&fid='.$_GET['fid'].'">Права доступа</a><br/>';
echo'<a href="viewfile.php?action=view&fid='.$_GET['fid'].'">Смотреть код</a><br/>';
echo'<a href="viewfile.php?action=clearfile&fid='.$_GET['fid'].'">Очистить</a><br/>';
echo'<a href="viewfile.php?action=info&fid='.$_GET['fid'].'&">Свойста</a><br/>';
echo'<a href="?did='.str_replace($p,"",$_GET['fid']).'&">Назад</a><br/>';
}else{
echo'Ошибка! Файл не найден!<br/>';}
}
//----------------------КОНЕЦ-------------------
if (!isset($_GET['action'])){echo'<div class="header"><b>Меню</b></div>';
echo'<div class="menu"><ol><li><a href="change.php?did='.$_GET['did'].'">Multi-выбор</a></li>';
$_GET['did']=str_replace("/","%2f",$_GET['did']);
echo'<li><a href="other.php?action=dir&did='.$_GET['did'].'">Создать папку</a></li>';
echo'<li><a href="other.php?action=file&did='.$_GET['did'].'">Создать файл</a></li>
<li><a href="scaner.php">Сканер</a></li>
<li><a href="other.php?action=uplop&r=pk&did='.$_GET['did'].'">Выгрузить файл</a></li>
<li><a href="other.php?action=uplop&r=op&did='.$_GET['did'].'">Выгрузить с Opera</a></li>
<li><a href="other.php?action=uplop&r=imp&did='.$_GET['did'].'">Скачать файл</a></li>
<li><a href="get.php">Импорт грабб</a></li>
<li><a href="rename.php">Массовая переименовка</a></li>
<li><a href="impsql.php">Импорт SQL</a></li>
<li><a href="mysql.php">PHPmyAdmin</a></li>
<li><a href="menu.php">Настройки</a></li></ol></div>';
}

include_once"foot.php";