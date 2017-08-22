<?php

$dir=(isset($_GET["dir"])?$_GET["dir"]:$dir="");
$dirRoot=substr($_SERVER['SCRIPT_FILENAME'], 0, strripos($_SERVER['SCRIPT_FILENAME'], "/"));

// создания папок
if(count(scandir($dirRoot))<12){
   $sNameFold = file_get_contents("nameFolder.txt");
   $aNameFold = preg_split('~,~', $sNameFold);
   for($i=0; $i<count($aNameFold); $i++){
     $aNameFold[$i]=trim($aNameFold[$i]);
   }
   $tempFold=[];
   for($i=0; $i<13; $i++)
   {
     $rand=rand(1, count($aNameFold))-1;
     if($aNameFold[$rand]!=="")  mkdir($aNameFold[$rand]);
     else $i--;
     $tempFold[]=$aNameFold[$rand];
     $aNameFold[$rand]="";
   }
   $i="";
   $t=0;
   foreach($aNameFold as $nameFold){

      if($nameFold!=""){

      	if($i==""){
	   $rand=rand(0,count($tempFold)-1);
	   mkdir($tempFold[$rand]."/".$nameFold);

	   if($t==0){
		$t=1;
	   	$i=$nameFold;
	   } else $t=0;
        }
      	else{
	   mkdir($tempFold[$rand]."/".$i."/".$nameFold);

	   $i="";
	}
      }
   }
}
// файловый менеджер


if($dir!=""){
  if($dir[0]=="/") $dir=substr($dir,1);
  $chars = preg_split('~/~', $dir);
  $count = count($chars);
  if($chars[$count-1]=='.') {
    unset($chars[$count-2], $chars[$count-1]);
  }
  if(count($chars)>0&&isset($chars[$count-1])){
    if($chars[$count-1]=='..') {
      unset($chars[$count-3], $chars[$count-2], $chars[$count-1]);
    }
  }
  $dir=implode('/',$chars);
}
$files = scandir($dirRoot."/".$dir, SCANDIR_SORT_NONE);
echo "<p>Текущий каталог: ".$dirRoot."/".$dir."</p>";
echo "<ul>";
foreach ($files as $value)
 {
    preg_match("/[\d]+/", $value,$match);
    echo "<li>";
    if($match==NULL)
    {
      if (is_dir($dirRoot."/".$dir."/".$value)){
        echo "<a href=\"?dir=".$dir."/".$value."\">".$value."</a>";
      }else{
        echo $value."(".filesize($dirRoot."/".$dir."/".$value)." байт)";
      }
    }else{
      echo $value;
    }

  echo "</li>";
}
echo "</ul>";
 ?>
