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


session_start();
include_once"config.php";
include_once"head.php";
echo '<div class="list2">';
if (!isset($_GET['action'])){
echo'<title>Мульти выбор</title>';
echo'<table>Выберите файл/папку</table><br>';

echo'<form method="post" action="change.php?action=pod&did='.$_GET['did'].'">';
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
$_GET['did']=str_replace("/","%2f",$_GET['did']);
echo' <input type="checkbox" name="sub[]" value="'.$dir_array[$i].'"/> <img src="img/dir.gif" alt="/"> <font color="00aaaa">'.$dir_array[$i].'</font><br/>';}

else{
$_GET['did']=str_replace("/","%2f",$_GET['did']);
echo' <input type="checkbox" name="sub[]" value="'.$dir_array[$i].'" /> <font color="00aaaa">'.$dir_array[$i].'</font><br>';}
}
echo'<input type="submit" value="OK"/></form><br>';
}else{echo'<center><b>Папка пуста!</b></center><br>';}
}else{echo'<center><b>Не верно указан путь!</b></center>';}}
if ($_GET['action']=="pod"){
echo'<table>Виберите действие</table>';
$sub=$_POST['sub'];

$c=count($sub); 
if ($c>0){
echo'<font color="00aa00">Выбрано: <b>'.$c.'</b> обьекта</font><br>';
echo'<form method="get" action="change.php?">';

echo'<input type="radio" name="action" value="delete" checked>Удалить<br><input type="radio" name="action" value="copy">Копировать<br><input type="radio" name="action" value="perem">Переместить<br><input type="radio" name="action" value="chmod">Права доступа<br>';
   for($i=0; $i<$c; $i++){  echo'<input type="hidden" name="sub[]" value="'.$sub[$i].'" />';} echo'<input type="hidden" name="did" value="'.$_GET['did'].'" />'; echo'<input type="hidden" name="copy" value="'.$_GET['did'].'" />'; echo'<input type="submit" value="Выбрать"/></form><br>'; 
}else{echo'Ничего не произошло...<br>';}}
 if ($_GET['action']=="delete"){
echo'Вы действительно хотите удалить следующие файлы/папки?<br>';
$did=str_replace('%2f','/',$_GET['did']); $sub=str_replace('/','%2f',$_GET['sub']); $c=count($sub); for($i=0; $i<$c; $i++){ 
if (is_dir($did.$f[$i])){ echo'<img src="img/dir.png" alt="/"> ';}
echo'<font color="00aa00">'.$f[$i].'</font><br>';
}
echo'<form method="post" action="change.php?action=unlink&did='.$_GET['did'].'">';
for($i=0; $i<$c; $i++){  echo'<input type="hidden" name="sub[]" value="'.$sub[$i].'" />';}
echo'<input type="submit" value="Да"/></form>';
echo'<form method="post" action="?did='.$_GET['did'].'">';
echo'<input type="submit" value="Нет"/></form><br>';}
if ($_GET['action']=="unlink"){
$_GET['did']=str_replace('%2f','/',$_GET['did']); $sub[]=$_POST['sub'];
foreach($sub as $value){$c=(int)count($value); unset($value);}
echo'<b>Файлов/папок к удалению: '.$c.'</b><br>';
for($i=0; $i<$c; $i++){ foreach($sub as $val=>$f){
if (is_dir($_GET['did'].$f[$i])){echo'<img src="img/dir.gif" alt="/"> '.$f[$i].' ';
if (unlink_dir($_GET['did'].$f[$i])){echo'<font color="00aaaa">удалено</font><br>';}else{echo'<font color="aa0000">отказано</font><br>';}}
if (is_file($_GET['did'].$f[$i])){echo' '.$f[$i].' ';
if (unlink($_GET['did'].$f[$i])){echo'<font color="00aaaa">удалено</font><br>';}else{echo'<font color="aa0000">отказано</font><br>';}}
}}
} if ($_GET['action']=="copy"){    include'config.php'; $_GET['copy']=str_replace('/','%2f',$_GET['copy']); if(!empty($_GET['sub'])){$sub=$_GET['sub']; $c=count($sub);  for($i=0; $i<$c; $i++){$f.=$sub[$i].'%7i';} }else{$f=$_GET['f']; } $dir_array=array(); $dir = opendir ($_GET['did']); $_GET['did']=str_replace("%2f","/",$_GET['did']); $bc=str_replace("/","%2f",$_GET['did']); echo'<a href="change.php?action=copy2&amp;did='.$bc.'&amp;copy='.$_GET['copy'].'&amp;f='.$f.'">Выбрать</a><br><a href="change.php?action=copy&amp;did='.$bc.'&amp;copy=..%2f'.$_GET['copy'].'&amp;f='.$f.'">Вверх</a><br>'; while ($file = readdir ($dir)) { if($file=="."||$file=="..") continue; $dir_array[]=$file; } closedir ($dir); asort($dir_array); $total = count($dir_array); if (file_exists($_GET['did'])){ if (!$total<1){ for ($i = 0; $i < $total; $i++){ $_GET['did']=str_replace("%2f","/",$_GET['did']); if (is_dir($_GET['did']."$dir_array[$i]")){ $_GET['did']=str_replace("/","%2f",$_GET['did']); 
echo'<img src="img/dir.gif" alt="/"> <a href="change.php?action=copy&amp;did='.$_GET['did'].''.$dir_array[$i].'%2f&amp;copy='.$_GET['copy'].'&amp;f='.$f.'">'.$dir_array[$i].'</a><br>';} }}else{echo'<center><b>Папка пуста!</b></center><br>';}}else{echo'<center><b>Не верно указан путь!</b></center>';} }
if ($_GET['action']=="copy2"){ $_GET['did']=realpath(str_replace('%2f','/',$_GET['did'])); $_GET['copy']=realpath(str_replace('%2f','/',$_GET['copy'])); $ex=explode('%7i',$_GET['f']); $c=count($ex)-1; for($i=0; $i<$c; $i++){ $path=pathinfo($ex[$i]); if(!empty($path['extension'])){   if (copy($_GET['copy'].'/'.$path['basename'],$_GET['did'].'/'.$path['basename'])){ $cf++;}}else{ if (copy_dir($_GET['copy'].'/'.$ex[$i],$_GET['did'])){ $cd++;}  }} if(empty($cd)){echo'Ошибка копирования папки';}else{echo'Папки скопированы<br>';}   if(empty($cf)){echo'Ошибка копирования файлов';}else{echo'Файлы скопированы<br>';}    }
 if ($_GET['action']=="perem"){    include'config.php'; $_GET['copy']=str_replace('/','%2f',$_GET['copy']); if(!empty($_GET['sub'])){$sub=$_GET['sub']; $c=count($sub);  for($i=0; $i<$c; $i++){$f.=$sub[$i].'%7i';} }else{$f=$_GET['f']; } $dir_array=array(); $dir = opendir ($_GET['did']); $_GET['did']=str_replace("%2f","/",$_GET['did']); $bc=str_replace("/","%2f",$_GET['did']); echo'<a href="change.php?action=perem2&amp;did='.$bc.'&amp;copy='.$_GET['copy'].'&amp;f='.$f.'">Выбрать</a><br><a href="change.php?action=perem&amp;did='.$bc.'&amp;copy=..%2f'.$_GET['copy'].'&amp;f='.$f.'">Вверх</a><br>'; while ($file = readdir ($dir)) { if($file=="."||$file=="..") continue; $dir_array[]=$file; } closedir ($dir); asort($dir_array); $total = count($dir_array); if (file_exists($_GET['did'])){ if (!$total<1){ for ($i = 0; $i < $total; $i++){ $_GET['did']=str_replace("%2f","/",$_GET['did']); if (is_dir($_GET['did']."$dir_array[$i]")){ $_GET['did']=str_replace("/","%2f",$_GET['did']);  echo'<img src="img/dir.gif" alt="/"> <a href="change.php?action=perem&amp;did='.$_GET['did'].''.$dir_array[$i].'%2f&amp;copy='.$_GET['copy'].'&amp;f='.$f.'">'.$dir_array[$i].'</a><br>';} }}else{echo'<center><b>Папка пуста!</b></center><br>';}}else{echo'<center><b>Не верно указан путь!</b></center>';} }
