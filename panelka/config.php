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


@error_reporting(E_ALL ^ E_NOTICE);
@ini_set('display_errors', false);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ALL ^ E_NOTICE);

if (empty($_GET['did'])){$_GET['did']='../';} //путь от куда начинаем
include_once"funkcions.php";
$file=file("data/user.dat");
$udata=explode("|",$file[0]);
if (!$udata[0]){ $udata[0]='Demo'; }
if (!$udata[1]){ $udata[1]='Demo'; }
if (!$udata[2]){ $udata[2]='20'; }
$root = $_SERVER['DOCUMENT_ROOT'];
if (!$_SERVER['REMOTE_ADDR']){ echo'<title>Error</title> <b>Sorry</b>'; exit;}
$cookielog=htmlspecialchars($_COOKIE['cookielog']);
$cookiepass=htmlspecialchars($_COOKIE['cookiepass']);

if ($udata[0]!==$cookielog && ($udata[1]!==$cookiepass)){ header('Location: auth.php'); exit;}

@define('ONPAGE',10);
@define('BACKUPDR','data');
@define('YESSQL','YES');
$oall=0;
$om=0;
$obp=intval($_POST['bp']);
$rh='';
$ru='';
$rp='';
$rb='';
?>