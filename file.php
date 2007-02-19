<?php
  # Source Speak - file view

  include('config.php');
  $project = $_REQUEST['project'];
  $path = $_REQUEST['path'];
  if (strstr($project,'..'))
    die ('Hey! No hacking!');
  if (strstr($path,'..'))
    die ('Hey! No hacking!');
   
  $filename = "projects/$project/$path";
  $filename_pretty = "cache/$project/$path";

  function mkdir_p($path)
  {
    return is_dir($path) || mkdir_p(dirname($path)) && mkdir($path);
  }

  if (!file_exists($filename))
  {
    die('That file doesnt exist');
  }

  if (!file_exists($filename_pretty) || filemtime($filename_pretty) <= filemtime($filename) || $_REQUEST['redo'])
  {
    //TODO: ex and rename in one step
    
    $cmd = "vim -e +\"source ./highlight.vim\" \"$filename\" 2>&1";
    //die($cmd);
    passthru ($cmd);
    //die('drop temp');

    mkdir_p(dirname($filename_pretty));
    rename ('cache/tmp.html',$filename_pretty)
      or die('Couldn\'t move file :-(');
  }
?>
<html>
<head>
  <title><?= $project ?></title>
  <link rel="stylesheet" href="common.css" type="text/css">  
</head>
<body>

  <table class="main-table" width="100%">
    <tr> 
      <td colspan=2 align=center>
        <img src="images/text-64.png">
        <font style="font-size:x-large; font-family:courier">
          <?= "$path$file" ?>
        </font>
  </table>

<pre><?php echo str_replace('^M','',implode('',file($filename_pretty))); ?></pre>

</body>
</html>
