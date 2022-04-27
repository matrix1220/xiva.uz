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

echo'<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<link rel="stylesheet" type="text/css" href="./style.css">';
echo'<div class="fmenu" align="center"><a href="/">'.$_SERVER['HTTP_HOST'].'</a></div>'; 
echo'<div class="phdr">Время сервера: '.date('d.m.Y H:i:s').'</div>'; 
?>
