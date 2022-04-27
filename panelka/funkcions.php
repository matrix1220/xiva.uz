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

 
//---- Библиотека функций :) автор: Vantuz =)) -----//


//----------------------- Функция копирования папки ------------------------//
  	function copy_dir($in,$to) { $in=str_replace('%2f','/',$in); $to=str_replace('%2f','/',$to);  	$ex=explode('/',$in); $cou=count($ex); $td=$ex[$cou-1];  $to=$to.'/'.$td;  	if(!is_dir($to)){ mkdir($to);} $dir=opendir($in);  while ($a=readdir($dir)) {  if ($a=='.' or $a=='..') continue;  if (is_file($in.'/'.$a)) {  copy($in.'/'.$a,$to.'/'.$a); }  else {  if (!is_dir($to.'/'.$a)) {  mkdir($to.'/'.$a); }  copy_dir($in.'/'.$a,$to.'/'.$a); } }  closedir($dir);  return $in;  } 
//----------------------- Функция определения кодировки ------------------------//
function is_utf($str){
if (function_exists('mb_detect_encoding')){
if (mb_detect_encoding($str) == "UTF-8") {return true;} else { return false;}
}

$letters=array("а","б","в","г","д","е","ё","ж","з","и","й","к","л","м","н","о","п","р","с","т","у","ф","х","ц","ч","ш","щ","ъ","ы","ь","э","ю","я");
foreach($letters as $letval){
if(strstr($str,$letval)){return true; break;} else { return false;}
}}
//------Функция удаления строки из файла-------//
function delete_lines($files, $lines){

if ($lines!==""){
if (file_exists($files)){

if(!is_array($lines)){

$file=file($files);
$fp=fopen($files,"a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
if (isset($file[$lines])){unset($file[$lines]);}
fputs ($fp, implode($file));
fflush($fp);
flock ($fp,LOCK_UN);
fclose($fp); 
unset ($lines);

} else {

$file=file($files);
$fp=fopen($files,"a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
foreach($lines as $val){ 
if (isset($file[$val])){unset($file[$val]);}
}
fputs ($fp, implode($file));
fflush($fp);
flock ($fp,LOCK_UN);
fclose($fp); 
unset ($lines);

}}}
}

//------------------- Функция сдига строки в файле --------------------//
function move_lines($files, $lines, $where){

if (file_exists($files)){
if ($lines!==""){
if ($where!==""){

if ($where==1) {$lines2 = $lines + 1;} else {$lines2 = $lines - 1;}

$file = file($files);

if (isset($file[$lines]) && isset($file[$lines2])){

$fp = fopen($files, "a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);

foreach($file as $key=>$val){ 

if ($lines==$key) {

fputs($fp, $file[$lines2]);

} elseif ($lines2==$key){

fputs($fp, $file[$lines]);

} else {
fputs($fp,$val);
}
}

fflush($fp);
flock ($fp,LOCK_UN);
fclose($fp);

}}}}
}

//------------------- Функция замены строки в файлe --------------------//
function replace_lines($files, $lines, $text){

if (file_exists($files)){
if ($lines!==""){
if ($text!=""){

$file = file($files);
$fp = fopen($files, "a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);

foreach($file as $key=>$val){ 

if ($lines==$key) {
fputs($fp,"$text\r\n");

} else {

fputs($fp,$val);
}
}

fflush($fp);
flock ($fp,LOCK_UN);
fclose($fp);
}}}
}


//------------------ Функция подсветки кода -------------------------//
function highlight_code($code) {



$code = highlight_string($code,true);


$code = '<code>'.$code.'</code>';
return $code;
}

//------------------ Функция перекодировки из UTF в WIN --------------------//
function utf_to_win($str) { 

if (function_exists('mb_convert_encoding')) return mb_convert_encoding($str, 'windows-1251', 'utf-8');
if (function_exists('iconv')) return iconv('utf-8', 'windows-1251', $str);

$utf8win1251 = array( 
"А"=>"\xC0","Б"=>"\xC1","В"=>"\xC2","Г"=>"\xC3","Д"=>"\xC4","Е"=>"\xC5","Ё"=>"\xA8","Ж"=>"\xC6","З"=>"\xC7","И"=>"\xC8","Й"=>"\xC9","К"=>"\xCA","Л"=>"\xCB","М"=>"\xCC",
"Н"=>"\xCD","О"=>"\xCE","П"=>"\xCF","Р"=>"\xD0","С"=>"\xD1","Т"=>"\xD2","У"=>"\xD3","Ф"=>"\xD4","Х"=>"\xD5","Ц"=>"\xD6","Ч"=>"\xD7","Ш"=>"\xD8","Щ"=>"\xD9","Ъ"=>"\xDA",
"Ы"=>"\xDB","Ь"=>"\xDC","Э"=>"\xDD","Ю"=>"\xDE","Я"=>"\xDF","а"=>"\xE0","б"=>"\xE1","в"=>"\xE2","г"=>"\xE3","д"=>"\xE4","е"=>"\xE5","ё"=>"\xB8","ж"=>"\xE6","з"=>"\xE7",
"и"=>"\xE8","й"=>"\xE9","к"=>"\xEA","л"=>"\xEB","м"=>"\xEC","н"=>"\xED","о"=>"\xEE","п"=>"\xEF","р"=>"\xF0","с"=>"\xF1","т"=>"\xF2","у"=>"\xF3","ф"=>"\xF4","х"=>"\xF5",
"ц"=>"\xF6","ч"=>"\xF7","ш"=>"\xF8","щ"=>"\xF9","ъ"=>"\xFA","ы"=>"\xFB","ь"=>"\xFC","э"=>"\xFD","ю"=>"\xFE","я"=>"\xFF"); 

return strtr($str, $utf8win1251); 
} 


//------------------ Функция перекодировки из WIN в UTF --------------------//
function win_to_utf($str) { 

if (function_exists('mb_convert_encoding')) return mb_convert_encoding($str, 'utf-8', 'windows-1251');
if (function_exists('iconv')) return iconv('windows-1251', 'utf-8', $str);

$win1251utf8 = array( 
"\xC0"=>"А","\xC1"=>"Б","\xC2"=>"В","\xC3"=>"Г","\xC4"=>"Д","\xC5"=>"Е","\xA8"=>"Ё","\xC6"=>"Ж","\xC7"=>"З","\xC8"=>"И","\xC9"=>"Й","\xCA"=>"К","\xCB"=>"Л","\xCC"=>"М",
"\xCD"=>"Н","\xCE"=>"О","\xCF"=>"П","\xD0"=>"Р","\xD1"=>"С","\xD2"=>"Т","\xD3"=>"У","\xD4"=>"Ф","\xD5"=>"Х","\xD6"=>"Ц","\xD7"=>"Ч","\xD8"=>"Ш","\xD9"=>"Щ","\xDA"=>"Ъ",
"\xDB"=>"Ы","\xDC"=>"Ь","\xDD"=>"Э","\xDE"=>"Ю","\xDF"=>"Я","\xE0"=>"а","\xE1"=>"б","\xE2"=>"в","\xE3"=>"г","\xE4"=>"д","\xE5"=>"е","\xB8"=>"ё","\xE6"=>"ж","\xE7"=>"з",
"\xE8"=>"и","\xE9"=>"й","\xEA"=>"к","\xEB"=>"л","\xEC"=>"м","\xED"=>"н","\xEE"=>"о","\xEF"=>"п","\xF0"=>"р","\xF1"=>"с","\xF2"=>"т","\xF3"=>"у","\xF4"=>"ф","\xF5"=>"х",
"\xF6"=>"ц","\xF7"=>"ч","\xF8"=>"ш","\xF9"=>"щ","\xFA"=>"ъ","\xFB"=>"ы","\xFC"=>"ь","\xFD"=>"э","\xFE"=>"ю","\xFF"=>"я"); 

return strtr($str, $win1251utf8); 
}

//------------------ Функция преобразования в нижний регистр для UTF ------------------//
function rus_utf_tolower($str){

if (function_exists('mb_strtolower')) return mb_strtolower($str, 'utf-8');

$arraytolower = array( 'А'=>'а','Б'=>'б','В'=>'в','Г'=>'г','Д'=>'д','Е'=>'е','Ё'=>'ё','Ж'=>'ж','З'=>'з','И'=>'и','Й'=>'й','К'=>'к','Л'=>'л','М'=>'м','Н'=>'н','О'=>'о','П'=>'п','Р'=>'р','С'=>'с','Т'=>'т','У'=>'у','Ф'=>'ф','Х'=>'х','Ц'=>'ц','Ч'=>'ч','Ш'=>'ш','Щ'=>'щ','Ь'=>'ь','Ъ'=>'ъ','Ы'=>'ы','Э'=>'э','Ю'=>'ю','Я'=>'я',
'A'=>'a','B'=>'b','C'=>'c','D'=>'d','E'=>'e','I'=>'i','F'=>'f','G'=>'g','H'=>'h','J'=>'j','K'=>'k','L'=>'l','M'=>'m','N'=>'n','O'=>'o','P'=>'p','Q'=>'q','R'=>'r','S'=>'s','T'=>'t','U'=>'u','V'=>'v','W'=>'w','X'=>'x','Y'=>'y','Z'=>'z');

return strtr($str, $arraytolower); 
}

//----------------------- Функция вырезания переноса строки --------------------------//
function no_br($msg, $replace = ""){ 
$msg = preg_replace ("|[\r\n]+|si", $replace, $msg);
return $msg;
}
//--------------- Функция правильного вывода веса файла -------------------//
function formatsize($file_size){

if ($file_size >= 1048576000){
$file_size = round(($file_size / 1073741824), 2) . " Gb";
} elseif (
$file_size >= 1024000){
$file_size = round(($file_size / 1048576), 2) . " Mb";
} elseif (
$file_size >= 1000){
$file_size = round(($file_size / 1024), 2) . " Kb";
} else {
$file_size = round($file_size) . " byte";}
return $file_size;
}

//--------------- Функция форматированного вывода размера файла -------------------//
function read_file($file){

if (file_exists($file)) {

return formatsize(filesize($file));

} else {
return 0;
}
}

//--------------- Функция подсчета веса директории -------------------//
function  read_dir($dir) { 
$dir=str_replace('%2f','/',$dir);

if (empty($allsize)){$allsize = '';}

if ($path = opendir($dir)){

$file=file("data/user.dat");
$udata=explode("|",$file[0]);

if ($udata[3] == 1){
while ($file_name = readdir($path)) {
if (($file_name!=='.') && ($file_name!=='..')){ 
if (is_dir($dir."/".$file_name)) {$allsize +=read_dir($dir."/".$file_name);} else { $allsize += filesize($dir."/".$file_name);}
}}
 }
closedir ($path); 
}
return  $allsize;
}

//------------------ Функция шифрования по ключу --------------------//
function xoft_encode($string, $key){   
$result = "";   
for($i = 1; $i<=strlen($string); $i++){   
$char = substr($string, $i-1,1);   
$keychar = substr($key, ($i % strlen($key)) - 1, 1);   
$char = chr(ord($char)+ord($keychar));   
$result .= $char;   
}   
return safe_encode($result);   
}   

//------------------ Функция расшифровки по ключу --------------------//	
function xoft_decode($string, $key){  
$string = safe_decode($string); 
$result = "";   
for($i = 1; $i<=strlen($string); $i++){   
$char = substr( $string, $i - 1, 1 );   
$keychar = substr($key, ($i % strlen($key)) - 1, 1);   
$char = chr(ord($char) - ord($keychar));   
$result .= $char;   
}   
return $result;   
}
//--------------------------- Функция перевода секунд во время -----------------------------//
function maketime($string){
if($string<3600){
$string=sprintf("%02d:%02d",(int)($string/60) % 60, $string % 60); 
}else{
$string=sprintf("%02d:%02d:%02d", (int)($string / 3600) % 24, (int)($string / 60) % 60, $string % 60); 	
}
return $string; 
}
//---------------------------------------------- Функция удаления папки --------------------------------------------------//
function unlink_dir($value){ $value=str_replace('%2f','/',$value);
$dir=opendir($value); 
while($file = readdir($dir)){
if(is_file("$value/$file")){
unlink("$value/$file");
}
elseif(is_dir("$value/$file") && $file !== "." && $file !== "..") {
unlink_dir("$value/$file");
		}
		}
		closedir($dir);
if(rmdir($value))
			return true;}
//---------------------------------------------- Функция очистки папки --------------------------------------------------//
function clear_dir($value){
$dir=opendir($value); 
while($file = readdir($dir)){
if(is_file("$value/$file")){
unlink("$value/$file");
}
elseif(is_dir("$value/$file") && $file !== "." && $file !== "..") {
clear_dir("$value/$file");
		}
		}
		closedir($dir);
return true;}

//------------------- Функция очистки файла --------------------//
function clear_files($files){
if (file_exists($files)){
$file = file($files);
$fp = fopen($files,"a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
fflush($fp);
flock ($fp,LOCK_UN);
fclose($fp);
}}
 ?>
