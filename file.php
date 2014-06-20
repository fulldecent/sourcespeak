<?php
error_reporting(-1);
# file.php - Shows a file in a project, with pretty coloring
#
# Inputs (in $_GET):
#   project: The name of the project (folder name in the projects dir)
#   path: A path of the file in that project
#   redo (optional): 'True' if you want to regenerate the styled code
#     note that styling is automatically updated when file changes

if (!file_exists('config.json')) {
    die('Please edit config-example.json and move it to config.json to activate this site.');
}
$config = json_decode(file_get_contents('config.json'));
$project = isset($_REQUEST['project']) ? $_REQUEST['project'] : '';
$path = isset($_REQUEST['path']) ? $_REQUEST['path'] : '';
$filename = "projects/$project/$path";
$filename_pretty = "cache/$project/$path";

if (strstr($project,'..')) {
    die ('Hey! No hacking!');
}
if (strstr($path,'..')) {
    die ('Hey! No hacking!');
}
if (preg_match('/[^a-z0-9A-Z]/', $project)) {
    die ('Hey! No hacking!');
}
if (strstr($filename,'..')) {
    die ('Hey! No hacking!');
}
if (!file_exists($filename)) {
     die('That source file does not exist');
}

if (!file_exists($filename_pretty) || filemtime($filename_pretty) <= filemtime($filename) || isset($_REQUEST['redo']))
{
    //TODO: ex and rename in one step
    //TODO: standardize file endings in this step too
    mkdir(dirname($filename_pretty), 0777, true);
    $cmd = 'FILE="'.$filename_pretty.'" vim -e +"source ./highlight.vim" '.escapeshellarg($filename).' 2>&1';
    $result = `$cmd`;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $config->siteName ?></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="common.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <a class="navbar-brand" href="index.php"><i style="margin:-14px 0; color:pink" class="glyphicon glyphicon-heart"></i> <?= $config->siteName ?></a>
        <p class="navbar-text"><?= $config->siteTagline ?></p>
      </div>
    </nav>
    <div class="container">
      <h1>
        <a href="project.php&#63;name=<?= $project?>"><i class="glyphicon glyphicon-book"></i> <?= $project ?></a><br>
    <?php
        if (dirname($path) && dirname($path) != '.')
          echo "    <a href=\"project.php&#63;name=".$project."&amp;path=".dirname($path)."\"><i class=\"glyphicon glyphicon-book\"></i>". dirname($path) ."</a><br>\n";
    ?>
        <i class="glyphicon glyphicon-file"></i> <?= basename($path) ?>
      </h1>
      <pre><?php echo str_replace('^M','',implode('',file($filename_pretty))); ?></pre>
    </div> <!-- /container -->
  </body>
</html>
