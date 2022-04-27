<div class="body">
<div id=logo><font id="font">Xiva</font></div>
<div align="center" class=menu>
<?php for($x=1;$x<=$pages;$x++){if($x==$i){echo"<img src=temp/buttonon.png>";}else{echo"<a href=javascript:change($x)><img src=temp/buttonoff.png></a>";}echo"\n";}?>
<img align="right" id="play" onClick="player()">
</div>
<div class=main>
<?php  echo"<img src=img/$i.jpg align=left id=img>\n<div align=center>\n"; include("txt/$i.txt"); echo"\n</div>\n";?>
</div>
</div>
<a href=javascript:change(i-1)><img id=prev src=temp/next.png></a>
<a href=javascript:change(i+1)><img id=next src=temp/next.png></a>
