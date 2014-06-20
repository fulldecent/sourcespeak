<?php
error_reporting(-1);
# project.php - Shows files in a project
#
# Inputs (in $_GET):
#   name: The name of the project (folder name in the projects dir)
#   path (optional): A path in that project

if (!file_exists('config.json')) {
    die('Please edit config-example.json and move it to config.json to activate this site.');
}
$config = json_decode(file_get_contents('config.json'));
$project = isset($_REQUEST['project']) ? $_REQUEST['project'] : '';
$path = isset($_REQUEST['path']) ? $_REQUEST['path'] : '';
if (strstr($project, '..')) {
    die ('Hey! No hacking!');
}
if (strstr($path, '..')) {
    die ('Hey! No hacking!');
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
      <div class="page-header">
        <h1><i class="glyphicon glyphicon-book"></i> <?= $project ?></h1>
      </div>
      <div class="row">
        <div class="col-md-8">
        <h2>Browsing /<?= $path ?></h2>
        <table class="table">
<?php
# List files

$dir_handle = opendir("projects/$project/$path") 
  or die('Project not found');

while ($file = readdir($dir_handle)) {
    if ($file[0]=='.') {
        continue;
    }
    echo "      <tr><td>\n";
    if (is_dir("projects/$project/$path$file")) {
        echo "        <a href=\"project.php&#63;project=$project&amp;path=$path$file/\">\n";
        echo "          <i class=\"glyphicon glyphicon-folder-open\"></i>&nbsp;\n";
        echo "          $file</a>\n";
    } else {
        echo "        <a href=\"file.php&#63;project=$project&amp;path=$path$file\">\n";
        echo "          <i class=\"glyphicon glyphicon-file\"></i>&nbsp;\n";
        echo "          $file</a>\n";
        echo "        <a style=\"font-weight:normal; font-style:italic\" href=\"projects/$project/$path$file\">(download)</a>\n";
    }
    echo "      </td></tr>\n";
}    
closedir($dir_handle);
?>
        </table>

        </div>
        <div class="col-md-4">
          <h2>Project info</h2>
<?php
if (file_exists("metadata/$project.json")) {
    $metadata = json_decode(file_get_contents("metadata/$project.json"));
    echo "        <dl class=\"dl-horizontal\">\n";
    foreach ($config->metadataFields as $field) {
        if (!isset($metadata->{$field->name})) continue;
        echo "          <dt>".$field->name.":</dt><dd>".$metadata->{$field->name}."</dd>\n";
    }
    echo "        </dl>\n";
} else {
    echo "        <dl class=\"dl-horizontal\"><dd>(no metadata)</dd></dl>";
}
?>        
          <p class="lead"><a href="tar.php&#63;project=<?= $project ?>"><i class="glyphicon glyphicon-download"></i> Download Tar</a>
        </div>
      </div>
    </div> <!-- /container -->
  </body>
</html>