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
echo '<div class="list2">';
if (!file_exists($_GET['fid'])){ echo'<title>Ошибка!</title><br/><b>Ошибка! Файл не найден!</b><br/>'; include_once"foot.php"; exit;}
if(!is_writeable($_GET['fid'])){ echo'<div class="rmenu">Внимание! Файл не доступен для записи!<br/>Редактирование не возможнo..</div>'; }
if ($_GET['action']=="edit"){
$file=file($_GET['fid']);
$total=count($file);
for ($i=0; $i<$total; $i++){
if($_GET['ai']==$i){

$fp=fopen($_GET['fid'],"a+");
flock ($fp,LOCK_EX);
ftruncate($fp,0);
for($i=0; $i<sizeof($file); $i++){
if ($_GET['ai']!=$i){
fputs($fp,$file[$i]);
}else{
fputs($fp,$_POST['name']."\r\n");}}
fflush ($fp);
flock($fp,LOCK_UN);
fclose($fp);

} }
$_GET['fid']=str_replace('/','%2f',$_GET['fid']);
header ('Location: ?fid='.$_GET['fid'].'&start='.$_GET['start'].'');
exit;
}
if($_GET['action']=="newstr"){
$_GET['fid']=str_replace('/','%2f',$_GET['fid']);
echo'<title>Новая строка</title><form action="?action=newstrok&fid='.$_GET['fid'].'&ai='.$_GET['ai'].'&start='.$_GET['start'].'" method="post">';
echo'Новая строка<br/>Строка: #'.$_GET['ai'].'<br/><textarea rows="'.$udata[4].'" name="name"></textarea><br/>';
echo'<input type="submit" value="Вставить"/></form>';
echo' <a href="?fid='.$_GET['fid'].'&start='.$_GET['start'].'">Назад</a><br>';
include_once"foot.php";
exit;}
if($_GET['action']=="newstrok"){
$_GET['fid']=str_replace('%2f','/',$_GET['fid']);
$file=file($_GET['fid']);

$fp=fopen($_GET['fid'],"a+");
$total=count($file); 
if (!$total){ $total=''; }
for ($i=0; $i<$total; $i++){
if($_GET['ai']==$i){
flock ($fp,LOCK_EX);
ftruncate($fp,0); 
for($i=0; $i<sizeof($file); $i++){
if ($_GET['ai']!=$i){ 

fputs($fp,$file[$i]); }else{ 
$bizname=$file[$i]; fputs($fp,$bizname.$_POST['name']."\r\n");}} 
fflush ($fp); flock($fp,LOCK_UN);
fclose($fp);
}}
$_GET['fid']=str_replace("/","%2f",$_GET['fid']);
header ('Location: ?fid='.$_GET['fid'].'&start='.$_GET['start'].''); exit;}
if($_GET['action']=="delstr"){
$file=file($_GET['fid']);
$fp=fopen($_GET['fid'],"w");
flock ($fp,LOCK_EX); 
for ($i=0; $i< sizeof($file); $i++){ 
if ($i==$_GET['ai']){ 
unset($file[$i]);}} 
fputs($fp,implode($file)); 
flock ($fp,LOCK_UN); 
fclose($fp);  
$_GET['fid']=str_replace('/','%2f',$_GET['fid']);
header ('Location: ?fid='.$_GET['fid'].'&start='.$_GET['start'].''); exit;}
if($_GET['action']=="ob"){
$fp=fopen($_GET['fid'],"a+");
flock ($fp,LOCK_EX);
fputs($fp,"".$_POST['name']."\r\n");
flock ($fp,LOCK_UN);
fclose($fp);
$_GET['fid']=str_replace('/','%2f',$_GET['fid']);
header ('Location: ?fid='.$_GET['fid'].'&start='.$_GET['start'].'');
}
if($_GET['action']=="sstring"){ if(empty($_GET['fid'])){ echo'Данные утеряны!'; include'foot.php'; exit;}  if(empty($_GET['s'])){  $_GET['fid']=str_replace('/','%2f',$_GET['fid']);
echo'<form action="edit.php?action=sstring&amp;fid='.$_GET['fid'].'&amp;s=yes" method="post">Что ищем?<br/><input type="text" name="text" value=""><br/><input type="submit" value="Искать"/></form>';

}else{
$fle=$_GET['fid']; $_GET['fid']=str_replace('/','%2f',$_GET['fid']);   $text=$_POST['text'];   $file=file($fle);  $cou=count($file); for($i=0; $i<$cou; $i++){ if(eregi($text,$file[$i])){  $t1=ceil($i/$udata[2]); $stra=$t1*10+$udata[2]; echo $i.': <a href="edit.php?fid='.$_GET['fid'].'&amp;start='.$stra.'&amp;s='.$i.'">'.htmlspecialchars($file[$i]).'</a><br>'; $pp++;}} if(empty($pp)){echo'Ничего не найдено';}  $up=dirname(realpath($_GET['fid']));  echo'<br><a href="index.php?did='.$up.'%2f">назад</a><br>'; }}
if($_GET['action']=="pstring"){ if(empty($_GET['s'])){$_GET['fid']=str_replace('/','%2f',$_GET['fid']);
echo'<form action="edit.php?action=pstring&amp;fid='.$_GET['fid'].'&amp;s=yes" method="post">Введите номер строки:<br><input type="text" name="nom" size="6" value="1"><br><input type="submit" value="Перейти"/></form>';
}else{
$nom=(int)$_POST['nom'];   $ill=str_replace('%2f','/',$_GET['fid']);  $cou=count(file($ill)); if($nom<=$cou){$t1=ceil($nom/$udata[2]);    $stroka=$t1*10+$udata[2];}else{ $t1=ceil($cou/$udata[2]);    $stroka=$t1*10+$udata[2];}      $_GET['fid']=str_replace('/','%2f',$_GET['fid']);  header ('Location: ?fid='.$_GET['fid'].'&start='.$stroka.''); }}

