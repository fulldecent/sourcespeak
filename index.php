<?php
  # index.php - Displays an overview of projects.
  #
  # Inputs: none

  if (!file_exists('config.php'))
    die('Please edit config-example.php and move it to config.php to activate this site.');

  $project_count = 0;

  require 'config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
  Welcome to <?= $site_name ?>, maintained by <?= $admin_email ?>

  This site is powered by Source Speak <?= $version ?>, available at: http://sourcespeak.sourceforge.net
-->
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <title>Welcome to <?= $site_name ?></title>
  <link rel="stylesheet" href="common.css" type="text/css" />
</head>
<body>
  <h1><img alt="logo" src="images/logo.png" /> <?= $site_name ?></h1>
  <div id="leftcolumn"> 
    <h2>Projects:</h2>
    <ul>
<?php
  # List each project

  foreach (glob('projects/*/') as $project)
  {
    if ($project[0]=='.') continue;
    $project = basename($project);
    if (preg_match('/[^a-zA-Z0-9.-]/',$project))
      continue;
    $project_count++;

    echo "      <li>\n";
    echo "        <a href=\"project.php&#63;name=$project\">\n";
    echo "          <img src=\"images/project-small.png\" alt=\"$project\" />\n";
    echo "          $project\n";
    echo "        </a>\n";

    if (file_exists("metadata/$project.txt"))
    {
      $metadata = unserialize(implode('',file("metadata/$project.txt")));
      echo "        <dl style=\"display:block\">\n";
      foreach ($metadata_fields as $field) // metadata_fields is set in config.php
      {
        if (!$metadata[$field[0]]) continue;
        echo "          <dt>".$field[0].":</dt><dd>".$metadata[$field[0]]."</dd>\n";
      }
      echo "        </dl>\n";
    }
    else
    {
      echo "        <p class=\"nometadata\">(no metadata)</p>";
    }
    echo "      </li>\n";
  }
?>
    </ul>
  </div>
  <div id="rightcolumn"> 
    <h2>Site:</h2>
    <ul>
      <li>
        <img src="images/project-small.png" alt="projects" />
        Hosted projects: <?= $project_count ?>
      </li>
      <li>
        <a href="about.php">
          <img src="images/logo-small.png" alt="link" />
          About
        </a>
      </li>
    </ul>
  </div>
  <div id="footer">&nbsp;</div>
</body>
</html>
