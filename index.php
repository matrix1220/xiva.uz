<html>
<head>
<?php
include("config.php");
include("head.tpl");
$i=$_GET['num'];
$play=$_GET['play'];
if(empty($play)){$play='true';}
if(empty($i)){echo'<!-- <meta http-equiv=Refresh content="12; url=index.php?num=1&play=true"> -->';}
if(empty($i)==false and $i<$pages+1){$img=GetImageSize("img/$i.jpg");include("script.tpl");}
?>
</head>
<body<?php if(empty($i)==false and $i<$pages+1){echo" onLoad='equalness()'";} ?>>
<?php
if(empty($i)){include("begin.tpl");}
elseif ($i==$pages+1){include("end.tpl");}
else {include("index.tpl");}
?>
</body>
</html>