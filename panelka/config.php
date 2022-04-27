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
$oall=0;if(isset($_POST['all'])){$oall=1;}
$om=0;if((isset($_POST['m'])) || (isset($_GET['m']))) {if(isset($_POST['m'])){$om=intval($_POST['m']);}else{$om=intval($_GET['m']);}if(($om<0)||($om>10)){$om=0;}}$obp=1;if((isset($_POST['bp'])) || (isset($_GET['bp']))) {if(isset($_POST['bp'])){
$obp=intval($_POST['bp']);}else{$obp=intval($_GET['bp']);}if($obp<1){$obp=1;}}$otp=1;if((isset($_POST['tp'])) || (isset($_GET['tp']))){if(isset($_POST['tp'])){$otp=intval($_POST['tp']);}else{$otp=intval($_GET['tp']);}if($otp<1){$otp=1;}}$oh='';
$rh='';$ou='';
$ru='';$op='';
$rp='';if((isset($_POST['h'],$_POST['u'],$_POST['p'])) || (isset($_GET['h'],$_GET['u'],$_GET['p']))){if(isset($_POST['h'],$_POST['u'],$_POST['p'])){$h=$_POST['h'];$u=$_POST['u'];$p=$_POST['p'];}else{$h=$_GET['h'];$u=$_GET['u'];$p=$_GET['p'];}$h=trim(rawurldecode($h));if(@preg_match('~^[[:print:]]{4,64}$~i',$h)){$oh=$h;$rh=rawurlencode($h);}unset($h);$u=trim(rawurldecode($u));if(@preg_match('~^[[:print:]]{1,64}$~i',$u)){$ou=$u;$ru=rawurlencode($u);}unset($u);$p=trim(rawurldecode($p));if(@preg_match('~^[[:print:]]{1,128}$~i',$p)){$op=$p;$rp=rawurlencode($p);}unset($p);}if($oh===''){$oh='localhost';}$ob='';
$rb='';if((isset($_POST['b'])) || (isset($_GET['b']))){if(isset($_POST['b'])){$b=$_POST['b'];}else{$b=$_GET['b'];}$b=trim(rawurldecode($b));if(@preg_match('~^[[:print:]]{1,64}$~i',$b)){$ob=$b;$rb=rawurlencode($b);}unset($b);}$cnms=0;$onms='';if(isset($_POST['nms'])){if(@is_array($_POST['nms'])){$nms=@array_map('trim',@array_map('rawurldecode',$_POST['nms']));$ctnms=count($nms);if($ctnms>=1){$check=0;for($ch=0;$ch<$ctnms;$ch++){if(@preg_match('~^[[:print:]]{1,64}$~i',$nms[$ch])){$check++;}}if($ctnms===$check){$cnms=$ctnms;$onms=$nms;}}unset($nms);}}$connect=0;if(($oh!=='')&&($ou!=='')&&($op!=='')&&($om>=1)){if(@mysql_connect($oh,$ou,$op)){$connect=1;}}$selectdb=0;if(($connect===1)&&($ob!=='')&&($om>3)){if(@mysql_select_db($ob)){$selectdb=1;}}$r=@mt_rand(100,999);@define('MY77CH','YES');
?>