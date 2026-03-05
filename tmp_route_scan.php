<?php
$dirs = ['resources/views/admin','resources/views/admin2'];
$used=[];
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('.', FilesystemIterator::SKIP_DOTS));
foreach($it as $f){
  $path = str_replace('\\','/',$f->getPathname());
  if(substr($path,-10) !== '.blade.php') continue;
  $ok=false;
  foreach($dirs as $d){ if(strpos($path,$d.'/')===0){ $ok=true; break; } }
  if(!$ok) continue;
  $txt = @file_get_contents($path); if($txt===false) continue;
  if(preg_match_all('/route\(\s*[\'\"]([^\'\"]+)[\'\"]/',$txt,$m)){
    foreach($m[1] as $n){ $used[$n]=true; }
  }
}
$defined=[];
foreach(glob('routes/*.php') as $rf){
  $txt = file_get_contents($rf);
  if(preg_match_all('/->name\(\s*[\'\"]([^\'\"]+)[\'\"]\s*\)/',$txt,$m)){
    foreach($m[1] as $n){ $defined[$n]=true; }
  }
}
$missing=[];
foreach(array_keys($used) as $n){ if(!isset($defined[$n])) $missing[]=$n; }
sort($missing);
file_put_contents('tmp_missing_names.txt', implode("\n",$missing));
echo "used=".count($used)." defined=".count($defined)." missing=".count($missing)."\n";
?>
