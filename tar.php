<?php
  $project = $_GET['project'];
  if (strstr('..', $project)) die ('Hey! No hacking');
  if (strstr("'", $project)) die ('Hey! No hacking');

  chdir('projects');
  $cmd = "tar -cf - ./'$project/'";
//die($cmd);
  header('Content-type: application/x-tar');
  header("Content-Disposition: attachment; filename=\"$project.tar\"");

  passthru($cmd);
?> 