if ($_GET['action']=="perem2"){ $_GET['did']=realpath(str_replace('%2f','/',$_GET['did'])); $_GET['copy']=realpath(str_replace('%2f','/',$_GET['copy'])); $ex=explode('%7i',$_GET['f']); $c=count($ex)-1; for($i=0; $i<$c; $i++){ $path=pathinfo($ex[$i]); if(!empty($path['extension'])){   if (copy($_GET['copy'].'/'.$path['basename'],$_GET['did'].'/'.$path['basename']) and unlink($_GET['copy'].'/'.$path['basename'])){ $cf++;}}else{ if (copy_dir($_GET['copy'].'/'.$ex[$i],$_GET['did']) and unlink_dir($_GET['copy'].'/'.$ex[$i])){ $cd++;}  }} if(empty($cd)){echo'Ошибка перемещения папки';}else{echo'Папки перемещены<br>';}   if(empty($cf)){echo'Ошибка перемещения файлов';}else{echo'Файлы перемещены<br>';}    }
if ($_GET['action']=="chmod" ){ $sub=str_replace('/','%2f',$_GET['sub']); $c=count($sub);  echo'<form method="post" action="change.php?action=chmode&did='.$_GET['did'].'">Задайте права<br><input type="text" name="ch" size="4" value="644"><br>Чему ставить такие права:<br>'; for($i=0; $i<$c; $i++){ foreach($sub as $val=>$f){ echo'<input type="hidden" name="sub[]" value="'.$f[$i].'" />';}}  for($i=0; $i<$c; $i++){   if (is_dir($_GET['did'].$f[$i])){ echo'<img src="img/dir.png" alt="/"> ';} echo'<font color="00aa00">'.$sub[$i].'</font><br>';} echo'<br><input type="submit" value="OK"/></form>'; }
if ($_GET['action']=="chmode"){ $sub=$_POST['sub']; $chmod=$_POST['chmod']; $c=count($sub);  $_GET['did']=str_replace('%2f','/',$_GET['did']); $cho='0'.$chmod; for($i=0; $i<$c; $i++){ if(chmod($_GET['did'].'/'.$sub[$i],$cho)){$gp++;}} if(!empty($gp)){echo'Права выставлены';}else{echo'Права не изменены';}  }
echo'<br><a href="index.php?did='.$_GET['did'].'">Назад</a><br>';
echo '</div>';
include_once"foot.php";
?> 