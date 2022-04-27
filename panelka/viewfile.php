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

if (!isset($_GET['action'])){echo'<title>Ошибка!</title><br><b>Ошибка! Не выбранна команда!</b><br>';include_once"foot.php";exit;}
if (!file_exists($_GET['fid'])){ echo'<title>Ошибка!</title><br><b>Ошибка! Файл не найден!</b><br>'; include_once"foot.php"; exit;}
if ($_GET['action']=="delfile"){
if ($_GET['r']=="1"){
if (unlink($_GET['fid'])){ 
echo'<title>Выполнено!</title><br>Файл успешно удалён!<br>'; 
}else{ echo'<title>Ошибка!</title><br>Ошибка удаления файла!<br>'; }
}else{
$_GET['fid']=str_replace('/','%2f',$_GET['fid']); 
echo'<title>Удалить?</title>'; echo'<br><b>Вы подтверждаете что хотите удалить файл?</b><br><a href="?action=delfile&r=1&fid='.$_GET['fid'].'">Да</a> <a href="index.php?action=viewfile&did='.$_GET['fid'].'">Нет</a><br>';}}
if($_GET['action']=="rar_view"){  if(preg_match("/h2m.ru/i",$_SERVER['HTTP_HOST'])){echo'Извените,но хостинг h2m.ru не поддерживает такую функцию, почему так? Вы можите обратится в icq 399196389';}else{ function sizer($s) { $o=1; while($s>1024)   {   $s = round($s / 1024, 1);   $o++;   } switch($o)   {   case(1):   $o='b';   break;   case(2):   $o='Kb';   break;   case(3):   $o='Mb';   break;   case(4):   $o='Gb';   break;   } return $s.$o; } $filepath =str_replace('%2f','/',$_GET['fid']);  $rar = rar_open($filepath) or die('Ошибка открытия RAR архива'); $list = rar_list($rar); $c = count($list); echo'Обьектов: '.$c.'<hr/>'; for($i = 0; $i<$c; $i++) {    echo $list[$i]->name.' ['.sizer($list[$i]->unpacked_size).'/'.sizer($list[$i]->packed_size).']<br/>'; } rar_close($rar);}}
//------------R-E-N-A-M-E------------//
if ($_GET['action']=="rename"){
echo'<title>Переименование</title>';
$_GET['fid']=str_replace("%2f","/",$_GET['fid']);
$exp = dirname(realpath($_GET['fid'])); 
$exts = realpath($_GET['fid']);
$exti=str_replace($exp,$exts,$exts);
$ext = strtolower(substr($exti, 1 + strrpos($exti, "/")));
$_GET['fid']=str_replace("/","%2f",$_GET['fid']); echo'<form action="?action=renamer&fid='.$_GET['fid'].'" method="post" />';
echo'<b>Перименование файла/папки</b><br><br>Название:<br> <input type="hidden" name="starname" value="'.$ext.'">'; echo'<input name="newname" value="'.$ext.'"/><br/>';
echo'<input type="submit" value="Переименовать"/></form>';
}
if ($_GET['action']=="renamer"){ 
if(eregi("/",$_POST['newname'])){ echo'<title>Ошибка!</title> <br>Ошибка! Не верное название файла! Допустимые символы: a-z _ 0-9 -<br>'; include_once"foot.php";exit;}
$a=str_replace($_POST['starname'],$_POST['newname'],$_GET['fid']);
 if (rename($_GET['fid'],$a)){echo'<title>Выполнено!</title><br>Файл/Папка успешно переминована!<br>'; 
}else{echo'<title>Ошибка!</title> Ошибка переименования Файла/Папки'; }
}
if ($_GET['action']=="view"){ $file = file_get_contents($_GET['fid']);
echo'<div class="p">'.highlight_string($file).'</div>'; 
include_once"foot.php";}
###############
if ($_GET['action']=="clearfile"){
if ($_GET['r']=="1"){ 
$fp=fopen($_GET['fid'],"w");
flock ($fp,LOCK_EX);
fputs($fp,"");
flock ($fp,LOCK_UN);
fclose($fp);
if ($fp){ echo'<title>Выполнено!</title><b>Файл успешно очищен!</b><br>';
}else{echo'<title>Ошибка!</title><br>Ошибка очистки файла!<br>Операция не позволяется!';}
}else{
$_GET['fid']=str_replace("/","%2f",$_GET['fid']);
echo'<title>Очистить?</title>';
echo'<br><b>Вы подтверждаете что хотите очистить файл?</b><br>
<a href="?action=clearfile&r=1&fid='.$_GET['fid'].'">Да</a> <a href="index.php?action=viewfile&fid='.$_GET['fid'].'">Нет</a><br>'; } }
###############
if ($_GET['action']=="chmod"){
$_GET['fid']=str_replace("%2f","/", $_GET['fid']);
$ext=substr(sprintf("%o",fileperms($_GET['fid'])),-3);
$_GET['fid']=str_replace("/","%2f", $_GET['fid']);
echo'<form action="?action=chmode&fid='.$_GET['fid'].'" method="post" />';
echo'<title>Права доступа</title><b>Права доступа</b><br>';
echo'Chmod:<br/><input name="chmod" size="5" value="'.$ext.'">';
echo'<input type="submit" value="Установить"/></form>';
}
if ($_GET['action']=="chmode"){
$_GET['fid']=str_replace("%2f","/", $_GET['fid']);
if(eregi("[^0-9]",$_POST['chmod'])){ echo'<title>Ошибка!</title> Не верно введены права доступа! Вводите только числа!'; include_once"foot.php"; exit;}
$chmod='0'.$_POST['chmod']; if (chmod($_GET['fid'],$chmod)){ chmod($_GET['fid'],$chmod); echo'<title>Выполнено!</title> <br>Прова доступа установлены! ('.$_POST['chmod'].')<br>';
 }else{echo'<title>Ошибка</title>Ошибка установки прав доступа! Операция не позволяет! ('.$_POST['chmod'].')<br>';}
}
if ($_GET['action']=="info"){ echo'<title>Свойства</title><br>';
echo'Размер: '.formatsize(filesize($_GET['fid'])).'<br>';
echo'Права доступа: '.substr(sprintf("%o",fileperms($_GET['fid'])),-3).'<br>';
echo'Група: '.filegroup($_GET['fid']).'<br>';
echo'Владелец: '.fileowner($_GET['fid']).'<br>';
echo'Время: '.maketime(filemtime($_GET['fid'])).'<br>';
}
include_once"foot.php";
?>