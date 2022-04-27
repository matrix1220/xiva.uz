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


// Скрипт Перекачивает К Вам На Хост Файлы
// Gemorroj

error_reporting(0);
set_time_limit(99999);
//ignore_user_abort(1);

if(substr_count($_SERVER['HTTP_USER_AGENT'],'MSIE')){
header('Content-type: text/html; charset=UTF-8');
}
else{
header('Content-type: application/xhtml+xml; charset=UTF-8');
}


print '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
<title>Gemor Get</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="menu">';


if($_POST['url'])
{
$b = file('browser.dat');
$s = sizeof($b)-1;

$ot = trim($_POST['ot']);
$do = trim($_POST['do']);
$dir = trim($_POST['dir']);
$url = trim($_POST['url']);
$referer = trim($_POST['referer']);

if(strlen($ot)>1 && $ot[0]==0){
$null = substr_count($ot,0);
for($i=0; $i<$null; ++$i){
$temp.= 0;
}
}


$ref = $get =array();


for($i=$ot; $i<=$do; ++$i)
{
if($temp!==false){
$num = $i/10;
if($num==1 || $num==10 || $num==100 || $num==1000 || $num==10000 || $num==100000 || $num==1000000){
$temp = substr($temp,0,-1);
}
}


if($temp!==false && $i!=$ot){
$get[] = str_replace('$',$temp.$i,$url);
$ref[] = str_replace('$',$temp.$i,$referer);
}
else{
$get[] = str_replace('$',$i,$url);
$ref[] = str_replace('$',$i,$referer);
}

}

//print_r($get);
//exit;


mkdir($dir,0777);
chmod($dir,0777);
if($_POST['http'] == 1){
$false = '<br/>Не удалось скопировать файлы по следующим URL:<br/>';
}
else{
$false = '';
}

$all = sizeof($get);
for($i=0; $i<=$all; $i++)
{
ini_set('user_agent',trim($b[mt_rand(0,$s)])."\r\nReferer: $ref[$i]\r\nAccept: */*\r\nAccept-Charset: utf-8\r\nAccept-language: ru-RU");

if($_POST['http'] == 1){
$headers = get_headers($get[0], 1);
if(strtoupper(substr(trim($headers[0]), -6)) != '200 OK'){
$false.= htmlspecialchars($get[$i]).'<br/>';
continue;
}
}
elseif($_POST['http'] == 2){
$headers = get_headers($get[0], 1);
if(strtoupper(substr(trim($headers[0]), -6)) != '200 OK'){
$host = parse_url($get[0]);
$ip = gethostbyname($host['host']);
print 'Ошибка!<br/>Host: '.$host['host'].'<br/>
IP: '.($ip!=$host['host']?$ip:'Не определен').'<br/>
<pre>';
if($headers = print_r($headers, 1)){
print 'Заголовки:<br/>'.htmlspecialchars($headers);
}
else{
echo '<div class="gmenu">Не удалось получить заголовки</div>';
}
print '</pre>
</div></body></html>';
exit;
}
}

if(copy($get[$i],$dir.basename($get[$i]))){
++$g;
}
}

chmod($dir,0755);

print 'Скопировано '.$g.' Файла(ов)'.$false;
}
else
{
print '<form action="'.$_SERVER['PHP_SELF'].'?" method="post">
<div>
<div class="bmenu">Куда Копировать</div>
<input type="text" name="dir" value="'.$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']).'/" size="'.(strlen($_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']))+3).'"/><br/>
<div class="bmenu">URL</div>
<input type="text" name="url" value="http://"/><br/>
<div class="bmenu">Referer</div>
<input type="text" name="referer" value="http://spaces.ru"/><br/>
<div class="bmenu">Начать с</div>
<input type="text" name="ot" size="3" value="001"/><br/>
<div class="bmenu">Закончить</div>
<input type="text" name="do" size="3" value="100"/><br/>
Если файл не найден<br/>
<select name="http">
<option value="0">Продолжить</option>
<option value="1">Запомнить URL и продолжиь</option>
<option value="2">Остановить перекачку</option>
</select><br/>
<input type="submit" value="Панеслась"/>
</div>
</form>';
}
echo '<div class="footer"><a href="index.php">В корень</a></div>';

print '</div></body></html>';
?>