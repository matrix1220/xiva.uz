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
$fils=file("data/user.dat");
$udata=explode("|",$fils[0]);

@setcookie("lastaddress",$_GET['addr'],time()+691200);

require_once'head.php';
 if($_GET['mode']){
   
  $url = htmlspecialchars(trim($_GET['addr']));
  
  if(!preg_match("#^https?://#iU",$url)) $url= "http://".$url;
  
  $purl = @parse_url($url);
  
  //get extens. file
  $ext = strtolower(strrchr($url,'.'));
  
  if($ext=='.jpg' or $ext=='.gif' or $ext=='.bmp' or $ext=='.ico' or $ext=='.png'){
  
    echo "
    <div class='menu'> <img src='".$url."' alt=''/> 
    </div> ";
    
require_once'foot.php';
        exit;
        
        }
        
  $cnt = @file_get_contents($url);
 
   //charset processing
   preg_match("#encoding ?= ?('|\")([^'\"]+)('|\")#i",$cnt,$ch);
   
   if(empty($ch[2])){ 
  
   preg_match("#charset ?= ?([^'\"]+)('|\")#i",$cnt,$ch);
  
   $ch[2] = $ch[1];
            }
                
  if($ch[2]!=='utf-8')
  $cnt = iconv($ch[2],"utf-8//IGNORE",$cnt);
  
  if(!$cnt){ echo"<div class='rmenu'>  Невозможно обратится к адресу (".$url.")<br />
                 Проверьте правильность введенного вами адреса и проверьте, доступен ли он с обычного браузера</div>";
  
require_once'foot.php';
        exit;
 
               }
               
               //icon processing
   
   preg_match("#<link ?rel ?= ?('|\") ?shortcut icon('|\") +href ?= ?('|\")([^'\"]+)('|\")#i",$cnt,$out);


  if(empty($out[4])) $out[4] = '/favicon.ico';
  
  
  //title processing
  
   preg_match("#< ?title ?>(.+)< ?/ ?title ?>#i",$cnt,$title);
   
   if(empty($title[1])){ 
  
   preg_match("# ?title ?= ?('|\")([^'\"]+)('|\")#i",$cnt,$title);
  
   $title[1] = $title[2];
            }
  
  //stat info
    echo"
<div class='gmenu'>Адрес<br/> ".strtolower($url)."<br/>
Загаловок       <b>".htmlspecialchars($title[1])."</b></div>";

  if($_GET['mode']=='scan'){     

     //replaces
     $cnt = preg_replace("#@import ?('|\")/?([^;'\"]+)#is","<a href='scaner.php?addr=http://".$purl['host']."/".$purl['path']."&mode=scan'>\\2</a>",$cnt);
     
     //x-ray
     $cnt = htmlspecialchars($cnt);
     //absolute site
     $cnt = preg_replace("#&lt;link ?rel ?= ?('|&quot;) ?stylesheet('|&quot;) +href ?= ?('|&quot;)/([a-z/\.\?\#0-9-_\+\(\)]+)('|&quot;)(.+)( ?/ ?&gt;)+#i","<a href='scaner.php?addr=http://".$purl['host']."/\\4&mode=scan'>\\0</a>",$cnt);
     $cnt = preg_replace("#((&lt;img ?src ?= ?)('|&quot;))/([a-z/\.\?\#0-9]+)(('|&quot;)(.+)/ ?&gt;)#i","\\1<a href='scaner.php?addr=http://".trim($purl['host'],'/')."/\\4&mode=scan'>\\4</a>\\5",$cnt);
     $cnt = preg_replace("#&lt;script(.*) +(src|href) ?= ?('|&quot;)/([a-z/\.\?\#0-9-_\+\(\)]+)('|&quot;)(.+)( ?&gt;)+#i","<a href='scaner.php?addr=http://".$purl['host']."/\\4&mode=scan'>\\0</a>",$cnt);
     $cnt = preg_replace("#(&lt;a(.*) +href ?= ?('|&quot;))/([a-z/\.\?\#0-9-_\+\(\)]+)(('|&quot;)(.+)( ?&gt;)+)#i","\\1<a href='scaner.php?addr=http://".$purl['host']."/\\4&mode=scan'>\\4</a>\\5",$cnt);

     //localy
     $cnt = preg_replace("#&lt;link ?rel ?= ?('|&quot;) ?stylesheet('|&quot;) +href ?= ?('|&quot;)([^/][a-z/\.\?\#0-9-_\+\(\)]+)('|&quot;)(.+)( ?/ ?&gt;)+#is","<a href='scaner.php?addr=http://".$purl['host']."/".$purl['path']."\\4&mode=scan'>\\0</a>",$cnt);
     $cnt = preg_replace("#((&lt;img ?src ?= ?)('|&quot;))([^/][a-z/\.\?\#0-9]+)(('|&quot;)(.+)/ ?&gt;)#is","\\1<a href='scaner.php?addr=http://".trim($purl['host'],'/')."/".$purl['path']."\\4&mode=scan'>\\4</a>\\5",$cnt);
     $cnt = preg_replace("#&lt;script([^;]) +(src|href) ?= ?('|&quot;)([^/][a-z/\.\?\#0-9\-_\+\(\)]+)('|&quot;)(.+)( ?&gt;)+#is","<a href='scaner.php?addr=http://".$purl['host']."/".$purl['path']."\\4&mode=scan'>\\0</a>",$cnt);
     $cnt = preg_replace("#(&lt;a(.*) +href ?= ?('|&quot;))([^/][a-z/\.\?\#0-9\-_\+\(\),]+)(('|&quot;)(.+)( ?&gt;)+)#is","\\1<a href='scaner.php?addr=http://".$purl['host']."/".$purl['path']."\\4&mode=scan'>\\4</a>\\5",$cnt);

     //url
     $cnt = preg_replace("#&lt;link ?rel ?= ?('|&quot;) ?stylesheet('|&quot;) +href ?= ?('|&quot;)(http?://[a-z/\.\?\#0-9-_\+\(\)]+)('|&quot;)(.+)( ?/ ?&gt;)+#i","<a href='scaner.php?addr=\\4&mode=scan'>\\0</a>",$cnt);
     $cnt = preg_replace("#((&lt;img ?src ?= ?)('|&quot;))(http://[a-z/\.\?\#0-9]+)(('|&quot;)(.+)/ ?&gt;)#i","\\1<a href='scaner.php?addr=\\4&mode=scan'>\\4</a>\\5",$cnt);
     $cnt = preg_replace("#&lt;script(.*) +(src|href) ?= ?('|&quot;)(http://[a-z/\.\?\#0-9\-_\+\(\)]+)('|&quot;)(.+)( ?&gt;)+#i","<a href='scaner.php?addr=\\4&mode=scan'>\\0</a>",$cnt);
     $cnt = preg_replace("#(&lt;a(.*) +href ?= ?('|&quot;))(http://[a-z/\.\?\#0-9\-_\+\(\),]+)(('|&quot;)(.+)( ?&gt;)+)#i","\\1<a href='scaner.php?addr=\\4&mode=scan'>\\4</a>\\5",$cnt);
                            }
                            
                            
     

switch($_GET['mode']){

  case'scan':
  
 
        
  echo"<div class='list2'>";
  
        
        
  echo nl2br($cnt);
  
  
  echo"</div>";
  
  //scan
  break;
  case 'copyscan':
  
         
  echo"<textarea rows=\"$udata[4]\">".nl2br($cnt)."</textarea>";
 
    break;
    
  default:

require_once'foot.php';

   exit;
  
  }


  }else{
  
     //radioactivity - ray
     $_COOKIE['lastaddress'] = htmlspecialchars($_COOKIE['lastaddress']);
  

echo"      
      <div class='menu'>
    
      <form method='get' action='scaner.php'>
      
<b>Адрес:</b><br />
<input type='text' name='addr' id='addr' value='{$_COOKIE['lastaddress']}'/>
<input type='submit' id='button' value='Панеслась'/><br/>
      
      

          <input type='radio' id='copyradio' class='formradio' name='mode' value='scan' checked>Обычный<br />
<input type='radio' id='copyradio' class='formradio' name='mode' value='copyscan'>Копировать</div>
         
       </form>
";                
  
}

#echo '<div class="list2"><a href="' . htmlspecialchars(getenv("HTTP_REFERER")) . '">&#171;Назад</a></div>';

require_once'foot.php';

?>