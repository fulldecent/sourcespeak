<?php
error_reporting(-1);
# index.php - Displays an overview of projects.
#
# Inputs: none
if (!file_exists('config.json'))
  die('Please copy config-example.json to config.json and edit it to activate this site.');
$config = json_decode(file_get_contents('config.json'));
$project_count = 0;
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
      <div class="row">
        <div class="col-md-8">
<?php
foreach (glob('projects/*/') as $project)
{
  if ($project[0]=='.') continue;
  $project = basename($project);
  if (preg_match('/[^a-zA-Z0-9.-]/',$project))
    continue;
  $project_count++;

  echo "      <div class=\"thumbnail\">\n";
  echo "        <a href=\"project.php&#63;project=$project\">\n";
  echo "          <h3><i class=\"glyphicon glyphicon-book\"></i> $project</h3>\n";
  echo "        </a>\n";

  if (file_exists("metadata/$project.json"))
  {
    $metadata = json_decode(file_get_contents("metadata/$project.json"));
    echo "        <dl class=\"dl-horizontal\">\n";
    foreach ($config->metadataFields as $field)
    {
      if (!isset($metadata->{$field->name})) continue;
      echo "          <dt>".$field->name.":</dt><dd>".$metadata->{$field->name}."</dd>\n";
    }
    echo "        </dl>\n";
  }
  else
  {
    echo "        <dl class=\"dl-horizontal\"><dd>(no metadata)</dd></dl>";
  }
  echo "      </div>\n";
}
?>
        </div>
        <div class="col-md-4">
          <p class="lead"><i class="glyphicon glyphicon-info-sign"></i> Hosted projects: <?= $project_count ?></p>
          <p class="lead"><i class="glyphicon glyphicon-info-sign"></i> Webmaster: <?= $config->adminEmail ?></p>
          <p class="lead"><i class="glyphicon glyphicon-info-sign"></i> Powered by Source Speak</p>
        </div>
      </div>
    </div> <!-- /container -->
  </body>
</html>
