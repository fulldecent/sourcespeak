<?php
  include('config.php');

  $project = $_REQUEST['name'];
  if (strstr($_REQUEST['path'],'..'))
    die ('Hey! No hacking!');
  
  if (file_exists("metadata/$project.txt"))
    $metadata = unserialize(implode('',file("metadata/$project.txt")));
  
  $path = $_REQUEST['path'];
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
        <img src="images/project-64.png">
        <font style="font-size:x-large; font-family:courier">
          <?= $project ?>
        </font>
    <tr valign=top>
      <td width="66%">
      
        <table width="100%">
        
          <tr>
            <td class="Section">
              Browsing: <?= "/$path" ?>
        
<?php
  # List files

  $dir_handle = opendir("projects/$project/$path");
  
  while ($file = readdir($dir_handle))
  {
    if ($file[0]=='.') continue;
    
//    $mimetype = `file -ib projects/$project/$file`;
//    $mimetype = mime_content_type("projects/$project/$file");
    echo '<tr><td class="content-left">';
    
    if (is_dir("projects/$project/$path$file"))
    {    
      echo "<a href=\"project.php&#63;name=$project&amp;path=$path$file/\">";
      echo '<img src="images/folder.png" align=center> ';
      echo "$file</a>";
    }
    else
    {
      echo "<a href=\"file.php&#63;project=$project&amp;path=$path$file\">";
      echo '<img src="images/text.png" align=center> ';
      echo "$file</a>";
      echo " <a style=\"font-weight:normal\" href=\"projects/$project/$path$file\"><i>(download)</i></a>";
    }
  }    
 
  closedir($dir_handle);
?>
        </table>
        
      
      <td align=right>
        <table width="100%">
          <tr>
            <td class="Section" align=right>Project info
          <tr><td class="content-right" align=right>
<?php
  # Project info

  if ($metadata)
  {
    echo "<table>";
    foreach ($metadata_fields as $field)
      if ($field[3]) 
        echo '<tr><td>'.$field[0].":<td>".$metadata[$field[0]];
    echo "</table>";
  }
  else
  {
    echo '<img src="images/info.png"> <i>No metadata</i><br>';
  }
?>
          <tr>
            <td class="content-right" align=right>
              <a href="index.php"><img src="images/link.png"> Home</a><br>
          <tr>
            <td class="content-right" align=right>
              <a href="tar.php&#63;project=<?= $project ?>"><img src="images/link.png"> Download Tar</a><br>
          <tr>
            <td class="content-right" align=right>
              <a href="edit.php?name=<?=$project?>"><img src="images/link.png"> Edit Metadata</a><br>
        </table>
  </table>
</body>
</html>
