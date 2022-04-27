<html>
<head>
<?php include("config.php"); include("head.tpl"); ?>
<style>
div.main{padding:60px;margin:100px;}
img{max-height:100%;}
</style>
</head>
<body onload="equalness()">
<div id="logo"><font id="font">Xiva</font></div>
<?php
for($i=1;$i<=$pages;$i++){
echo"<div class=main>\n";
echo"<img src=img/$i.jpg align=left id=img>\n<div align=center>\n"; include("txt/$i.txt"); echo"\n<h2 align=center>$i</h2></div>\n";
echo"</div>";
                         }
?>
</body>
</html>