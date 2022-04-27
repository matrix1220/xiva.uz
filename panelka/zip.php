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
echo'<title>Просмотр архива '.strtolower(substr($_GET['arch'], 1 + strrpos($_GET['arch'], "/"))).'</title>';
echo ' <b>Просмотр архива</b><br><br>';
if(!$_GET['arch']){ echo'<title>Ошибка!</title> Ошибка! Не выбран архив!'; include_once"foot.php"; exit;} 
$arch=$_GET['arch'];
if (!$_GET['action']){
$zip=new PclZip($_GET['arch']);
if (($list = $zip->listContent()) != 0){

sort($list);

$countlist = count($list);
$zfilename = array();
$zfilesize = array();
$zfolder = array();

for ($i=0; $i<$countlist; $i++){

$zfilename[]=$list[$i]['filename'];
$zfilesize[]=$list[$i]['size'];
$zfolder[]=$list[$i]['folder'];
}
$totalsize=array_sum($zfilesize);

$total = count($zfilename);
echo 'Название <b>'.strtolower(substr($arch, 1 + strrpos($arch, "/"))).'</b><br><br>';
echo 'Всего файлов: '.$total.'<br>Вес распакованного архива: '.formatsize($totalsize).'<br>';

$start = (int)$_GET['start'];
if($start < 0 || $start > $total){$start = 0;}
if ($total < $start + $udata[2]){ $end = $total; }
else {$end = $start + $udata[2]; }
for ($i = $start; $i < $end; $i++){

$ext=strtolower(strrchr($zfilename[$i], "."));

switch($ext){
case 'dir': $ico='dir.gif'; break;
case '.jpg': case '.jpeg': $ico='jpg.gif'; break;
case '.gif': $ico='gif.gif'; break;
case '.mid': $ico='mid.gif'; break;
case '.mp3': $ico='mp3.gif'; break;
case '.wav': case '.amr': $ico='wav.gif'; break;
case '.mmf': $ico='mmf.gif'; break;
case '.jad': $ico='jad.gif'; break;
case '.jar': $ico='jar.gif'; break;
case '.zip': $ico='zip.gif'; break;
case '.txt': $ico='txt.gif'; break;
case '.exe': $ico='exe.gif'; break;
case '.htm': $ico='htm.gif'; break;
case '.html': $ico='htm.gif'; break;
case '.php': $ico='php.gif'; break;
default: $ico='file.gif'; break; }

if($zfolder[$i]=="1"){
$zfilename[$i]=substr($zfilename[$i],0,-1);

echo '<img src="images/dir.gif" alt=""> <b>Директория '.$zfilename[$i].'</b><br>';
}else{
echo ' <a href="zip.php?action=preview&arch='.$arch.'&open='.$zfilename[$i].'&start='.$start.'&">'.$zfilename[$i].'</a>';
echo ' ('.formatsize($zfilesize[$i]).')<br>';
}}

echo '<br>';
if($total>0){
$ba=ceil($total/$udata[2]);
$ba2=$ba*$udata[2]-$udata[2];

echo '<br><br>Страницы:';
$asd=$start-($udata[2]*3);
$asd2=$start+($udata[2]*4);

if($asd<$total && $asd>0){echo ' <a href="zip.php?start=0&arch='.$arch.'&">1</a> ... ';}
for($i=$asd; $i<$asd2;){

if($i<$total && $i>=0){
$ii=floor(1+$i/$udata[2]);

if ($start==$i) {
echo ' <b>('.$ii.')</b>';
} else {
echo ' <a href="zip.php?start='.$i.'&arch='.$arch.'&">'.$ii.'</a> ';
}}

$i=$i+$udata[2];}
if($asd2<$total){echo ' ... <a href="zip.php?start='.$ba2.'&arch='.$arch.'&">'.$ba.'</a>';}
}

}else{
echo '<br> Невозможно открыть архив! <br>';
echo 'Ошибка: '.$zip->errorInfo(true);
}

echo'<br><br>* <a href="index.php?action=viewfile&fid='.$arch.'&">Вернуться</a><br>';
echo'* <a href="index.php">Файловый менеджер</a><br>';
}
////////////////////////////////// Просмотр  файла ////////////////////////////////
if($_GET['action']=="preview"){
		
$zip=new PclZip($arch);
$content = $zip->extract(PCLZIP_OPT_BY_NAME, $_GET['open'],PCLZIP_OPT_EXTRACT_AS_STRING);
$content = $content[0]['content'];

$preview = explode("\r\n",$content);
$count = count($preview);
$ext = strtolower(substr($_GET['open'], strrpos($_GET['open'], '.') + 1));

echo 'Название архива: <b>'.strtolower(substr($arch, 1 + strrpos($arch, "/"))).'</b><br>';
echo 'Открытый файл: <b>'.$_GET['open'].'</b><br>';

if ($ext!="gif" && $ext!="jpg" && $ext!="png"){

//---------------------- Файл ----------------------//
echo 'Всего строчек: '.(int)$count.'<br><br>';

if(is_utf($content)){echo highlight_code($content);}else{echo highlight_code(win_to_utf($content));}

echo '« <a href="zip.php?arch='.$arch.'&start='.$_GET['start'].'&">Назад</a><br>';

}else{

//-------------------- Картинка --------------------//
if($_GET['create']=="image"){
ob_end_clean();	
ob_clean();
header('Content-Disposition: attachment; filename="image.'.$ext.'";');
if($ext=="jpg"){$ext="jpeg";}
header("Content-type: image/$ext");
header("Content-Length: ".strlen($content));
echo $content;
exit;}
echo'Image:<br> <a href="zip.php?action=preview&arch='.$arch.'&open='.$_GET['open'].'&create=image"> <img src="zip.php?action=preview&arch='.$arch.'&open='.$_GET['open'].'&create=image" alt=""></a><br>';
echo '« <a href="zip.php?arch='.$arch.'&start='.$_GET['start'].'&">Назад</a><br>';
//--------------------------------------------------//
}}

include_once"foot.php";
?>