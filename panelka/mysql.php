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


@define('MY77FL', 'YES');
include_once"config.php";
include_once"head.php";
echo'<title>PHPmyAdmin</title>'.
'<div class="gmenu">';
if($connect !== 1) {
echo '<div class="bmenu"><b>Вход в PHPmyAdmin</b></div>';
if(($oh !== '')&&($ou !== '')&&($op !== '')&&($om >= 1)) {
echo '<br/>Нет соединения!<br/>Проверьте ввод!';
}
echo '</div>'.
'<form action="?r='.$r.'" method="post">'.
'<input type="hidden" name="m" value="1"/>'.
'<div class="phdr"><b>MySQL сервер:</b></div>'.
'<textarea name="h" rows="4">'.str_replace('$', '&#036;', htmlspecialchars($oh, ENT_QUOTES)).'</textarea><br/>'.
'<div class="phdr"><b>Пользователь:</b></div>'.
'<textarea name="u" rows="4">'.str_replace('$', '&#036;', htmlspecialchars($ou, ENT_QUOTES)).'</textarea><br/>'.
'<div class="phdr"><b>Пароль:</b></div>'.
'<textarea name="p" rows="4">'.str_replace('$', '&#036;', htmlspecialchars($op, ENT_QUOTES)).'</textarea><br/>'.
'<div class="phdr"><b>Имя базы</b> (не обязательно):</div>'.
'<textarea name="b" rows="4">'.str_replace('$', '&#036;', htmlspecialchars($ob, ENT_QUOTES)).'</textarea><br/>'.
'<input type="submit" value="Войти"/>'.
'</form>'.
'<br>'.
'';
echo'<div class="phdr"><a href="index.php">Файловый менеджер</a></div>';
include_once"foot.php";
exit; }
if(($ob === '')||($om === 2)||($om === 3)) {
if(($om === 2)&&(isset($_POST['newdb']))) {
$newdb = trim($_POST['newdb']);
if(@preg_match('~^[[:print:]]{1,64}$~i', $newdb)) {
if(@mysql_query('CREATE DATABASE '.$newdb.'')) {
echo '<font color="'.FONTS.'"><b>База данных:</b><br>'.str_replace('$', '&#036;', htmlspecialchars($newdb, ENT_QUOTES)).'<br/> успешно создана!</font><br/>';
} else {
echo '<font color="'.FONTS.'"><u>База данных</u>:<br/>'.str_replace('$', '&#036;', htmlspecialchars($newdb, ENT_QUOTES)).'<br/>не была создана.<br/><u>Причина ошибки</u>:<br/>'.str_replace('$', '&#036;', htmlspecialchars(@mysql_error(), ENT_QUOTES)).'</font><br/>';
} } else {
echo '<font color="'.FONTS.'">Недопустимое имя для базы данных или его длинна более 64 символов!</font><br/>';
}
unset($newdb);
echo '<br>'; }
if(($om === 3)&&($cnms >= 1)&&($onms !== '')) {
$tq = 0; $fq = 0;
for($q = 0; $q < $cnms; $q++) {
if(@mysql_query('DROP DATABASE '.$onms[$q].'')) {
$tq++; } else {
$fq++;
echo '<font color="'.FONTS.'"><u>База данных</u>:<br/>'.str_replace('$', '&#036;', htmlspecialchars($onms[$q], ENT_QUOTES)).'<br/>не была удалена.<br/><u>Причина ошибки</u>:<br/>'.str_replace('$', '&#036;', htmlspecialchars(@mysql_error(), ENT_QUOTES)).'</font><br>';
} }
if($tq === $cnms) {
if($cnms > 1) {
$bas = '<u>'.$tq.'</u> баз данных';
} else {
$bas = 'базы данных<br/><u>'.str_replace('$', '&#036;', htmlspecialchars($onms[0], ENT_QUOTES)).'</u>';
}
echo 'Запрос на удаление<br> '.$bas.' <br>успешно выполнен!<br>';
}
unset($onms); }
if($shdbs = @mysql_query('SHOW DATABASES')) {
$alldbs = @mysql_num_rows($shdbs);
if($alldbs >= 1) {
echo '<table>Баз данных:</table> <b>'.$alldbs.'</b><br>';
}
$allpgs = ceil($alldbs/ONPAGE);
if($obp > $allpgs) {
$obp = $allpgs; }
$otb = intval($obp * ONPAGE - ONPAGE);
if($otb < 0) {
$otb = 0; }
$dob = intval($otb + ONPAGE);
if($dob > $alldbs) {
$dob = $alldbs; }
echo '</small></p>'.
'<form action="?r='.$r.'" method="post">'.
'<p align="left" style="background-color: '.FORMS.'">'.
'<input type="hidden" name="h" value="'.$rh.'"/>'.
'<input type="hidden" name="u" value="'.$ru.'"/>'.
'<input type="hidden" name="p" value="'.$rp.'"/>';
if($alldbs >= 1) {
for($n = $otb; $n < $dob; $n++) {
$bnm = @mysql_result($shdbs, $n, 0);
echo '<input type="checkbox" name="nms[]" value="'.rawurlencode($bnm).'"/> '.
'<small><a href="?r='.$r.'&amp;h='.$rh.'&amp;u='.$ru.'&amp;p='.$rp.'&amp;b='.rawurlencode($bnm).'&amp;m=1&amp;bp='.$obp.'" style="color: '.FONTS.'">'.str_replace('$', '&#036;', htmlspecialchars($bnm, ENT_QUOTES)).'</a></small><br/>';
} } else {
echo 'Баз данных не обнаружено</b><br>';
}
echo'<br>';
if($allpgs > 1) {
echo '<small>Стр.: <u>'.$obp.'/'.$allpgs.'</u><br/>';
if($obp > 1) {
echo '[<a href="?r='.$r.'&amp;h='.$rh.'&amp;u='.$ru.'&amp;p='.$rp.'&amp;m=1&amp;bp='.($obp - 1).'">&lt;&lt;</a>]';
}
if($obp < $allpgs) {
echo '[<a href="?r='.$r.'&amp;h='.$rh.'&amp;u='.$ru.'&amp;p='.$rp.'&amp;m=1&amp;bp='.($obp + 1).'">&gt;&gt;</a>]';
}
echo '</small><br/>';
if($allpgs > 2) {
echo '<input type="text" name="bp" size="4" maxlength="4" value="'.$obp.'"/><br/>';
} else {
echo '<input type="hidden" name="bp" value="'.$obp.'"/>';
} }
echo '<table>Новая база:</table><br>'.
'<textarea name="newdb" rows="4"></textarea><br/>'.
'<small><u>Действие</u>:</small><br/>'.
'<select name="m">'.
'<option value="2" selected="selected">создать</option>';
if($allpgs > 2) {
echo '<option value="1">перейти</option>';
}
if($alldbs >= 1) {
echo '<option value="3">удалить</option>';
}
echo '</select><br/>';
echo '<input type="submit" value="Выполнить!"/>'.
'</p></form>'.
'<p align="left"><small>';
} else {
echo '<b>Просмотр списка баз данных невозможен</b> <br>'.str_replace('$', '&#036;', htmlspecialchars(@mysql_error(), ENT_QUOTES)).'<br>';
} } else {
$gots = 1;
echo '<u>База данных</u>:<br/><font color="'.FONTS.'">'.str_replace('$', '&#036;', htmlspecialchars($ob, ENT_QUOTES)).'</font><br/>';
if(($om > 3)&&($selectdb !== 1)) {
echo '<b>Сейчас не возможно выбрать базу данных</b> <br>'.str_replace('$', '&#036;', htmlspecialchars(@mysql_error(), ENT_QUOTES)).'<br>'.
'<br>* <a href="?r='.$r.'&amp;h='.$rh.'&amp;u='.$ru.'&amp;p='.$rp.'&amp;m=1&amp;bp='.$obp.'">К базам</a><br/>'.
'<a href="?r='.$r.'&amp;h='.$rh.'&amp;u='.$ru.'&amp;p='.$rp.'&amp;b='.$rb.'">Войти снова</a>'.
'</small></p>'; include_once"foot.php";
exit; }
if(($om === 4)&&(isset($_POST['sql']))) {
echo '<br>';
$sql = trim($_POST['sql']);
if(isset($_POST['yes'])) {
$sql = trim(@base64_decode($sql));
if(@preg_match('~^[[:print:]]{1,1020}(\.sql|\.txt)$~i', $sql)) {
if(@filetype($sql) === 'file') {
if($data = @file_get_contents($sql)) {
@preg_match_all('~((DROP.+\;)|(CREATE.+\).*\;)|(INSERT.+\)\s*\;(\r|\n)))~isU', $data."\n", $matches);
$ct = count($matches[0]);
if($ct >= 1) {
$tq = 0; $fq = 0;
for($q = 0; $q < $ct; $q++) {
$query = trim($matches[0][$q]);
if(@mysql_query($query)) {
$tq++; } else {
$fq++;
echo '<b>Ошибка в запросе</b> <br>'.str_replace('$', '&#036;', htmlspecialchars($query, ENT_QUOTES)).' <br>'.str_replace('$', '&#036;', htmlspecialchars(@mysql_error(), ENT_QUOTES)).'<br>';
} }
if($tq === $ct) {
echo '<font color="'.FONTS.'">Импорт таблиц<br/>успешно выполнен!</font><br>';
}
echo 'Запросов: <u>'.$ct.'</u><br/>Успешных: <u>'.$tq.'</u><br/>С ошибкой: <u>'.$fq.'</u><br/>';
} else {
echo '<font color="'.FONTS.'"><u>Запросов типа</u>:<br/>DROP, CREATE, INSERT<br/>в файле нет.</font><br/>';
}
unset($data);
unset($matches);
} else {
echo '<font color="'.FONTS.'"><u>Ошибка импорта.</u></font><br/>';
} } else {
echo 'Файл не является обычным файлом или не был найден<br>';
}
@clearstatcache();
} else {
echo 'Возможно в адресе недопустимые символы или его длинна более 1024.<br/>Возможно расширение файла не &quot;.sql&quot; и не &quot;.txt&quot;.<br>';
} } else {
if($sql !== '') {
echo '<font color="'.FONTS.'">Подтверждаем<br/>импорт таблиц?</font><br/>-</small></p>'.
'<form action="?r='.$r.'" method="post">'.
'<p align="left" style="background-color: '.FORMS.'">'.
'<input type="hidden" name="h" value="'.$rh.'"/>'.
'<input type="hidden" name="u" value="'.$ru.'"/>'.
'<input type="hidden" name="p" value="'.$rp.'"/>'.
'<input type="hidden" name="b" value="'.$rb.'"/>'.
'<input type="hidden" name="m" value="4"/>'.
'<input type="hidden" name="bp" value="'.$obp.'"/>'.
'<input type="hidden" name="tp" value="'.$otp.'"/>'.
'<input type="hidden" name="sql" value="'.@base64_encode($sql).'"/>'.
'<input type="hidden" name="yes" value="yes"/>'.
'<input type="submit" value="выполнить"/>'.
'</p></form>'.
'<p align="left"><small>';
} else {
echo '<font color="'.FONTS.'">Строка адреса<br/>SQL - таблиц<br/>была пуста.</font><br/>';
} }
unset($sql); }
elseif(($om === 5)&&((($cnms >= 1)&&($onms !== ''))||($oall === 1))) {
echo '---<br/>';
if($oall === 1) {
$onms = array();
if($shts = @mysql_query('SHOW TABLES FROM '.$ob.'')) {
while($tnm = @mysql_fetch_row($shts)) {
$onms[] = $tnm[0];
} } }
$ct = count($onms);
if($ct >= 1) {
$dump = '';
$d = 0; $v = 0;
for($n = 0; $n < $ct; $n++) {
$shcr = @mysql_query('SHOW CREATE TABLE '.$onms[$n].'');
$rwcr = @mysql_fetch_row($shcr);
$dump .= 'DROP TABLE IF EXISTS `'.$onms[$n].'`;'."\r\n";
$dump .= @strtr(@preg_replace('~[\s]+~', ' ', $rwcr[1]), @array("( "=>"(\r\n", ", "=>",\r\n", ") )"=>")\r\n)")).";\r\n\r\n";
$st = @mysql_query('SELECT * FROM '.$onms[$n].'');
$nr = @mysql_num_rows($st);
$nf = @mysql_num_fields($st);
$wi = 0;
while($rowi = @mysql_fetch_row($st)) {
$in = 'INSERT INTO `'.$onms[$n].'` VALUES (';
for($i = 0; $i < $nf; $i++) {
if($rowi[$i] === NULL) {
$in .= 'NULL'; }
elseif($rowi[$i] !== '') {
$ft = @mysql_field_type($st, $i);
if(($ft === 'tinyint')||($ft === 'smallint')||($ft === 'mediumint')||($ft === 'int')||($ft === 'integer')||($ft === 'bigint')) {
$in .= $rowi[$i];
} else {
$in .= '\''.$rowi[$i].'\'';
} } else {
$in .= '\'\''; }
if($i < $nf - 1) {
$in .= ', '; } }
$in .= ');'."\r\n";
$dump .= $in;
unset($in);
if($wi === $nr - 1) {
$dump .= "\r\n"; }
$wi++; }
$d++; $v += $wi; }
if($ct > 1) {
$backupnm = $ob;
} else {
$backupnm = $onms[0];
}
if($fp = @fopen(BACKUPDR.'/'.$backupnm.'.txt', 'wb')) {
$w = @fwrite($fp, $dump);
if($w !== -1) {
if(($w >= 0)&&($w < 1024)) {
$wr = @round($w/1000, 3).' Kb';
}
elseif(($w >= 1024)&&($w < 1048576)) {
$wr = @round($w/1024, 3).' Kb';
}
elseif($w > 1048576) {
$wr = @round($w/1024/1024, 3).' Mb';
} else { $wr = '--'; }
if($ct > 1) {
$tabl = ''; } else {
$tabl = 'ы'; }
echo 'Дамп из <u>'.$d.'</u> таблиц '.$tabl.' <br>успешно создан!<br/>Его вес: <u>'.$wr.'</u> <br>Записано<br/>CREATE: <u>'.$d.'</u><br/>INSERT: <u>'.$v.'</u><br/>DROP: <u>'.$d.'</u><br/>';
} else {
echo '<font color="'.FONTS.'">Запись в файл<br/>не была выполнена.</font><br/>';
}
@fclose($fp);
} else {
echo 'Невозможно <br>создать файл!<br>';
}
unset($dump);
} else {
echo '<font color="'.FONTS.'">Массив таблиц пуст.</font><br/>';
}
unset($onms); }
elseif(($om === 6)&&(YESSQL === 'YES')&&(isset($_POST['sql']))) {
echo '<br>';
$sql = trim($_POST['sql']);
if(isset($_POST['yes'])) {
$sql = str_replace('*_96*', '`', trim(@base64_decode($sql)));
if(@get_magic_quotes_gpc()) {
$sql = @stripslashes($sql);
}
if($sql !== '') {
if(@mysql_query($sql)) {
echo '<font color="'.FONTS.'">Ваш SQL - запрос<br/>успешно выполнен!</font><br/>';
} else {
echo '<font color="'.FONTS.'">Ваш SQL - запрос<br/>не был выполнен.<br/><u>Причина ошибки</u>:<br/>'.str_replace('$', '&#036;', htmlspecialchars(@mysql_error(), ENT_QUOTES)).'</font><br/>';
} } else {
echo '<font color="'.FONTS.'">Строка вашего<br/>SQL - запроса<br/>была пуста.</font><br/>';
} } else {
if($sql !== '') {
echo '<font color="'.FONTS.'">Подтверждаем<br/>SQL - запрос?</font><br/>-</small></p>'.
'<form action="?r='.$r.'" method="post">'.
'<p align="left" style="background-color: '.FORMS.'">'.
'<input type="hidden" name="h" value="'.$rh.'"/>'.
'<input type="hidden" name="u" value="'.$ru.'"/>'.
'<input type="hidden" name="p" value="'.$rp.'"/>'.
'<input type="hidden" name="b" value="'.$rb.'"/>'.
'<input type="hidden" name="bp" value="'.$obp.'"/>'.
'<input type="hidden" name="tp" value="'.$otp.'"/>'.
'<input type="hidden" name="m" value="6"/>'.
'<input type="hidden" name="sql" value="'.@base64_encode($sql).'"/>'.
'<input type="hidden" name="yes" value="yes"/>'.
'<input type="submit" value="выполнить"/>'.
'</p></form>'.
'<p align="left"><small>';
} else {
echo 'Строка вашего <br>SQL - запроса<br/>была пуста<br>';
} }
unset($sql); }
elseif((($om > 6)&&($om < 10)&&((($cnms >= 1)&&($onms !== ''))||($oall === 1)))||(($om === 10)&&($cnms === 1)&&($onms !== '')&&(isset($_POST['sql'])))) {
echo '---<br/>';
if(($om > 6)&&($om < 10)&&((($cnms >= 1)&&($onms !== ''))||($oall === 1))) {
if($om === 7) {
$query = 'DROP TABLE ';
$action = 'удаление, для';
}
if($om === 8) {
$query = 'TRUNCATE TABLE ';
$action = 'очистка, для';
}
if($om === 9) {
$query = 'OPTIMIZE TABLE ';
$action = 'оптимизация, для';
}
if($oall === 1) {
$onms = array();
if($shtbs = @mysql_query('SHOW TABLES FROM '.$ob.'')) {
while($rowtbs = @mysql_fetch_row($shtbs)) {
$onms[] = $rowtbs[0];
} } }
$ct = count($onms);
if($ct >= 1) {
$tq = 0; $fq = 0;
for($q = 0; $q < $ct; $q++) {
$querys = trim($query.$onms[$q]);
if(@mysql_query($querys)) {
$tq++; } else {
$fq++;
echo 'Ваш запрос <br>'.$action.'<br/>'.str_replace('$', '&#036;', htmlspecialchars($onms[$q], ENT_QUOTES)).'<br/>не был выполнен <br>'.str_replace('$', '&#036;', htmlspecialchars(@mysql_error(), ENT_QUOTES)).'<br>';
if($ct > 1) {
echo '<br>'; }
} }
if($tq === $ct) {
if($ct > ONPAGE) {
echo '<font color="'.FONTS.'">Ваш запрос -<br/>'.$action.'<br/>';
if($oall === 1) {
echo 'ВСЕХ <u>'.$ct.'</u> таблиц<br/>';
} else {
echo '<u>'.$ct.'</u> таблиц<br/>'; }
echo 'успешно выполнен!</font><br/>';
} else {
echo '<font color="'.FONTS.'">Ваш запрос -<br/>'.$action.'<br/>';
if($oall === 1) {
echo 'ВСЕХ <u>'.$ct.'</u> таблиц:<br/>';
}
echo ''.@strtr(htmlspecialchars(@implode(",\n", $onms), ENT_QUOTES), @array("\n"=>"<br/>", "$"=>"&#036;")).'<br/>успешно выполнен!</font><br/>';
} }
if($ct > 1) {
if($fq < 1) {
echo '---<br/>'; }
echo 'Запросов: <u>'.$ct.'</u><br/>Успешных: <u>'.$tq.'</u><br/>С ошибкой: <u>'.$fq.'</u><br/>';
} } else {
echo '<font color="'.FONTS.'">Массив таблиц пуст!</font><br/>';
}
unset($onms); }
elseif(($om === 10)&&($cnms === 1)&&($onms !== '')&&(isset($_POST['sql']))) {
$sql = trim($_POST['sql']);
if(@preg_match('~^[[:print:]]{1,64}$~i', $sql)) {
if(@mysql_query('ALTER TABLE '.$onms[0].' RENAME '.$sql.'')) {
echo '<font color="'.FONTS.'"><u>Таблица</u>:<br/>'.str_replace('$', '&#036;', htmlspecialchars($onms[0], ENT_QUOTES)).'<br/>переименована в<br/>'.str_replace('$', '&#036;', htmlspecialchars($sql, ENT_QUOTES)).'</font><br/>';
} else {
echo '<font color="'.FONTS.'"><u>Таблица</u>:<br/>'.str_replace('$', '&#036;', htmlspecialchars($onms[0], ENT_QUOTES)).'<br/>не переименована в<br/>'.str_replace('$', '&#036;', htmlspecialchars($sql, ENT_QUOTES)).'<br/><u>Причина ошибки</u>:<br/>'.str_replace('$', '&#036;', htmlspecialchars(@mysql_error(), ENT_QUOTES)).'</font><br/>';
} } else {
echo '<font color="'.FONTS.'">Недопустимое новое имя для таблицы или его длинна более 64 символов!</font><br/>';
}
unset($onms);
unset($sql); }
else {
echo '<font color="'.FONTS.'">Произошла ошибка.<br/>Команда не ясна.</font><br/>';
} }
else {
$gots = 2;
if($shtbs = @mysql_query('SHOW TABLES FROM '.$ob.'')) {
$alltbs = @mysql_num_rows($shtbs);
if($alltbs >= 1) {
echo '<u>Таблиц</u>: <font color="'.FONTS.'"><u>'.$alltbs.'</u></font><br/>';
}
$allpgs = ceil($alltbs/ONPAGE);
if($otp > $allpgs) {
$otp = $allpgs; }
$ott = intval($otp * ONPAGE - ONPAGE);
if($ott < 0) {
$ott = 0; }
$dot = intval($ott + ONPAGE);
if($dot > $alltbs) {
$dot = $alltbs; }
echo '---</small></p>'.
'<form action="?r='.$r.'" method="post">'.
'<p align="left" style="background-color: '.FORMS.'">'.
'<input type="hidden" name="h" value="'.$rh.'"/>'.
'<input type="hidden" name="u" value="'.$ru.'"/>'.
'<input type="hidden" name="p" value="'.$rp.'"/>'.
'<input type="hidden" name="b" value="'.$rb.'"/>';
if($alltbs >= 1) {
for($n = $ott; $n < $dot; $n++) {
$tnm = @mysql_result($shtbs, $n, 0);
echo '<input type="checkbox" name="nms[]" value="'.rawurlencode($tnm).'"/> '.
'<small><font color="'.FONTS.'">'.str_replace('$', '&#036;', htmlspecialchars($tnm, ENT_QUOTES)).'</small><br/>';
} } else {
echo '<small><font color="'.FONTS.'">Таблиц пока нет.</font></small><br/>';
}
echo '<input type="hidden" name="bp" value="'.$obp.'"/>'.
'<small>---</small><br/>';
if($allpgs > 1) {
echo '<small>Стр.: <u>'.$otp.'/'.$allpgs.'</u><br/>';
if($otp > 1) {
echo '[<a href="?r='.$r.'&amp;h='.$rh.'&amp;u='.$ru.'&amp;p='.$rp.'&amp;b='.$rb.'&amp;m=1&amp;bp='.$obp.'&amp;tp='.($otp - 1).'">&lt;&lt;</a>]';
}
if($otp < $allpgs) {
echo '[<a href="?r='.$r.'&amp;h='.$rh.'&amp;u='.$ru.'&amp;p='.$rp.'&amp;b='.$rb.'&amp;m=1&amp;bp='.$obp.'&amp;tp='.($otp + 1).'">&gt;&gt;</a>]';
}
echo '</small><br/>';
if($allpgs > 2) {
echo '<input type="text" name="tp" size="4" maxlength="4" value="'.$otp.'"/><br/>';
} else {
echo '<input type="hidden" name="tp" value="'.$otp.'"/>';
} }
echo '<small><u>Данные запроса</u>:</small><br/>'.
'<textarea name="sql" rows="4"></textarea><br/>'.
'<small><u>Действие</u>:</small><br/>'.
'<select name="m">'.
'<option value="4" selected="selected">импорт таблиц</option>';
if($allpgs > 2) {
echo '<option value="1">переход на стр.</option>';
}
if($alltbs >= 1) {
echo '<option value="5">BackUp таблиц</option>';
if(YESSQL === 'YES') {
echo '<option value="6">SQL - запрос</option>';
}
echo '<option value="7">удаление таб.</option>'.
'<option value="8">очистка таб.</option>'.
'<option value="9">оптимизация</option>'.
'<option value="10">переименов.</option>';
}
echo '</select><br/>';
if($alltbs > 1) {
echo '<input type="checkbox" name="all" value="all"/>'.
'<small><u>ВСЕ</u></small><br/>';
}
echo '<input type="submit" value="Выполнить!"/>'.
'</p></form>'.
'<p align="left"><small>';
} else {
echo '---<br/><font color="'.FONTS.'">Просмотр списка таблиц невозможен.<br/><u>Причина ошибки</u>:<br/>'.str_replace('$', '&#036;', htmlspecialchars(@mysql_error(), ENT_QUOTES)).'</font><br/>';
} }
if(($ob !== '')&&($om !== 2)&&($om !== 3)) {
echo '---<br/><a href="?r='.$r.'&amp;h='.$rh.'&amp;u='.$ru.'&amp;p='.$rp.'&amp;m=1&amp;bp='.$obp.'">К базам</a><br/>';
if($gots === 1) {
echo '<a href="?r='.$r.'&amp;h='.$rh.'&amp;u='.$ru.'&amp;p='.$rp.'&amp;b='.$rb.'&amp;m=1&amp;bp='.$obp.'&amp;tp='.$otp.'">К таблицам</a><br/>';
} } }
echo '---<br/><a href="?r='.$r.'&amp;h='.$rh.'&amp;u='.$ru.'&amp;p='.$rp.'&amp;b='.$rb.'">Войти снова</a>'.
'</small></p>';
include_once"foot.php";
?>