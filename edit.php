<?php
  # edit.php - Edit metadata for a project
  #
  # Inputs (in $_GET):
  #   name: The name of the project (folder name in the projects dir)

  require 'config.php';

  $project = $_REQUEST['name'];
   if (strstr($project,'..'))
      die ('Hey! No hacking!');

  if ($_POST)
  {
    if ($_POST['password'] != $admin_password)
      die ('Invalid admin password, go back... try again');
    
    foreach ($_POST as $field => $data)
    {
      if ($field == 'password') continue;
      $metadata[$field] = $data;
    }
    
    $fp = fopen("metadata/$project.txt", 'w+');
    fwrite($fp, serialize($metadata));
    fclose($fp);
    
    header("Location: project.php?name=$project");
  }

  if (file_exists("metadata/$project.txt"))
    $metadata = unserialize(file_get_contents("metadata/$project.txt"));
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <title><?= $project ?></title>
  <link rel="stylesheet" href="common.css" type="text/css" />
</head>
<body>
    <form method="post" action="edit.php&#63;name=<?= $_REQUEST['name']?>">
  <h1><img src="images/project.png" alt="project" /> Editing metadata for <?= $project ?></h1>
  <div id="leftcolumn">
    <h2>Project info:</h2>
    <div class="form">
<?php
      foreach ($metadata_fields as $field)
      {
        $x++;
        echo "      <label for=\"md$x\">".$field[0].":</label>\n";
        echo "      <input id=\"md$x\" type=\"text\" name=\"".$field[0]."\" value=\"".$metadata[$field[0]]."\" />\n";
      }
?>
      <label for="pass">Admin password:</label>
      <input id="pass" name="password" type="password" />
      <input id="submit" type="submit" value="Save Changes" />
      <div style="clear:left" />
    </div>
  </div>
  </form>
</body>
</html>