if($_GET['action']=="obs"){ 
$_GET['fid']=str_replace('/','%2f',$_GET['fid']);
echo'<title>Редактор</title>
Новая строка:<br>
<form action="?action=ob&fid='.$_GET['fid'].'&start='.(int)$_GET['start'].'" method="post">
<textarea rows="'.$udata[4].'" name="name"></textarea><br/>

<input type="submit" value="Вставить"/></form>';
echo' <a href="?fid='.$_GET['fid'].'&start='.$_GET['start'].'">Назад</a><br>';
}
if($_GET['action']=="viewstr"){ 
$file=file($_GET['fid']);
$_GET['fid']=str_replace('/','%2f',$_GET['fid']);

echo'<title>Редактор</title><form action="?action=edit&fid='.$_GET['fid'].'&ai='.$_GET['ai'].'&start='.(int)$_GET['start'].'" method="post">';
$total=count($file);
for ($i=0; $i<$total; $i++){
if($_GET['ai']==$i){
$file[$i]=htmlspecialchars($file[$i]);
echo'Строка: #'.(int)$_GET['ai'].'<br/><textarea name="name" rows="'.$udata[4].'">'.$file[$i].'</textarea><br/>';}}

echo'<input type="submit" value="Изменить" /></form> ';
echo'<a href="?fid='.$_GET['fid'].'&start='.$_GET['start'].'">Назад</a><br>';
include_once"foot.php";
exit;
}
if(!isset($_GET['action'])){
$file=file($_GET['fid']);
$title = strtolower(substr($_GET['fid'], 1 + strrpos($_GET['fid'], "/"))); echo'<title>'.$title.'</title>'; echo '<div class="p">';
$_GET['fid']=str_replace("/","%2f",$_GET['fid']); 


$total=count($file);

$start = (int)$_GET['start'];
if($start<0 || $start>$total){$start=0;}
if ($total<$start+$udata[2]){ $end = $total; }else{$end=$start+$udata[2]; }
for ($i = $start; $i < $end; $i++){

$file[$i]=htmlspecialchars($file[$i]);
echo' '.$i.': ';
echo'<a href="?action=viewstr&fid='.$_GET['fid'].'&ai='.$i.'&start='.$start.'">'.$file[$i].' </a>';
echo' <a href="?action=newstr&fid='.$_GET['fid'].'&ai='.$i.'&start='.$start.'"><img src="img/php.png" alt="&para;"></a> ';
echo' <a href="?action=delstr&fid='.$_GET['fid'].'&ai='.$i.'&start='.$start.'"><img src="img/del.png" alt=""></a><br>';}
if($total<1){ echo' <a href="?action=obs&fid='.$_GET['fid'].'&start='.$start.'"><img src="img/php.png" alt="&para;"></a> ';}
echo'<br> <table><br>'; if($start!= 0){echo'<a href="?fid='.$_GET['fid'].'&start='.($start-$udata[2]).'"><<<</a>';}
if($total>$start+20) {echo '<a href="?fid='.$_GET['fid'].'&start='.($start+$udata[2]).'">>>></a>';}
$ba=ceil($total/$udata[2]);
$ba2=$ba*$udata[2]-$udata[2];
echo'<br>Стр:';
$asd=$start-($udata[2]*3);
$asd2=$start+($udata[2]*4);
if($asd<$total && $asd>0){echo' <a href="?fid='.$_GET['fid'].'&start=0">1</a> ... ';}
for($i=$asd; $i<$asd2;){
if($i<$total && $i>=0){
$ii=floor(1+$i/$udata[2]);
if ($start==$i){echo' <b>('.$ii.')</b>'; }else{ echo' <a href="?fid='.$_GET['fid'].'&start='.$i.'">'.$ii.'</a>';}}$i=$i+$udata[2];}
if($asd2<$total){echo' ... <a href="?fid='.$_GET['fid'].'&start='.$ba2.'">'.$ba.'</a>';}
$fl=$f;
echo'</div></div></div><br><div class="p">

<br>Всего строк: '.$total.'<br>';
$_GET['fid']=str_replace('%2f','/',$_GET['fid']); $up=dirname(realpath($_GET['fid'])); $up=str_replace('/','%2f',$up);
$eid=str_replace('/','%2f',$_GET['fid']);  echo'<a href="edit.php?action=pstring&amp;fid='.$eid.'">к строке</a><br><a href="edit.php?action=sstring&amp;fid='.$eid.'">искать</a><br>'; echo'<a href="index.php?did='.$up.'%2f">выйти</a>';
$smf=str_replace("%2f","/",$_GET['fid']);
$sf=str_replace($root,"",$smf); $sf=str_replace("..","",$sf);
echo'<br><a href="http://'.$_SERVER['HTTP_HOST'].$sf.'">Просмотреть</a></div>'; 
}
echo '</div>';
include_once"foot.php";
?>
