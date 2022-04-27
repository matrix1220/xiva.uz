<html>
 <head>
  <?php include("config.php"); include("head.tpl"); $i=$_POST['num']; if(empty($i)||$i>$pages){$i=1;} ?>
  <style>
div.main{margin-top:20px;padding:30px;}
  </style>
  <style>
  </style>
  <script>
var i=0,rx=0,ry=0,rz=0,sx=0,sy=0,tx=0,ty=0,tz=0,browser="-webkit-";
function animate0() {
document.getElementsByTagName('style')[1].innerHTML+="@-webkit-keyframes anim"+i+" {from{"+browser+"transform:skew("+sx+"deg,"+sy+"deg) \ rotateX("+rx+"deg) \ rotateY("+ry+"deg) \ rotateZ("+rz+"deg) \ translate3d("+tx+"px,"+ty+"px,"+tz+"px);}";
                    }
function animate1() {
document.getElementsByTagName('style')[1].innerHTML+="to{"+browser+"transform:skew("+sx+"deg,"+sy+"deg) \ rotateX("+rx+"deg) \ rotateY("+ry+"deg) \ rotateZ("+rz+"deg) \ translate3d("+tx+"px,"+ty+"px,"+tz+"px);}}";
$("#edit").css(browser+"animation","anim"+i+" 1s"); 
$("#edit").css(browser+"transform","skew("+sx+"deg,"+sy+"deg) \ rotateX("+rx+"deg) \ rotateY("+ry+"deg) \ rotateZ("+rz+"deg) \ translate3d("+tx+"px,"+ty+"px,"+tz+"px)");
i++;
                   }
  </script>
 </head>
 <body>
  <div id="logo"><font id="font">Xiva</font></div>
   <div class=main>
    <form action=3d.php method=POST>
     sahifa:
     <select name=num>
<?php for($x=1;$x<=$pages;$x++){echo"        <option ";if($x==$i){echo"selected";}echo" value=$x>$x\n";} ?>
     </select><br>
     <table width=100%>
      <tr>
       <td>
        X:<input type=range onChange="animate0();rx=this.value;animate1();" value=0 min=0 max=180><br>
        Y:<input type=range onChange="animate0();ry=this.value;animate1();" value=0 min=0 max=180><br>
        Z:<input type=range onChange="animate0();rz=this.value;animate1();" value=0 min=0 max=180><br>
       </td>
       <td>
        X:<input type=range onChange="animate0();sx=this.value;animate1();" value=0 min=0 max=180><br>
        y:<input type=range onChange="animate0();sy=this.value;animate1();" value=0 min=0 max=180><br>
       </td>
       <td>
        X:<input type=range onChange="animate0();tx=this.value;animate1();" value=0 min=0 max=500><br>
        Y:<input type=range onChange="animate0();ty=this.value;animate1();" value=0 min=0 max=500><br>
        Z:<input type=range onChange="animate0();tz=this.value;animate1();" value=0 min=0 max=500><br>
       </td>
      <tr>
       <td colspan=2>
        <input type=submit value=ochish>
       </td>
      </tr>
     </table>
    <form>
   </div>
    <div class=main id=edit>
     <img src=img/<?php  echo"$i";?>.jpg align=left id=img>
     <div align=center>
      <?php include("txt/$i.txt"); ?>
      <h1><?php echo $i; ?></h1>
     </div>
    </div>
 </body>
</html>