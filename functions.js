function equalness(){wh=window.innerHeight;if(wh/100*70<ih){$(".main").css("min-height",(wh/100*70+5)+'px');}else{$(".main").css("min-height",(ih+10)+'px');}if(play){time=setInterval("isPlaying()",1000); document.getElementById("play").src="temp/pause.png";}
else{ document.getElementById("play").src="temp/play.png";}}
function change(x){$('.body').css('-webkit-animation','te 1s'); setTimeout(function(){location.assign('?num='+x+'&play='+play);},800);}
function player(){
if(play){play=false;document.getElementById("play").src="temp/play.png";clearInterval(time);}
else{play=true;document.getElementById("play").src="temp/pause.png";time=setInterval('isPlaying()',1000); }}
function isPlaying() {t++;if(t==10){change(i+1);}}