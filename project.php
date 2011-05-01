<?php
  # project.php - Shows files in a project
  #
  # Inputs (in $_GET):
  #   name: The name of the project (folder name in the projects dir)
  #   path (optional): A path in that project

  require 'config.php';

  $project = $_REQUEST['name'];
  if (strstr($_REQUEST['path'],'..'))
    die ('Hey! No hacking!');
  if (strstr($_REQUEST['name'],'..'))
    die ('Hey! No hacking!');
  
  if (file_exists("metadata/$project.txt"))
    $metadata = unserialize(implode('',file("metadata/$project.txt")));
  
  $path = $_REQUEST['path'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <title><?= $project ?></title>
  <link rel="stylesheet" href="common.css" type="text/css" />
</head>
<body>
  <h1><img src="images/project.png" alt="project" /> <?= $project ?></h1>
  <div id="leftcolumn">
    <h2>Browsing: <?= "/$path" ?></h2>
    <ul>
<?php
  # List files

  $dir_handle = opendir("projects/$project/$path") 
    or die('Project not found');
  
  while ($file = readdir($dir_handle))
  {
    if ($file[0]=='.') continue;
    
//    $mimetype = `file -ib projects/$project/$file`;
//    $mimetype = mime_content_type("projects/$project/$file");
    echo "      <li>\n";
    
    if (is_dir("projects/$project/$path$file"))
    {    
      echo "        <a href=\"project.php&#63;name=$project&amp;path=$path$file/\">\n";
      echo "          <img src=\"images/folder-small.png\" alt=\"directory\" />\n";
      echo "          $file</a>\n";
    }
    else
    {
      echo "        <a href=\"file.php&#63;project=$project&amp;path=$path$file\">\n";
      echo "          <img src=\"images/source-small.png\" alt=\"file\" />\n";
      echo "          $file</a>\n";
      echo "        <a style=\"font-weight:normal; font-style:italic\" href=\"projects/$project/$path$file\">(download)</a>\n";
    }

    echo "      </li>\n";
  }    
 
  closedir($dir_handle);
?>
    </ul>
  </div>
  <div id="rightcolumn">
    <h2>Project Info</h2>
    <ul>
      <li>
<?php
  if ($metadata)
  {
    echo "        <dl>\n";
    foreach ($metadata_fields as $field)
      if ($metadata[$field[0]]) 
        echo "          <dt>".$field[0].":</dt><dd>".$metadata[$field[0]]."</dd>\n";
    echo "        </dl>\n";
    echo "        <div style=\"clear:both\" />\n";
  }
  else
  {
    echo "        <p class=\"nometadata\">No metadata</p>\n";
  }
?>
      </li>
      <li>
        <a href="index.php"><img src="images/logo-small.png" alt="link" /> Home</a>
      </li>
      <li>
        <a href="tar.php&#63;project=<?= $project ?>"><img src="images/logo-small.png" alt="link" /> Download Tar</a>
      </li>
      <li>
        <a href="edit.php?name=<?=$project?>"><img src="images/logo-small.png" alt="link" /> Edit Metadata</a>
      </li>
    </ul>
  </div>
  <div id="footer">&nbsp;</div>
</body>
</html>
