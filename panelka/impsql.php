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
if(empty($_POST['mode']))
{
echo '<form action="" method="post">
<div class="menu">
<input type="hidden" name="mode" value="do"/><br/>
<div class="bmenu">Хост:</div>
<input type="text" name="host" value="localhost"/><br/>
<br/>
<div class="bmenu">Имя базы:</div>
<input type="text" name="db" value="db_name"/><br/>
<div class="bmenu">Имя пользователя:</div>
<input type="text" name="user" value="db_user"/><br/>
<div class="bmenu">Пароль:</div>
<input type="text" name="password" value="pass"/><br/>
<div class="bmenu">Адрес файла SQL:</div>
<textarea name="address" nums="25" rows="2">'.$_SERVER['DOCUMENT_ROOT'].'/</textarea><br/>
<input type="submit" value="Продолжить">
</div></form>';
}
else
{
echo '<div class="text">
';
$query=file_get_contents($_POST['address']) or die('Не читает '.$_POST['address'].'!<br/></div>'.$end);
$queryes=preg_split("#(SELECT|CREATE|DROP|UPDATE|INSERT|SHOW|REVOKE|MATCH|LIKE|GRANT|DESCRIBE|OPTIMIZE|COUNT|ALTER|AGAINST|)[-a-z0-9_.:@&?=+,!/~*'%$\"\s\n]*;#i", $query);
$count=count($queryes)-1;
$connect=mysql_connect($_POST['host'], $_POST['user'], $_POST['password']) or die('Не соединяет с сервером MySQL, потому что '.mysql_error().'<br/></div>'.$end);
mysql_select_db($_POST['db']) or die('Не просматриваются данные базы потому что '.mysql_error().'<br/></div>'.$end);
echo 'Запросов: '.$count.'<br/>';
for($i=0;$i<$count;$i++)
{
if (($i+1)%2==0)
{
echo '<div class="even">';
}
else
{
echo '<div class="uneven">';
}
echo '<b>'.($i+1).'.</b> ';
if(mysql_query($queryes[$i]))
{
echo htmlspecialchars($queryes[$i]).'<br/>
<span style="color:#0fdd0f">Запрос выполнен!<br/></span>';
}
else
{
echo htmlspecialchars($queryes[$i]).'<br/>
<span style="color:#dd0011">Запрос не выполнен!<br/></span>';
}
echo '</div>';
}
echo '</div>';
mysql_close();
}
include'foot.php';
?>
