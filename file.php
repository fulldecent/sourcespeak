<?php
  # file.php - Shows a file in a project, with pretty coloring
  #
  # Inputs (in $_GET):
  #   project: The name of the project (folder name in the projects dir)
  #   path: A path of the file in that project
  #   redo (optional): 'True' if you want to regenerate the styled code
  #     note that styling is automatically updated when file changes

  require 'config.php';
  $project = $_REQUEST['project'];
  $path = $_REQUEST['path'];
  $filename = "projects/$project/$path";
  $filename_pretty = "cache/$project/$path";

  if (preg_match('/[^a-z0-9A-Z]/', $project))
    die ('Hey! No hacking!');
  if (strstr($filename,'..'))
    die ('Hey! No hacking!');
  if (!file_exists($filename))
    die('That source file doesnt exist');

  function mkdir_p($path)
  {
    return is_dir($path) || mkdir_p(dirname($path)) && mkdir($path);
  }

  if (!file_exists($filename_pretty) || filemtime($filename_pretty) <= filemtime($filename) || $_REQUEST['redo'])
  {
    //TODO: ex and rename in one step
    //TODO: standardize file endings in this step too
    
    mkdir_p(dirname($filename_pretty));
    $cmd = 'FILE="'.$filename_pretty.'" vim -e +"source ./highlight.vim" '.escapeshellarg($filename).' 2>&1';
    $result = `$cmd`;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <title><?= $project ?></title>
  <link rel="stylesheet" href="common.css" type="text/css" />
</head>
<body class="sourcepage">
  <h1>
    <a href="project.php&#63;name=<?= $project?>"><img src="images/project-small.png" alt="project" /> <?= $project ?></a><br>
<?php
    if (dirname($path) && dirname($path) != '.')
      echo "    <a href=\"project.php&#63;name=".$project."&amp;path=".dirname($path)."\"><img src=\"images/folder-small.png\" alt=\"folder\" /> ". dirname($path) ."</a><br>\n";
?>
    <img src="images/source-small.png" alt="file" /> <?= basename($path) ?>
  </h1>

  <pre><?php echo str_replace('^M','',implode('',file($filename_pretty))); ?></pre>

</body>
</html>
