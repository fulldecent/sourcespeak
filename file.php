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
if (!isset($_REQUEST['project'], $_REQUEST['path'])) {
    die('Valid URL format is: file.php?project=PROJECT&path=PATH');
}
if (strstr($_REQUEST['project'] . $_REQUEST['path'], '..')) {
    die ('Hey! No hacking!');
}

$config = json_decode(file_get_contents('config.json'));
$project = isset($_REQUEST['project']) ? $_REQUEST['project'] : '';
$path = isset($_REQUEST['path']) ? $_REQUEST['path'] : '';
$filename = "projects/$project/$path";
if (!file_exists($filename)) {
    die('That source file does not exist');
}
$filenamePretty = "cache/$project/$path.txt";
if (!file_exists($filenamePretty) || filemtime($filenamePretty) <= filemtime($filename) || isset($_REQUEST['redo'])) {
    if (!is_dir(dirname($filenamePretty))) {
        mkdir(dirname($filenamePretty), 0777, true);
    }
    $cmd = 'FILE="'.$filenamePretty.'" vim -e +"source ./highlight.vim" '.escapeshellarg($filename).' 2>&1';
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
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
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
        <a class="navbar-brand" href="index.php">
          <i style="margin:-14px 0; color:pink" class="glyphicon glyphicon-heart"></i>
          <?= $config->siteName ?>
        </a>
        <p class="navbar-text"><?= $config->siteTagline ?></p>
      </div>
    </nav>
    <div class="container">
      <h1>
        <a href="project.php&#63;name=<?= $project?>"><i class="glyphicon glyphicon-book"></i> <?= $project ?></a><br>
<?php
if (dirname($path) && dirname($path) != '.') {
    $hrefEntities = "project.php&#63;name=".$project."&amp;path=".dirname($path);
    echo "    <a href=\"$hrefEntities\"><i class=\"glyphicon glyphicon-book\"></i>". dirname($path) ."</a><br>\n";
}
?>
        <i class="glyphicon glyphicon-file"></i> <?= basename($path) ?>
      </h1>
<?php
echo "<pre>";
echo str_replace('^M', '', implode('', file($filenamePretty)));
echo "</pre>";
?>
    </div>
  </body>
</html>
