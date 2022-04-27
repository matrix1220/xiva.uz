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
echo '<div class="menu">';
if(!($_POST[papka]))
{
echo("<div class='bmenu'><b>Массовая переименовка файлов</b></div>");
echo('<form action="rename.php" method="post">
<div class="phdr"><b>Папка с файлами:</b><br/></div>(например files/kartinki без слэша в конце)<br/><input type="text" name="papka" value="files/"/><br/>
<div class="phdr"><b>Ваш сайт:</b></div> (без http://)<br/><input type="text" name="url" maxlength="20"/><br/>
<div class="phdr"><b>Префикс:</b></div> (например Name_) :<br/><input type="text" name="pered" maxlength="20" value="Text_"/><br/>
<input type=submit value=Принять!><br>
');
}
else
{

$dir=$_POST[papka];
if(!($panika=@opendir($dir)))
die('нет такой папки<br><b><a href="rename.php"><<<Назад</a><br/></b>');

function my_rename($dirname) 
{ 
   
    $s=strlen($_POST[url]);
    $s=$s+5;
    $kol=strlen($_POST[pered]);
    $nomer=$s+$kol;
    $ext_arr = array('jpeg', 'jpg', 'gif', 'txt', 'gif'); 
    $dir = opendir($dirname); 
    $count = 1; 
    while (($file = readdir($dir)) !== false) { 
     $bexa=strlen($count);
     $bumer=$nomer+$bexa-4;
        if (is_file($dirname . '/' . $file)) { 
            $info = pathinfo($dirname . '/' . $file); 
            if (in_array(strtolower($info['extension']), $ext_arr)) { 
                rename($dirname . '/' . $file, $dirname . '/' . str_pad($count, $bumer , "$_POST[pered]$_POST[url]_", STR_PAD_LEFT) . '.' . strtolower($info['extension'])); 
                $count ++ ; 
            } 
        } elseif (is_dir($dirname . '/' . $file) && $file != '.' && $file != '..')my_rename($dirname . '/' . $file); 
    } 
    closedir($dir); 
} 
if($_POST[papka])
{
$dir="$_POST[papka]";
my_rename("$dir"); 
print("Перейменовка закончена");
}}
echo '</div>';
include_once"foot.php";
?>