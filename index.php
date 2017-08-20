<?php
$dir=(isset($_GET["dir"])?$_GET["dir"]:$dir="");
$dirRoot=substr($_SERVER['SCRIPT_FILENAME'], 0, strripos($_SERVER['SCRIPT_FILENAME'], "/"));

if($dir!=""){
  if($dir[0]=="/") $dir=substr($dir,1);
  $chars = preg_split('~/~', $dir);
  if($chars[count($chars)-1]=='.') {
    unset($chars[count($chars)-1]);
    unset($chars[count($chars)-1]);
  }
  if(count($chars)>0){
    if($chars[count($chars)-1]=='..') {
      unset($chars[count($chars)-1]);
      unset($chars[count($chars)-1]);
      unset($chars[count($chars)-1]);
    }
  }
  $dir=implode('/',$chars);
}
$files = scandir($dirRoot."/".$dir);
echo "<p>Текущий каталог: ".$dirRoot."/".$dir."</p>";
echo "<ul>";
foreach ($files as $value)
 {
    preg_match("/[\d]+/", $value,$match);
    if($match==NULL)
    {
      echo "<li>";
      if (is_dir($dirRoot."/".$dir."/".$value)){
        echo "<a href=\"?dir=".$dir."/".$value."\">".$value."</a>";
      }else{
        echo $value."(".filesize($dirRoot."/".$dir."/".$value)." байт)";
      }
    }
  echo "</li>";
}
echo "</ul>";
 ?>
